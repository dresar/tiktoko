<?php

namespace Tikstore\Notifications;

use Yano;

class Responic extends Base
{
    private $token;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->token = get_theme_mod('_tikstore_responic_token');
    }

    /**
     * format receiven phone number
     *
     * @param  string $to
     * @return void
     */
    private function format_receiver($phone)
    {
        $phone_to_check = str_replace('-', '', $phone);
        $phone_to_check = preg_replace('/[^0-9]/', '', $phone_to_check);
        $phone_to_check = preg_replace('/^620/', '62', $phone_to_check);
        $phone_to_check = preg_replace('/^0/', '62', $phone_to_check);

        return $phone_to_check;
    }

    private function format_message($message, $args)
    {
        $message = $message;
        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $message, $matches);

        foreach ($matches[1] as $key => $tag) {
            if (isset($args[$tag])) {
                $value = $args[$tag];


                $message = str_replace('[' . $tag . ']', $value, $message);
            }
        }

        return $message;
    }

    public function sent($receiver, $message)
    {
        global $wpdb;

        $receiver = $this->format_receiver($receiver);

        $response = wp_remote_post('https://panel.responic.com/api/message', [
            'body' => wp_json_encode([
                'receiver' => $receiver,
                'message' => [
                    'text' => $message
                ]
            ]),
            'headers'   => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);

        if (is_wp_error($response)) {
            error_log('Failed to send notification: ' . $response->get_error_message());
            return [
                'code' => 400,
                'value' => [
                    'message' => $response->get_error_message(),
                ]
            ];
        }

        return [
            'code' => (int) wp_remote_retrieve_response_code($response),
            'value' => json_decode(wp_remote_retrieve_body($response), true),
        ];
    }

    /**
     * default_message
     *
     * @param  string $event
     * @param  bool $admin
     * @return mixed
     */
    public function default_message($event, $admin = false)
    {
        $default = new ResponicDefaultMessage();

        if ($admin === false) {
            if ($event == 'new_order') {
                return $default->customer_new_order();
            }

            if ($event == 'new_order_cod') {
                return $default->customer_new_order_cod();
            }

            if ($event == 'on_hold') {
                return $default->customer_on_hold();
            }

            if ($event == 'on_shipping') {
                return $default->customer_on_shipping();
            }

            if ($event == 'completed') {
                return $default->customer_completed();
            }

            if ($event == 'canceled') {
                return $default->customer_canceled();
            }

            if ($event == 'refunded') {
                return $default->customer_refunded();
            }
        }

        if ($event == 'new_order') {
            return $default->admin_new_order();
        }

        return '';
    }

    public static function customizer()
    {
        Yano::field('text', [
            'id'            => '_tikstore_responic_token',
            'label'         => __('Api token', 'tikstore'),
            'description'   => __('Responic api token', 'tikstore'),
            'section'       => 'section_notification_general',
            'priority'      => 3,
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_notification_provider') == 'responic') {
                    return true;
                } else {
                    return false;
                }
            }
        ]);
    }
}
