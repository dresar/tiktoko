<?php
namespace Field;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Settings.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Yano_Settings {


	/**
	 * Holds all the validations.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $validations;


	/**
	 * Initialize for creating settings.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $wp_customize  Class for WP_CUSTOMIZE_MANAGER. 
	 * @param  array   $args 		  Set of arguments for rendering settings.
	 * @param string   $field_name 	  Field name with settings.
	 * @return boolean
	 */
	public function init_settings( $wp_customize, $args, $field_name ) {
		$arguments = $this->sanitize_argument( $args, $field_name );
		if ( $arguments != false ) {
			$this->validations = $arguments['validations'];
			$wp_customize->add_setting( $arguments['id'], array(
				'default'			=> $arguments['default'],
				'validate_callback'	=> function( $validity, $value ) {
					return $this->validations( $this->validations, $validity, $value );
				}
			));
			return true;
		}
		return false;
	}


	/**
	 * Sanitize the arguments depending on the required parameter.
	 *
	 * @since 1.0.0
	 * 
	 * @param array   $args 	   Set of arguments for rendering settings.
	 * @param string  $field_name  Field name with settings.
	 * @return bolean|array
	 */
	protected function sanitize_argument( $args, $field_name ) {
		$rules = [
			'id'			=> [
				'rule'		=> 'required',
				'default'	=> '',
				'type'		=> 'string'
			],
			'default'		=> [
				'rule'	  	=> 'optional',
				'default' 	=> '',
				'type'		=> 'any'
			],
			'validations' 	=> [
				'rule'	  	=> 'optional',
				'default' 	=> '',
				'type'		=> 'array'
			]
		];

		$configs = [];
		$config_keys = array_keys( $args );
		foreach ( $rules as $key => $value ) {
			if ( ! array_key_exists( $key,  $args ) ) {
				if ( $value['rule'] == 'required' ) {
					yano_alert_warning( 'Error 100: '. yano_code( 'info', $key ) .' is required in field '. yano_code( 'success', $field_name ) .'.' );
					return false;
				} elseif ( $value['rule'] == 'optional' ) {
					$configs[ $key ] = $value['default'];
				}
			} else {
				if ( $value['type'] == 'string' ) {
					if ( empty( $args[ $key ] ) && $value['rule'] == 'required' ) {
						yano_alert_warning( 'Error 100: '. yano_code( 'info', $key ) .' is required in field '. yano_code( 'success', $field_name ) .'.' );
						return false;
					}else {
						if ( is_string( $args[ $key ] ) == false ) {
							yano_alert_warning( 'Error 103: '. yano_code( 'info', $key ) .' must be supplied string in field '. yano_code( 'success', $field_name ) .'.' );
							return false;
						}
					}
				} elseif ( $value['type'] == 'array' ) {
					if ( empty( $args[ $key ] ) && $value['rule'] == 'required' ) {
						yano_alert_warning( 'Error 100: '. yano_code( 'info', $key ) .' is required in field '. yano_code( 'success', $field_name ) .'.' );
						return false;
					}else {
						if ( ! is_array( $args[ $key ] ) ) {
							yano_alert_warning( 'Error 101: '. yano_code( 'info', $key ) .' must be supplied array in '. yano_code( 'success', $field_name ) .'.' );
							return false;
						}
					}
				}
				$configs[ $key ] = $args[ $key ];
			}
		}
		return $configs;
	}


