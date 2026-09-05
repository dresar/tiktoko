<?php
namespace Field;

use Control\Yano_Date_Picker_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Date Picker.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Date_Picker extends Yano_Settings {


	/**
	 * Rendering Date Picker.
	 *
	 * @since 1.0.0
	 * 
	 * @param object  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $config 		 List of configuration.
	 */
	public function render( $wp_customize, $config ) {
		$default_type = 'string';
		if ( $config['mode'] == 'range' ) {
			$default_type = 'array';
		}

		$rules = array(
			'label'			=> array(
				'rule'		=> 'empty',
				'default'	=> 'Date Picker Field',
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
				'type'		=> $default_type
			),
			'placeholder'	=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'string'
			),
			'mode'			=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'string'
			),
			'enable_time'	=> array(
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

		$field_name =  yano_error_field_name( 'date-picker', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_mode = yano_is_valid_argument_value([
			'value'		=> $args['mode'],
			'valid'		=> [ 'single', 'range' ],
			'field'		=> $field_name,
			'allowed'	=> 'single, range',
			'argument'	=> 'mode'
		]);
		$is_valid_default = $this->is_valid_default( $args['default'], $args['mode'], $args['enable_time'], $field_name );
		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_mode == true && $is_valid_default == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Date_Picker_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'default'		=> $args['default'],
				'placeholder'	=> $args['placeholder'],
				'mode'			=> $args['mode'],
				'enable_time'	=> $args['enable_time'],
				'active_callback' => $args['active_callback']		
			)));
		}
	}


	/**
	 * Validate default value.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string|array  $default      Set of default date.
	 * @param  string 	 	 $mode         Mode value single | range.
	 * @param  boolean 	 	 $enable_time  Sets if allowed time in calendar.
	 * @param  string  		 $field        Complete name of field.
	 * @return boolean            
	 */
	private function is_valid_default( $default, $mode, $enable_time, $field ) {
		if ( ! empty( $default ) ) {
			$format = ( $enable_time == true ? 'Y-m-d H:i' : 'Y-m-d' );
			if ( $mode == 'range' ) {
				if ( count( $default ) == 2 ) {
					foreach ( $default as $key => $date ) {
						if ( yano_is_valid_date( $date, $format ) == false ) {
							yano_alert_warning( 'Error 308: default date value '. yano_code( 'error', $date ) .' is invalid date in field '. yano_code( 'info', $field ) .', here is the valid format '. yano_code( 'success', $format ) .'.' );
							return false;
						}
					}
				} else {
					yano_alert_warning( 'Error 309: field '. yano_code( 'info', $field ) .' is set as '. yano_code( 'success', 'mode: range' ) .' so array default must have two date:: START DATE and END DATE.' );
							return false;
				}
			} else {
				if ( yano_is_valid_date( $default, $format ) == false ) {
					yano_alert_warning( 'Error 308: default date value '. yano_code( 'error', $default ) .' is invalid date in field '. yano_code( 'info', $field ) .', here is the valid format '. yano_code( 'success', $format ) .'.' );
					return false;
				}
			}
		}
		return true;
	}
}