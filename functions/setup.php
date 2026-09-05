<?php

/**
 * remove unused resource
 * @var [type]
 */
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

remove_action('wp_head', 'rest_output_link_wp_head', 10);

// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

add_filter('xmlrpc_enabled', '__return_false');

/**
 * Theme setup.
 */
function tikstore_setup()
{
    add_theme_support('title-tag');

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'tikstore'),
        )
    );

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    load_theme_textdomain('tikstore', get_template_directory() . '/languages');

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');

    add_theme_support('editor-styles');
    add_editor_style('css/editor-style.css');

    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'tikstore_setup');



/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tikstore_nav_menu_add_li_class($classes, $item, $args, $depth)
{
    if (isset($args->li_class)) {
        $classes[] = $args->li_class;
    }

    if (isset($args->{"li_class_$depth"})) {
        $classes[] = $args->{"li_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'tikstore_nav_menu_add_li_class', 10, 4);

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The curren item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tikstore_nav_menu_add_submenu_class($classes, $args, $depth)
{
    if (isset($args->submenu_class)) {
        $classes[] = $args->submenu_class;
    }

    if (isset($args->{"submenu_class_$depth"})) {
        $classes[] = $args->{"submenu_class_$depth"};
    }

    return $classes;
}

add_filter('nav_menu_submenu_css_class', 'tikstore_nav_menu_add_submenu_class', 10, 3);

function tikstore_body_class($classes, $class)
{
    if (current_user_can('administrator')) {
        //$class[] = 'pt-8';
    }
    return $class;
}
//add_filter('body_class', 'tikstore_body_class', 10, 2);

function tikstore_create_cart_page()
{
    $args = array(
        'name'        => 'cart',
        'post_type'   => 'page',
        'numberposts' => 1,
        'post_status' => 'any'
    );
    $posts = get_posts($args);

    if (empty($posts)) {
        $post_id = wp_insert_post([
            'post_title'   => 'Cart',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'cart'
        ]);

        return $post_id;
    }

    $post = $posts[0];

    wp_update_post([
        'ID' => $post->ID,
        'post_status' => 'publish',
        'post_type' => 'page'
    ]);

    return $post->ID;
}
function tikstore_create_checkout_page()
{
    $args = array(
        'name'        => 'checkout',
        'post_type'   => 'page',
        'numberposts' => 1,
        'post_status' => 'any'
    );
    $posts = get_posts($args);

    if (empty($posts)) {
        $post_id = wp_insert_post([
            'post_title'   => 'Checkout',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'checkout'
        ]);

        return $post_id;
    }

    $post = $posts[0];

    wp_update_post([
        'ID' => $post->ID,
        'post_status' => 'publish',
        'post_type' => 'page'
    ]);

    return $post->ID;
}

function tikstore_create_thank_page()
{
    $args = array(
        'post_name'   => 'thank',
        'post_type'   => 'page',
        'numberposts' => 1,
        'post_status' => 'any'
    );
    $posts = get_posts($args);

    if (empty($posts)) {
        $post_id = wp_insert_post([
            'post_title'   => 'Thank',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'thank'
        ]);

        return $post_id;
    }

    $post = $posts[0];

    wp_update_post([
        'ID' => $post->ID,
        'post_status' => 'publish',
        'post_type' => 'page'
    ]);

    return $post->ID;
}

function tikstore_create_blog_page()
{
    $args = array(
        'post_name'   => 'blog',
        'post_type'   => 'page',
        'numberposts' => 1,
        'post_status' => 'any'
    );
    $posts = get_posts($args);

    if (empty($posts)) {
        $post_id = wp_insert_post([
            'post_title'   => 'Blog',
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_name'    => 'blog'
        ]);

        return $post_id;
    }

    $post = $posts[0];

    wp_update_post([
        'ID' => $post->ID,
        'post_status' => 'publish',
        'post_type' => 'page'
    ]);

    return $post->ID;
}

function tikstore_create_shipping_cost_table()
{
    global $wpdb;

    $table = $wpdb->prefix . 'tikstore_shipping_cost';
    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
          ID bigint NOT NULL AUTO_INCREMENT,
          name varchar(255) NOT NULL,
          data longtext NULL,
          created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
          updated_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
          PRIMARY KEY (ID)
        )";
    $wpdb->query($sql);
}

function tikstore_create_notification_table()
{
    global $wpdb;

    $table = $wpdb->prefix . 'tikstore_notification';
    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
          ID bigint NOT NULL AUTO_INCREMENT,
          event varchar(255) NOT NULL,
          order_id int(11) NULL,
          message longtext NULL,
          status_code int(3) NULL,
          status_value longtext NULL,
          sent_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
          PRIMARY KEY (ID)
        )";
    $wpdb->query($sql);
}


function tikstore_on_theme_activate_event(string $old_name, WP_Theme $old_theme)
{
    tikstore_create_cart_page();
    tikstore_create_checkout_page();
    tikstore_create_thank_page();
    tikstore_create_blog_page();
    tikstore_create_shipping_cost_table();
    tikstore_create_notification_table();
}
add_action('after_switch_theme', 'tikstore_on_theme_activate_event', 10, 2);

function tikstore_base()
{
    $data = [
        'site' => site_url(),
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wp_rest'),
        'message' => [
            'cart' => [
                'item' => [
                    'added' => __('Added to cart', 'tikstore'),
                    'deleted' => __('Item deleted', 'tikstore')
                ]
            ],
            'confirmation' => [
                'cancel' => __('Cancel', 'tikstore'),
                'confirm' => __('Yes, delete', 'tikstore'),
                'subject' => __('Are yu sure?', 'tikstore')
            ],
            'input' => [
                'error' => __('Complete this filed', 'tikstore')
            ],
            'shipping' => [
                'label' => __('Shipping', 'tikstore'),
                'empty' => __('Please select a shipping method first', 'tikstore')
            ],
            'payment' => [
                'empty' => __('Please select a payment method first', 'tikstore')
            ]
        ],
        'label' => [
            'shipping' => [
                'free' => [
                    'title' => __('Free shipping', 'tikstore'),
                ]
            ]
        ],
        'shipping' => [
            'provider' => get_theme_mod('_tikstore_shipping_provider', 'free') == '0' ? 0 : get_theme_mod('_tikstore_shipping_provider', 'free'),
        ],
        'rajaongkir' => [
            'source' => [
                'subdistrict' => TIKSTORE_URL . '/data/rajaongkir-subdistrict.json'
            ]
        ]
    ];

    return json_encode($data);
}

add_filter('next_posts_link_attributes', 'tikstore_next_posts_link');
function tikstore_next_posts_link()
{
    return 'class="next"';
}

add_filter('previous_posts_link_attributes', 'tikstore_prev_posts_link');
function tikstore_prev_posts_link()
{
    return 'class="prev"';
}


function tikstore_menu()
{
    add_menu_page(
        __('Tiktoko', 'tikstore'),
        __('Tiktoko', 'tikstore'),
        'manage_options',
        'tikstore',
        ['Tikstore\License', 'page'],
        false,
        6
    );
}
// add_action('admin_menu', 'tikstore_menu');

function tikstore_ajax_activate_license()
{

    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if (isset($nonce)  && wp_verify_nonce($nonce, 'tikstore')) {

        $code = isset($_POST['code']) ? sanitize_text_field($_POST['code']) : 0;

        $licence = new Tikstore\License();
        $licence->code = $code;
        $licence->activate();

        echo json_encode(['status' => 'success', 'message' => 'License activated']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Nonce failed']);
    exit;
}
add_action('wp_ajax_tikstore_activate_license', 'tikstore_ajax_activate_license');

function tikstore_ajax_deactivate_license()
{

    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if (isset($nonce)  && wp_verify_nonce($nonce, 'tikstore')) {

        $code = isset($_POST['code']) ? sanitize_text_field($_POST['code']) : 0;

        $licence = new Tikstore\License();
        $licence->deactivate();

        echo json_encode(['status' => 'success', 'message' => 'License deactivated']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Nonce failed']);
    exit;
}
add_action('wp_ajax_tikstore_deactivate_license', 'tikstore_ajax_deactivate_license');
