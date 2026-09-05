<?php
namespace Field;

use Control\Yano_Content_Editor_Control;
use Field\Yano_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Field Content Editor.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Field_Content_Editor extends Yano_Settings {
	

	/**
	 * Rendering Content Editor.
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
				'default'	=> 'Content Editor Field',
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
			'uploader'		=> array(
				'rule'		=> 'empty',
				'default'	=> '',
				'type'		=> 'boolean'
			),
			'toolbars'		=> array(
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

		$field_name =  yano_error_field_name( 'content-editor', $config['id'] );
		$args = yano_sanitize_argument( $field_name, $config, $rules );
		$is_valid_toolbars = yano_is_valid_argument_value([
			'value'		=> $args['toolbars'],
			'valid'		=> [ 'bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'alignleft', 
							 'aligncenter', 'alignright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 
							 'wp_adv', 'formatselect', 'underline', 'alignjustify', 'forecolor', 'pastetext', 'removeformat', 
							 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help' ],
			'field'		=> $field_name,
			'allowed'	=> 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv, formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
			'argument'	=> 'toolbars'
		]);

		if ( is_array( $args ) && parent::sanitize_argument( $config, $field_name ) != false && $is_valid_toolbars == true ) {
			$this->init_settings( $wp_customize, $config, $field_name );
			$wp_customize->add_control( new Yano_Content_Editor_Control( $wp_customize, $args['id'] . '_field', array(
				'label'			=> esc_html( $args['label'] ),
				'description'	=> esc_html( $args['description'] ),
				'section'		=> $args['section'],
				'settings'		=> $args['id'],
				'priority'		=> $args['priority'],
				'default'		=> $args['default'],
				'uploader'  	=> $args['uploader'],
				'toolbars'		=> yano_unique( $args['toolbars'], [] ),
				'active_callback' => $args['active_callback']
			)));
		}
	}
}