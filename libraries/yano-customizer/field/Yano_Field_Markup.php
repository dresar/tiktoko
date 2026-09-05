<?php
namespace Field;

use Control\Yano_Markup_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Markup.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Markup extends Yano_Settings {


	/**
	 * Rendering Markup.
	 *
	 * @since 1.0.0
	 * 
	 * @param object  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $config 		 List of configuration.
	 */
	public function render( $wp_customize, $config ) {
		$rules = array(
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
			'html'			=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'string'
			),
			'active_callback' => array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'any'
			)
		);

		$field_name =  yano_error_field_name( 'markup', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false  ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Markup_Control( $wp_customize, $args['id'] . '_field', array(
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'html'			=> $args['html'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}