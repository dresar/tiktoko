<?php

function tikstore_shipping()
{
    if (get_theme_mod('_tikstore_shipping_provider', 'free') == '0') return null;

    $class = new Tikstore\Shippings\Rajaongkir();
    // if(tikstore_options('shipping_provider') == 'rajaongkir'){

    // }

    return $class;
}

function tikstore_save_shipping_origin_name($customizer)
{
    $origin_name = tikstore_shipping()->origin_name(true);
    if ($origin_name) {
        update_option('tikstore_shipping_origin_name', $origin_name);
    }
}
add_action('customize_save_after', 'tikstore_save_shipping_origin_name');

function tikstore_shipping_method_api(WP_REST_Request $request)
{
    $destination = $request->get_param('destination');
    $weight = $request->get_param('weight');
    try {
        $data = tikstore_shipping()->method($destination, $weight);

        return new WP_REST_Response($data, 200);
    } catch (\Exception $e) {
        return new WP_REST_Response([
            'message' => $e->getMessage()
        ], 404);
    }
}

add_action('rest_api_init', function () {
    register_rest_route('tikstore/v1', '/shipping/method', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'tikstore_shipping_method_api',
        'permission_callback' => function ($request) {
            return true;
        },
    ));
});

function tikstore_get_shipping_costs()
{
    global $wp;
    if (is_admin()) return;

    if (isset($wp->query_vars['pagename']) && $wp->query_vars['pagename'] == 'checkout') {
        try {
            $shippings = tikstore_shipping()->validate_cost('sicepat_2495-177-10_42-3-21|REG|3-6');
            __dd($shippings);
        } catch (\Exception $e) {
            __dd($e->getMessage());
        }
        exit;
    }
}
//add_action('wp', 'tikstore_get_shipping_costs');
