<?php

namespace Tikstore\PaymentMethods;

use Yano;

class Cod extends Base
{

    private $default = [];

    /**
     * constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->default = [
            'name'                      => 'COD',
            'description'               => __('Cash on Delivery', 'tikstore'),
            'instruction'               => __('Pay when the goods arrive', 'tikstore'),
            'use_unique_number_pricing' => false
        ];

        $this->id                        = 'cod';
        $this->is_enable                 = get_theme_mod('_tikstore_payment_method_' . $this->id, false);
        $this->name                      = get_theme_mod('_tikstore_payment_method_' . $this->id . '_name', $this->default['name']);
        $this->description               = get_theme_mod('_tikstore_payment_method_' . $this->id . '_description', $this->default['description']);
        $this->icon                      = TIKSTORE_URL . '/img/payments/cod.png';
        $this->use_unique_number_pricing = true;
        $this->instruction               = get_theme_mod('_tikstore_payment_method_' . $this->id . '_instruction', $this->default['instruction']);
    }

    public function action_wa()
    {
        $text = '_' . $this->instruction() . '_' . PHP_EOL;

        return $text;
    }

    /**
     * action
     *
     * @return void
     */
    public function action()
    {
        echo '';
    }

    /**
     * customizer
     * 
     * setting form
     *
     * @return void
     */
    public function customizer()
    {

        $section_id = 'section_' . $this->id;

        // section
        Yano::section($section_id, [
            'title'       => $this->name,
            'description' => $this->name . ' setting',
            'priority'    => 1,
            'panel'       => 'panel_payment_method'
        ]);

        Yano::field('switch', [
            'id'          => '_tikstore_payment_method_' . $this->id,
            'label'       => 'Activate?',
            'description' => sprintf(__('Activate %s payment method', 'tikstore'), $this->name),
            'section'     => $section_id,
            'default'     => false,
            'priority'    => 1
        ]);

        Yano::field('markup', [
            'id'       => '_tikstore_payment_method_' . $this->id . '_line_1',
            'section'  => $section_id,
            'priority'    => 1,
            'html'     => '<p><hr/></p>'
        ]);

        Yano::field(
            'text',
            [
                'id'          => '_tikstore_payment_method_' . $this->id . '_name',
                'label'       => __('Title', 'tikstore'),
                'section'     => $section_id,
                'default' => $this->default['name'],
                'priority'    => 2,
                'active_callback' => function () {
                    if (get_theme_mod('_tikstore_payment_method_' . $this->id) == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            ]
        );

        Yano::field('markup', [
            'id'       => '_tikstore_payment_method_' . $this->id . '_line_2',
            'section'  => $section_id,
            'priority'    => 2,
            'html'     => '<p><hr/></p>',
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_payment_method_' . $this->id) == true) {
                    return true;
                } else {
                    return false;
                }
            }
        ]);

        Yano::field(
            'textarea',
            [
                'id'          => '_tikstore_payment_method_' . $this->id . '_description',
                'label'       => __('Description', 'tikstore'),
                'section'     => $section_id,
                'default' => $this->default['description'],
                'priority'    => 3,
                'active_callback' => function () {
                    if (get_theme_mod('_tikstore_payment_method_' . $this->id) == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            ]
        );

        Yano::field('markup', [
            'id'       => '_tikstore_payment_method_' . $this->id . '_line_3',
            'section'  => $section_id,
            'priority'    => 3,
            'html'     => '<p><hr/></p>',
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_payment_method_' . $this->id) == true) {
                    return true;
                } else {
                    return false;
                }
            }
        ]);

        Yano::field('content-editor', [
            'id'          => '_tikstore_payment_method_' . $this->id . '_instruction',
            'label'       => 'Payment instruction',
            'description' => 'Payment instruction',
            'section'     => $section_id,
            'priority'    => 4,
            'default' => $this->default['instruction'],
            'active_callback' => function () {
                if (get_theme_mod('_tikstore_payment_method_' . $this->id) == true) {
                    return true;
                } else {
                    return false;
                }
            }
        ]);
    }
}
