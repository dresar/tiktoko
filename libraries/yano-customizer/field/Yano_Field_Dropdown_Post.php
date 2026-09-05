<?php
namespace Field;

use Control\Yano_Dropdown_Post_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Dropdown Post.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Dropdown_Post extends Yano_Settings {


	/**
	 * Rendering Dropdown Post.
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
				'default'	=> 'Dropdown Post Field',
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
			'order'			=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'string'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'dropdown-post', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_order = yano_is_valid_argument_value([
			'value'		=> $args['order'],
			'valid'		=> [ 'asc', 'desc' ],
			'field'		=> $field_name,
			'allowed'	=> 'asc, desc',
			'argument'	=> 'order'
		]);
		
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_order == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Dropdown_Post_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'order'			=> $args['order'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}