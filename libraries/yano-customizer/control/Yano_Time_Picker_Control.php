<?php

namespace Control;

defined('ABSPATH') || exit;

/**
 * Yano Time Picker Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Time_Picker_Control extends \WP_Customize_Control
{


    /**
     * Time format in military.
     *
     * @since 1.0.0
     * 
     * @var boolean
     */
    public $military_format;


    /**
     * The placeholder in input.
     *
     * @since 1.0.0
     * 
     * @var string
     */
    public $placeholder;


    /**
     * Adding third party libraries.
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        // css
        if (wp_style_is('yano-flatpickr-css', 'enqueued') == false) {
            wp_enqueue_style('yano-flatpickr-css', tikstore_yano_resource_url() . 'assets/flatpickr/flatpickr.min.css');
        }

        // js
        if (wp_script_is('yano-flatpickr-js', 'enqueued') == false) {
            wp_enqueue_script('yano-flatpickr-js', tikstore_yano_resource_url() . 'assets/flatpickr/flatpickr.min.js', array('jquery'), '1.0', true);
        }
    }


    /**
     * Render the time picker controller and display in frontend.
     *
     * @since 1.0.0
     * 
     * @return html
     */
    public function render_content()
    {
?>
        <label>
            <?php if (!empty($this->label)) : ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif; ?>

            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
            <?php endif; ?>
        </label>

        <div class="yano-time-picker-parent">
            <div class="yano-time-picker-parent-container">
                <input type="hidden" id="yano-time-picker-input-main-<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" <?php echo $this->link(); ?>>

                <input type="text" id="yano-time-picker-input-<?php echo esc_attr($this->id); ?>" class="yano-time-picker-input" data-id="<?php echo esc_attr($this->id); ?>" data-military_format="<?php echo esc_attr($this->military_format); ?>" data-value="<?php echo esc_attr($this->value()); ?>" placeholder="<?php echo esc_attr($this->placeholder); ?>">

                <button class="yano-time-picker-btn yano-time-picker-btn-open" data-id="<?php echo esc_attr($this->id); ?>">
                    <i class="dashicons dashicons-clock"></i>
                </button>

                <button class="yano-time-picker-btn yano-time-picker-btn-clear" data-id="<?php echo esc_attr($this->id); ?>">
                    <i class="dashicons dashicons-no-alt"></i>
                </button>
            </div>
        </div>
<?php
    }
}
