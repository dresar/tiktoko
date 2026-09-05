<?php
defined('ABSPATH') || exit;

/**
 * Sanitize the aguments in panel, section and control.
 *
 * @since 1.0.0
 *
 * @param  string  $field    The field type.
 * @param  array   $configs  List of configurations.
 * @param  array   $rules    List of rules.
 * @return array
 */
if (!function_exists('yano_sanitize_argument')) {
    function yano_sanitize_argument($field, $configs, $rules)
    {
        $new_config  = $configs;
        $config_keys = array_keys($configs);
        foreach ($rules as $key => $value) {
            if (!array_key_exists($key, $configs)) {
                if ($value['rule'] == 'required') {
                    yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                    return false;
                } elseif ($value['rule'] == 'empty') {
                    $new_config[$key] = $value['default'];
                }
            } else {
                if ($value['type'] == 'string') {
                    if (empty($configs[$key]) && $value['rule'] == 'required') {
                        yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                        return false;
                    } else {
                        if (is_string($configs[$key]) == false) {
                            yano_alert_warning('Error 103: ' . yano_code('info', $key) . ' must be supplied string in field ' . yano_code('success', $field) . '.');
                            return false;
                        }
                    }
                } elseif ($value['type'] == 'number') {
                    if (!isset($configs[$key])  && $value['rule'] == 'required') {
                        yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                        return false;
                    } else {
                        if (is_numeric($configs[$key]) == false) {
                            yano_alert_warning('Error 102: ' . yano_code('info', $key) . ' must be supplied numeric in field ' . yano_code('success', $field) . '.');
                            return false;
                        }
                    }
                } elseif ($value['type'] == 'array') {
                    if (empty($configs[$key]) && $value['rule'] == 'required') {
                        yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                        return false;
                    } else {
                        if (!is_array($configs[$key])) {
                            yano_alert_warning('Error 101: ' . yano_code('info', $key) . ' must be supplied array in ' . yano_code('success', $field) . '.');
                            return false;
                        }
                    }
                } elseif ($value['type'] == 'boolean') {
                    if (empty($configs[$key]) && $value['rule'] == 'required') {
                        yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                        return false;
                    } else {
                        if (!is_bool($configs[$key])) {
                            yano_alert_warning('Error 115: ' . yano_code('info', $key) . ' must be supplied boolean in ' . yano_code('success', $field) . '.');
                            return false;
                        }
                    }
                }
            }
        }
        return $new_config;
    }
}


/**
 * Checks the arguments.
 *
 * @since 1.0.0
 *
 * @param  array   $rules  List of rules.
 * @param  array   $data   Containing the data to be check.
 * @param  string  $field  The name of the field.
 * @return boolean
 */
if (!function_exists('yano_check_arguments')) {
    function yano_check_arguments($rules, $data, $field)
    {
        if (!empty($data)) {
            $keys = array_keys($data);
            foreach ($rules as $key => $value) {
                if (!array_key_exists($key, $data)) {
                    if ($value['rule'] == 'required') {
                        yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                        return false;
                        break;
                    }
                } else {
                    if ($value['type'] == 'string') {
                        if (empty($data[$key]) && $value['rule'] == 'required') {
                            yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                            return false;
                            break;
                        } else {
                            if (is_string($data[$key]) == false) {
                                yano_alert_warning('Error 103: ' . yano_code('info', $key) . ' must be supplied string in field ' . yano_code('success', $field) . '.');
                                return false;
                                break;
                            }
                        }
                    } elseif ($value['type'] == 'number') {
                        if (!isset($data[$key])  && $value['rule'] == 'required') {
                            yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                            return false;
                            break;
                        } else {
                            if (is_numeric($data[$key]) == false) {
                                yano_alert_warning('Error 102: ' . yano_code('info', $key) . ' must be supplied numeric in field ' . yano_code('success', $field) . '.');
                                return false;
                                break;
                            }
                        }
                    } elseif ($value['type'] == 'array') {
                        if (empty($data[$key]) && $value['rule'] == 'required') {
                            yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                            return false;
                            break;
                        } else {
                            if (!is_array($data[$key])) {
                                yano_alert_warning('Error 101: ' . yano_code('info', $key) . ' must be supplied array in ' . yano_code('success', $field) . '.');
                                return false;
                                break;
                            }
                        }
                    }
                }
            }
            return true;
        }
    }
}


