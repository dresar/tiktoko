<?php

namespace Tikstore;

use Yano;
use Tikstore\Shippings\Rajaongkir;
use Tikstore\Shippings\Free;
use Tikstore\Notifications\Responic;

class Customizer
{
    protected $prefix = '_tikstore_';

    protected function defaults()
    {
        return apply_filters('tikstore_default_options', [
            'custom_logo'                                     => TIKSTORE_URL . '/img/logo.png',
            '_tikstore_homepage' => 'product',
            '_tikstore_currency'                              => 'IDR',
            '_tikstore_currency_symbol'                       => 'Rp',
            '_tikstore_order_invoice_format' => '#Order/{year}/{month}/{date}/{number}',
            '_tikstore_marketplace_tokopedia'                 => true,
            '_tikstore_marketplace_tokopedia_link'            => '',
            '_tikstore_marketplace_shoppe'                    => true,
            '_tikstore_marketplace_shoppe_link'               => '',
            '_tikstore_marketplace_bukalapak'                 => true,
            '_tikstore_marketplace_bukalapak_link'            => '',
            '_tikstore_marketplace_tiktok'                    => true,
            '_tikstore_marketplace_tiktok_link'               => '',
            '_tikstore_notification_provider' => 'responic',
            '_tikstore_footer_widget_payment_bca'            => true,
            '_tikstore_footer_widget_payment_bni'            => true,
            '_tikstore_footer_widget_payment_bri'            => true,
            '_tikstore_footer_widget_payment_bsi'            => true,
            '_tikstore_footer_widget_payment_cimbniaga'      => true,
            '_tikstore_footer_widget_payment_mandiri'        => true,
            '_tikstore_footer_widget_payment_permatabank'    => true,
            '_tikstore_footer_widget_payment_seabank'        => true,
            '_tikstore_footer_widget_payment_spay'           => true,
            '_tikstore_footer_widget_shipping_anteraja'      => true,
            '_tikstore_footer_widget_shipping_gosend'        => true,
            '_tikstore_footer_widget_shipping_grabexpress'   => true,
            '_tikstore_footer_widget_shipping_idexpress'     => true,
            '_tikstore_footer_widget_shipping_j&t'           => true,
            '_tikstore_footer_widget_shipping_j&tcargo'      => true,
            '_tikstore_footer_widget_shipping_jne'           => true,
            '_tikstore_footer_widget_shipping_ninjaexpress'  => true,
            '_tikstore_footer_widget_shipping_shoppeexpress' => true,
            '_tikstore_footer_widget_shipping_sicepat'       => true,
            '_tikstore_shipping_provider' => 'rajaongkir',
        ]);
    }

    /**
     * Init
     *
     * @since 1.0.0
     * @access public
     */
    public static function init()
    {
        $self = new self;
        Yano::panel('panel_general', [
            'title'       => __('General', 'tikstore'),
            'description' => __('Generaal Option', 'tikstore'),
            'priority'    => 30
        ]);

        Yano::panel('panel_shipping', [
            'title'       => __('Shipping', 'tikstore'),
            'description' => __('Shipping option', 'tikstore'),
            'priority'    => 31
        ]);

        Yano::panel('panel_payment_method', [
            'title'       => __('Payment Method', 'tikstore'),
            'description' => __('Payment method option', 'tikstore'),
            'priority'    => 32
        ]);

        Yano::panel('panel_notification', [
            'title'       => __('Notification', 'tikstore'),
            'description' => __('Notification option', 'tikstore'),
            'priority'    => 33
        ]);

        Yano::panel('panel_tracking', [
            'title'       => __('Tracking', 'tikstore'),
            'description' => __('Tracking option', 'tikstore'),
            'priority'    => 50
        ]);

        Yano::panel('panel_footer', [
            'title'       => __('Footer', 'tikstore'),
            'description' => __('Footer Option', 'tikstore'),
            'priority'    => 100
        ]);

        $self->general_homepage();
        $self->general_currency();
        $self->general_order();
        $self->general_marketplace();
        $self->shipping_general();
        $payment_methods = tikstore_payment_methods();

        foreach ($payment_methods as $method) {
            $method->customizer();
        }

        $self->notification_general();
        Responic::customizer();
        $self->notification_new_order();
        $self->notification_on_hold();
        $self->notification_on_shipping();
        $self->notification_completed();
        $self->notification_canceled();
        $self->notification_refunded();

        $self->tracking_fb_pixel();
        $self->tracking_tiktok_pixel();

        $self->footer_widget_payments();
        $self->footer_widget_shippings();

        do_action('tikstore_customizer_control');
    }

