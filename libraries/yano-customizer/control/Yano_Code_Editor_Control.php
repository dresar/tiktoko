<?php

namespace Control;

defined('ABSPATH') || exit;

/**
 * Yano Code Editor Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Code_Editor_Control extends \WP_Customize_Control
{


    /**
     * Type of programming languge html, css, 
     * javascript and php are available.
     *
     * @since 1.0.0
     * 
     * @var string
     */
    public $language;


    /**
     * Adding third party libraries.
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        // styles
        if (wp_style_is('yano-codemirror-css', 'enqueued') == false) {
            wp_enqueue_style('yano-codemirror-css', tikstore_yano_resource_url() . 'assets/codemirror/lib/codemirror.css');
        }

        // js
        if (wp_script_is('yano-codemirror-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-js', tikstore_yano_resource_url() . 'assets/codemirror/lib/codemirror.js', array(), '1.0', true);
        }

        // modes
        if (wp_script_is('yano-codemirror-htmlmixed-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-htmlmixed-js', tikstore_yano_resource_url() . 'assets/codemirror/mode/htmlmixed/htmlmixed.js', array(), '1.0', true);
        }

        if (wp_script_is('yano-codemirror-xml-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-xml-js', tikstore_yano_resource_url() . 'assets/codemirror/mode/xml/xml.js', array(), '1.0', true);
        }

        if (wp_script_is('yano-codemirror-javascript-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-javascript-js', tikstore_yano_resource_url() . 'assets/codemirror/mode/javascript/javascript.js', array(), '1.0', true);
        }

        if (wp_script_is('yano-codemirror-css-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-css-js', tikstore_yano_resource_url() . 'assets/codemirror/mode/css/css.js', array(), '1.0', true);
        }

        if (wp_script_is('yano-codemirror-clike-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-clike-js', tikstore_yano_resource_url() . 'assets/codemirror/mode/clike/clike.js', array(), '1.0', true);
        }

        if (wp_script_is('yano-codemirror-php-js', 'enqueued') == false) {
            wp_enqueue_script('yano-codemirror-php-js', tikstore_yano_resource_url() . 'assets/codemirror/mode/php/php.js', array(), '1.0', true);
        }
    }


    /**
     * Render the code editor controller and display in frontend.
     *
     * @since 1.0.0
     * 
     * @return html
     */
    public function render_content()
    {
?>
        <div class="yano-code-editor-parent">
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>

                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                <?php endif; ?>
            </label>

            <textarea id="yano-code-editor-input-<?php echo esc_attr($this->id); ?>" style="display: none" name="<?php echo esc_attr($this->id); ?>" <?php echo $this->link(); ?>><?php echo $this->value(); ?></textarea>

            <textarea id="yano-code-editor-textarea-<?php echo esc_attr($this->id); ?>" class="yano-code-editor-textarea" data-id="<?php echo esc_attr($this->id); ?>" data-language="<?php echo esc_attr($this->language); ?>"></textarea>
        </div>
<?php
    }
}