/**
 * Check data type errors and print a warning.
 *
 * @since 1.0.0
 *
 * @param  array   $rule  		Set of rules.
 * @param  array   $data_value  Set of data to be check.
 * @param  string  $key 		Key of the rules.
 * @param  string  $field 		Name of the field.
 * @return boolean
 */
if (!function_exists('yano_data_type_message_error')) {
    function yano_data_type_message_error($rule_value, $data_value, $key, $field)
    {
        if ($rule_value['type'] == 'string') {
            if (empty($data_value[$key]) && $rule_value['rule'] == 'required') {
                yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                return false;
            } else {
                if (is_string($data_value[$key]) == false) {
                    yano_alert_warning('Error 103: ' . yano_code('info', $key) . ' must be supplied string in field ' . yano_code('success', $field) . '.');
                    return false;
                }
            }
        } elseif ($rule_value['type'] == 'number') {
            if (!isset($data_value[$key])  && $rule_value['rule'] == 'required') {
                yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                return false;
            } else {
                if (is_numeric($data_value[$key]) == false) {
                    yano_alert_warning('Error 102: ' . yano_code('info', $key) . ' must be supplied numeric in field ' . yano_code('success', $field) . '.');
                    return false;
                }
            }
        } elseif ($rule_value['type'] == 'array') {
            if (empty($data_value[$key]) && $rule_value['rule'] == 'required') {
                yano_alert_warning('Error 100: ' . yano_code('info', $key) . ' is required in field ' . yano_code('success', $field) . '.');
                return false;
            } else {
                if (!is_array($data_value[$key])) {
                    yano_alert_warning('Error 101: ' . yano_code('info', $key) . ' must be supplied array in ' . yano_code('success', $field) . '.');
                    return false;
                }
            }
        }
    }
}


/**
 * Sanitize the arguments of settings.
 *
 * @since 1.0.0
 *
 * @param  array  $configs  Set of configuration.
 * @return boolean|array
 */
if (!function_exists('yano_sanitize_settings_argument')) {
    function yano_sanitize_settings_argument($configs)
    {
        // rules for settings
        $rules = array(
            'settings'    => array(
                'rule'        => 'required',
                'default'    => ''
            ),
            'default'    => array(
                'rule'          => 'optional',
                'default'     => ''
            ),
            'validations' => array(
                'rule'          => 'optional',
                'default'     => ''
            )
        );
        $args = array();
        $config_keys = array_keys($configs);
        foreach ($rules as $key => $value) {
            if (!array_key_exists($key,  $configs)) {
                if ($value['rule'] == 'required') {
                    $error_msg = 'Error! ' . $key . ' is required in creating settings.';
                    return false;
                } elseif ($value['rule'] == 'optional') {
                    $args[$key] = $value['default'];
                }
            } else {
                $args[$key] = $configs[$key];
            }
        }
        return $args;
    }
}


/**
 * Return the complete name of the field with setting.
 *
 * @since 1.0.0
 *
 * @param  string  $field    Name of the field.
 * @param  string  $setting  The setting of the field.
 * @return string
 */
if (!function_exists('yano_error_field_name')) {
    function yano_error_field_name($field, $setting)
    {
        $output = $field;
        if (!empty($setting)) {
            $output = $field . ': ' . $setting;
        }
        return $output;
    }
}


/**
 * Prints an alert message for error or warning.
 * NOTE: this will only display in customizer preview state.
 *
 * @since 1.0.0
 *
 * @param  string  $message  The error or warning message to be printed.
 */
