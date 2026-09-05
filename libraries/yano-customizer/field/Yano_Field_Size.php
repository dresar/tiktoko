<?php
namespace Field;

use Control\Yano_Size_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Size.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Size extends Yano_Settings {

	
	/**
	 * Rendering Size.
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
				'default'	=> 'Size Field',
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
			'placeholder'	=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'string'
			),
			'units'			=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'array'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'size', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_units = yano_is_valid_argument_value([
			'value'		=> $args['units'],
			'valid'		=> [ 'px', 'em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%' ],
			'field'		=> $field_name,
			'allowed'	=> 'px, em, ex, ch, rem, vw, vh, vmin, vmax, %',
			'argument'	=> 'units'
		]);

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_units == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Size_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'placeholder'	=> esc_attr( $args['placeholder'] ),
				'units'			=> $args['units'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}