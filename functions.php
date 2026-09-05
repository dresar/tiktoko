<?php

/**
 * Tiktoko functions and definitions
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package Tikstore
 * @author Labs ID Team <admin@labs.id>
 */


define('TIKSTORE_VERSION', '1.6.6');
define('TIKSTORE_PATH', get_template_directory());
define('TIKSTORE_URL', get_stylesheet_directory_uri());
define('TIKSTORE_AUTHOR', 'TikToko');
define('TIKSTORE_NAME','TikToko');

/**
 * required all classes
 */
//require_once TIKSTORE_PATH . '/vendor/autoload.php';
require_once TIKSTORE_PATH . '/libraries/tgm/class-tgm-plugin-activation.php';
require_once TIKSTORE_PATH . '/libraries/yano-customizer/yano-customizer.php';
require_once TIKSTORE_PATH . '/classes/customizer.php';
require_once TIKSTORE_PATH . '/classes/product.php';
require_once TIKSTORE_PATH . '/classes/order.php';
require_once TIKSTORE_PATH . '/classes/shippings/base.php';
require_once TIKSTORE_PATH . '/classes/shippings/free.php';
require_once TIKSTORE_PATH . '/classes/shippings/rajaongkir.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/base.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/manual-bank-transfer.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-mandiri.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-bca.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-bsi.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-bni.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-bri.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-permata.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-cimbniaga.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/transfer-bank-seabank.php';
require_once TIKSTORE_PATH . '/classes/payment-methods/cod.php';
require_once TIKSTORE_PATH . '/classes/notifications/base.php';
require_once TIKSTORE_PATH . '/classes/notifications/responic-default-message.php';
require_once TIKSTORE_PATH . '/classes/notifications/responic.php';
// require_once TIKSTORE_PATH . '/classes/license.php';

/**
 * required all functions
 */
require_once TIKSTORE_PATH . '/functions/setup.php';
require_once TIKSTORE_PATH . '/functions/customizer.php';
require_once TIKSTORE_PATH . '/functions/register.php';
require_once TIKSTORE_PATH . '/functions/asset.php';
require_once TIKSTORE_PATH . '/functions/query.php';
require_once TIKSTORE_PATH . '/functions/misc.php';
require_once TIKSTORE_PATH . '/functions/shipping.php';
require_once TIKSTORE_PATH . '/functions/payment-method.php';
require_once TIKSTORE_PATH . '/functions/order.php';
require_once TIKSTORE_PATH . '/functions/notification.php';
require_once TIKSTORE_PATH . '/functions/tracking.php';

function themedd_updater() {
	require_once( trailingslashit( TIKSTORE_PATH ) . '/classes/updater/theme-updater.php' );
}

add_action( 'after_setup_theme', 'themedd_updater' );

if (!function_exists('__dd')) {
    function __dd()
    {
        $bt     = debug_backtrace();
        $caller = array_shift($bt);

        $result = array(
            "file"  => $caller["file"],
            "line"  => $caller["line"],
            "args"  => func_get_args()
        );

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