if (!function_exists('yano_alert_warning')) {
    function yano_alert_warning($message)
    {
        if (is_customize_preview()) {
            echo '<div class="yano-alert-msg" style="padding: 5px 5px; margin-bottom: 1rem; border-radius: 0.25em; color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; font-family: monospace;"><p style="font-size: 14px; margin: 0;"> <strong>[Yano] </strong> ' . $message . '</p></div>';
        }
    }
}


/**
 * Split string in to array via "|".
 *
 * @since 1.0.0
 *
 * @param  string  $string  The string to be exploded.
 * @return array
 */
if (!function_exists('yano_split_arr')) {
    function yano_split_arr($string)
    {
        return explode("|", $string);
    }
}


/**
 * Checks if the string ends with the $end_string.
 *
 * @since 1.0.0
 *
 * @param  string  $string      String to be check.
 * @param  string  $end_string  The keyword to be find in string.
 * @return boolean
 */
if (!function_exists('yano_ends_with')) {
    function yano_ends_with($string, $end_string)
    {
        $length = strlen($end_string);
        if ($length == 0) {
            return true;
        }
        return (substr($string, -$length) === $end_string);
    }
}


/**
 * Truncate the string without breaking words if the string is 
 * longer than the set limit
 *
 * @since 1.0.0
 * 
 * @param string  $string  value to check
 * @param number  $limit   the limit character of string
 * @return string 
 */
if (!function_exists('yano_wordwrap')) {
    function yano_wordwrap($string, $limit)
    {
        if (!empty($string)) {
            $output = $string;
            if (strlen($string) > $limit) {
                $output = explode("\n", wordwrap($string, $limit));
                $output = $output[0] . '...';
            }
            return $output;
        }
    }
}


/**
 * Inserting string inside <p> tag.
 *
 * @since 1.0.0
 *
 * @param string  $string  The string to be inserted in <p> tag.
 * @return html
 */
if (!function_exists('yano_p')) {
    function yano_p($string)
    {
        return '<p>' . $string . '</p>';
    }
}


/**
 * Checking if the unit size is in valid
 *
 * @since 1.0.0
 *
 * @param array   $units  list of units provided by user
 * @param string  $field  the name of field
 * @return boolean
 */
if (!function_exists('yano_unit_validation')) {
    function yano_is_valid_unit($units, $field)
    {
        $allowed = ['px', 'em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%'];
        if (!empty($units) && is_array($units)) {
            $unique_units = array_unique($units);
            foreach ($unique_units as $key => $value) {
                if (in_array($value, $allowed) == false) {
                    yano_alert_warning('Error 114: ' . yano_code('error', $value) . ' is invalid unit in field ' . yano_code('success', $field) . '.');
                    return false;
                    break;
                }
            }
            return true;
        }
        return false;
    }
}


/**
 * Validate if the default value is exi in given choices.
 *
 * @since 1.0.0
 *
 * @param string|array 	$default  The default value.
 * @param array  		$chocies  The list of choices.
 * @param string  		$field 	  The target field name.
 * @return  boolean
 */
if (!function_exists('yano_is_valid_default')) {
    function yano_is_valid_default($default, $choices, $field)
    {
        if (!empty($default)) {
            if (gettype($default) == 'array') {
                foreach ($default as $key => $value) {
                    if (array_key_exists($value, $choices) == false) {
                        yano_alert_warning('Error 305: default value ' . yano_code('error', $value) . ' does not exists in choices in field ' . yano_code('success', $field) . '.');
                        return false;
                    }
                }
            } else {
                if (array_key_exists($default, $choices) == false) {
                    yano_alert_warning('Error 305: default value ' . yano_code('error', $default) . ' does not exists in choices in field ' . yano_code('success', $field) . '.');
                    return false;
                }
            }
        }
        return true;
    }
}


/**
 * Validate the value of an arguments and display error message.
 *
 * @since 1.0.0
 *
 * @param  string 		 $args['argument'] 	the name of the argument 			| required									
 * @param  string|array  $args['value']		the value of the arguments 			| required
 * @param  string|array  $args['valid']   	the valid or list of valid value 	| required
 * @param  string 		 $args['allowed']	the allowed values for argument  	| optional
 */
