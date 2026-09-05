<?php
function tikstore_encrypt($string, $length = 16)
{
    $secret_key = AUTH_KEY;
    $secret_iv = AUTH_SALT;

    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, $length);

    return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
}
function tikstore_decrypt($string, $length = 16)
{
    $secret_key = AUTH_KEY;
    $secret_iv = AUTH_SALT;

    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, $length);

    return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
}

function tikstore_marketplaces_links()
{
    $marketplaces = [];

    if (tikstore_options('marketplace_tokopedia')) {
        $marketplaces['tokopedia'] = [
            'label' => 'Tokopedia',
            'image' => TIKSTORE_URL . '/img/tokopedia-16.png',
            'link' => tikstore_options('marketplace_tokopedia_link')
        ];
    }

    if (tikstore_options('marketplace_shoppe')) {
        $marketplaces['shoppe'] = [
            'label' => 'Shoppe',
            'image' => TIKSTORE_URL . '/img/shoppe-16.png',
            'link' => tikstore_options('marketplace_shoppe_link')
        ];
    }

    if (tikstore_options('marketplace_bukalapak')) {
        $marketplaces['bukalapak'] = [
            'label' => 'Bukalapak',
            'image' => TIKSTORE_URL . '/img/bukalapak-16.png',
            'link' => tikstore_options('marketplace_bukalapak_link')
        ];
    }

    if (tikstore_options('marketplace_tiktok')) {
        $marketplaces['tiktok'] = [
            'label' => 'Tiktok',
            'image' => TIKSTORE_URL . '/img/tiktok-16.png',
            'link' => tikstore_options('marketplace_tiktok_link')
        ];
    }

    return apply_filters('tikstore_marketplaces_links', $marketplaces);
}

/**
 * get product thumbnail url
 *
 * @param  int $product_id
 * @return string
 */
function tiktstore_product_thumbnail_url($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;

    $galleries = get_post_meta($product_id, 'images', true);
    if (empty($galleries) || !is_array($galleries)) return '';

    $thumbnail = '';
    foreach ($galleries as $attacment_id => $url) {
        $type = wp_check_filetype($url);
        if (in_array($type['ext'], ['png', 'jpg', 'jpeg', 'webp', 'svg'])) {

            /**
             * handle if site url not match
             */
            $url = explode('/wp-content', $url);
            $thumbnail = site_url() . '/wp-content' . $url[1];
            break;
        }
    }
    return $thumbnail;
}

/**
 * get product thumbnail url
 *
 * @param  int $product_id
 * @return array
 */
function tiktstore_product_images($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;

    $images = get_post_meta($product_id, 'images', true);
    if (empty($images) || !is_array($images)) return '';

    $images_url = [];
    foreach ($images as $attacment_id => $url) {
        $file = wp_check_filetype($url);
        if (in_array($file['ext'], ['png', 'jpg', 'jpeg', 'webp', 'svg'])) {

            /**
             * handle if site url not match
             */
            $url = explode('/wp-content', $url);
            $file['source'] = site_url() . '/wp-content' . $url[1];
            $images_url[$attacment_id] = $file;
        }
    }
    return $images_url;
}

/**
 * get currency symbol
 *
 * @return string
 */
function tikstore_currency()
{
    $currency_symbol = tikstore_options('currency_symbol');

    if ($currency_symbol) {
        return $currency_symbol;
    }

    return tikstore_options('currency');
}

/**
 * get footer widget payments
 *
 * @return array
 */
function tikstore_footer_widget_payments()
{
    $payment_icons = [];

    $payments = [
        'bca'         => 'Bca',
        'bni'         => 'Bni',
        'bri'         => 'Bri',
        'bsi'         => 'Bsi',
        'cimbniaga'   => 'CIMB Niaga',
        'mandiri'     => 'Mandiri',
        'permatabank' => 'Permata Bank',
        'seabank'     => 'Sea Bank',
        'spay'        => 'Shoppe Pay'
    ];

    foreach ($payments as $key => $label) {
        if (tikstore_options('footer_widget_payment_' . $key)) {
            $payment_icons[] = TIKSTORE_URL . '/img/payments/' . $key . '.png';
        }
    }

    return apply_filters('tikstore_footer_widget_payments', $payment_icons);
}

/**
 * get footer widget shippings
 *
 * @return array
 */
function tikstore_footer_widget_shippings()
{
    $shipping_icons = [];

    $shippings = [
        'anteraja'      => 'Anteraja',
        'gosend'        => 'Go send',
        'grabexpress'   => 'Grab Express',
        'idexpress'     => 'ID Express',
        'j&t'           => 'J&T Express',
        'j&tcargo'      => 'J&T Cargo',
        'jne'           => 'JNE',
        'ninjaexpress'  => 'Ninja Express',
        'shoppeexpress' => 'Shoppe Express',
        'sicepat'       => 'Sicepat'
    ];

    foreach ($shippings as $key => $label) {
        if (tikstore_options('footer_widget_shipping_' . $key)) {
            $shipping_icons[] = TIKSTORE_URL . '/img/shippings/' . $key . '.png';
        }
    }

    return apply_filters('tikstore_footer_widget_shippings', $shipping_icons);
}

