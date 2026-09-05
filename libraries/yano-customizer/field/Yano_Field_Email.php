<?php
namespace Field;

use Control\Yano_Email_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Email.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Email extends Yano_Settings {


	/**
	 * Validate the default value if its a valid email.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $default  Default email value.
	 * @param  string  $field 	 The name of the field.
	 * @return boolean 
	 */
	private function is_valid_default( $default, $field ) {
		if ( ! empty( $default ) ) {
			if ( filter_var( $default, FILTER_VALIDATE_EMAIL ) == false ) {
				yano_alert_warning( 'Error 315: invalid Email in '. yano_code( 'error', 'default' ) .' at field '. yano_code( 'success', $field ) .'.');
				return false;
			}
		}
		return true;
	}


	/**
	 * Rendering Email.
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
				'default'	=> 'Email Field',
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
			'placeholder'	=> array(
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

		$field_name =  yano_error_field_name( 'email', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		if ( empty( $config['default'] ) ) {
			$config['default'] = '';
		}
		
		$is_valid_default = $this->is_valid_default( $config['default'], $field_name );
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_default == true ) {
			$new_config = yano_push_default_validation( $config, [ 'valid_email' ] );
			$this->init_settings( $wp_customize, $new_config, $field_name );
			$wp_customize->add_control( new Yano_Email_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'placeholder'	=> $args['placeholder'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}