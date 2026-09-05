<?php

namespace Tikstore\Shippings;

use Yano;

class Rajaongkir extends Base
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
        Yano::section('section_shipping_rajaongkir', [
            'title'       => __('Rajaongkir', 'tikstore'),
            'description' => __('Rajaongkir setting', 'tikstore'),
            'priority'    => 2,
            'panel'       => 'panel_shipping'
        ]);

        Yano::field('text', [
            'id'            => '_tikstore_shipping_rajangkir_api_key',
            'label'         => __('Api key', 'tikstore'),
            'description'   => __('Rajaongkir Api key', 'tikstore'),
            'section'       => 'section_shipping_rajaongkir',
            'priority'      => 1,
        ]);

        Yano::field('select', [
            'id'            => '_tikstore_shipping_rajaongkir_type',
            'label'         => __('Account Type', 'tikstore'),
            'description'   => __('Rajaongkir account type', 'tikstore'),
            'section'       => 'section_shipping_rajaongkir',
            'priority'      => 2,
            'default' => self::DEFAULT_ACCOUNT_TYPE,
            'choices'       => [
                'pro' => 'Pro',
                'basic' => 'Basic',
                'starter' => 'Starter'
            ],
        ]);

        Yano::field('tagging-select', [
            'id'            => '_tikstore_' . self::ORIGIN_KEY,
            'label'         => __('Your shipping origin', 'tikstore'),
            'description'   => __('Where are orders shipped from?', 'tikstore'),
            'section'       => 'section_shipping_rajaongkir',
            'priority'      => 3,
            'maxitem'       => 1,
            'choices'       => self::subdistricts(),
        ]);

        Yano::field('checkbox-multiple', [
            'id'          => '_tikstore_shipping_rajaongkir_courier_pro',
            'label'       => 'Courier',
            'description' => __('Check to enable courier on this site', 'tikstore'),
            'section'     => 'section_shipping_rajaongkir',
            'priority'    => 4,
            'choices'     => [
                'pos'     => 'Pos',
                'jne'     => 'JNE',
                'tiki'    => 'Tiki',
                'pcp'     => 'Priority Cargo and Package',
                'esl'     => 'Eka Sari Lorena',
                'rpx'     => 'RPX Holding',
                'pandu'   => 'Pandu Logistics',
                'wahana'  => 'Wahana Prestasi Logistik',
                'sicepat' => 'SiCepat Express',
                'jnt'     => 'JnT Express',
                'pahala'  => 'Pahala Kencana',
                'sap'     => 'SAP Express',
                'jet'     => 'JET Express',
                'slis'    => "Solusi Express",
                'dse'     => '21 Express',
                'first'   => 'First Express',
                'ncs'     => 'Nusantara Card Semesta',
                'star'    => 'Star Cargo',
                'lion'    => 'Lon Parcel',
                'ninja'   => 'Ninja Express',
                'idl'     => 'IDL Cargo',
                'rex'     => 'Royal Express Indonesia',
            ],
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_shipping_rajaongkir_type', 'pro') == 'pro') {
                    return true;
                } else {
                    return false;
                }
            }
        ]);

        Yano::field('checkbox-multiple', [
            'id'          => '_tikstore_shipping_rajaongkir_courier_basic',
            'label'       => 'Courier',
            'description' => __('Check to enable courier on this site', 'tikstore'),
            'section'     => 'section_shipping_rajaongkir',
            'priority'    => 4,
            'choices'     => [
                'pos' => 'Pos',
                'jne' => 'JNE',
                'tiki' => 'Tiki',
                'pcp' => 'Priority Cargo and Package',
                'esl' => 'Eka Sari Lorena',
                'rpx' => 'RPX Holding',
            ],
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_shipping_rajaongkir_type', 'pro') == 'basic') {
                    return true;
                } else {
                    return false;
                }
            }
        ]);

        Yano::field('checkbox-multiple', [
            'id'          => '_tikstore_shipping_rajaongkir_courier_starter',
            'label'       => 'Courier',
            'description' => __('Check to enable courier on this site', 'tikstore'),
            'section'     => 'section_shipping_rajaongkir',
            'priority'    => 4,
            'choices'     => [
                'pos' => 'Pos',
                'jne' => 'JNE',
                'tiki' => 'Tiki',
            ],
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_shipping_rajaongkir_type', 'pro') == 'starter') {
                    return true;
                } else {
                    return false;
                }
            }
        ]);
    }

    public function method($destination, $weight = 1000)
    {
        global $wpdb;

        $table = $wpdb->prefix . 'tikstore_shipping_cost';

        $api_key = get_theme_mod('_tikstore_shipping_rajangkir_api_key');
        if (empty($api_key)) {
            throw new \Exception(__('Rajaongkir api key not set', 'tikstore'));
        }

        $origin = $this->origin_id();

        if (empty($origin)) {
            throw new \Exception(__('Rajaongkir origin id not set', 'tikstore'));
        }

        if (count(explode('-', $origin)) < 3) {
            throw new \Exception(__('Invalid origin id', 'tikstore'));
        }

        if (count(explode('-', $destination)) < 3) {
            throw new \Exception('invalid', __('Invalid destination id', 'tikstore'));
        }

        $type = get_theme_mod('_tikstore_shipping_rajaongkir_type', 'pro');

        $couriers = get_theme_mod('_tikstore_shipping_rajaongkir_courier_' . $type);
        if (empty($couriers)) {
            throw new \Exception(__('Rajaongkir couriers not set', 'tikstore'));
        }

        $costs = [];

        foreach (explode(',', $couriers) as $courier) {
            $db_name = "rajaongkir_{$type}_{$courier}_{$origin}_{$destination}_{$weight}";
            $db = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE `name` = %s", $db_name));
            if (null == $db) {
                $res = $this->fetch($courier, $destination, $weight);
                if ($res) {
                    $wpdb->insert($table, [
                        'name' => $db_name,
                        'data' => maybe_serialize($res)
                    ]);
                    $costs[] = $res;
                }
            } else {
                if (strtotime($db->updated_at) < strtotime('-30 days')) {
                    $res = $this->fetch($courier, $destination, $weight);
                    if ($res) {
                        $wpdb->insert($table, [
                            'name' => $db_name,
                            'data' => maybe_serialize($res)
                        ]);
                        $costs[] = $res;
                    }
                } else {
                    $costs[] = maybe_unserialize($db->data);
                }
            }
        }

        $data = [];

        foreach ($costs as $method) {
            foreach ($method['costs'] as $cost) {
                foreach ($cost['cost'] as $c) {
                    $etd = isset($c['etd']) ? $c['etd'] : '';
                    $etd = str_replace('HARI', '', $etd);
                    $etd = str_replace(' ', '', $etd);
                    $data[] = [
                        'id' => $method['code'] . '_' . $origin . '_' . $destination . '_' . $weight . '|' . $cost['service'] . '|' . $etd,
                        'courier' => [
                            'name' => $method['name'],
                            'code' => $method['code']
                        ],
                        'service' => $cost['service'],
                        'cost' => $c['value'],
                        'etd' => $etd,
                        'note' => isset($c['note']) ? $c['note'] : ''
                    ];
                }
            }
        }

        return $data;
    }

    private function fetch($courier, $destination, $weight = 1000)
    {
        $origin = $this->origin_id();

        $api_key = get_theme_mod('_tikstore_shipping_rajangkir_api_key');

        $type = get_theme_mod('_tikstore_shipping_rajaongkir_type', 'pro');
        $endpoint = 'https://api.rajaongkir.com/starter/cost';

        if ($type == 'pro') {
            $endpoint = 'https://pro.rajaongkir.com/api/cost';
        } else if ($type == 'basic') {
            $endpoint = 'https://api.rajaongkir.com/basic/cost';
        }

        list($origin_subdistrict_id, $origin_city_id, $origin_province_id) = explode('-', $origin);
        list($destination_subdistrict_id, $destination_city_id, $destination_province_id) = explode('-', $destination);

        $args = array(
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'key' => $api_key,
            ),
            'body' => array(
                'weight'      => $weight,
                'courier'     => $courier,
            )
        );

        if ($type == 'pro') {
            $args['body']['origin'] = $origin_subdistrict_id;
            $args['body']['originType'] = 'subdistrict';
            $args['body']['destination'] = $destination_subdistrict_id;
            $args['body']['destinationType'] = 'subdistrict';
        } else {
            $args['body']['origin'] = $origin_city_id;
            $args['body']['destination'] = $destination_city_id;
        }

        $res = wp_remote_post($endpoint, $args);

        if (!is_wp_error($res)) {
            $body = json_decode(wp_remote_retrieve_body($res), true);

            return isset($body['rajaongkir']['results'][0]) ? $body['rajaongkir']['results'][0] : [];
        }

        error_log(json_encode($args['body']));
        error_log($res->get_error_message());

        return [];
    }

    public function validate_cost($id)
    {
        global $wpdb;

        $table = $wpdb->prefix . 'tikstore_shipping_cost';
        $type = get_theme_mod('_tikstore_shipping_rajaongkir_type', 'pro');

        $shipping_cost = 0;

        $id = explode('|', $id);
        if (isset($id[0]) && isset($id[1])) {
            $db_name = 'rajaongkir_' . $type . '_' . $id[0];
            $db = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE `name` = %s", $db_name));

            if ($db) {
                $data = maybe_unserialize($db->data, true);

                foreach ($data['costs'] as $cost) {
                    if ($cost['service'] == $id[1]) {
                        $shipping_cost = isset($cost['cost'][0]['value']) ? floatval($cost['cost'][0]['value']) : $shipping_cost;
                    }
                }
            }
        }

        return $shipping_cost;
    }
}
