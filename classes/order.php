<?php

namespace Tikstore;

/**
 * Order classes
 */
class Order
{
    const POST_TYPE = 'tikstore-order';

    private $meta_keys = [
        'customer',
        'items',
        'shipping',
        'payment'
    ];

    public $id = 0;

    public $title;

    public $name;

    public $weight = 0;

    public $total = 0;

    public $summary = [];

    public $status = 'new_order';

    public $phone;

    public $date;

    /**
     * __construct
     *
     * @param  int $order_id
     * @return void
     */
    public function __construct($order_id = 0)
    {
        $this->_populate($order_id);
    }

    private function _populate($order_id)
    {
        $post = get_post($order_id);
        if ($post && $post->post_type == 'tikstore-order') {
            $this->id     = $post->ID;
            $this->title  = $post->post_title;
            $this->name   = $post->post_name;
            $this->status = $post->post_status;
            $this->date = $post->post_date;

            $subtotal = 0;
            foreach ((array)$this->items as $item) {
                if (isset($item['price'])) {
                    $subtotal += floatval($item['price']) * intval($item['quantity']);
                }

                $weight = isset($item['weight']) ? floatval($item['weight']) : 1000;
                $this->weight += $weight * intval($item['quantity']);
            }

            $shipping = $this->shipping;

            $this->summary = [
                [
                    'label' => 'Sub Total',
                    'value' => $subtotal,
                    'operation' => '+'
                ],
                [
                    'label' => __('Shipping', 'tikstore'),
                    'value' => isset($shipping['cost']) ? $shipping['cost'] : 0,
                    'operation' => '+'
                ]
            ];

            $total = 0;
            foreach ((array)$this->summary as $summary) {
                if ($summary['operation'] == '-') {
                    $total = $total - floatval($summary['value']);
                } else {
                    $total = $total + floatval($summary['value']);
                }
            }

            $this->total = $total;

            if (isset($this->customer['phoneCode']) && isset($this->customer['phone'])) {
                $phone = $this->customer['phoneCode'] . $this->customer['phone'];
                $this->phone = str_replace('+', '', $phone);
            }
        }
    }

    /**
     * getter
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array($name, $this->meta_keys)) {
            $value = maybe_unserialize(get_post_meta($this->id, $name, true));
            if ($name == 'items' && empty($value)) {
                return [];
            }

            if ($name == 'customer' && empty($value)) {
                return [
                    'name' => ''
                ];
            }

            return $value;
        }

        return NULL;
    }

    /**
     * setter
     *
     * @param  string $name
     * @return void
     */
    public function __set($name, $value)
    {
        $this->$name = maybe_serialize($value);
    }

    public function save()
    {
        if ($this->id === 0) {
            $order = self::create();
            if (is_wp_error($order)) {
                return $order;
            }
            $order_id = $order->id;
        } else {
            $order_id = $this->id;
        }

        foreach ($this->meta_keys as $meta_name) {
            update_post_meta($order_id, $meta_name, $this->$meta_name);
        }

        return $this;
    }

    public function payment()
    {
        return tikstore_payment_method($this->payment['id']);
    }

