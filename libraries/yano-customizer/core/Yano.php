<?php
use Core\Yano_Init;
use Field\Yano_Field_Audio_Uploader;
use Field\Yano_Field_Button_Set;
use Field\Yano_Field_Text;
use Field\Yano_Field_Select;
use Field\Yano_Field_Size;
use Field\Yano_Field_Sortable;
use Field\Yano_Field_Switch;
use Field\Yano_Field_Checkbox;
use Field\Yano_Field_Checkbox_Multiple;
use Field\Yano_Field_Checkbox_Pill;
use Field\Yano_Field_Code_Editor;
use Field\Yano_Field_Color;
use Field\Yano_Field_Color_Picker;
use Field\Yano_Field_Color_Set;
use Field\Yano_Field_Content_Editor;
use Field\Yano_Field_Date_Picker;
use Field\Yano_Field_Dropdown_Custom_Post;
use Field\Yano_Field_Dropdown_Page;
use Field\Yano_Field_Dropdown_Post;
use Field\Yano_Field_Email;
use Field\Yano_Field_File_Uploader;
use Field\Yano_Field_Image_Checkbox;
use Field\Yano_Field_Image_Radio;
use Field\Yano_Field_Image_Uploader;
use Field\Yano_Field_Markup;
use Field\Yano_Field_Numeric;
use Field\Yano_Field_Radio;
use Field\Yano_Field_Range;
use Field\Yano_Field_Tagging;
use Field\Yano_Field_Tagging_Select;
use Field\Yano_Field_Textarea;
use Field\Yano_Field_Time_Picker;
use Field\Yano_Field_Toggle;
use Field\Yano_Field_Url;
use Field\Yano_Field_Video_Uploader;

defined( 'ABSPATH' ) || exit;

