<?php
namespace Field;

use Control\Yano_Range_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Range.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Range extends Yano_Settings {


	/**
	 * Rendering Range.
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
				'default'	=> 'Range Field',
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
			'default'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'number'
			),
			'priority'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'number'
			),
			'min'			=> array(
				'rule'		=> 'required',
				'default'	=> 0,
				'type'		=> 'number'
			),
			'max'			=> array(
				'rule'		=> 'required',
				'default'	=> 1,
				'type'		=> 'number'
			),
			'step'			=> array(
				'rule'		=> 'required',
				'default'	=> 1,
				'type'		=> 'number'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'range', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Range_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'min'			=> $args['min'],
				'max'			=> $args['max'],
				'step'			=> $args['step'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}