    /**
     * register custom post type
     *
     * @return void
     */
    public static function post_type(): void
    {
        \register_post_type(
            self::POST_TYPE,
            array(
                'labels' => array(
                    'name'               => __('Order', 'tikstore'),
                    'singular_name'      => __('Order', 'tikstore'),
                    'add_new'            => __('Add New', 'tikstore'),
                    'add_new_item'       => __('Add New order', 'tikstore'),
                    'edit'               => __('Edit', 'tikstore'),
                    'edit_item'          => __('Edit order', 'tikstore'),
                    'new_item'           => __('New order', 'tikstore'),
                    'view'               => __('View order', 'tikstore'),
                    'view_item'          => __('View order', 'tikstore'),
                    'search_items'       => __('Search order', 'tikstore'),
                    'not_found'          => __('No orders found', 'tikstore'),
                    'not_found_in_trash' => __('No orders found in Trash', 'tikstore')
                ),
                'public' => false,
                'show_ui' => true,
                'publicly_queryable' => false,
                'exclude_from_search' => true,
                'hierarchical' => false,
                'has_archive' => false,
                'supports' => array(
                    'title',
                ),
                'can_export' => false,
                'capability_type' => 'post',
                'capabilities' => array(
                    //'create_posts' => false,
                ),
                'menu_icon' => 'dashicons-cart',
            )
        );

        register_post_status('new_order', array(
            'label'                     => _x('New Order', 'post status label', 'tikstore'),
            'public'                    => true,
            'label_count'               => _n_noop('New Order <span class="count">(%s)</span>', 'New Order <span class="count">(%s)</span>', 'tikstore'),
            'post_type'                 => [self::POST_TYPE], // Define one or more post types the status can be applied to.
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-yes',
        ));

        register_post_status('on_hold', array(
            'label'                     => _x('On Hold', 'post status label', 'tikstore'),
            'public'                    => true,
            'label_count'               => _n_noop('On Hold <span class="count">(%s)</span>', 'On Hold <span class="count">(%s)</span>', 'tikstore'),
            'post_type'                 => [self::POST_TYPE], // Define one or more post types the status can be applied to.
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-dismiss',
        ));

        register_post_status('on_shipping', array(
            'label'                     => _x('On Shipping', 'post status label', 'tikstore'),
            'public'                    => true,
            'label_count'               => _n_noop('On Shipping <span class="count">(%s)</span>', 'On Shipping <span class="count">(%s)</span>', 'tikstore'),
            'post_type'                 => [self::POST_TYPE], // Define one or more post types the status can be applied to.
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-dismiss',
        ));

        register_post_status('completed', array(
            'label'                     => _x('Completed', 'post status label', 'tikstore'),
            'public'                    => true,
            'label_count'               => _n_noop('Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>', 'tikstore'),
            'post_type'                 => [self::POST_TYPE], // Define one or more post types the status can be applied to.
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-businessman',
        ));

        register_post_status('canceled', array(
            'label'                     => _x('Canceled', 'post status label', 'tikstore'),
            'public'                    => true,
            'label_count'               => _n_noop('Canceled <span class="count">(%s)</span>', 'Canceled <span class="count">(%s)</span>', 'tikstore'),
            'post_type'                 => [self::POST_TYPE], // Define one or more post types the status can be applied to.
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-businessman',
        ));

        register_post_status('refunded', array(
            'label'                     => _x('Refunded', 'post status label', 'tikstore'),
            'public'                    => true,
            'label_count'               => _n_noop('Refunded <span class="count">(%s)</span>', 'Refunded <span class="count">(%s)</span>', 'tikstore'),
            'post_type'                 => [self::POST_TYPE], // Define one or more post types the status can be applied to.
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-businessman',
        ));
    }

    public static function create()
    {
        $order_number = intval(get_option('tikstore_order_number', 0)) + 1;

        $format = tikstore_options('order_invoice_format');
        $format = str_replace('{year}', date('Y'), $format);
        $format = str_replace('{month}', date('m'), $format);
        $format = str_replace('{date}', date('d'), $format);
        $order_number_format = str_replace('{number}', $order_number, $format);

        $args = [
            'post_type' => self::POST_TYPE,
            'post_title' => $order_number_format,
            'post_status' => 'new_order'
        ];
        $order_id = wp_insert_post($args);

        if (is_wp_error($order_id)) {
            return $order_id;
        }

        update_option('tikstore_order_number', $order_number);

        return new self($order_id);
    }

    public static function status_metabox()
    {
        $post_id = null;
        if (isset($_GET['post'])) {
            $post_id = $_GET['post'];
        } else if (isset($_POST['post_ID'])) {
            $post_id = $_POST['post_ID'];
        }

        if (null == $post_id) return;
        if (get_post_type($post_id) != 'tikstore-order') return;

        $order = new self($post_id);


        /**
         * Sample metabox to demonstrate each field type included
         */
        $cmb = new_cmb2_box(array(
            'id'            => 'tikstore_order_status_metabox',
            'title'         => esc_html__('Status', 'tikstore'),
            'object_types'  => array('tikstore-order'),
            'context'    => 'side',
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Status', 'tikstore'),
            'desc'       => '',
            'id'         => 'status',
            'type'       => 'select',
            'default' => $order->status,
            'options' => array(
                'new_order'   => 'New Order',
                'on_hold'     => 'On Hold',
                'on_shipping' => 'On Shipping',
                'completed'   => 'Completed',
                'canceled'   => 'Canceled',
                'refunded'    => 'Refunded',
            ),
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Shipping tracking number', 'tikstore'),
            'desc'       => '',
            'id'         => 'shipping_tracking',
            'type'       => 'text',
            'attributes' => array(
                'data-conditional-id'    => 'status',
                'data-conditional-value' => 'on_shipping',
            ),
        ));

        $cmb->add_field(array(
            'name'       => '<button type="submit" style="width: 100%;" class="button button-primary button-hero">' . __('Update order') . '</button>',
            'desc'       => '',
            'id'         => 'submit',
            'type'       => 'title',
        ));
    }

