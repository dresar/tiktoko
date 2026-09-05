<?php

namespace Tikstore\Shippings;

use Yano;

class Free extends Base
{
    const ORIGIN_KEY = 'shipping_rajaongkir_origin';

    const DEFAULT_ACCOUNT_TYPE = 'pro';

    /**
     * get shipping origin_id
     *
     * @return mixed
     */
    public function origin_id()
    {
        $subdistrict_ids = tikstore_options(self::ORIGIN_KEY);

        if (isset($subdistrict_ids[0])) {
            return $subdistrict_ids[0];
        }

        return false;
    }

    /**
     * get shipping origin_name
     *
     * @return mixed
     */
    public function origin_name($query = false)
    {
        if (false === $query) {
            return get_option('tikstore_shipping_origin_name');
        }

        $subdistricts = self::subdistricts();
        $subdistrict_id = $this->origin_id();

        if ($subdistrict_id && isset($subdistricts[$subdistrict_id])) {
            return $subdistricts[$subdistrict_id];
        }

        return false;
    }

    /**
     * subdistricts
     *
     * @return mixed
     */
    public static function subdistricts()
    {
        global $wp_filesystem;

        $file_url  = TIKSTORE_URL . '/data/rajaongkir-subdistrict.json';
        $file_path = TIKSTORE_PATH . '/data/rajaongkir-subdistrict.json';

        try {
            require_once ABSPATH . 'wp-admin/includes/file.php';

            if (is_null($wp_filesystem)) {
                WP_Filesystem();
            }

            if (!$wp_filesystem instanceof \WP_Filesystem_Base || (is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code())) {
                throw new \Exception('WordPress Filesystem Abstraction classes is not available', 1);
            }

            if (!$wp_filesystem->exists($file_path)) {
                throw new \Exception('JSON file is not exists or unreadable', 1);
            }

            $json = $wp_filesystem->get_contents($file_path);
        } catch (\Exception $e) {
            // Get JSON data by HTTP if the WP_Filesystem API procedure failed.
            $json = wp_remote_retrieve_body(wp_remote_get(esc_url_raw($file_url)));
        }

        if (!$json) {
            return false;
        }

        $data = json_decode($json, true);

        if ('No error' !== json_last_error_msg() || !$data) {
            return false;
        }

        $subdistricts = [];
        foreach ($data as $subdistrict) {
            $key = $subdistrict['subdistrict_id'] . '-' . $subdistrict['city_id'] . '-' . $subdistrict['province_id'];
            $subdistricts[$key] = $subdistrict['subdistrict_name'] . ', ' . $subdistrict['city'] . ' ' . $subdistrict['province'];
        }

        return $subdistricts;
    }

    public static function customizer()
    {
        Yano::section('section_shipping_free', [
            'title'       => __('Free Shipping', 'tikstore'),
            'description' => __('Free Shipping setting', 'tikstore'),
            'priority'    => 2,
            'panel'       => 'panel_shipping'
        ]);

        Yano::field('text', [
            'id'            => '_tikstore_shipping_rajangkir_api_key',
            'label'         => __('Api key', 'tikstore'),
            'description'   => __('Rajaongkir Api key', 'tikstore'),
            'section'       => 'section_shipping_free',
            'priority'      => 1,
        ]);

        Yano::field('content-editor', [
            'id'          => '_tikstore_shipping_free_message',
            'label'       => 'Message',
            'description' => __('Message for customer', 'tikstore'),
            'section'     => 'section_shipping_free',
            'priority'    => 4,
            'default' => get_theme_mod('_tikstore_shipping_free_message', 'Gratis ongkir untuk pesananmu hari ini')
        ]);
    }

    public function method($destination, $weight = 1000)
    {
        return [];
    }

    public function validate_cost($id)
    {
        return false;
    }
}
