<?php
/*
Plugin Name: WooCommerce Email Inquiry & Cart Options LITE
Description: Transform your entire WooCommerce products catalog or any individual product into an online brochure with Product Email Inquiry button and pop-up email form. Add product email inquiry functionality to any product either with WooCommerce functionality or hide that functionality and the page becomes a brochure.
Version: 1.0.8
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
define('WC_EMAIL_INQUIRY_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define('WC_EMAIL_INQUIRY_DIR', WP_CONTENT_DIR.'/plugins/'.WC_EMAIL_INQUIRY_FOLDER);
define('WC_EMAIL_INQUIRY_NAME', plugin_basename(__FILE__) );
define('WC_EMAIL_INQUIRY_TEMPLATE_PATH', WC_EMAIL_INQUIRY_FILE_PATH . '/templates' );
define('WC_EMAIL_INQUIRY_IMAGES_URL',  WC_EMAIL_INQUIRY_URL . '/assets/images' );
define('WC_EMAIL_INQUIRY_JS_URL',  WC_EMAIL_INQUIRY_URL . '/assets/js' );
define('WC_EMAIL_INQUIRY_CSS_URL',  WC_EMAIL_INQUIRY_URL . '/assets/css' );
if(!defined("WC_EMAIL_AUTHOR_URI"))
    define("WC_EMAIL_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-email-inquiry-and-cart-options/");

include('admin/admin-ui.php');
include('admin/admin-interface.php');

include('admin/admin-pages/admin-rules-roles-page.php');
include('admin/admin-pages/admin-email-inquiry-page.php');
include('admin/admin-pages/admin-quotes-mode-page.php');
include('admin/admin-pages/admin-orders-mode-page.php');

include('admin/admin-init.php');

include('classes/class-wc-email-inquiry-functions.php');
include('classes/class-wc-email-inquiry-hook.php');
include('classes/class-wc-email-inquiry-metabox.php');

include('admin/wc-email-inquiry-init.php');


/**
* Call when the plugin is activated and deactivated
*/
register_activation_hook(__FILE__,'wc_email_inquiry_install');

function wc_email_inquiry_lite_uninstall(){
	if ( get_option('wc_email_inquiry_lite_clean_on_deletion') == 1 ) {
		
		delete_option( 'wc_email_inquiry_rules_roles_settings' );
		delete_option( 'wc_email_inquiry_global_settings' );
		delete_option( 'wc_email_inquiry_contact_form_settings' );
		delete_option( 'wc_email_inquiry_3rd_contactforms_settings' );
		delete_option( 'wc_email_inquiry_email_options' );
		delete_option( 'wc_email_inquiry_customize_email_button' );
		delete_option( 'wc_email_inquiry_customize_email_popup' );
		delete_option( 'wc_email_inquiry_contact_success' );
		
		delete_option( 'wc_email_inquiry_fancybox_popup_settings' );
		delete_option( 'wc_email_inquiry_colorbox_popup_settings' );
		
		delete_option( 'wc_email_inquiry_quote_product_page' );
		delete_option( 'wc_email_inquiry_quote_widget_cart' );
		delete_option( 'wc_email_inquiry_quote_cart_page' );
		delete_option( 'wc_email_inquiry_quote_cart_note' );
		delete_option( 'wc_email_inquiry_quote_checkout_page' );
		delete_option( 'wc_email_inquiry_quote_checkout_top_message' );
		delete_option( 'wc_email_inquiry_quote_checkout_bottom_message' );
		delete_option( 'wc_email_inquiry_quote_order_received_page' );
		delete_option( 'wc_email_inquiry_quote_order_received_top_message' );
		delete_option( 'wc_email_inquiry_quote_order_received_bottom_message' );
		delete_option( 'wc_email_inquiry_quote_new_account_email_settings' );
		delete_option( 'wc_email_inquiry_quote_new_account_email_content' );
		
		delete_option( 'wc_email_inquiry_order_product_page' );
		delete_option( 'wc_email_inquiry_order_widget_cart' );
		delete_option( 'wc_email_inquiry_order_cart_page' );
		delete_option( 'wc_email_inquiry_order_cart_note' );
		delete_option( 'wc_email_inquiry_order_checkout_page' );
		delete_option( 'wc_email_inquiry_order_checkout_top_message' );
		delete_option( 'wc_email_inquiry_order_checkout_bottom_message' );
		delete_option( 'wc_email_inquiry_order_order_received_page' );
		delete_option( 'wc_email_inquiry_order_order_received_top_message' );
		delete_option( 'wc_email_inquiry_order_order_received_bottom_message' );
		delete_option( 'wc_email_inquiry_order_new_account_email_settings' );
		delete_option( 'wc_email_inquiry_order_new_account_email_content' );
		
		delete_option( 'wc_email_inquiry_lite_clean_on_deletion' );
	}
}
if ( get_option('wc_email_inquiry_lite_clean_on_deletion') == 1 ) {
	register_uninstall_hook( __FILE__, 'wc_email_inquiry_lite_uninstall' );
}
?>
