<?php

namespace Control;

defined('ABSPATH') || exit;

/**
 * Yano Sortable Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Sortable_Control extends \WP_Customize_Control
{


    /**
     * The Default value.
     *
     * @since 1.0.0
     * 
     * @var array
     */
    public $default;


    /**
     * List of items.
     *
     * @since 1.0.0
     * 
     * @var array
     */
    public $items;


    /**
     * Show handler icon.
     *
     * @since 1.0.0
     * 
     * @var boolean
     */
    public $handle;


    /**
     * Adding third party libraries.
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        // js
        if (wp_script_is('yano-sortable-js', 'enqueued') == false) {
            wp_enqueue_script('yano-sortable-js', tikstore_yano_resource_url() . 'assets/sortable/Sortable.min.js', array(), '1.0', true);
        }
    }


    /**
     * Encode the $this->value when type is array
     * @return string 
     */
    private function encoded_value()
    {
        $value = $this->value();
        if (!empty($this->value())) {
            if (is_array($this->value())) {
                $value = json_encode($this->value());
            }
        }
        return $value;
    }


    /**
     * Display the status of the list
     * @param  string|int   $key   the key index of array value
     * @return string    the status enable | disabled
     */
    private function status($key)
    {
        $status = 'enable';
        if (!empty($this->value())) {
            // sanitizing order value
            if (gettype($this->value()) == 'string') {
                $order = json_decode($this->value());
            } elseif (gettype($this->value()) == 'array') {
                $order = $this->value();
            }

            // checking if array key exists in array order
            if (in_array($key, $order) == false) {
                $status = 'disabled';
            }
        }
        return $status;
    }


    /**
     * Display the icon depending on the status.
     *
     * @since 1.0.0
     * 
     * @param  string  $status  The status of the list : $this->status( $key ). 
     * @return string
     */
    private function icon($status)
    {
        return ($status == 'enable' ? 'dashicons-hidden' : 'dashicons-visibility');
    }


    /**
     * Return the value with validation and sanitation
     * Decode also json data from db if data is from db or data type is string.
     *
     * @since 1.0.0
     * 
     * @return array
     */
    private function get_values()
    {
        if (empty($this->value())) {
            return $this->items;
        } else {
            if (gettype($this->value()) == 'string') {
                // this happens during retriving data from db :: data is imploded into string with glue ","
                // need to decode json
                $array_order = json_decode($this->value());
            } else {
                $array_order = $this->value();
            }
            // fliping array by array_order and get data from $this->items
            $new_item_order = array_replace(array_flip($array_order), $this->items);
            return $new_item_order;
        }
    }


    /**
     * Render the sortable controller and display in frontend.
     *
     * @since 1.0.0
     * 
     * @return html
     */
    public function render_content()
    {
?>
        <div class="yano-sortable-parent">
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>

                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                <?php endif; ?>
            </label>

            <input type="hidden" id="yano-sortable-input-<?php echo esc_attr($this->id); ?>" value="<?php echo $this->encoded_value(); ?>" name="<?php echo esc_attr($this->id); ?>" <?php echo $this->link(); ?>>

            <?php if (!empty($this->items)) : ?>

                <ul id="yano-sortable-list-<?php echo esc_attr($this->id); ?>" class="yano-sortable-list" data-id="<?php echo esc_attr($this->id); ?>" data-handle="<?php echo esc_attr($this->handle); ?>">

                    <?php foreach ($this->get_values() as $key => $item) : ?>

                        <li data-id="<?php echo esc_attr($key); ?>" class="<?php echo ($this->handle == true ? 'has-handle' : '') . ' ' . $this->status($key); ?>">

                            <?php if ($this->handle == true) : ?>
                                <div class="yano-sortable-handle"><i class="dashicons dashicons-move"></i></div>
                            <?php endif; ?>

                            <div class="yano-sortable-text">
                                <span><?php echo esc_html($item); ?></span>
                            </div>

                            <div class="yano-sortable-state">
                                <i class="dashicons <?php echo $this->icon($this->status($key)); ?>"></i>
                            </div>

                        </li>

                    <?php endforeach; ?>

                </ul>

            <?php endif; ?>
        </div>
<?php
    }
}