    public static function customer_metabox()
    {
        global $wp_filesystem;

        $post_id = null;
        if (isset($_GET['post'])) {
            $post_id = $_GET['post'];
        } else if (isset($_POST['post_ID'])) {
            $post_id = $_POST['post_ID'];
        }

        if (null == $post_id) return;

        if (get_post_type($post_id) != 'tikstore-order') return;

        $order = new self($post_id);

        $file_url  = TIKSTORE_URL . '/data/phone-codes.json';
        $file_path = TIKSTORE_PATH . '/data/phone-codes.json';

        try {
            require_once ABSPATH . 'wp-admin/includes/file.php';

            if (is_null($wp_filesystem)) {
                WP_Filesystem();
            }

            if (!$wp_filesystem instanceof \WP_Filesystem_Base || (is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code())) {
                throw new \Exception('WordPress Filesystem Abstraction classes is not available', 1);
            }

            if (!$wp_filesystem->exists($file_path)) {
                throw new \Exception('JSON file is not exists or unreadable', 1);
            }

            $json = $wp_filesystem->get_contents($file_path);
        } catch (\Exception $e) {
            // Get JSON data by HTTP if the WP_Filesystem API procedure failed.
            $json = wp_remote_retrieve_body(wp_remote_get(esc_url_raw($file_url)));
        }

        $data = json_decode($json, true);

        $phoneCodes = [];

        foreach ($data as $phoneCode) {
            $phoneCodes[$phoneCode['dial_code']] = $phoneCode['dial_code'] . ' (' . $phoneCode['code'] . ')';
        }

        /**
         * customer detail order metabox
         */
        $cmb = new_cmb2_box(array(
            'id'            => 'tikstore_order_customer_metabox',
            'title'         => esc_html__('Customer', 'tikstore'),
            'object_types'  => array('tikstore-order'),
            //'context'    => 'side',
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Name', 'tikstore'),
            'desc'       => '',
            'id'         => 'customer_name',
            'type'       => 'text',
            'default' => $order->customer['name']
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Phone Code', 'tikstore'),
            'desc'       => '',
            'id'         => 'customer_phoneCode',
            'type'       => 'select',
            'options' => $phoneCodes,
            'default' => $order->customer['phoneCode']
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Phone', 'tikstore'),
            'desc'       => '',
            'id'         => 'customer_phone',
            'type'       => 'text',
            'default' => $order->customer['phone']
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Address', 'tikstore'),
            'desc'       => '',
            'id'         => 'customer_address',
            'type'       => 'textarea_small',
            'default' => $order->customer['address']
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Subdistrict', 'tikstore'),
            'desc'       => '',
            'id'         => 'subdistrict_name',
            'type'       => 'text',
            'default' => $order->customer['subdistrict']['name'],
            'attributes' => [
                'readonly' => true,
                'style' => 'width: 100%'
            ]
        ));

        // $phone = get_post_meta($post_id, 'customer_phone', true);
        // $phone = preg_replace('/[^0-9]/', '', $phone);
        // $phone = preg_replace('/^620/', '62', $phone);
        // $phone = preg_replace('/^0/', '62', $phone);

        // $cmb->add_field(array(
        //     'name'       => '<button type="button" style="width: 100%;" class="button button-primary" onclick="customerFollowUp(\'' . $phone . '\');"> Follow Up</button>',
        //     'desc'       => '',
        //     'id'         => 'submit',
        //     'type'       => 'title',
        // ));
    }