/**
 * get prodcut price
 *
 * @param  int|bool $product_id
 * @return string
 */
function tikstore_product_price($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;
    return floatval(get_post_meta($product_id, 'price', true));
}

/**
 * get money formated product price
 *
 * @param  int|bool $product_id
 * @return string
 */
function tikstore_product_formated_price($product_id = false): string
{
    $price = tikstore_product_price($product_id);
    $currency = tikstore_currency();
    $formated_price = apply_filters('tikstore_product_formated_price', tikstore_money($price, false));

    return $currency . $formated_price;
}

function tikstore_money($amount, $with_currency_symbol = true)
{
    $formated = number_format($amount, 0, '.', ',');
    $currency = tikstore_currency();

    if ($with_currency_symbol == false) {
        return $formated;
    }

    return $currency . $formated;
}

/**
 * get product striked price
 *
 * @param  int|bool $product_id
 * @return string
 */
function tikstore_product_price_strik($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;
    return floatval(get_post_meta($product_id, 'price_strik', true));
}

/**
 * get formated product stricker price
 *
 * @param  int|bool $product_id
 * @return string
 */
function tikstore_product_formated_price_strik($product_id = false)
{
    $price = tikstore_product_price_strik($product_id);
    if (empty($price)) return '';
    $currency = tikstore_currency();
    $formated_price = apply_filters('tikstore_product_formated_price_strik', tikstore_money($price, false));

    return $currency . $formated_price;
}

/**
 * get product promo text
 *
 * @param  int|bool $product_id
 * @return mixed
 */
function tikstore_product_promo_text($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;
    return get_post_meta($product_id, 'promo_text', true);
}

function tikstore_product_custom_variations($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;
    $custom_variations = get_post_meta($product_id, 'custom_variation', true);

    if (empty($custom_variations) || !is_array($custom_variations)) return [];

    $variations = [];
    foreach ($custom_variations as $variation) {
        if ($variation['price']) {
            $variations[$variation['name']] = $variation['price'];
        } else {
            $variations[$variation['name']] = tikstore_product_price($product_id);
        }
    }

    return $variations;
}

/**
 * convert array to json
 *
 * @param  array $data
 * @param  bool $echo
 * @return string
 */
function tikstore_json($data, $echo = true)
{
    $json = json_encode((object)$data);
    $json = htmlentities2($json, ENT_QUOTES);

    if (false == $echo) return $json;

    echo $json;
}

function tikstore_string_to_key($string)
{
    if (empty($string)) return false;

    $string = str_replace(' ', '-', $string);
    $string = strtolower($string);

    return $string;
}


/**
 * json data of product
 * used for cart
 *
 * @param int|bool $product_id
 * @return string
 */
function tikstore_product_json_data($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;
    $product = get_post($product_id);

    if (empty($product)) return '';

    $color_variations  = get_post_meta($product_id, 'colors', true);
    $color_variant     = isset($color_variations[0]) ? $color_variations[0] : '';
    $custom_variations = get_post_meta($product_id, 'custom_variation', true);
    $custom_variant    = isset($custom_variations[0]['name']) ? $custom_variations[0]['name'] : '';
    $cart_id           = $product->ID . '|' . tikstore_string_to_key($color_variant) . '|' . tikstore_string_to_key($custom_variant);
    $custom_variant_price = isset($custom_variations[0]['price']) && $custom_variations[0]['price'] ? floatval($custom_variations[0]['price']) : 0;

    $data = [
        'cart_id'              => $cart_id,
        'id'                   => $product->ID,
        'title'                => $product->post_title,
        'thumbnail'            => tiktstore_product_thumbnail_url($product_id),
        'quantity'             => 1,
        'price'                => $custom_variant_price > 0 ? $custom_variant_price : tikstore_product_price($product_id),
        'price_strik'          => tikstore_product_price_strik($product_id),
        'color_variant'        => $color_variant,
        'custom_variant_title' => get_post_meta($product_id, 'custom_variation_title', true),
        'custom_variant'       => $custom_variant,
        'stock'                => intval(get_post_meta($product_id, 'stock', true)),
        'weight'               => get_post_meta($product_id, 'weight', true) ? intval(get_post_meta($product_id, 'weight', true)) : 1000,
        'is_checked'           => true
    ];

    return tikstore_json($data, false);
}

/**
 * make image on content lazyload
 * @param  [type] $img [description]
 * @return [type]      [description]
 */
