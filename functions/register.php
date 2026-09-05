<?php

/**
 * setup required plugin
 */
function tikstore_register_required_plugins()
{
    /*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
    $plugins = array(
        array(
            'name'      => 'CMB2',
            'slug'      => 'cmb2',
            'required'  => true,
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),
        array(
            'name'               => 'CMB2 Coditionals', // The plugin name.
            'slug'               => 'cmb2-conditionals', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/data/cmb2-conditionals.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),


    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     * 
     * 
     */
    $config = array(
        'id'           => 'tikstore',              // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'tikstore_register_required_plugins');

/**
 * register tikstore post type;
 *
 * @return void
 */
function tikstore_register_post_type(): void
{
    $status = get_option( 'tiktoko_license_key_status', false );
    if ( 'valid' == $status ) {
        $product = new \Tikstore\Product;
        $product->post_type();
        $product->taxonomy();

        Tikstore\Order::post_type();
    }
}
add_action('init', 'tikstore_register_post_type');

/**
 * register metabox fields
 *
 * @return void
 */
function tikstore_register_metabox(): void
{
    $status = get_option( 'tiktoko_license_key_status', false );
    if ( 'valid' == $status ) {
        $product = new \Tikstore\Product;
        $product->images_metabox();
        $product->attributes_metabox();
        $product->color_variation_metabox();
        $product->custom_variation_metabox();
    }
}
add_action('cmb2_admin_init', 'tikstore_register_metabox');

add_action('admin_menu', function () {
    remove_meta_box('submitdiv', 'tikstore-order', 'side');
});

function tikstore_order_metabox()
{
    $status = get_option( 'tiktoko_license_key_status', false );
    if ( 'valid' == $status ) {
        Tikstore\Order::status_metabox();
        Tikstore\Order::customer_metabox();
        Tikstore\Order::detail_metabox();
        Tikstore\Order::notification_metabox();
    }
}
add_action('cmb2_admin_init', 'tikstore_order_metabox');

add_filter('manage_tikstore-product_posts_columns', ['Tikstore\Product', 'column']);
add_action('manage_tikstore-product_posts_custom_column', ['Tikstore\Product', 'content_column'], 10, 2);

add_filter('manage_tikstore-order_posts_columns', ['Tikstore\Order', 'column']);
add_action('manage_tikstore-order_posts_custom_column', ['Tikstore\Order', 'content_column'], 10, 2);

/**
 * admin order footer script
 * @return [type] [description]
 */
function tikstore_order_admin_footer()
{
    $current_screen = get_current_screen();
    if ($current_screen->parent_file == 'edit.php?post_type=tikstore-order' || $current_screen->parent_file == 'edit.php?post_type=tikstore-product') :
?>
        <script>
            jQuery('.order_name .row-actions').hide();
            jQuery('.product_title .row-actions').hide();

            function resendNotification(button, id) {
                button.innerHTML = 'Sending ...';
                button.disabled = true;
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php '); ?>",
                    dataType: "json",
                    data: {
                        action: "resend_notification",
                        nonce: "<?php echo wp_create_nonce('tikstore'); ?>",
                        id: id,
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    },
                    complete: function(xhr, status) {
                        res = xhr.responseJSON;
                        if (res.status == 'success') {
                            button.innerHTML = 'Done';
                            alert('Message sent')
                        } else {
                            button.innerHTML = 'Resend';
                            button.disabled = false;
                            alert(res.message);
                        }
                    }
                });
            }
        </script>
<?php
    endif;
}
add_action('admin_footer', 'tikstore_order_admin_footer');
