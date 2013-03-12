<?php
/*
Plugin Name: WooCommerce Email Inquiry & Cart Options LITE
Description: Transform your entire WooCommerce products catalog or any individual product into an online brochure with Product Email Inquiry button and pop-up email form. Add product email inquiry functionality to any product either with WooCommerce functionality or hide that functionality and the page becomes a brochure.
Version: 1.0.0
Author: A3 Revolution
Author URI: http://www.a3rev.com/
License: This software is under commercial license and copyright to A3 Revolution Software Development team

	WooCommerce Email Inquiry & Cart Options. Plugin for the WooCommerce shopping Cart.
	Copyright© 2011 A3 Revolution Software Development team
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define('WC_EMAIL_INQUIRY_FILE_PATH', dirname(__FILE__));
define('WC_EMAIL_INQUIRY_DIR_NAME', basename(WC_EMAIL_INQUIRY_FILE_PATH));
define('WC_EMAIL_INQUIRY_FOLDER', dirname(plugin_basename(__FILE__)));
define('WC_EMAIL_INQUIRY_URL', WP_CONTENT_URL.'/plugins/'.WC_EMAIL_INQUIRY_FOLDER);
define('WC_EMAIL_INQUIRY_DIR', WP_CONTENT_DIR.'/plugins/'.WC_EMAIL_INQUIRY_FOLDER);
define('WC_EMAIL_INQUIRY_NAME', plugin_basename(__FILE__) );
define('WC_EMAIL_INQUIRY_IMAGES_URL',  WC_EMAIL_INQUIRY_URL . '/assets/images' );
define('WC_EMAIL_INQUIRY_JS_URL',  WC_EMAIL_INQUIRY_URL . '/assets/js' );
define('WC_EMAIL_INQUIRY_CSS_URL',  WC_EMAIL_INQUIRY_URL . '/assets/css' );
if(!defined("WC_EMAIL_AUTHOR_URI"))
    define("WC_EMAIL_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-email-inquiry-and-cart-options/");

include('admin/classes/class-wc-email-inquiry-settings.php');
include('classes/class-wc-email-inquiry-functions.php');
include('classes/class-wc-email-inquiry-hook.php');
include('classes/class-wc-email-inquiry-metabox.php');
include('admin/wc-email-inquiry-init.php');

/**
* Call when the plugin is activated and deactivated
*/
register_activation_hook(__FILE__,'wc_email_inquiry_install');
?>