	/**
	 * Call the list of validation methods.
	 *
	 * @since 1.0.0
	 * 
	 * @param  array   $validations  List of validations.
	 * @param  object  $validity 	 Validations message.
	 * @param  string  $value 		 Value of field.
	 * @return object
	 */
	private function validations( $validations, $validity, $value ) {
		$rules = array(
			'required'		=> array(
				'param'		=> false
			),
			'valid_email'	=> array(
				'param'		=> false
			),
			'valid_url'		=> array(
				'param'		=> false	
			),
			'valid_ip'		=> array(
				'param'		=> false	
			),
			'numeric'		=> array(
				'param'		=> false	
			),
			'is_integer'	=> array(
				'param'		=> false	
			),
			'alpha'			=> array(
				'param'		=> false
			),
			'alpha_numeric'	=> array(
				'param'		=> false
			),
			'min_length'	=> array(
				'param'		=> true
			),
			'max_length'	=> array(
				'param'		=> true
			),
			'exact_length'	=> array(
				'param'		=> true
			),
			'greater_than'	=> array(
				'param'		=> true
			),
			'greater_than_equal_to'	=> array(
				'param'		=> true
			),
			'less_than'	=> array(
				'param'		=> true
			),
			'less_than_equal_to'	=> array(
				'param'		=> true
			),
			'in_list'		=> array(
				'param'		=> true
			),
			'not_in_list'	=> array(
				'param'		=> true
			),
			'total_words' 	=> array(
				'param'		=> true
			),
			'total_words_greater_than' => array(
				'param'		=> true
			),
			'total_words_less_than'	   => array(
				'param'		=> true
			),
			'equal_to_setting'	=> array(
				'param'		=> true
			),
			'not_equal_to_setting'	=> array(
				'param'		=> true
			)
		);

		if ( ! empty( $validations ) ) {
			if ( is_array( $validations ) ) {

				foreach ( $validations as $key => $data ) {
					$clean_data = $this->get_clean_validation( $data );

					if ( array_key_exists( $clean_data, $rules ) ) {
						if ( $rules[ $clean_data ]['param'] == true ) {
							if ( $this->has_bracket( $data ) == true ) {
								if ( ! empty( $this->get_param( $data ) ) ) {
									// calling validation method with parameter
									if ( method_exists( __CLASS__, $clean_data ) ) {
										call_user_func( array( __CLASS__, $clean_data ), $validity, $value, $this->get_param( $data ) );
									}
								} else {
									$validity->add( 'fatal_error', yano_p( 'Error 301: <strong>'. $clean_data . '</strong> has no parameter supplied.' ) );
								}
							} else {
								$validity->add( 'fatal_error', yano_p( 'Error 301: <strong>'. $clean_data . '</strong> has no parameter supplied.' ) );
							}
						} else {
							// calling validation method
							if ( method_exists( __CLASS__, $clean_data ) ) {
								call_user_func( array( __CLASS__, $clean_data ), $validity, $value );
							}
						}
					} else {
						// checkig if a custom validation
						if ( $this->is_custom_validation( $clean_data ) == true ) {
							if ( function_exists( $clean_data ) ) {
								call_user_func( $clean_data, $validity, $value );
							} else {
								$validity->add( 'fatal_error', yano_p( 'Error 302: custom validation function <strong>'. $clean_data .'</strong> not found.' ) );
							}
						} else {
							$validity->add( 'fatal_error', yano_p( 'Error 300: invalid validation <strong>'. $clean_data .'</strong>.' ) );
						}
					}
				}

			} else {
				$validity->add( 'fatal_error', yano_p( 'Error 303: validation arguments must be in a set of array.' ) );
			}
		}
		return $validity;
	}


	/**
	 * Get the parameter inside bracket [].
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $data  Data to be check.  
	 * @return string
	 */
	private function get_param( $data ) {
		preg_match( '#\[(.*?)\]#', $data, $match );
		return $match[1];
	}


	/**
	 * Checks if the validation has a parameter.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $data  Data to be check.
	 * @return boolean
	 */
	private function has_bracket( $data ) {
		if ( strpos( $data, '[' ) || strpos( $data, ']' ) ) {
			return true;
		}
	}


	/**
	 * Gets the value without a bracket.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $value  Data to be check.
	 * @return string
	 */
	private function get_clean_validation( $value ) {
		if ( $this->has_bracket( $value ) == true ) {
			$explode = explode( '[', $value, 2 );
			return $explode[0];
		}
		return $value;
	}


	/**
	 * Checks if the validation is custom.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $value  Value to be check.
	 * @return boolean
	 */
	private function is_custom_validation( $value ) {
		$length = strlen( '_yano_validation' ); 
	    if ( $length == 0 ) { 
	        return true; 
	    } 
	    return ( substr( $value, -$length ) === '_yano_validation' ); 
	}

	

	/**
	 * ###############################################
	 * 			SETS OF VALIDATIONS
	 * ###############################################
	 */
	

