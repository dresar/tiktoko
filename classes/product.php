<?php

namespace Tikstore;

/**
 * Product classes
 */
class Product
{
    const POST_TYPE = 'tikstore-product';

    const POST_TYPE_SLUG = 'product';

    const TAXONOMY_CATEGORY_TYPE = 'tikstore-product-category';

    const TAXONOMY_CATEGORY_SLUG = 'product-category';

    /**
     * register custom post type
     *
     * @return void
     */
    public function post_type(): void
    {
        \register_post_type(
            self::POST_TYPE,
            array(
                'labels' => array(
                    'name'               => __('Product', 'tikstore'),
                    'singular_name'      => __('Product', 'tikstore'),
                    'add_new'            => __('Add New', 'tikstore'),
                    'add_new_item'       => __('Add New Product', 'tikstore'),
                    'edit'               => __('Edit', 'tikstore'),
                    'edit_item'          => __('Edit Product', 'tikstore'),
                    'new_item'           => __('New Product', 'tikstore'),
                    'view'               => __('View Product', 'tikstore'),
                    'view_item'          => __('View Product', 'tikstore'),
                    'search_items'       => __('Search Product', 'tikstore'),
                    'not_found'          => __('No Products found', 'tikstore'),
                    'not_found_in_trash' => __('No Products found in Trash', 'tikstore')
                ),
                'public' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'supports' => array(
                    'title',
                    'editor',
                ),
                'can_export' => true,
                'menu_icon' => 'dashicons-products',
                'rewrite' =>  array(
                    'slug' => self::POST_TYPE_SLUG,
                    'width_front' => false
                )
            )
        );
    }

