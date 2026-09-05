<?php

/**
 * Plugin Name:   	  Yano Customizer Framework
 * Description:   	  Yano is a tool for WordPress Theme Developer to develop theme using WordPress Customizer API while writing clean and minimal code.
 * Author:        	  Mafel John Cahucom
 * Author URI:    	  https://www.facebook.com/mafeljohn.cahucom
 * Version:       	  1.0.0
 * Text Domain:   	  yano-customizer-framework
 * Requires WP:   	  4.9
 * GitHub Plugin URI: https://mafelcahucom.github.io/yano-customizer-framework/
 * License: GPLv2 or later
 */

// Exist direct access.
defined('ABSPATH') || exit;


// Check if autload exists.
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}


// Get The Current Location In URL.
function tikstore_yano_resource_url()
{
    return get_template_directory_uri() . "/libraries/yano-customizer/";
}


// Autoload Dependencies.
use Core\Yano_Config;

// Instantiating Yano_Config Class.
$CONFIG = new Yano_Config;

// Adding all third party libraries.
$CONFIG->register_enqueue();

// Requiring Global Helper.
require dirname(__FILE__) . '/lib/Yano_Helper.php';

// Requiring Global Utilities.
require dirname(__FILE__) . '/lib/Yano_Util.php';

// Requiring main core Yano class.
require dirname(__FILE__) . '/core/Yano.php';
