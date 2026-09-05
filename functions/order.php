<?php

use YahnisElsts\PluginUpdateChecker\v5p0\Plugin\Update;

function tikstore_update_order($field_id, $updated, $action, $metabox)
{
    $post_id = intval($metabox->data_to_save['post_ID']);
    if (get_post_type($post_id) != 'tikstore-order') return;

    $order = new Tikstore\Order($post_id);

    $customer = $order->customer;

    if ($field_id == 'customer_name') {
        $customer['name'] = $metabox->value;
        delete_post_meta($order->id, 'customer_name');
    }

    if ($field_id == 'customer_phone') {
        $customer['phone'] = $metabox->value;
        delete_post_meta($order->id, 'customer_phone');
    }

    if ($field_id == 'customer_phoneCode') {
        $customer['phoneCode'] = $metabox->value;
        delete_post_meta($order->id, 'customer_phoneCode');
    }

    if ($field_id == 'customer_address') {
        $customer['address'] = $metabox->value;
        delete_post_meta($order->id, 'customer_address');
    }

    $order->customer = $customer;
    $order->save();

    if ($field_id == 'status') :

        $new_status = sanitize_text_field($metabox->value);

        tikstore_change_order_status($order->id, $new_status);
    endif;
}
add_action('cmb2_save_field', 'tikstore_update_order', 10, 4);

function tikstore_handle_order_metabox($post_id)
{
    if (get_post_type($post_id) != 'tikstore-order') return;

    $shipping_tracking = isset($_POST['shipping_tracking']) ? sanitize_text_field($_POST['shipping_tracking']) : '';
    if ($shipping_tracking) {
        update_post_meta($post_id, 'shipping_tracking', $shipping_tracking);
    }
}
add_action('save_post', 'tikstore_handle_order_metabox');

function tikstore_change_order_status($order_id, $new_status)
{
    global $wpdb;

    delete_post_meta($order_id, 'status');

    $old_status = get_post_status($order_id);
    if ($old_status == $new_status) return;

    $wpdb->update(
        $wpdb->posts,
        array(
            'post_status' => sanitize_text_field($new_status)
        ),
        array(
            'ID' => intval($order_id)
        )
    );
    clean_post_cache($order_id);

    $order = new Tikstore\Order($order_id);
    tikstore_order_notification($order, $new_status);

    do_action('tikstore_order_change_status', $order->id, $old_status, $new_status);
}

function tikstore_create_order_api(WP_REST_Request $request)
{
    $params = $request->get_json_params();
    $items    = $params['items'];
    $customer = $params['customer'];
    $shipping = $params['shipping'];
    $payment  = $params['payment'];

    if (empty($items) || empty($customer) || empty($shipping) || empty($payment)) {
        return new WP_REST_Response([
            'success' => false,
            'items' => $items,
            'customer' => $customer,
            'shipping' => $shipping,
            'payment' => $payment
        ], 400);
    }

    $validated_items = [];
    foreach ($items as $item) {
        list($item_id, $color, $custom) = explode('|', $item['cart_id']);

        $price = tikstore_product_price(intval($item_id));
        $custom_variations = get_post_meta(intval($item_id), 'custom_variation', true);

        /**
         * validate item price
         */
        if ($custom && $custom_variations) {
            foreach ($custom_variations as $variation) {

                if (empty($variation['price'])) continue;

                if (tikstore_string_to_key($variation['name']) == $custom) {
                    $price = floatval($variation['price']);
                }
            }
        }

        $item['price'] = $price;

        $validated_items[] = $item;
    }

    $shipping_provider = get_theme_mod('_tikstore_shipping_provider', 'free');

    if ($shipping_provider == 'free' || $shipping_provider == '0') {
        $shipping['cost'] = 0;
    } else {
        $cost = tikstore_shipping()->validate_cost($shipping['id']);
        if ($cost && $cost > 0) {
            $shipping['cost'] = tikstore_shipping()->validate_cost($shipping['id']);
        }
    }

    $order = Tikstore\Order::create();
    $order->items = $validated_items;
    $order->customer = $customer;
    $order->shipping = $shipping;
    $order->payment = $payment;
    $order = $order->save();

    if ($payment['id'] == 'cod') {
        wp_update_post(array('ID' => $order->id, 'post_status' => 'on_hold'));
    }

    return new WP_REST_Response($order->name, 200);
}

add_action('rest_api_init', function () {
    register_rest_route('tikstore/v1', '/order', array(
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'tikstore_create_order_api',
        'args' => [
            'items' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_array($param);
                }
            ],
            'customer' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_array($param);
                }
            ],
            'shipping' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_array($param);
                }
            ],
            'payment' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_array($param);
                }
            ]
        ],
        'permission_callback' => function ($request) {
            return true;
        },
    ));
});

function tikstore_order_payment()
{
    global $wp, $order;
    if (is_admin()) return;

    if (isset($wp->query_vars['pagename']) && $wp->query_vars['pagename'] == 'thank') {
        $number = isset($_GET['number']) ? sanitize_title($_GET['number']) : '';
        $query = new WP_Query([
            'post_type'   => 'tikstore-order',
            'name'        => $number,
            'post_status' => 'any',
            'fields'      => 'ids',
            'numberposts' => 1
        ]);
        if ($query->found_posts == 0) {
            wp_redirect(site_url());
        }
        $order_id = isset($query->posts[0]) ? $query->posts[0] : 0;
        $order = new Tikstore\Order($order_id);
        if ($order->payment['id'] == 'cod') {
            tikstore_notification_sent_new_order_cod($order);
        } else {
            tikstore_notification_sent_new_order($order);
        }
    }
}
add_action('wp', 'tikstore_order_payment');