function tikstore_content_img($img)
{

    //preg_match_all('/(\w+)=["\']([a-zA-Z0-9-\/_.:\'"]+)["\']/', $img_tag, $matches, PREG_SET_ORDER, 0);

    $img_tag = isset($img[0]) ? $img[0] : '';

    if (!$img_tag) return $img_tag;

    preg_match('/x-src="/', $img_tag, $match);
    if (empty($match)) {
        $img_tag = str_replace(' src="', ' x-src="', $img_tag);
    }

    return $img_tag;
}

/**
 * make iframe on content lazyload
 * @param  [type] $iframe [description]
 * @return [type]         [description]
 */
function tikstore_content_iframe($iframe)
{
    $iframe_tag = isset($iframe[0]) ? $iframe[0] : '';

    if (empty($iframe_tag)) return $iframe_tag;

    $src   = isset($iframe[1]) ? $iframe[1] : '';

    preg_match('/youtu/', $src, $match);
    if ($match) {
        $parts = parse_url($src);
        if (isset($parts['path'])) {
            $path = explode('/', trim($parts['path'], '/'));
            $youtube_id = $path[count($path) - 1];

            $iframe_tag = str_replace('></iframe>', ' poster="https://i3.ytimg.com/vi/' . $youtube_id . '/hqdefault.jpg"></iframe>', $iframe_tag);
        }
    }

    preg_match('/x-src="/', $iframe_tag, $match);
    if (empty($match)) {
        $iframe_tag = str_replace(' src="', ' x-src="', $iframe_tag);
    }
    return $iframe_tag;
}

/**
 * modify content output
 * @param  string $content [description]
 * @return string          [description]
 */
function tikstore_the_content($content)
{

    if (is_feed() || is_search() || is_archive()) {
        return $content;
    }


    $img_pattern = '/<img\s+[^>]*>/si';

    $iframe_pattern = '/<iframe.*?s*src="(.*?)".*?<\/iframe>/si';

    $content = preg_replace_callback($img_pattern, 'tikstore_content_img', $content);

    $content = preg_replace_callback($iframe_pattern, 'tikstore_content_iframe', $content);

    return $content;
}
add_filter('the_content', 'tikstore_the_content', 9999);

function tikstore_is_cart_page()
{
    global $post;

    if (empty($post)) return false;

    if ($post->post_name == 'cart' && $post->post_type == "page") return true;

    return false;
}

function tikstore_is_checkout_page()
{
    global $post;

    if (empty($post)) return false;

    if ($post->post_name == 'checkout' && $post->post_type == "page") return true;

    return false;
}

function tikstore_is_thank_page()
{
    global $post;

    if (empty($post)) return false;

    if ($post->post_name == 'thank' && $post->post_type == "page") return true;

    return false;
}


/**
 * get single random admin whatsapp number
 * @return string
 */
function tikstore_get_admin_phone()
{

    $phone = get_theme_mod('_tikstore_notification_admin_phones');
    if (empty($phone)) return '';

    $phones = explode(',', $phone);
    $key = array_rand($phones, 1);

    $wa = isset($phones[$key]) ? $phones[$key] : '';
    $wa = preg_replace('/[^0-9]/', '', $wa);
    $wa = preg_replace('/^620/', '62', $wa);
    $wa = preg_replace('/^0/', '62', $wa);

    return $wa;
}

/**
 * get whatsapp link bot on mobile and desktop device
 * @return string
 */
function tikstore_get_link_wa_admin()
{
    $link_wa = 'https://web.whatsapp.com/send';
    if (wp_is_mobile()) {
        $link_wa = 'whatsapp://send';
    }

    return $link_wa . '?phone=' . tikstore_get_admin_phone();
}

function __tikstore()
{
    return new Tikstore\License();
}

if (!function_exists('pagination')) :

    function pagination($paged = '', $max_page = '')
    {
        $big = 999999999; // need an unlikely integer
        if (!$paged) {
            $paged = get_query_var('paged');
        }

        if (!$max_page) {
            global $wp_query;
            $max_page = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        }

        return paginate_links(array(
            'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'     => '?paged=%#%',
            'current'    => max(1, $paged),
            'total'      => $max_page,
            'mid_size'   => 1,
            'prev_text'  => __('«'),
            'next_text'  => __('»'),
            'type'       => 'array'
        ));
    }
endif;

function tikstore_heading_on()
{
    if (is_front_page()) return true;

    if (is_page_template(['page-blog.php']) ||  is_page() && get_post(get_the_ID())->post_name == 'blog') return true;

    if (is_post_type_archive(['tikstore-product'])) return true;

    return apply_filters('tikstore_heading_on', false);
}


function tikstore_on_plugins_updated()
{
    __tikstore()->periodic_check();
}

add_action('wp_update_plugins', 'tikstore_on_plugins_updated');


function t()
{
    global $wp;
    __dd($wp);
    exit;
}
//add_action('wp', 't');
