<?php

namespace Tikstore\PaymentMethods;

use Yano;

trait ManualBankTransfer
{
    public function action_wa()
    {
        $text = '_' . $this->instruction() . '_' . PHP_EOL;
        $text .= '----------------------' . PHP_EOL;
        $text .= '*' . get_theme_mod('_tikstore_payment_method_' . $this->id() . '_account_number') . '* | ' . get_theme_mod('_tikstore_payment_method_' . $this->id() . '_account_name') . PHP_EOL;
        $text .= '----------------------' . PHP_EOL;

        return $text;
    }

    /**
     * action
     *
     * @return void
     */
    public function action()
    {
        ob_start();
        get_template_part('template-parts/manual-bank-transfer-action', null, [
            'icon' => $this->icon(),
            'instruction' => $this->instruction(),
            'account_number' => get_theme_mod('_tikstore_payment_method_' . $this->id() . '_account_number'),
            'account_name' => get_theme_mod('_tikstore_payment_method_' . $this->id() . '_account_name'),
        ]);
        $html = ob_get_clean();
        echo $html;
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

        Yano::field('markup', [
            'id'       => '_tikstore_payment_method_' . $this->id . '_line_4',
            'section'  => $section_id,
            'priority'    => 4,
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
            'text',
            [
                'id'          => '_tikstore_payment_method_' . $this->id . '_account_name',
                'label'       => __('Account Name', 'tikstore'),
                'section'     => $section_id,
                'priority'    => 5,
                'active_callback' => function () {
                    if (get_theme_mod('_tikstore_payment_method_' . $this->id) == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            ]
        );

        Yano::field(
            'text',
            [
                'id'          => '_tikstore_payment_method_' . $this->id . '_account_number',
                'label'       => __('Account Number', 'tikstore'),
                'section'     => $section_id,
                'priority'    => 5,
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
            'id'       => '_tikstore_payment_method_' . $this->id . '_line_5',
            'section'  => $section_id,
            'priority'    => 5,
            'html'     => '<p><hr/></p>',
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
