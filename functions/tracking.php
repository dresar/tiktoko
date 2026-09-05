<?php

function tikstore_facebook_pixel_ids()
{
    $counts = [1, 2, 3, 4, 5];
    $ids = [];
    foreach ($counts as $count) {
        $id = get_theme_mod('_tikstore_tracking_fbpixel_' . $count);
        if ($id) {
            $ids[] = $id;
        }
    }

    return $ids;
}

function tikstore_tiktok_pixel_ids()
{
    $counts = [1, 2, 3, 4, 5];
    $ids = [];
    foreach ($counts as $count) {
        $id = get_theme_mod('_tikstore_tracking_tiktokpixel_' . $count);
        if ($id) {
            $ids[] = $id;
        }
    }

    return $ids;
}

function tikstore_show_facebook_pixel_tracking()
{
    if (empty(tikstore_facebook_pixel_ids())) return false;

    if (is_home() && false == get_theme_mod('_tikstore_tracking_fbpixel_on_home', true)) return false;

    if (tikstore_is_cart_page() && false == get_theme_mod('_tikstore_tracking_fbpixel_on_cart', true)) return false;

    if (tikstore_is_checkout_page() && false == get_theme_mod('_tikstore_tracking_fbpixel_on_chekcout', true)) return false;

    if (tikstore_is_thank_page() && false == get_theme_mod('_tikstore_tracking_fbpixel_on_thank', true)) return false;

    if (is_singular('post') && false == get_theme_mod('_tikstore_tracking_fbpixel_on_post', true)) return false;

    if (is_singular('page') && false == get_theme_mod('_tikstore_tracking_fbpixel_on_page', true)) return false;

    if (is_singular('tikstore-product') && false == get_theme_mod('_tikstore_tracking_fbpixel_on_product', true)) return false;

    ob_start();
    get_template_part('template-parts/tracking-facebook-pixel');
    $code = ob_get_clean();
    echo $code;
}
add_action('wp_head', 'tikstore_show_facebook_pixel_tracking');


function tikstore_show_tiktok_pixel_tracking()
{
    if (empty(tikstore_facebook_pixel_ids())) return false;

    if (is_home() && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_home', true)) return false;

    if (tikstore_is_cart_page() && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_cart', true)) return false;

    if (tikstore_is_checkout_page() && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_chekcout', true)) return false;

    if (tikstore_is_thank_page() && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_thank', true)) return false;

    if (is_singular('post') && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_post', true)) return false;

    if (is_singular('page') && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_page', true)) return false;

    if (is_singular('tikstore-product') && false == get_theme_mod('_tikstore_tracking_tiktokpixel_on_product', true)) return false;

    ob_start();
    get_template_part('template-parts/tracking-tiktok-pixel');
    $code = ob_get_clean();
    echo $code;
}
add_action('wp_head', 'tikstore_show_tiktok_pixel_tracking');