    /**
     * currency section
     *
     * @return void
     */
    public function general_homepage()
    {

        // section
        Yano::section('section_general_homepage', [
            'title'       => 'Homepage',
            'description' => 'Homepage Setting',
            'priority'    => 1,
            'panel'       => 'panel_general'
        ]);

        Yano::field('radio', [
            'id'           => '_tikstore_homepage',
            'label'        => 'Select Homepage',
            'section'      => 'section_general_homepage',
            'default'      => $this->default('_tikstore_homepage'),
            'priority'     => 1,
            'choices'      => apply_filters('tikstore_homepage_query', [
                'product' => 'Product',
                'blog' => 'Blog'
            ])
        ]);
    }

    /**
     * currency section
     *
     * @return void
     */
    public function general_currency()
    {

        // section
        Yano::section('section_general_currency', [
            'title'       => 'Currency',
            'description' => 'Currency Setting',
            'priority'    => 1,
            'panel'       => 'panel_general'
        ]);

        Yano::field('select', [
            'id'           => '_tikstore_currency',
            'label'        => 'Select currency',
            'section'      => 'section_general_currency',
            'default'      => $this->default('_tikstore_currency'),
            'priority'     => 1,
            'choices'      => array(
                'ALL' => 'Albania Lek',
                'AFN' => 'Afghanistan Afghani',
                'ARS' => 'Argentina Peso',
                'AWG' => 'Aruba Guilder',
                'AUD' => 'Australia Dollar',
                'AZN' => 'Azerbaijan New Manat',
                'BSD' => 'Bahamas Dollar',
                'BBD' => 'Barbados Dollar',
                'BDT' => 'Bangladeshi taka',
                'BYR' => 'Belarus Ruble',
                'BZD' => 'Belize Dollar',
                'BMD' => 'Bermuda Dollar',
                'BOB' => 'Bolivia Boliviano',
                'BAM' => 'Bosnia and Herzegovina Convertible Marka',
                'BWP' => 'Botswana Pula',
                'BGN' => 'Bulgaria Lev',
                'BRL' => 'Brazil Real',
                'BND' => 'Brunei Darussalam Dollar',
                'KHR' => 'Cambodia Riel',
                'CAD' => 'Canada Dollar',
                'KYD' => 'Cayman Islands Dollar',
                'CLP' => 'Chile Peso',
                'CNY' => 'China Yuan Renminbi',
                'COP' => 'Colombia Peso',
                'CRC' => 'Costa Rica Colon',
                'HRK' => 'Croatia Kuna',
                'CUP' => 'Cuba Peso',
                'CZK' => 'Czech Republic Koruna',
                'DKK' => 'Denmark Krone',
                'DOP' => 'Dominican Republic Peso',
                'XCD' => 'East Caribbean Dollar',
                'EGP' => 'Egypt Pound',
                'SVC' => 'El Salvador Colon',
                'EEK' => 'Estonia Kroon',
                'EUR' => 'Euro Member Countries',
                'FKP' => 'Falkland Islands (Malvinas) Pound',
                'FJD' => 'Fiji Dollar',
                'GHC' => 'Ghana Cedis',
                'GIP' => 'Gibraltar Pound',
                'GTQ' => 'Guatemala Quetzal',
                'GGP' => 'Guernsey Pound',
                'GYD' => 'Guyana Dollar',
                'HNL' => 'Honduras Lempira',
                'HKD' => 'Hong Kong Dollar',
                'HUF' => 'Hungary Forint',
                'ISK' => 'Iceland Krona',
                'INR' => 'India Rupee',
                'IDR' => 'Indonesia Rupiah',
                'IRR' => 'Iran Rial',
                'IMP' => 'Isle of Man Pound',
                'ILS' => 'Israel Shekel',
                'JMD' => 'Jamaica Dollar',
                'JPY' => 'Japan Yen',
                'JEP' => 'Jersey Pound',
                'KZT' => 'Kazakhstan Tenge',
                'KPW' => 'Korea (North) Won',
                'KRW' => 'Korea (South) Won',
                'KGS' => 'Kyrgyzstan Som',
                'LAK' => 'Laos Kip',
                'LVL' => 'Latvia Lat',
                'LBP' => 'Lebanon Pound',
                'LRD' => 'Liberia Dollar',
                'LTL' => 'Lithuania Litas',
                'MKD' => 'Macedonia Denar',
                'MYR' => 'Malaysia Ringgit',
                'MUR' => 'Mauritius Rupee',
                'MXN' => 'Mexico Peso',
                'MNT' => 'Mongolia Tughrik',
                'MZN' => 'Mozambique Metical',
                'NAD' => 'Namibia Dollar',
                'NPR' => 'Nepal Rupee',
                'ANG' => 'Netherlands Antilles Guilder',
                'NZD' => 'New Zealand Dollar',
                'NIO' => 'Nicaragua Cordoba',
                'NGN' => 'Nigeria Naira',
                'NOK' => 'Norway Krone',
                'OMR' => 'Oman Rial',
                'PKR' => 'Pakistan Rupee',
                'PAB' => 'Panama Balboa',
                'PYG' => 'Paraguay Guarani',
                'PEN' => 'Peru Nuevo Sol',
                'PHP' => 'Philippines Peso',
                'PLN' => 'Poland Zloty',
                'QAR' => 'Qatar Riyal',
                'RON' => 'Romania New Leu',
                'RUB' => 'Russia Ruble',
                'SHP' => 'Saint Helena Pound',
                'SAR' => 'Saudi Arabia Riyal',
                'RSD' => 'Serbia Dinar',
                'SCR' => 'Seychelles Rupee',
                'SGD' => 'Singapore Dollar',
                'SBD' => 'Solomon Islands Dollar',
                'SOS' => 'Somalia Shilling',
                'ZAR' => 'South Africa Rand',
                'LKR' => 'Sri Lanka Rupee',
                'SEK' => 'Sweden Krona',
                'CHF' => 'Switzerland Franc',
                'SRD' => 'Suriname Dollar',
                'SYP' => 'Syria Pound',
                'TWD' => 'Taiwan New Dollar',
                'THB' => 'Thailand Baht',
                'TTD' => 'Trinidad and Tobago Dollar',
                'TRY' => 'Turkey Lira',
                'TRL' => 'Turkey Lira',
                'TVD' => 'Tuvalu Dollar',
                'UAH' => 'Ukraine Hryvna',
                'GBP' => 'United Kingdom Pound',
                'USD' => 'United States Dollar',
                'UYU' => 'Uruguay Peso',
                'UZS' => 'Uzbekistan Som',
                'VEF' => 'Venezuela Bolivar',
                'VND' => 'Viet Nam Dong',
                'YER' => 'Yemen Rial',
                'ZWD' => 'Zimbabwe Dollar'
            )
        ]);

        // Text Field
        Yano::field(
            'text',
            [
                'id'          => '_tikstore_currency_symbol',
                'label'       => 'Currency symbol',
                'description' => 'Currency for display pricing, default is "currency value"',
                'section'     => 'section_general_currency',
                'priority'    => 2,
                'default' => $this->default('_tikstore_currency_symbol')
            ]
        );
    }

