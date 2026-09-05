<?php

/**
 * modify homepage and search post query
 * @param  [type] $query [description]
 * @return [type]        [description]
 */
function tikstore_query_product_for_homepage($query)
{
    global $wp;

    if ('nav_menu_item' == $query->get('post_type')) return;

    if (is_home()) {

        if (tikstore_options('homepage') == 'product') {
            $query->set('post_type', 'tikstore-product');
        } elseif (tikstore_options('homepage') == 'blog') {
            $query->set('post_type', 'post');
        }
    }
}
add_action('pre_get_posts', 'tikstore_query_product_for_homepage', 10);

/**
 * caching related products expired every 6 hours for fast loading
 */
function tikstore_set_product_related_cache()
{

    global $related_products;

    if ('tikstore-product' != get_post_type()) return;

    if (get_post_meta(get_the_ID(), '_product_related_cache_expired', true) < strtotime('now')) :

        $args = array(
            'post__not_in'        => array(get_the_ID()),
            'posts_per_page'      => 12,
            'ignore_sticky_posts' => 1,
            'post_type'           => 'tikstore-product',
            'post_status'    => 'publish',
        );

        $categories = get_the_terms(get_the_ID(), 'tikstore-product-category');

        if ($categories) :
            $category_ids = array();
            foreach ($categories as $category) :
                $category_ids[] = $category->term_id;
            endforeach;

            if ($category_ids) :
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'tikstore-product-category',
                        'field' => 'term_id',
                        'terms' => $category_ids,
                    )
                );
            endif;
        endif;

        $query = new WP_Query($args);
        if ($query->have_posts()) {
            update_post_meta(get_the_ID(), '_product_related_cache', $query);
            update_post_meta(get_the_ID(), '_product_related_cache_expired', strtotime('+6 hours'));
        }

    endif;

    $related_products = get_post_meta(get_the_ID(), '_product_related_cache', true);
}
add_action('wp', 'tikstore_set_product_related_cache');

function tikstore_clear_related_product($post_id)
{
    global $related_products;

    if ('tikstore-product' != get_post_type($post_id)) return;

    delete_post_meta(get_the_ID(), '_product_related_cache');
    delete_post_meta(get_the_ID(), '_product_related_cache_expired');

    $related_products = '';
}
add_action('save_post', 'tikstore_clear_related_product', 10, 1);

function tikstore_product_related($product_id = false)
{
    $product_id = false === $product_id ? get_the_ID() : $product_id;
    $query = get_post_meta($product_id, '_product_related_cache', true);

    if ($query instanceof WP_Query) {
        return $query;
    }

    return null;
}