if (!function_exists('yano_is_valid_argument_value')) {
    function yano_is_valid_argument_value($args)
    {
        if (empty($args['type'])) {
            $args['type'] = '';
        }

        if (!empty($args['value'])) {
            if (is_array($args['value']) == true) {
                foreach ($args['value'] as $key => $value) {
                    if ($args['type'] == 'key') {
                        // checking in array key
                        if (array_key_exists($value, $args['valid']) == false) {
                            if (empty($args['allowed'])) {
                                yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $value) . ' is invalid in field ' . yano_code('success', $args['field']) . '.');
                            } else {
                                yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $value) . ' is invalid in field ' . yano_code('success', $args['field']) . '. Here are the list of valid ' . yano_code('info', $args['allowed']) . '.');
                            }
                            return false;
                        }
                    } else {
                        // checking in array value
                        if (in_array($value,  $args['valid']) == false) {
                            if (empty($args['allowed'])) {
                                yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $value) . ' is invalid in field ' . yano_code('success', $args['field']) . '.');
                            } else {
                                yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $value) . ' is invalid in field ' . yano_code('success', $args['field']) . '. Here are the list of valid ' . yano_code('info', $args['allowed']) . '.');
                            }
                            return false;
                        }
                    }
                }
            } else {
                if ($args['type'] == 'key') {
                    // checking in array key
                    if (array_key_exists($args['value'], $args['valid']) == false) {
                        if (empty($args['allowed'])) {
                            yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $args['value']) . ' is invalid in field ' . yano_code('success', $args['field']) . '.');
                        } else {
                            yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $args['value']) . ' is invalid in field ' . yano_code('success', $args['field']) . '. Here are the list of valid ' . yano_code('info', $args['allowed']) . '.');
                        }
                        return false;
                    }
                } else {
                    // checking in array value
                    if (in_array($args['value'], $args['valid']) == false) {
                        if (empty($args['allowed'])) {
                            yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $args['value']) . ' is invalid in field ' . yano_code('success', $args['field']) . '.');
                        } else {
                            yano_alert_warning('Error 305: ' . $args['argument'] . ' value ' . yano_code('error', $args['value']) . ' is invalid in field ' . yano_code('success', $args['field']) . '. Here are the list of valid ' . yano_code('info', $args['allowed']) . '.');
                        }
                        return false;
                    }
                }
            }
        }
        return true;
    }
}


/**
 * Set value with default if value is empty .
 *
 * @since 1.0.0
 *
 * @param any  $value 	 The data value.
 * @param any  $default  The default value.
 * @return any
 **/
if (!function_exists('yano_set_default')) {
    function yano_set_default($value, $default)
    {
        return (empty($value) ? $default : $value);
    }
}


/**
 * Return array key into a single imploded string.
 *
 * @since 1.0.0
 *
 * @param array  $array  Containing the key to be imploded.
 * @return string
 */
if (!function_exists('yano_get_keys_imploded')) {
    function yano_get_keys_imploded($array)
    {
        $output = '';
        if (!empty($array)) {
            if (is_array($array)) {
                $output = implode(', ', array_keys($array));
            }
        }
        return $output;
    }
}


/**
 * Validate if the date given is valid by custom format.
 *
 * @since 1.0.0
 *
 * @param string  $date    The date given.
 * @param string  $format  The format to check.
 * @return boolean
 */
if (!function_exists('yano_is_valid_date')) {
    function yano_is_valid_date($date, $format)
    {
        if (!empty($date)) {
            $date_obj = DateTime::createFromFormat($format, $date);
            return $date_obj && $date_obj->format($format) == $date;
        }
        return false;
    }
}


/**
 * Checks if the array has a duplicate value.
 *
 * @since 1.0.0
 *
 * @param array  $array  The array value to be checked.
 * @return boolean
 */
