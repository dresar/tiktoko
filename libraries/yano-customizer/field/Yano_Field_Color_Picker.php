<?php
namespace Field;

use Control\Yano_Color_Picker_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Color Picker.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Color_Picker extends Yano_Settings {

	/**
	 * Rendering Color Picker.
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
				'default'	=> 'Color Picker Field',
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
				'type'		=> 'string'
			),
			'format'		=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'string'
			),
			'opacity'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'boolean'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'color-picker', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_format = yano_is_valid_argument_value([
			'value'		=> $args['format'],
			'valid'		=> [ 'hex', 'HEX', 'rgba', 'RGBA' ],
			'field'		=> $field_name,
			'allowed'	=> 'hex, rgba',
			'argument'	=> 'format'
		]);

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_format == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Color_Picker_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'default'		=> ( $args['default'] ? $args['default'] : 'transparent' ),
				'format'		=> $args['format'],
				'opacity'		=> $args['opacity'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}