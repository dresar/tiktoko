<?php

namespace Core;

defined('ABSPATH') || exit;

/**
 * Yano Config.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Yano_Config
{

    /**
     * Register third party libraries.
     *
     * @since 1.0.0
     */
    public function register_enqueue()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue']);
    }


    /**
     * Equeue styles and scripts.
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        // editor
        if (function_exists('wp_enqueue_editor')) {
            wp_enqueue_editor();
        }

        // media
        if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }

        // CSS
        wp_enqueue_style('yano-control-ui-style', tikstore_yano_resource_url() . 'assets/css/control-ui.css');

        // JS
        wp_enqueue_script('yano-helper', tikstore_yano_resource_url() . 'assets/js/helper.js', array('jquery'), '1.0', true);
        wp_enqueue_script('yano-control', tikstore_yano_resource_url() . 'assets/js/control.js', array('jquery'), '1.0', true);
    }
}
