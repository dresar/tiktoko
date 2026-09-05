<?php
namespace Field;

use Control\Yano_Audio_Uploader_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Audio Uploader.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Audio_Uploader extends Yano_Settings {

	/**
	 * Rendering Audio Uploader
	 *
	 * @since 1.0.0
	 * 
	 * @param object  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $config 		 Containg the list configuration.
	 */
	public function render( $wp_customize, $config ) {
		$rules = array(
			'label'			=> array(
				'rule'		=> 'empty',
				'default'	=> 'Audio Uploader Field',
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
			'default'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'number'
			),
			'extensions'	=> array(
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

		$field_name =  yano_error_field_name( 'audio-uploader', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_extensions = yano_is_valid_argument_value([
			'value'		=> $args['extensions'],
			'valid'		=> [ 'mp3', 'm4a', 'ogg', 'wav', 'mpg' ],
			'field'		=> $field_name,
			'allowed'	=> 'mp3, m4a, ogg, wav, mpg',
			'argument'	=> 'extension'
		]);

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_extensions == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Audio_Uploader_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'placeholder'	=> $args['placeholder'],
				'default'		=> $args['default'],
				'extensions'	=> yano_unique( $args['extensions'], [] ),
				'active_callback' => $args['active_callback']
			)));
		}
	}
}