    /**
     * order section
     *
     * @return void
     */
    public function general_order()
    {

        // section
        Yano::section('section_general_order', [
            'title'       => 'Order',
            'description' => 'Order Setting',
            'priority'    => 2,
            'panel'       => 'panel_general'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">{year}</span> = will be replaced with current Year',
            '<span style="font-weight:bold">{month}</span> = will be replaced with current Month',
            '<span style="font-weight:bold">{date}</span> = will be replaced with current Date',
            '<span style="font-weight:bold">{number}</span> = will be replaced with current invoice number'
        ];

        // Text Field
        Yano::field(
            'text',
            [
                'id'          => '_tikstore_order_invoice_format',
                'label'       => 'Invoice Format',
                'section'     => 'section_general_order',
                'priority'    => 2,
                'default' => $this->default('_tikstore_order_invoice_format')
            ]
        );

        Yano::field('markup', [
            'id'       => '_tikstore_order_invoice_format_shortcode',
            'section'  => 'section_general_order',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);
    }

    /**
     * marketplace section
     *
     * @return void
     */
    public function general_marketplace()
    {

        // section
        Yano::section('section_general_marketplace', [
            'title'       => __('Marketplace', 'tikstore'),
            'description' => __('marketplace setting', 'tikstore'),
            'priority'    => 3,
            'panel'       => 'panel_general'
        ]);

        $marketplaces = [
            'tokopedia' => 'Tokopedia',
            'shoppe' => 'Shoppe',
            'bukalapak' => 'Bukalapak',
            'tiktok' => 'Tiktok'
        ];

        foreach ($marketplaces as $key => $label) {
            Yano::field('toggle', [
                'id'          => '_tikstore_marketplace_' . $key,
                'label'       => $label,
                'description' => sprintf(__('Show %s store link', 'tikstore'), $label),
                'section'     => 'section_general_marketplace',
                'default' => true
            ]);

            Yano::field(
                'text',
                [
                    'id'          => '_tikstore_marketplace_' . $key . '_link',
                    'label'       => sprintf(__('Your %s store link', 'tikstore'), $label),
                    'section'     => 'section_general_marketplace',
                    'default' => '',
                    'active_callback' => function () use ($key) {
                        if (get_theme_mod('_tikstore_marketplace_' . $key) == true) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                ]
            );

            Yano::field('markup', [
                'id'       => 'line_marketplace_' . $key,
                'section'  => 'section_general_marketplace',
                'html'     => '<p><hr/></p>'
            ]);
        }
    }

    /**
     * store shipping section
     *
     * @return void
     */
    public function shipping_general()
    {

        // section
        Yano::section('section_shipping_general', [
            'title'       => __('General', 'tikstore'),
            'description' => __('Shipping general setting', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_shipping'
        ]);

        Yano::field('radio', [
            'id'             => '_tikstore_shipping_provider',
            'label'          => __('Shipping Provider', 'tikstore'),
            'description'    => __('Select shipping provider', 'tikstore'),
            'section'        => 'section_shipping_general',
            'priority'       => 1,
            'default' => 'free',
            'choices'        => [
                0            => __('Disable Shipping', 'tikstore'),
                'free'       => __('Free Shipping', 'tikstore'),
                'rajaongkir' => __('Rajaongkir', 'tikstore'),
            ]
        ]);

        Free::customizer();
        Rajaongkir::customizer();
    }

    public function notification_general()
    {
        Yano::section('section_notification_general', [
            'title'       => __('General', 'tikstore'),
            'description' => __('Notification general setting', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_admin_phones',
            'label'          => __('Admin Phones', 'tikstore'),
            'description'    => __('Sparate phone number by "|"', 'tikstore'),
            'section'        => 'section_notification_general',
            'priority'       => 2,
            'placeholder' => 'ex: 08123456789|0819876543'
        ]);

        Yano::field('radio', [
            'id'             => '_tikstore_notification_provider',
            'label'          => __('Notification Provider', 'tikstore'),
            'description'    => __('Select notification provider', 'tikstore'),
            'section'        => 'section_notification_general',
            'priority'       => 2,
            'default'        => tikstore_options('notification_provider'),
            'choices'        => apply_filters('tikstore_notification_providers', [
                'responic'     => 'Responic',
            ])
        ]);
    }

    public function notification_new_order()
    {
        Yano::section('section_notification_new_order', [
            'title'       => __('New Order', 'tikstore'),
            'description' => __('Notification new order message', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">[order_number]</span> => Order number',
            '<span style="font-weight:bold">[customer_name]</span> => Customer name',
            '<span style="font-weight:bold">[customer_phone]</span> => Customer phone',
            '<span style="font-weight:bold">[customer_address]</span> => Customer address',
            '<span style="font-weight:bold">[items]</span> => Order items',
            '<span style="font-weight:bold">[summary]</span> => Order summary',
            '<span style="font-weight:bold">[shipping]</span> => Shipping method',
            '<span style="font-weight:bold">[payment]</span> = Payment Method',
        ];

        Yano::field('markup', [
            'id'       => '_tikstore_notification_new_order_shortcode',
            'section'  => 'section_notification_new_order',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_new_order_message',
            'label'          => __('Message', 'tikstore'),
            'section'        => 'section_notification_new_order',
            'priority'       => 3,
            'default'        => tikstore_notification()->default_message('new_order'),
        ]);

        Yano::field('markup', [
            'id'       => '_tikstore_notification_new_order_message_line',
            'section'  => 'section_notification_new_order',
            'html'     => '<p><hr/></p>',
            'priority'       => 3,
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_new_order_cod_message',
            'label'          => __('Message COD payment method', 'tikstore'),
            'section'        => 'section_notification_new_order',
            'priority'       => 4,
            'default'        => tikstore_notification()->default_message('new_order_cod'),
        ]);

        Yano::field('markup', [
            'id'       => '_tikstore_notification_new_order_cod_message_line',
            'section'  => 'section_notification_new_order',
            'html'     => '<p><hr/></p>',
            'priority'       => 4,
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_new_order_message_admin',
            'label'          => __('Message for admin', 'tikstore'),
            'section'        => 'section_notification_new_order',
            'priority'       => 5,
            'default'        => tikstore_notification()->default_message('new_order'),
        ]);
    }

    public function notification_on_hold()
    {
        Yano::section('section_notification_on_hold', [
            'title'       => __('On Hold', 'tikstore'),
            'description' => __('Notification on hold message', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">[order_number]</span> => Order number',
            '<span style="font-weight:bold">[customer_name]</span> => Customer name',
            '<span style="font-weight:bold">[customer_phone]</span> => Customer phone',
            '<span style="font-weight:bold">[customer_address]</span> => Customer address',
            '<span style="font-weight:bold">[items]</span> => Order items',
            '<span style="font-weight:bold">[summary]</span> => Order summary',
            '<span style="font-weight:bold">[shipping]</span> => Shipping method',
            '<span style="font-weight:bold">[payment]</span> = Payment Method',
        ];

        Yano::field('markup', [
            'id'       => '_tikstore_notification_on_hold_shortcode',
            'section'  => 'section_notification_on_hold',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_on_hold_message',
            'label'          => __('Message', 'tikstore'),
            'section'        => 'section_notification_on_hold',
            'priority'       => 3,
            'default'        => tikstore_notification()->default_message('on_hold'),
        ]);
    }

    public function notification_on_shipping()
    {
        Yano::section('section_notification_on_shipping', [
            'title'       => __('On Shipping', 'tikstore'),
            'description' => __('Notification on shipping message', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">[order_number]</span> => Order number',
            '<span style="font-weight:bold">[customer_name]</span> => Customer name',
            '<span style="font-weight:bold">[customer_phone]</span> => Customer phone',
            '<span style="font-weight:bold">[customer_address]</span> => Customer address',
            '<span style="font-weight:bold">[items]</span> => Order items',
            '<span style="font-weight:bold">[summary]</span> => Order summary',
            '<span style="font-weight:bold">[shipping]</span> => Shipping method',
            '<span style="font-weight:bold">[payment]</span> = Payment Method',
            '<span style="font-weight:bold">[shipping_tracking]</span> = Shipping tracking number',
        ];

        Yano::field('markup', [
            'id'       => '_tikstore_notification_on_shipping_shortcode',
            'section'  => 'section_notification_on_shipping',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_on_shipping_message',
            'label'          => __('Message', 'tikstore'),
            'section'        => 'section_notification_on_shipping',
            'priority'       => 3,
            'default'        => tikstore_notification()->default_message('on_shipping'),
        ]);
    }

    public function notification_completed()
    {
        Yano::section('section_notification_completed', [
            'title'       => __('Completed', 'tikstore'),
            'description' => __('Notification on completed message', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">[order_number]</span> => Order number',
            '<span style="font-weight:bold">[customer_name]</span> => Customer name',
            '<span style="font-weight:bold">[customer_phone]</span> => Customer phone',
            '<span style="font-weight:bold">[customer_address]</span> => Customer address',
            '<span style="font-weight:bold">[items]</span> => Order items',
            '<span style="font-weight:bold">[summary]</span> => Order summary',
            '<span style="font-weight:bold">[shipping]</span> => Shipping method',
            '<span style="font-weight:bold">[payment]</span> = Payment Method',
        ];

        Yano::field('markup', [
            'id'       => '_tikstore_notification_cmpleted_shortcode',
            'section'  => 'section_notification_completed',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_completed_message',
            'label'          => __('Message', 'tikstore'),
            'section'        => 'section_notification_completed',
            'priority'       => 3,
            'default'        => tikstore_notification()->default_message('completed'),
        ]);
    }

    public function notification_canceled()
    {
        Yano::section('section_notification_canceled', [
            'title'       => __('Canceled', 'tikstore'),
            'description' => __('Notification on canceled message', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">[order_number]</span> => Order number',
            '<span style="font-weight:bold">[customer_name]</span> => Customer name',
            '<span style="font-weight:bold">[customer_phone]</span> => Customer phone',
            '<span style="font-weight:bold">[customer_address]</span> => Customer address',
            '<span style="font-weight:bold">[items]</span> => Order items',
            '<span style="font-weight:bold">[summary]</span> => Order summary',
            '<span style="font-weight:bold">[shipping]</span> => Shipping method',
            '<span style="font-weight:bold">[payment]</span> = Payment Method',
        ];

        Yano::field('markup', [
            'id'       => '_tikstore_notification_canceled_shortcode',
            'section'  => 'section_notification_canceled',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_canceled_message',
            'label'          => __('Message', 'tikstore'),
            'section'        => 'section_notification_canceled',
            'priority'       => 3,
            'default'        => tikstore_notification()->default_message('canceled'),
        ]);
    }

    public function notification_refunded()
    {
        Yano::section('section_notification_refunded', [
            'title'       => __('Refunded', 'tikstore'),
            'description' => __('Notification on refunded message', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_notification'
        ]);

        $shortcodes = [
            '<span style="font-weight:bold">[order_number]</span> => Order number',
            '<span style="font-weight:bold">[customer_name]</span> => Customer name',
            '<span style="font-weight:bold">[customer_phone]</span> => Customer phone',
            '<span style="font-weight:bold">[customer_address]</span> => Customer address',
            '<span style="font-weight:bold">[items]</span> => Order items',
            '<span style="font-weight:bold">[summary]</span> => Order summary',
            '<span style="font-weight:bold">[shipping]</span> => Shipping method',
            '<span style="font-weight:bold">[payment]</span> = Payment Method',
        ];

        Yano::field('markup', [
            'id'       => '_tikstore_notification_refunded_shortcode',
            'section'  => 'section_notification_refunded',
            'priority' => 3,
            'html'     => implode('<br/>', $shortcodes)
        ]);

        Yano::field('textarea', [
            'id'             => '_tikstore_notification_refunded_message',
            'label'          => __('Message', 'tikstore'),
            'section'        => 'section_notification_refunded',
            'priority'       => 3,
            'default'        => tikstore_notification()->default_message('refunded'),
        ]);
    }

    public function tracking_fb_pixel()
    {
        Yano::section('section_tracking_fbpixel', [
            'title'       => __('Facebook Pixel', 'tikstore'),
            'description' => __('Tracking facebook pixel option', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_tracking'
        ]);

        $counts = [1, 2, 3, 4, 5];
        foreach ($counts as $count) {
            Yano::field('text', [
                'id'             => '_tikstore_tracking_fbpixel_' . $count,
                'label'          => __('Facebook pixel ID ' . $count, 'tikstore'),
                'section'        => 'section_tracking_fbpixel',
                'priority'       => 1,
            ]);
        }

        Yano::field('markup', [
            'id'       => '_tikstore_tracking_fbpixel_line',
            'section'  => 'section_tracking_fbpixel',
            'priority' => 2,
            'html'     => '<p><hr/></p>'
        ]);

        $pages = [
            'home'     => 'Home page',
            'post'     => 'Blog post',
            'page'     => 'Site page',
            'product'  => 'Product page',
            'cart'     => 'Cart page',
            'checkout' => 'Checkout page',
            'thank'    => 'Thanks page'
        ];
        foreach ($pages as $page => $name) {
            Yano::field('checkbox', [
                'id'          => '_tikstore_tracking_fbpixel_on_' . $page,
                'label'       => $name,
                'description' => 'Enable facebook pixel on ' . $name . '?',
                'section'     => 'section_tracking_fbpixel',
                'priority'    => 3,
                'default' => true
            ]);
        }
    }

    public function tracking_tiktok_pixel()
    {
        Yano::section('section_tracking_tiktokpixel', [
            'title'       => __('Tiktok Pixel', 'tikstore'),
            'description' => __('Tracking tiktok pixel option', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_tracking'
        ]);

        $counts = [1, 2, 3, 4, 5];
        foreach ($counts as $count) {
            Yano::field('text', [
                'id'             => '_tikstore_tracking_tiktokpixel_' . $count,
                'label'          => __('Tiktok pixel ID ' . $count, 'tikstore'),
                'section'        => 'section_tracking_tiktokpixel',
                'priority'       => 1,
            ]);
        }

        Yano::field('markup', [
            'id'       => '_tikstore_tracking_tiktokpixel_line',
            'section'  => 'section_tracking_tiktokpixel',
            'priority' => 2,
            'html'     => '<p><hr/></p>'
        ]);

        $pages = [
            'home'     => 'Home page',
            'post'     => 'Blog post',
            'page'     => 'Site page',
            'product'  => 'Product page',
            'cart'     => 'Cart page',
            'checkout' => 'Checkout page',
            'thank'    => 'Thanks page'
        ];
        foreach ($pages as $page => $name) {
            Yano::field('checkbox', [
                'id'          => '_tikstore_tracking_tiktokpixel_on_' . $page,
                'label'       => $name,
                'description' => 'Enable tiktok pixel on ' . $name . '?',
                'section'     => 'section_tracking_tiktokpixel',
                'priority'    => 3,
                'default' => true
            ]);
        }
    }

    public function footer_widget_payments()
    {
        // section
        Yano::section('section_footer_widget_payments', [
            'title'       => __('Widget Payments', 'tikstore'),
            'description' => __('Footer widget payments info', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_footer'
        ]);

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
            Yano::field('toggle', [
                'id'          => '_tikstore_footer_widget_payment_' . $key,
                'label'       => $label,
                'description' => sprintf(__('Show %s payment method', 'tikstore'), $label),
                'section'     => 'section_footer_widget_payments',
                'default' => true
            ]);

            Yano::field('markup', [
                'id'       => 'line_footer_widget_payment_' . $key,
                'section'  => 'section_footer_widget_payments',
                'html'     => '<p><hr/></p>'
            ]);
        }
    }

    public function footer_widget_shippings()
    {
        // section
        Yano::section('section_footer_widget_shippings', [
            'title'       => __('Widget shippings', 'tikstore'),
            'description' => __('Footer widget shippings info', 'tikstore'),
            'priority'    => 1,
            'panel'       => 'panel_footer'
        ]);

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
            Yano::field('toggle', [
                'id'          => '_tikstore_footer_widget_shipping_' . $key,
                'label'       => $label,
                'description' => sprintf(__('Show %s shipping image', 'tikstore'), $label),
                'section'     => 'section_footer_widget_shippings',
                'default' => true
            ]);

            Yano::field('markup', [
                'id'       => 'line_footer_widget_shippings_' . $key,
                'section'  => 'section_footer_widget_shippings',
                'html'     => '<p><hr/></p>'
            ]);
        }
    }

    /**
     * get default data
     *
     * @param  mixed $key
     * @return void
     */
    public function default($key)
    {
        $defaults = $this->defaults();
        return isset($defaults[$key]) ? $defaults[$key] : '';
    }

    /**
     * get value from customizer
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        if ('custom_logo' == $key) {
            $custom_logo_id = get_theme_mod('custom_logo');
            return $custom_logo_id ? wp_get_attachment_url($custom_logo_id) : $this->default('custom_logo');
        }

        $key = $this->prefix . $key;

        return get_theme_mod($key, $this->default($key));
    }
}