if (!function_exists('yano_array_has_dupes')) {
    function yano_array_has_dupes($array)
    {
        return count($array) !== count(array_unique($array));
    }
}


/**
 * Return the value for special values | SPECIAL VALUES MEANS string to be
 * exploded as array using explode().
 *
 * @since 1.0.0
 *
 * @param string  $setting  The target setting index in db.
 * @return array
 */
if (!function_exists('yano_get_special_values')) {
    function yano_get_special_values($setting)
    {
        $output = [];
        if (!empty($setting)) {
            $value = get_theme_mod($setting);
            if (!empty($value)) {
                $output = $value;
                if (!is_array($value)) {
                    $output = explode(',', $value);
                }
            }
        }
        return $output;
    }
}


/**
 * Return value in array from json_encoded.
 *
 * @since 1.0.0
 * 
 * @param string  $setting 	The setting index in db.
 * @return array
 */
if (!function_exists('yano_get_decoded_values')) {
    function yano_get_decoded_values($setting)
    {
        $output = [];
        if (!empty($setting)) {
            if (!empty(get_theme_mod($setting))) {
                if (is_array(get_theme_mod($setting))) {
                    $output = get_theme_mod($setting);
                } else {
                    $output = json_decode(get_theme_mod($setting));
                }
            }
        }
        return $output;
    }
}


/**
 * Push a default validation in settings.
 *
 * @since 1.0.0
 *
 * @param array  $config 			   The set of configuration.
 * @param array  $default_validations  The default validations to be pushed in configuration.
 * @return array
 */
if (!function_exists('yano_push_default_validation')) {
    function yano_push_default_validation($config, $default_validations)
    {
        if (array_key_exists('validations', $config)) {
            foreach ($default_validations as $key => $validation) {
                array_push($config['validations'], $validation);
            }
        } else {
            $config['validations'] = $default_validations;
        }
        return $config;
    }
}


/**
 *  Return code with inline style.
 *
 * @since 1.0.0
 *
 * @param string  $type  	The type of alert or color.
 * @param string  $message  The message to be printed inside code.
 * @return html
 */
if (!function_exists('yano_code')) {
    function yano_code($type, $message)
    {
        $type = $type ? $type : 'default';
        $output = '';
        $background = '#000000';
        $border_color = '#000000';
        switch ($type) {
            case 'default':
                $background = '#d4d4d4';
                $border_color = '#9c9b9b';
                break;
            case 'info':
                $background = '#2989ec';
                $border_color = '#196dc3';
                break;
            case 'success':
                $background = '#26d04b';
                $border_color = '#0c962a';
            case 'error':
                $background = '#f32b0a';
                $border_color = '#bb1f06';
                break;
        }
        $template = '<code style="background: ' . $background . '; padding: 4px; border-radius: 3px; color: black;border: 1px solid #' . $border_color . ';" >' . $message . '</code>';
        return $template;
    }
}


/**
 * Validating argument "choices" and displaying error message
 * Used at: "Image-Radio" and "Image-Checkbox".
 *
 * @since 1.0.0
 * 
 * @param  array   $choices  The list of choices.
 * @param  string  $field 	 The target field name.
 * @return boolean
 */