	/**
	 * Print error message if the value is empty
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function required( $validity, $value ) {
		if ( empty( $value ) ) {
			$validity->add( 'error', yano_p( 'Required field.' ) );
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value is empty a valid email.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function valid_email( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( filter_var( $value, FILTER_VALIDATE_EMAIL ) == false ) {
				$validity->add( 'error', yano_p( 'Invalid email address.' ) );
			}
		}
		return $validity;
	}
	

	/**
	 * Print error message if the value is not valid url.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function valid_url( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( filter_var( $value, FILTER_VALIDATE_URL ) == false ) {
				$validity->add( 'error', yano_p( 'Invalid url.' ) );
			}
		}
		return $validity;
	}


	/**
	 * Print error message if the value is not valid IP Address.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function valid_ip( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( filter_var( $value, FILTER_VALIDATE_IP ) == false ) {
				$validity->add( 'error', yano_p( 'Invalid IP address.' ) );
			}
		}
		return $validity;
	}


	/**
	 * Print error message if the value is not valid number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function numeric( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( is_numeric( $value ) == false ) {
				$validity->add( 'error', yano_p( 'Value must be numeric.' ) );
			}
		}
		return $validity;
	}


	/**
	 * Print error message if the value is not integer,
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function is_integer( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( filter_var( $value, FILTER_VALIDATE_INT ) == false ) {
				$validity->add( 'error', yano_p( 'Invalid integer.' ) );
			}
		}
		return $validity;
	}


	/**
	 * Print error message if the value contains not alphabetical.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function alpha( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( ctype_alpha( $value ) == false ) {
				$validity->add( 'error', 'Must contain only alphabetic characters.' );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value contains none alphabetical and numeric.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @return object
	 */
	private function alpha_numeric( $validity, $value ) {
		if ( ! empty( $value ) ) {
			if ( ctype_alnum( $value ) == false ) {
				$validity->add( 'error', 'Must contain only numeric and alphabetic characters.' );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if string length is less than $min.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $min 	  Minimum length of characters.
	 * @return object
	 */
	private function min_length( $validity, $value, $min ) {
		if ( ctype_digit( $min ) == true ) {
			if ( strlen( $value ) < intval( $min ) ) {
				$validity->add( 'error', yano_p( 'Characters must not lesser '. $min.'.'  ) );
			}
		} else {
			$validity->add( 'error', yano_p( 'Error 304: invalid parameter for min_length must be integer.' ) );
		}
		return $validity;
	}

	
	/**
	 * Print error message if character length is greater than $max.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $max 	  Maximum length of characters.
	 * @return object
	 */
	private function max_length( $validity, $value, $max ) {
		if ( ctype_digit( $max ) == true ) {
			if ( strlen( $value ) > intval( $max ) ) {
				$validity->add( 'error', yano_p( 'Characters must not exceed '. $max.'.'  ) );
			}
		} else {
			$validity->add( 'error', yano_p( 'Error 304: invalid parameter for max_length must be integer.' ) );
		}
		return $validity;
	}

	
	/**
	 * Print error message if character length is not equal to $length.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $length    Length of characters.
	 * @return object
	 */
	private function exact_length( $validity, $value, $length ) {
		if ( ctype_digit( $length ) == true ) {
			if ( strlen( $value ) != intval( $length ) ) {
				$validity->add( 'error', yano_p( 'Total characters must be exact '. $length .'.'  ) );
			}
		} else {
			$validity->add( 'error', yano_p( 'Error 304: invalid parameter for exact_length must be integer.' ) );
		}
	}


	/**
	 * Print error message if the value is less than or equal to $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Number set to be condition.
	 * @return object
	 */
	private function greater_than( $validity, $value, $number ) {
		if ( is_numeric( $value ) && is_numeric( $number ) ) {
			if ( floatval( $value ) <= $number ) {
				$validity->add( 'error', yano_p('Value must greater than '. $number .'.') );
			}
		} else {
			if ( is_numeric( $value ) == false ) {
				$validity->add( 'error', yano_p('Invalid value must be numeric.') );
			}

			if ( is_numeric( $number ) == false ) {
				$validity->add( 'error', yano_p( 'Error 304: invalid parameter for greater_than must be numeric.' ) );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value is less than to $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Number set to be condition.
	 * @return object
	 */
	private function greater_than_equal_to( $validity, $value, $number ) {
		if ( is_numeric( $value ) && is_numeric( $number ) ) {
			if ( floatval( $value ) < $number ) {
				$validity->add( 'error', yano_p('Value must greater than '. $number .'.') );
			}
		} else {
			if ( is_numeric( $value ) == false ) {
				$validity->add( 'error', yano_p('Invalid value must be numeric.') );
			}

			if ( is_numeric( $number ) == false ) {
				$validity->add( 'error', yano_p( 'Error 304: invalid parameter for greater_than_equal_to must be numeric.' ) );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value is greater than $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Number set to be condition.
	 * @return object
	 */
	private function less_than( $validity, $value, $number ) {
		if ( is_numeric( $value ) && is_numeric( $number ) ) {
			if ( floatval( $value ) >= $number ) {
				$validity->add( 'error', yano_p('Value must less than '. $number .'.') );
			}
		} else {
			if ( is_numeric( $value ) == false ) {
				$validity->add( 'error', yano_p('Invalid value must be numeric.') );
			}

			if ( is_numeric( $number ) == false ) {
				$validity->add( 'error', yano_p( 'Error 304: invalid parameter for less_than must be numeric.' ) );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value is greater than $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Number set to be condition.
	 * @return object
	 */
	private function less_than_equal_to( $validity, $value, $number ) {
		if ( is_numeric( $value ) && is_numeric( $number ) ) {
			if ( floatval( $value ) > $number ) {
				$validity->add( 'error', yano_p('Value must less than '. $number .'.') );
			}
		} else {
			if ( is_numeric( $value ) == false ) {
				$validity->add( 'error', yano_p('Invalid value must be numeric.') );
			}

			if ( is_numeric( $number ) == false ) {
				$validity->add( 'error', yano_p( 'Error 304: invalid parameter for less_than_equal_to must be numeric.' ) );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value is not in predetermined list value.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  array   $list 	  Set of predetermined values.
	 * @return object
	 */
	private function in_list( $validity, $value, $list ) {
		$filtered_list = array_filter( explode( ',', $list ) );
		if ( ! empty( $filtered_list ) ) {
			if ( ! in_array( $value, $filtered_list ) ) {
				$validity->add( 'error', yano_p( 'Value must be in predermined list <code>'. implode( ',', $filtered_list ) .'</code>' ) );
			}
		}
		return $validity;
	}

	
	/**
	 * Print error message if the value is in predetermined list value.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  array   $list 	  Set of predermined values.
	 * @return object
	 */
	private function not_in_list( $validity, $value, $list ) {
		$filtered_list = array_filter( explode( ',', $list ) );
		if ( ! empty( $filtered_list ) ) {
			if ( in_array( $value, $filtered_list ) ) {
				$validity->add( 'error', yano_p( 'Value must not in predermined list <code>'. implode( ',', $filtered_list ) .'</code>' ) );
			}
		}
		return $validity;
	}


	/**
	 * Print error message if value total word count is not equal to $number
	 * @param  object     $validity    	object for displaying error message
	 * @param  string 	  $value 	   	field value
	 * @param  integer 	  $number 		total words
	 * @return object 	  error message
	 */
	
	/**
	 * Print error message if the value total word count is not equal to $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Total count of words.
	 * @return object
	 */
	private function total_words( $validity, $value, $number ) {
		if ( is_numeric( $number ) ) {
			if ( intval( $number ) != str_word_count( $value ) ) {
				$validity->add( 'error', yano_p( 'Total words must be exactly '. intval( $number ) .'.' ) );
			}
		} else {
			$validity->add( 'error', yano_p( 'Error 304: invalid parameter for total_words must be numeric.' ) );
		}
	}

	
	/**
	 * Print error message if the value total word count is less than $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Total count of words.
	 * @return object
	 */
	private function total_words_greater_than( $validity, $value, $number ) {
		if ( is_numeric( $number ) ) {
			if ( str_word_count( $value ) < intval( $number ) ) {
				$validity->add( 'error', yano_p( 'Total words must be greater than '. intval( $number ) .'.' ) );
			}
		} else {
			$validity->add( 'error', yano_p( 'Error 304: invalid parameter for total_words_greater_than must be numeric.' ) );
		}
	}

	
	/**
	 * Print error message if the value total word count is greater than $number.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  number  $number 	  Total count of words.
	 * @return object
	 */
	private function total_words_less_than( $validity, $value, $number ) {
		if ( is_numeric( $number ) ) {
			if ( str_word_count( $value ) > intval( $number ) ) {
				$validity->add( 'error', yano_p( 'Total words must be less than '. intval( $number ) .'.' ) );
			}
		} else {
			$validity->add( 'error', yano_p( 'Error 304: invalid parameter for total_words_less_than must be numeric.' ) );
		}
	}

	
	/**
	 * Print error message if the value is not equal to $settings.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  string  $settings  The value of settings or get_theme_mod().
	 * @return object
	 */
	private function equal_to_setting( $validity, $value, $settings ) {
		if ( get_theme_mod( $settings ) ) {
			if ( get_theme_mod( $settings ) != $value ) {
				$validity->add( 'error', yano_p( 'Value must equal to setting: <code>'. $settings .'</code>.' ) );
			}
		}
		return $validity;
	}


	/**
	 * Print error message if the value is equal to $settings.
	 *
	 * @since 1.0.0
	 * 
	 * @param  object  $validity  Object for displaying error message.
	 * @param  string  $value 	  Value of the field.
	 * @param  string  $settings  The value of settings or get_theme_mod().
	 * @return object
	 */
	private function not_equal_to_setting( $validity, $value, $settings ) {
		if ( get_theme_mod( $settings ) ) {
			if ( get_theme_mod( $settings ) == $value ) {
				$validity->add( 'error', yano_p( 'Value must not equal to setting: <code>'. $settings .'</code>.' ) );
			}
		}
		return $validity;
	}
}