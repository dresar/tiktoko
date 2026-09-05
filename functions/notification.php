<?php

function tikstore_notification()
{
    $class = new Tikstore\Notifications\Responic();
    // if(tikstore_options('notification_provider') == 'responic'){

    // }

    return $class;
}

function tikstore_notification_replace_shortcode($message, $order)
{
    $args = [
        'order_number'      => $order->title,
        'customer_name'     => $order->customer['name'],
        'customer_phone'    => $order->phone,
        'items'             => $order->items,
        'customer_address'  => $order->customer['address'] . $order->customer['subdistrict']['name'],
        'shipping'          => $order->shipping['name'] . '(' . $order->shipping['service'] . ')',
        'summary'           => $order->summary,
        'payment'           => $order->payment()->action_wa(),
        'shipping_tracking' => get_post_meta($order->id, 'shipping_tracking', true),
        'total'             => tikstore_money($order->total),
    ];

    preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $message, $matches);

    foreach ($matches[1] as $key => $tag) {
        if (isset($args[$tag])) {
            $value = $args[$tag];
            if ($tag == 'items') {
                $value = '';
                $number = 1;
                foreach ($args['items'] as $item) {
                    $subtotal = intval($item['quantity']) * floatval($item['price']);
                    $value .= $number . '. _' . $item['title'] . '_' . PHP_EOL;
                    if ($item['color_variant']) {
                        $value .= '   ```' . sprintf(__('Color: %s'), $item['color_variant']) . '```' . PHP_EOL;
                    }
                    if ($item['custom_variant']) {
                        $value .= '   ```' . $item['custom_variant_title'] . ': ' . $item['custom_variant'] . '```' . PHP_EOL;
                    }
                    $value .= '   (' . $item['quantity'] . ') x @' . tikstore_money($item['price']) . ' = *' . tikstore_money($subtotal) . '*' . PHP_EOL . PHP_EOL;
                    $number++;
                }
            }

            if ($tag == 'summary') {
                $value = '';
                foreach ($args['summary'] as $summary) {
                    if ($summary['operation'] == '-') {
                        $value .= '_' . $summary['label'] . '_' . ': -' . tikstore_money($summary['value']) . PHP_EOL;
                    } else {
                        $value .= '_' . $summary['label'] . '_' . ': ' . tikstore_money($summary['value']) . PHP_EOL;
                    }
                }
                $value .= '_Total_: *' . tikstore_money($order->total) . '*' . PHP_EOL;
            }
            $message = str_replace('[' . $tag . ']', $value, $message);
        }
    }

    return $message;
}


function tikstore_notification_sent_new_order($order)
{
    global $wpdb;

    if ($order->status !== 'new_order') return;

    $table = $wpdb->prefix . 'tikstore_notification';
    $notification = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE event = %s AND order_id = %d", 'new_order', $order->id));

    if ($notification) {
        if ($notification->status_code == 200) return;

        $result = tikstore_notification()->sent($order->phone, $notification->message);
        $wpdb->update($table, [
            'status_code'  => $result['code'],
            'status_value' => maybe_serialize($result['value'])
        ], [
            'ID' => $notification->ID
        ]);
    } else {
        $message = get_theme_mod('_tikstore_notification_new_order_message', tikstore_notification()->default_message('new_order'));
        $message = tikstore_notification_replace_shortcode($message, $order);
        $result = tikstore_notification()->sent($order->phone, $message);
        $wpdb->insert($table, [
            'event'        => 'new_order',
            'order_id'     => $order->id,
            'message'      => $message,
            'status_code'  => $result['code'],
            'status_value' => maybe_serialize($result['value'])
        ]);
    }

    return $result;
}
function tikstore_notification_sent_new_order_cod($order)
{
    global $wpdb;

    if ($order->status !== 'on_hold') return;

    $table = $wpdb->prefix . 'tikstore_notification';
    $notification = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE event = %s AND order_id = %d", 'new_order', $order->id));

    if ($notification) {
        if ($notification->status_code == 200) return;

        $result = tikstore_notification()->sent($order->phone, $notification->message);
        $wpdb->update($table, [
            'status_code'  => $result['code'],
            'status_value' => maybe_serialize($result['value'])
        ], [
            'ID' => $notification->ID
        ]);
    } else {
        $message = get_theme_mod('_tikstore_notification_new_order_cod_message', tikstore_notification()->default_message('new_order_cod'));
        $message = tikstore_notification_replace_shortcode($message, $order);
        $result = tikstore_notification()->sent($order->phone, $message);
        $wpdb->insert($table, [
            'event'        => 'new_order',
            'order_id'     => $order->id,
            'message'      => $message,
            'status_code'  => $result['code'],
            'status_value' => maybe_serialize($result['value'])
        ]);
    }

    return $result;
}

function tikstore_order_notification($order, $event)
{
    global $wpdb;

    if ($order->status != $event) return;

    $table = $wpdb->prefix . 'tikstore_notification';
    $notification = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE event = %s AND order_id = %d", $event, $order->id));

    if ($notification) {
        if ($notification->status_code == 200) return;

        $result = tikstore_notification()->sent($order->phone, $notification->message);
        $wpdb->update($table, [
            'status_code'  => $result['code'],
            'status_value' => maybe_serialize($result['value'])
        ], [
            'ID' => $notification->ID
        ]);
    } else {
        $message = get_theme_mod('_tikstore_notification_' . $event . '_message', tikstore_notification()->default_message($event));
        $message = tikstore_notification_replace_shortcode($message, $order);
        $result = tikstore_notification()->sent($order->phone, $message);
        $wpdb->insert($table, [
            'event'        => $event,
            'order_id'     => $order->id,
            'message'      => $message,
            'status_code'  => $result['code'],
            'status_value' => maybe_serialize($result['value'])
        ]);
    }

    return $result;
}

add_action('wp_ajax_resend_notification', 'tikstore_ajax_resend_notification');
function tikstore_ajax_resend_notification()
{
    global $wpdb;
    $table = $wpdb->prefix . 'tikstore_notification';

    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    $notification_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if (isset($nonce)  && wp_verify_nonce($nonce, 'tikstore')) {

        $notification = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE ID = %d", $notification_id));

        if ($notification) {
            $order = new Tikstore\Order($notification->order_id);
            $result = tikstore_notification()->sent($order->phone, $notification->message);
            if ($result['code'] == 200) {
                echo json_encode(
                    [
                        'status' => 'success',
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'status' => 'error',
                        'message' => isset($result['value']['message']) ? $result['value']['message'] : json_encode($result['value'])
                    ]
                );
            }

            $wpdb->update($table, [
                'status_code'  => $result['code'],
                'status_value' => maybe_serialize($result['value'])
            ], [
                'ID' => $notification->ID
            ]);
            exit;
        }

        echo json_encode(['status' => 'error', 'message' => 'Notification not found']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Nonce failed']);
    exit;
}