    public static function notification_metabox()
    {
        global $wpdb;

        $table = $wpdb->prefix . 'tikstore_notification';

        $post_id = null;
        if (isset($_GET['post'])) {
            $post_id = $_GET['post'];
        } else if (isset($_POST['post_ID'])) {
            $post_id = $_POST['post_ID'];
        }

        if (null == $post_id) return;

        if (get_post_type($post_id) != 'tikstore-order') return;

        $order = new self($post_id);



        /**
         * customer detail order metabox
         */
        $cmb = new_cmb2_box(array(
            'id'            => 'tikstore_order_notification_metabox',
            'title'         => esc_html__('Notification', 'tikstore'),
            'object_types'  => array('tikstore-order'),
            'context'    => 'side',
        ));

        $notifications = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE order_id = %d", $post_id));



        // $phone = get_post_meta($post_id, 'customer_phone', true);
        // $phone = preg_replace('/[^0-9]/', '', $phone);
        // $phone = preg_replace('/^620/', '62', $phone);
        // $phone = preg_replace('/^0/', '62', $phone);

        if ($notifications) {
            foreach ($notifications as $notif) {
                $status_value = maybe_unserialize($notif->status_value);
                if ($notif->status_code == 200) {
                    $text = __('Sent', 'tikstore') . ': <span style="color: green">success</span>';
                } else {
                    $error_message = isset($status_value['message']) && is_string($status_value['message']) ? $status_value['message'] : json_encode($status_value);
                    $text = '<div>' . __('Status', 'tikstore') . ':  <span style="color: red">error</span></div>';
                    $text .= '<div>Message: ' . $error_message . '</div>';
                    $text .= '<button type="button" style="width: 100%;" class="button button-primary" onclick="resendNotification(this, \'' . $notif->ID . '\');">Resend</button>';
                }
                $cmb->add_field(array(
                    'name'       => $notif->event . ' Notification',
                    'desc'       => $text,
                    'id'         => sanitize_title($notif->event . ' Notification'),
                    'type'       => 'title',
                ));
            }
        } else {
            $cmb->add_field(array(
                'name'       => __('No notifications found', 'tikstore'),
                'desc'       => '',
                'id'         => 'submit',
                'type'       => 'title',
            ));
        }
    }


    public static function detail_metabox()
    {
        $post_id = null;
        if (isset($_GET['post'])) {
            $post_id = $_GET['post'];
        } else if (isset($_POST['post_ID'])) {
            $post_id = $_POST['post_ID'];
        }

        if (null == $post_id) return;

        if (get_post_type($post_id) != 'tikstore-order') return;

        $order = new self($post_id);

        ob_start();
?>
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Produk</th>
                    <th style=" width: 50px;">Qty</th>
                    <th style="text-align: right;">Weight (@)</th>
                    <th style="text-align: right;">Harga (@)</th>
                    <th style="text-align: right">Sub Total</th>
                </tr>
                </tehad>
            <tbody>
                <?php foreach ((array)$order->items as $item) : ?>
                    <?php
                    $weight = isset($item['weight']) ? $item['weight'] : 1000;
                    ?>
                    <tr>
                        <td style="width: 40%;"><a target="_blank" href="<?php echo get_edit_post_link($item['id']); ?>"><?php echo $item['title']; ?></a></td>
                        <td style="width: 50px"><?php echo $item['quantity']; ?></td>
                        <td style="text-align: right"><?php echo $weight; ?> gram</td>
                        <td style="text-align: right"><?php echo tikstore_money($item['price']); ?></td>
                        <td style="text-align: right">
                            <?php
                            $subtotal = floatval($item['price']) * intval($item['quantity']);
                            echo tikstore_money($subtotal);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?php
        $d = ob_get_contents();
        ob_end_clean();

        $cmb = new_cmb2_box(array(
            'id'            => 'tikstore_order_detail_metabox',
            'title'         => esc_html__('Detail', 'tikstore'),
            'object_types'  => array('tikstore-order'),
        ));

        $cmb->add_field(array(
            'name'       => '<p style="width: 100%;display:block">' . $d . '</p>',
            'desc'       => '',
            'id'         => 'items',
            'type'       => 'title',
            'save_field' => false,
        ));

        // $cmb->add_field(array(
        //     'name'       => esc_html__('Catatan untuk penjual', 'tikstore'),
        //     'desc'       => '',
        //     'id'         => 'customer_note',
        //     'type'       => 'textarea',
        //     'save_field' => false,
        //     'attributes' => array(
        //         'readonly' => 'readonly',
        //     ),
        // ));

        foreach ($order->summary as $summary) {
            $cmb->add_field(array(
                'name'       => $summary['label'],
                'desc'       => '',
                'id'         => 'summary_' . sanitize_title($summary['label']),
                'type'       => 'text_money',
                'save_field' => false,
                'attributes' => array(
                    'readonly' => 'readonly',
                ),
                'before_field' => tikstore_currency(),
                'default' => tikstore_money($summary['value'], false),
            ));
        }

        $cmb->add_field(array(
            'name'       => esc_html__('Total', 'tikstore'),
            'desc'       => '',
            'id'         => 'total',
            'type'       => 'text_money',
            'save_field' => false,
            'attributes' => array(
                'readonly' => 'readonly',
            ),
            'before_field' => tikstore_currency(),
            'default' => tikstore_money($order->total, false),
            'escape_cb' => 'tikstore_metabox_number_format',
        ));

        $cmb->add_field(array(
            'name' => 'Total Weight',
            'id'   => 'weight',
            'default' => $order->weight,
            'type' => 'text_small',
            'after_field' => 'gram',
            'save_field' => false,
            'attributes' => array(
                'type' => 'number',
                'min'  => '0',
                'readonly' => 'readonly',
            ),
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Shipping Method', 'tikstore'),
            'desc'       => '',
            'id'         => 'shipping_method',
            'type'       => 'text',
            'save_field' => false,
            'attributes' => array(
                'readonly' => 'readonly',
            ),
            'default' => $order->shipping['name'],
        ));

        $cmb->add_field(array(
            'name'       => esc_html__('Payment Method', 'tikstore'),
            'desc'       => '',
            'id'         => 'payment_method',
            'type'       => 'text',
            'save_field' => false,
            'attributes' => array(
                'readonly' => 'readonly',
            ),
            'default' => $order->payment['name'],
        ));
    }

