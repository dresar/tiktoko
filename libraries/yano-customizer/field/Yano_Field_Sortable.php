<?php
namespace Field;

use Control\Yano_Sortable_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Sortable.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Sortable extends Yano_Settings {


	/**
	 * Checks if the default value is valid or values are exists in items.
	 * Also if the total count of default is equal to total count of items.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array   $default  Set of default value order.
	 * @param  array   $items    Set of items to be ordered.
	 * @param  string  $field    Complete field name.
	 * @return boolean
	 */
	private function is_valid_default( $default, $items, $field ) {
		if ( ! empty( $default ) ) {
			if ( count( $default ) <= count( $items ) ) {
				if ( yano_array_has_dupes( $default ) == false ) {
					foreach ( $default as $key => $value ) {
						if ( array_key_exists( $value, $items ) == false ) {
							yano_alert_warning( 'Error 311: default value '. yano_code( 'error', $value ) .' does not exists in items in field '. yano_code( 'success', $field ) .'.');
							return false;
						}
					}
				} else {
					yano_alert_warning( 'Error 313: duplicate values found in '. yano_code( 'error', 'default' ) .' at field '. yano_code( 'success', 'items: '. $field ) .'.' );
					return false;
				}
			} else {
				yano_alert_warning( 'Error 312: total '.yano_code( 'error', 'default: '. count( $default ) ) .' count must less than or equal to the total count of '. yano_code( 'success', 'items: '. count( $items ) ) .'.' );
				return false;
			}
		}	
		return true;
	}


	/**
	 * Sanitize and validate array value in to unique array.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array  $array  Sets of value to be check.
	 * @return array
	 */
	private function unique_value( $array ) {
		if ( ! empty( $array ) && is_array( $array ) ) {
			return array_unique( $array );
		}
		return [];
	}


	/**
	 * Rendering Sortable.
	 *
	 * @since 1.0.0
	 * 
	 * @param object  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $config 		 List of configuration.
	 */
	public function render( $wp_customize, $config ) {
		$rules = array(
			'label'			=> array(
				'rule'		=> 'empty',
				'default'	=> 'Sortable Field',
				'type'		=> 'string'
			),
			'description'	=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'string'
			),
			'section'		=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'string'
			),
			'priority'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'number'
			),
			'default'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'array'
			),
			'handle'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'boolean'
			),
			'items'			=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'array'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'sortable', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_default = $this->is_valid_default( $args['default'], $this->unique_value( $args['items'] ), $field_name );

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_default == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Sortable_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'handle'		=> $args['handle'],
				'default'		=> $this->unique_value( $args['default'] ),
				'items'			=> $this->unique_value( $args['items'] ),
				'active_callback' => $args['active_callback']
			)));
		}
	}
}