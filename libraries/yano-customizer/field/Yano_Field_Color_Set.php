<?php
namespace Field;

use Control\Yano_Color_Set_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Color Set.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Color_Set extends Yano_Settings {


	/**
	 * Rendering Color Set.
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
				'default'	=> 'Color Set Field',
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
				'rule'		=> 'required',
				'default'	=> '#000000',
				'type'		=> 'string'
			),
			'priority'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'number'
			),
			'colors'		=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'array'
			),
			'shape'			=> array(
				'rule'		=> 'empty',
				'default'	=> 'square',
				'type'		=> 'string'
			),
			'size'			=> array(
				'rule'		=> 'empty',
				'default'	=> 20,
				'type'		=> 'number'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'color-set', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Color_Set_Control( $wp_customize, $args['id'] . '_field', array(
				'type'			=> 'color-palette-material',
				'label'			=> __( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'default'		=> $args['default'],
				'priority'		=> $args['priority'],
				'colors'		=> $args['colors'],
				'shape'			=> $args['shape'],
				'size'			=> $args['size'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}