if (!function_exists('yano_image_select_valid_choices')) {
    function yano_image_select_valid_choices($choices, $field)
    {
        if (!empty($choices)) {
            foreach ($choices as $choice_key => $choice_value) {
                // checking if the choice key index must supplied an array
                if (is_array($choice_value) == false) {
                    yano_alert_warning('Error 316: choices values must be supplied an array in index ' . yano_code('error', 'KEY: ' . $choice_key) . ' at field ' . yano_code('success', $field) . '.');
                    return false;
                    break;
                } else {

                    // checking if the "image" and "title" key exists in $choice_value array
                    $allowed_keys = ['image', 'title'];
                    foreach ($allowed_keys as $key => $value) {
                        if (array_key_exists($value, $choice_value) == false) {
                            yano_alert_warning('Error 317: choices value at index ' . yano_code('error', 'KEY: ' . $choice_key) . ' has missing ' . yano_code('info', $value) . ' at field ' . yano_code('success', $field) . '.');
                            return false;
                        } else {
                            foreach ($choice_value as $child_key => $child_value) {
                                // checking if $child_value is empty
                                if (empty($child_value)) {
                                    yano_alert_warning('Error 319: choices value at ' . yano_code('error', $choice_key . ' > ' . $child_key) . ' is required at field ' . yano_code('success', $field));
                                    return false;
                                } else {
                                    // checking $child_value if not string
                                    if (gettype($child_value) != 'string') {
                                        yano_alert_warning('Error 318: choices value at ' . yano_code('error', $choice_key . ' > ' . $child_key) . ' must be supplied ' . yano_code('info', 'string') . ' at field ' . yano_code('success', $field));
                                        return false;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
}


/**
 * Validating argument "size" and displaying error messages
 * Used at: "Image-Radio" and "Image-Checkbox".
 *
 * @since 1.0.0
 * 
 * @param  array   $size   The set size.
 * @param  string  $field  The target field name.
 * @return boolean
 */
if (!function_exists('yano_image_select_valid_size')) {
    function yano_image_select_valid_size($size, $field)
    {
        if (!empty($size)) {
            $allowed_keys = ['width', 'height'];
            foreach ($allowed_keys as $key => $value) {
                if (array_key_exists($value, $size) == false) {
                    yano_alert_warning('Error 321: size value has missing index ' . yano_code('info', $value) . ' at field ' . yano_code('success', $field) . '.');
                    return false;
                } else {
                    foreach ($size as $key => $value) {
                        if (gettype($value) != 'string') {
                            //if (gettype($child_value) != 'string') {
                            yano_alert_warning('Error 322: size value at ' . yano_code('error', $key) . ' must be supplied ' . yano_code('info', 'string') . ' at field ' . yano_code('success', $field));
                            return false;
                            //}
                        }
                    }
                }
            }
        }
        return true;
    }
}


/**
 * Validating the attachment and displaying error message.
 *
 * @since 1.0.0
 *
 * @param string  $args['attachment']  The attachment value is either 'url' or 'attachment id'.
 * @param string  $args['field'] 	   The complete field name.
 * @param string  $args['type'] 	   The type of media 'image, video, text and others'.
 * @return boolean
 */
if (!function_exists('yano_is_valid_attachment')) {
    function yano_is_valid_attachment($args)
    {
        if (!empty($args['attachment'])) {
            if (is_array($args['attachment'])) {
                foreach ($args['attachment'] as $key => $value) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        return true;
                    } else {
                        if (wp_get_attachment_url($value) == false) {
                            yano_alert_warning('Error 330: ' . yano_code('info', $args['type']) . ' attachment not found or invalid ' . yano_code('error', 'attachment id: ' . $value) . ' in field ' . yano_code('success', $args['field']) . '.');
                            return false;
                        }
                    }
                }
            } else {
                if (filter_var($args['attachment'], FILTER_VALIDATE_URL)) {
                    return true;
                } else {
                    if (wp_get_attachment_url($args['attachment']) == false) {
                        yano_alert_warning('Error 330: ' . yano_code('info', $args['type']) . ' attachment not found or invalid ' . yano_code('error', 'attachment id: ' . $args['attachment']) . ' in field ' . yano_code('success', $args['field']) . '.');
                        return false;
                    }
                }
            }
        }
        return true;
    }
}


/**
 * Returning unique array and fallback to default if array is empty.
 *
 * @since 1.0.0
 *
 * @param array  $array 	The array value.
 * @param any 	 $default  	The default fallback value.
 * @return any
 */
if (!function_exists('yano_unique')) {
    function yano_unique($array, $default)
    {
        $output = $default;
        if (!empty($array)) {
            if (is_array($array)) {
                $output = array_unique($array);
            }
        }
        return $output;
    }
}