/**
 * Yano.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Yano {

	/**
	 * Holds set of arguments.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $config = array();


	/**
	 * Get WP_Customize_Manager.
	 *
	 * @since 1.0.0
	 * 
	 * @return object
	 */
	protected function wp_cm() {
		global $wp_customize;
		return $wp_customize;
	}


	/**
	 * Adding panel.
	 *
	 * @since 1.0.0
	 *
	 * @param string 	$id 					a unique slug-like string to use as an id
	 * @param array 	$config 				hold the set of arguments
	 * @param string 	$config['title']	    the visible name of the panel
	 * @param string 	$config['description'] 	the discription of the panel
	 * @param int 		$config['priority']		the order of panels appears in the Theme Customizer Sizebar
	 */
	public static function panel( $id ,$config ) {
		if ( is_customize_preview() ) {
			if ( ! empty( $id ) && ! empty( $config ) ) {
				( new self )->render_panel( $id, $config );
			}
		}
	}


	/**
	 * Rendering Panel.
	 *
	 * @since 1.0.0
	 * 
	 * @param string  $id 			 A unique slug-like string to use as an id.
	 * @param array   $config 		 Containing the set of arguments.
	 */
	private function render_panel( $id, $config ) {
		$rules = array(
			'title'			=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'string'
			),
			'description'	=> array(
				'rule'		=> 'not',
				'default'	=> '',
				'type'		=> 'string'
			),
			'priority'		=> array(
				'rule'		=> 'not',
				'default'	=> '',
				'type'		=> 'number'
			)
		);

		// sanitizing $config and return sanitized value
		$args = yano_sanitize_argument( 'panel: '. $id, $config, $rules );

		// creating panel
		if ( $args != false ) {
			$this->wp_cm()->add_panel( $id, $args );
		}
	}


	/**
	 * Adding Section.
	 *
	 * @since 1.0.0
	 * 
	 * @param string  $id 	   A unique slug-like string to use as an id.
	 * @param array   $config  Containing the set of arguments.
	 */
	public static function section( $id ,$config ) {
		if ( is_customize_preview() ) {
			if ( ! empty( $id ) && ! empty( $config ) ) {
				( new self )->render_section( $id, $config );
			}
		}
	}


	/**
	 * Rendering Section.
	 *
	 * @since 1.0.0
	 * 
	 * @param string  $id 	   A unique slug-like string to use as an id.
	 * @param array   $config  Hold the set of arguments.
	 */
	private function render_section( $id, $config ) {
		$rules = array(
			'title'			=> array(
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'string'
			),
			'description'	=> array(
				'rule'		=> 'not',
				'default'	=> '',
				'type'		=> 'string'
			),
			'panel'			=> array(
				'rule'		=> 'not',
				'default'	=> '',
				'type'		=> 'string'
			),
			'priority'		=> array(
				'rule'		=> 'not',
				'default'	=> '',
				'type'		=> 'number'
			)
		);

		// sanitizing $config and return sanitized value
		$args = yano_sanitize_argument( 'section:'. $id, $config, $rules );

		// creating section
		if ( $args != false ) {
			$this->wp_cm()->add_section( $id, $args );
		}
	}


	/**
	 * Adding Field.
	 *
	 * @since 1.0.0 
	 *
	 * @param string  $id 	   A unique slug-like string to use as an id.
	 * @param array   $config  Hold the set of arguments for specific field.
	 */
	public static function field( $type, $config ) {
		if ( is_customize_preview() ) {
			if ( ! empty( $type ) && ! empty( $config ) ) {
				(new self)->render_field( $type, $config );
			}
		}
	}


	/**
	 * Rendering Field.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $type    The type of field.
	 * @param array   $config  Hold the set of arguments for specific field.
	 */
	private function render_field( $type, $config ) {
		switch ( $type ) {
			case 'audio-uploader':
				(new Yano_Field_Audio_Uploader)->render( $this->wp_cm(), $config );
				break;
			case 'button-set':
				(new Yano_Field_Button_Set)->render( $this->wp_cm(), $config );
				break;
			case 'text':
				(new Yano_Field_Text)->render( $this->wp_cm(), $config );
				break;
			case 'select':
				(new Yano_Field_Select)->render( $this->wp_cm(), $config );
				break;
			case 'size':
				(new Yano_Field_Size)->render( $this->wp_cm(), $config );
				break;
			case 'sortable':
				(new Yano_Field_Sortable)->render( $this->wp_cm(), $config );
				break;
			case 'switch':
				(new Yano_Field_Switch)->render( $this->wp_cm(), $config );
				break;
			case 'checkbox':
				(new Yano_Field_Checkbox)->render( $this->wp_cm(), $config );
				break;
			case 'checkbox-multiple':
				(new Yano_Field_Checkbox_Multiple)->render( $this->wp_cm(), $config );
				break;
			case 'checkbox-pill':
				(new Yano_Field_Checkbox_Pill)->render( $this->wp_cm(), $config );
				break;
			case 'code-editor':
				(new Yano_Field_Code_Editor)->render( $this->wp_cm(), $config );
				break;
			case 'color':
				(new Yano_Field_Color)->render( $this->wp_cm(), $config );
				break;
			case 'color-picker':
				(new Yano_Field_Color_Picker)->render( $this->wp_cm(), $config );
				break;
			case 'color-set':
				(new Yano_Field_Color_Set)->render( $this->wp_cm(), $config );
				break;
			case 'content-editor':
				(new Yano_Field_Content_Editor)->render( $this->wp_cm(), $config );
				break;
			case 'date-picker':
				(new Yano_Field_Date_Picker)->render( $this->wp_cm(), $config );
				break;
			case 'dropdown-custom-post':
				(new Yano_Field_Dropdown_Custom_Post)->render( $this->wp_cm(), $config );
				break;
			case 'dropdown-page':
				(new Yano_Field_Dropdown_Page)->render( $this->wp_cm(), $config );
				break;
			case 'dropdown-post':
				(new Yano_Field_Dropdown_Post)->render( $this->wp_cm(), $config );
				break;
			case 'email':
				(new Yano_Field_Email)->render( $this->wp_cm(), $config );
				break;
			case 'file-uploader':
				(new Yano_Field_File_Uploader)->render( $this->wp_cm(), $config );
				break;
			case 'image-checkbox':
				(new Yano_Field_Image_Checkbox)->render( $this->wp_cm(), $config );
				break;
			case 'image-radio':
				(new Yano_Field_Image_Radio)->render( $this->wp_cm(), $config );
				break;
			case 'image-uploader':
				(new Yano_Field_Image_Uploader)->render( $this->wp_cm(), $config );
				break;
			case 'markup':
				(new Yano_Field_Markup)->render( $this->wp_cm(), $config );
				break;
			case 'numeric':
				(new Yano_Field_Numeric)->render( $this->wp_cm(), $config );
				break;
			case 'radio':
				(new Yano_Field_Radio)->render( $this->wp_cm(), $config );
				break;
			case 'range':
				(new Yano_Field_Range)->render( $this->wp_cm(), $config );
				break;
			case 'tagging':
				(new Yano_Field_Tagging)->render( $this->wp_cm(), $config );
				break;
			case 'tagging-select':
				(new Yano_Field_Tagging_Select)->render( $this->wp_cm(), $config );
				break;
			case 'textarea':
				(new Yano_Field_Textarea)->render( $this->wp_cm(), $config );
				break;
			case 'time-picker':
				(new Yano_Field_Time_Picker)->render( $this->wp_cm(), $config );
				break;
			case 'toggle':
				(new Yano_Field_Toggle)->render( $this->wp_cm(), $config );
				break;
			case 'url':
				(new Yano_Field_Url)->render( $this->wp_cm(), $config );
				break;
			case 'video-uploader':
				(new Yano_Field_Video_Uploader)->render( $this->wp_cm(), $config );
				break;
		}
	}
}