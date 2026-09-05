<?php
namespace Field;

use Control\Yano_Numeric_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Numeric.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Numeric extends Yano_Settings {


	/**
	* Validating options in arguments.
	*
	* @since 1.0.0
	*
	* @param array   $options  List of options.
	* @param string  $field    Name of field.
	*/
	private function options_validation( $options, $field ) {
		$rules = array(
			'min'	=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'number'
			),
			'max'	=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'number'
			),
			'step'	=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'number'
			)
		);

		if ( yano_check_arguments( $rules, $options, $field ) == true ) {
			if ( $options['min'] >= $options['max'] ) {
				yano_alert_warning( 'Error 110: min must be less than max in field ' . yano_code( 'success', $field ) .'.' );
				return false;
			} elseif ( $options['max'] <= $options['min'] ) {
				yano_alert_warning( 'Error 111: max must be greater than min in field ' . yano_code( 'success', $field ) .'.' );
				return false;
			} else {
				if ( $options['step'] >= $options['max'] ) {
					yano_alert_warning( 'Error 112: step must be less than max in field ' . yano_code( 'success', $field ) .'.' );
					return false;
				} elseif ( $options['step'] <= 0 ) {
					yano_alert_warning( 'Error 113: step must be greater than 0 in field ' . yano_code( 'success', $field ) .'.' );
					return false;
				} else {
					return true;
				}
			}
		} else {
			return false;
		}
	}


	/**
	 * Rendering Numeric.
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
				'default'	=> 'Number Field',
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
			'options'		=> array(
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

		$field_name =  yano_error_field_name( 'numeric', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_options_valid = $this->options_validation( $args['options'], $field_name );
		
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_options_valid == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Numeric_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'options'		=> $args['options'],
				'active_callback' => $args['active_callback']
			)));
		}
	}
}