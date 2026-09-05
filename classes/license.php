<?php

namespace Tikstore;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * License Classes
 */
class License
{
    /**
     * alias for license server url
     * 
     * @since 1.0.0
     * @var string
     */
    const SERVER = 'https://member.tematoko.com';

    /**
     * alias for license ID
     * 
     * @since 1.0.0
     */
    private $id = '8DOS3683EN';

    /**
     * api url
     */
    private $api;

    /**
     * this site host
     */
    private $host;

    /**
     * license code
     */
    private $code = '';

    /**
     * license key
     */
    private $key;

    /**
     * license data
     */
    private $data = [];


    /**
     * construction
     *
     */
    public function __construct()
    {
        $this->api  = self::SERVER . '/wp-json/salesloo/v1/file/license';
        $this->host = preg_replace("(^https?://)", "", site_url());
        $this->key  = '__tkshplcns';
        $this->data();
    }

    /**
     * data
     * 
     * get data from database;
     * 
     * @since 1.0.0
     * @return mixed
     */
    private function data()
    {
        $option = get_option($this->key);

        if (empty($option)) return $this;
        $this->data = json_decode(tikstore_decrypt($option), true);

        return $this;
    }

    public function __set($name, $value)
    {
        if ($name == 'code') {
            $this->code = $value;
        }
    }

    /**
     * getter
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        $value = NULL;

        if (array_key_exists($name, (array)$this->data))
            $value = maybe_unserialize($this->data[$name]);

        return $name == 'status' ? intval($value) : $value;
    }

    /**
     * update_option
     *
     * @param  mixed $result
     * @return void
     */
    private function update_option($result)
    {
        wp_cache_delete($this->key, 'options');
        update_option($this->key, tikstore_encrypt(json_encode($result)));
    }

    /**
     * show menu page
     */
    public static function page()
    {
        ob_start();
        get_template_part(
            'template-parts/license',
            '',
            [
                'license' => new self(),
                'title' => __('Tiktoko Theme License', 'tikstore'),
                'activate_action' => 'tikstore_activate_license',
                'deactivate_action' => 'tikstore_deactivate_license'
            ]
        );
        $html = ob_get_clean();
        echo $html;
    }

    /**
     * api_response
     *
     * @param  mixed $response
     * @return mixed
     */
    private function api_response($response)
    {
        if (!is_wp_error($response)) {
            $result   = json_decode(wp_remote_retrieve_body($response), true);
            $code = intval(wp_remote_retrieve_response_code($response));
        } else {
            $result = [
                'status' => 999,
                'message' => $response->get_error_message()
            ];
        }

        return $result;
    }


    /**
     * activate 
     * 
     * activate the license
     *
     * @return mixed
     */
    public function activate()
    {
        $server = add_query_arg([
            'purchase_code' => $this->code,
            'id'            => $this->id,
            'host'          => $this->host
        ], $this->api);

        $result = $this->api_response(wp_remote_post($server));

        if (isset($result['status']) && intval($result['status']) != 999) {
            $this->update_option($result);
        }

        return true;
    }

    /**
     * delete
     * 
     * delete the license
     *
     * @return void
     */
    public function deactivate()
    {
        $server = add_query_arg([
            'purchase_code' => $this->purchase_code,
            'id'            => $this->id,
            'host'          => $this->host
        ], $this->api);

        $result = $this->api_response(
            wp_remote_request(
                $server,
                ['method' => 'DELETE']
            )
        );

        if (isset($result['status']) && intval($result['status']) == 200) {

            unset($result['status']);
            $this->update_option($result);
        }

        return true;
    }

    /**
     * check
     * 
     * checking the license
     * 
     * @return void
     */
    private function check()
    {
        $server = add_query_arg([
            'purchase_code' => $this->code,
            'id'            => $this->id,
            'host'          => $this->host
        ], $this->api);

        if ($this->data['id'] == $this->id) {
            $result = $this->api_response(wp_remote_get($server));

            if (isset($result['status']) && intval($result['status']) != 999) {
                $this->update_option($result);
            }
        } else {
            $expired_at = strtotime($this->expired_at);

            $is_expired = $expired_at && $expired_at <= strtotime('now') ? true : false;

            if ($is_expired) {
                $result = [
                    'message' => sprintf(__('Your purchase code has an expired, please renew your purchase or use another active purchase code', 'tikstore'), $this->host),
                    'status' => 403
                ];

                $this->update_option($result);
            }
        }

        return true;
    }

    /**
     * periodic_check
     * 
     * on license periodic check
     *
     * @return void
     */
    public function periodic_check()
    {
        if ($this->purchase_code && $this->status == 200) {
            $this->code = $this->purchase_code;
            $this->check();
        }
    }
}