    /**
     * register taxonomy for product
     *
     * @return void
     */
    public function taxonomy(): void
    {
        \register_taxonomy(
            self::TAXONOMY_CATEGORY_TYPE,
            array(self::POST_TYPE),
            array(
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => _x('Categories', 'tikstore'),
                    'singular_name'     => _x('Category', 'tikstore'),
                    'search_items'      => __('Search Categories', 'tikstore'),
                    'all_items'         => __('All Categories', 'tikstore'),
                    'parent_item'       => __('Parent Category', 'tikstore'),
                    'parent_item_colon' => __('Parent Category:', 'tikstore'),
                    'edit_item'         => __('Edit Category', 'tikstore'),
                    'update_item'       => __('Update Category', 'tikstore'),
                    'add_new_item'      => __('Add New Category', 'tikstore'),
                    'new_item_name'     => __('New Category Name', 'tikstore'),
                    'menu_name'         => __('Categories', 'tikstore'),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => self::TAXONOMY_CATEGORY_SLUG),
            )
        );
    }

    public static function images_metabox()
    {
        $cmb = new_cmb2_box(array(
            'id'           => 'tikstore_product_images',
            'title'        => 'Images Gallery',
            'object_types' => [self::POST_TYPE],
        ));

        $cmb->add_field(array(
            'name' => 'Images',
            'desc' => '',
            'id'   => 'images',
            'type' => 'file_list',
            // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
            // 'query_args' => array( 'type' => 'image' ), // Only images attachment
            // Optional, override default text strings
            'text' => array(
                'add_upload_files_text' => 'Add or Upload Image',
                'remove_image_text' => "Remove Image",
                'file_text' => "File:",
                'file_download_text' => "Download",
                'remove_text' => "Remove"
            ),
            'attributes'  => array(
                'required'    => 'required',
            ),
        ));
    }

    public static function attributes_metabox()
    {
        $cmb = new_cmb2_box(array(
            'id'           => 'tikstore_product_attributes',
            'title'        => 'Attributes',
            'object_types' => [self::POST_TYPE],
        ));

        $cmb->add_field(array(
            'name' => 'Price',
            'desc' => __('Fill price without money format, Ex: 1000 for one thousand', 'tikstore'),
            'id'   => 'price',
            'type' => 'text_money',
            'before_field' => tikstore_currency(),
            'attributes'  => array(
                'required'    => 'required',
            ),
            'sanitization_cb' => function ($value, $field_args, $field) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '', $value);
                return $value;
            }
        ));

        $cmb->add_field(array(
            'name' => 'Price Strik',
            'desc' => __('Fill price without money format and must be higher from price', 'tikstore'),
            'id'   => 'price_strik',
            'type' => 'text_money',
            'before_field' => tikstore_currency(),
            'sanitization_cb' => function ($value, $field_args, $field) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '', $value);
                return $value;
            }
        ));

        $cmb->add_field(array(
            'name' => 'Promo Text',
            'id'   => 'promo_text',
            'type' => 'text',
            'repeatable' => true
        ));

        $cmb->add_field(array(
            'name' => 'Weight',
            'id'   => 'weight',
            'default' => 1000,
            'type' => 'text_small',
            'after_field' => 'gram',
            'attributes' => array(
                'type' => 'number',
                'min'  => '0',
            ),
        ));

        $cmb->add_field(array(
            'name' => 'Stock',
            'id'   => 'stock',
            'desc'        => __('Fill 0 if this product is out off stock', 'tikstore'),
            'type' => 'text_small',
            'attributes' => array(
                'type' => 'number',
                'min'  => '0',
            ),
        ));
    }

    public static function color_variation_metabox()
    {
        $cmb = new_cmb2_box(array(
            'id'           => 'tikstore_product_color_variation',
            'title'        => 'Color variation',
            'object_types' => [self::POST_TYPE],
        ));


        $cmb->add_field(array(
            'name' => 'Color name',
            'id'   => 'colors',
            'type' => 'text',
            'repeatable' => true,
            'attributes' => [
                'placeholder' => __('Blue, Red, or White', 'tikstore')
            ]
        ));
    }

    public static function custom_variation_metabox()
    {
        $cmb = new_cmb2_box(array(
            'id'           => 'tikstore_product_custom_variation',
            'title'        => 'Custom variation',
            'object_types' => [self::POST_TYPE]
        ));

        $cmb->add_field(array(
            'name' => 'Variation title',
            'id'   => 'custom_variation_title',
            'type' => 'text',
            'desc'        => __('Suitable for bundle or size variation', 'tikstore'),
            'attributes' => [
                'placeholder' => __('Size', 'tikstore')
            ]
        ));

        $group_id = $cmb->add_field(array(
            'desc' => '',
            'id'   => 'custom_variation',
            'type' => 'group',
            'repeatable' => true,
            'options'     => array(
                'group_title'       => __('Variation {#}', 'tikstore'), // since version 1.1.4, {#} gets replaced by row number
                'add_button'        => __('Add Another variation', 'tikstore'),
                'remove_button'     => __('Remove variation', 'tikstore'),
                'sortable'          => true,
                'remove_confirm' => esc_html__('Are you sure you want to remove?', 'tikstore'), // Performs confirmation before removing group.
            ),
        ));

        $cmb->add_group_field($group_id, array(
            'name' => 'Name',
            'id'   => 'name',
            'type' => 'text',
        ));

        $cmb->add_group_field($group_id, array(
            'name' => 'Custom price',
            'id'   => 'price',
            'type' => 'text_money',
            'desc'        => __('Empty this field if variation doesn\'t have a custom pricing', 'tikstore'),
            'before_field' => tikstore_currency(),
            'sanitization_cb' => function ($value, $field_args, $field) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '', $value);
                return $value;
            }
        ));
    }

    /**
     * product set custom column
     * @param  array $columns [description]
     * @return array          [description]
     */
    public static function column($columns)
    {

        $new_columns['cb']                                 = '<input type="checkbox"/>';
        $new_columns['product_title']                      = __('Title', 'tikstore');
        $new_columns['product_price']                      = __('Price', 'tikstore');
        $new_columns['product_weight']                     = __('Weight', 'tikstore');
        $new_columns['taxonomy-tikstore-product-category'] = __('Category', 'tikstore');
        $new_columns['product_action']                     = __('&nbsp;', 'tikstore');

        return $new_columns;
    }

    /**
     * product manage custom column
     * @param  string $column  [description]
     * @param  int $post_id [description]
     * @return string          [description]
     */
    public static function content_column($column, $post_id)
    {

        switch ($column):

            case 'product_title':
                echo '<div><span style="font-weight: bold">' . get_the_title($post_id) . '</span></div>';
                echo '<div>' . get_the_date('Y-m-d H:i:s', $post_id) . '</div>';
                break;

            case 'product_price':
                echo '<span>' . tikstore_product_formated_price($post_id) . '</span><br/>';
                echo '<span><del>( ' . tikstore_product_formated_price_strik($post_id) . ' )</del></span><br/>';
                break;

            case 'product_weight':
                $weight = get_post_meta($post_id, 'weight', true) ? get_post_meta($post_id, 'weight', true) : 1000;
                echo '<span>' . $weight . '</span> gram<br/>';
                break;

            case 'product_action':
                echo '<div style="text-align:right">';
                echo '<a href="' . get_edit_post_link($post_id) . '" class="button">Edit</a>&nbsp';
                echo '<a  target="_blank" href="' . get_the_permalink($post_id) . '" class="button">View</a>';
                echo '</div>';
                break;

        endswitch;
    }
}
