<?php

/**
 * Enqueue theme assets.
 */
function tikstore_enqueue_scripts()
{
    $status = get_option( 'tiktoko_license_key_status', false );
    if ( 'valid' == $status ) {
        $theme = wp_get_theme();

        wp_enqueue_style('tikstore', tikstore_asset('css/app.css'), array(), $theme->get('Version'));
        wp_enqueue_script('tikstore', tikstore_asset('js/app.js'), array(), $theme->get('Version'), true);
    }
}

add_action('wp_enqueue_scripts', 'tikstore_enqueue_scripts');

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tikstore_asset($path)
{
    if (!in_array(wp_get_environment_type(), ['local', 'development', 'dev'])) {
        return get_stylesheet_directory_uri() . '/' . $path;
    }

    return add_query_arg('time', time(),  get_stylesheet_directory_uri() . '/' . $path);
}

add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

function special_nav_class($classes, $item)
{
    $classes[] = 'py-3 px-3 border-b border-gray-100';
    return $classes;
}
