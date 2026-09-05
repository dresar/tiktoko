<?php

namespace Control;

defined('ABSPATH') || exit;

/**
 * Yano Tagging Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Tagging_Control extends \WP_Customize_Control
{


    /**
     * The maximum tag item.
     *
     * @since 1.0.0
     * 
     * @var integer
     */
    public $maxitem;


    /**
     * Holds the placeholder.
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
        // styles
        if (wp_style_is('yano-selectize-css', 'enqueued') == false) {
            wp_enqueue_style('yano-selectize-css', tikstore_yano_resource_url() . 'assets/selectize/selectize.css');
        }

        // js
        if (wp_script_is('yano-selectize-js', 'enqueued') == false) {
            wp_enqueue_script('yano-selectize-js', tikstore_yano_resource_url() . 'assets/selectize/selectize.min.js', array(), '1.0', false);
        }
    }


    /**
     * Finalize the max item.
     *
     * @since 1.0.0
     * 
     * @return number
     */
    private function final_max_item()
    {
        if (isset($this->maxitem)) {
            if (is_numeric($this->maxitem)) {
                $max = $this->maxitem;
            } else {
                $max = 'none';
            }
        }
        return $max;
    }


    /**
     * Returns the imploded value whether in "array" or string format.
     *
     * @since 1.0.0
     * 
     * @return string
     */
    private function imploded_value()
    {
        $output = $this->value();
        if (is_array($this->value())) {
            $output = implode(',', $this->value());
        }
        return $output;
    }


    /**
     * Render the tagging controller and display in frontend.
     *
     * @since 1.0.0
     * 
     * @return html
     */
    public function render_content()
    {
?>
        <div class="yano-tagging-parent">
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>

                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                <?php endif; ?>
            </label>

            <input type="text" class="yano-tagging-control" id="<?php echo esc_attr($this->id) ?>" name="<?php echo esc_attr($this->id) ?>" value="<?php echo esc_attr($this->imploded_value()); ?>" placeholder="<?php echo esc_attr($this->placeholder); ?>" data-maxitem="<?php echo $this->final_max_item() ?>" <?php echo $this->link(); ?>>
        </div>
<?php
    }
}
