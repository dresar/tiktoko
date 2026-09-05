<?php
namespace Field;

use Control\Yano_Image_Uploader_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Image Uploader.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Image_Uploader extends Yano_Settings {


	/**
	 * Rendering Image Uploader.
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
				'default'	=> 'Image Uploader Field',
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

		$field_name =  yano_error_field_name( 'image-uploader', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_extensions = yano_is_valid_argument_value([
			'value'		=> $args['extensions'],
			'valid'		=> [ 'png', 'jpeg', 'jpg', 'gif', 'ico' ],
			'field'		=> $field_name,
			'allowed'	=> 'png, jpeg, jpg, gif, ico',
			'argument'	=> 'extension'
		]);

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_extensions == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Image_Uploader_Control( $wp_customize, $args['id'] . '_field', array(
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