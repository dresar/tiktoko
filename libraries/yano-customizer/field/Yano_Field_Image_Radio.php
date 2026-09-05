<?php
namespace Field;

use Control\Yano_Image_Radio_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Image Radio.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Image_Radio extends Yano_Settings {


	/**
	 * Rendering Image Radio.
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
				'default'	=> 'Image Radio Field',
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
			'size'			=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'array'
			),
			'direction'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'string'
			),
			'choices'		=> array(
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

		$field_name =  yano_error_field_name( 'image-radio', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_choices = yano_image_select_valid_choices( $args['choices'], $field_name );
		$is_valid_size = yano_image_select_valid_size( $args['size'], $field_name );
		$is_valid_direction = yano_is_valid_argument_value([
			'value'		=> $args['direction'],
			'valid'		=> [ 'row', 'column' ],
			'field'		=> $field_name,
			'allowed'	=> 'row, column',
			'argument'	=> 'direction'
		]);
		$is_valid_default = yano_is_valid_argument_value([
			'value'		=> $args['default'],
			'valid'		=> $args['choices'],
			'field'		=> $field_name,
			'allowed'	=> yano_get_keys_imploded( $args['choices'] ),
			'type'		=> 'key',
			'argument'	=> 'default'
		]);

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_choices == true && $is_valid_direction == true && $is_valid_size == true && $is_valid_default == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Image_Radio_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'default'		=> $args['default'],
				'direction'		=> $args['direction'],
				'choices'		=> $args['choices'],
				'size'			=> $args['size'],
				'active_callback' => $args['active_callback']
			)));
		}
	}	
}