    /**
     * order set custom column
     * @param  array $columns [description]
     * @return array          [description]
     */
    public static function column($columns)
    {

        $new_columns['cb'] = '<input type="checkbox"/>';
        $new_columns['order_name'] = __('Title', 'tikstore');
        $new_columns['order_item'] = __('Items', 'tikstore');
        $new_columns['order_customer'] = __('Customer', 'tikstore');
        $new_columns['order_total'] = __('Total', 'tikstore');
        $new_columns['order_shipping'] = __('Shipping', 'tikstore');
        $new_columns['order_payment'] = __('Payment', 'tikstore');
        //$new_columns['order_followup'] = __('Follow Up', 'tikstore');
        $new_columns['order_action'] = __('&nbsp;', 'tikstore');

        return $new_columns;
    }

    /**
     * order manage custom column
     * @param  string $column  [description]
     * @param  int $post_id [description]
     * @return string          [description]
     */
    public static function content_column($column, $post_id)
    {

        $phone = get_post_meta($post_id, 'phone', true);

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^620/', '62', $phone);
        $phone = preg_replace('/^0/', '62', $phone);

        $order = new self($post_id);

        switch ($column):

            case 'order_name':
                echo '<div><span style="font-weight: bold">' . get_the_title($post_id) . '</span></div>';
                echo '<div>' . get_the_date('Y-m-d H:i:s', $post_id) . '</div>';
                break;

            case 'order_item':
                foreach ($order->items as $item) {
                    $link = get_the_permalink($item['id']);
                    echo '<div><a href="' . $link . '" target="__blank">- ' . $item['title'] . '</a></div>';
                }
                break;

            case 'order_customer':
                echo '<span>' . $order->customer['name'] . '</span><br/>';
                echo '<span>( ' . $order->phone . ' )</span><br/>';
                break;

            case 'order_total':
                echo '<span>' . tikstore_money($order->total) . '</span><br/>';
                break;

            case 'order_shipping':
                $shipping = $order->shipping;
                $shipping_name = isset($shipping['name']) ? $shipping['name'] : '';
                echo '<div>' . $shipping_name . '</div>';
                break;

            case 'order_payment':
                $payment = $order->payment;
                $payment_name = isset($payment['name']) ? $payment['name'] : '';
                echo '<div>' . $payment_name . '</div>';
                break;

            case 'order_followup':
                echo '<button type="button" class="button button-primary" onclick="customerFollowUp(\'' . $phone . '\');">Follow Up</button>';
                break;

            case 'order_action':
                $statuse = get_post_status($post_id);
                $statuses = array(
                    'new_order'   => 'New Order',
                    'on_hold'     => 'On Hold',
                    'on_shipping' => 'On Shipping',
                    'completed'   => 'Completed',
                    'refunded'    => 'Refunded',
                    'canceled'   => 'Canceled',
                );

                $statuse = isset($statuses[$statuse]) ? $statuse : 'new_order';
                $status = isset($statuses[$statuse]) ? $statuses[$statuse] : 'New Order';
                echo '<div class="order-status-' . $statuse . '">' . $status . '</div>';
                echo '<div style="text-align:right">';
                echo '<a href="' . get_edit_post_link($post_id) . '" class="button">View Order</a>&nbsp';
                //echo '<a href="'.get_delete_post_link( $post_id ).'" class="button">Delete</a>';
                echo '</div>';
                break;

        endswitch;
    }
}
