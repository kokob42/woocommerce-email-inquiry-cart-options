<?php
function wc_email_inquiry_install(){
	update_option('a3rev_wc_email_inquiry_version', '1.0.0');
	WC_Email_Inquiry_Settings::set_settings_default(true, true);
}

update_option('a3rev_wc_email_inquiry_plugin', 'wc_email_inquiry');

/**
 * Load languages file
 */
function wc_email_inquiry_init() {
	load_plugin_textdomain( 'wc_email_inquiry', false, WC_EMAIL_INQUIRY_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wc_email_inquiry_init');

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Email_Inquiry_Hook_Filter', 'plugin_extra_links'), 10, 2 );
				
	// Include style into header
	add_action('get_header', array('WC_Email_Inquiry_Hook_Filter', 'add_style_header') );
	
	// Include script into footer
	add_action('get_footer', array('WC_Email_Inquiry_Hook_Filter', 'script_contact_popup'), 1);
	
	// AJAX wc_email_inquiry contact popup
	add_action('wp_ajax_wc_email_inquiry_popup', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_popup') );
	add_action('wp_ajax_nopriv_wc_email_inquiry_popup', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_popup') );
	
	// AJAX wc_email_inquiry_action
	add_action('wp_ajax_wc_email_inquiry_action', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_action') );
	add_action('wp_ajax_nopriv_wc_email_inquiry_action', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_action') );
	
	// Hide Add to Cart button on Shop page
	add_action('woocommerce_before_template_part', array('WC_Email_Inquiry_Hook_Filter', 'shop_before_hide_add_to_cart_button'), 100, 3 );
	add_action('woocommerce_after_template_part', array('WC_Email_Inquiry_Hook_Filter', 'shop_after_hide_add_to_cart_button'), 1, 3 );
	
	// Hide Add to Cart button on Details page
	add_action('woocommerce_before_add_to_cart_button', array('WC_Email_Inquiry_Hook_Filter', 'details_before_hide_add_to_cart_button'), 100 );
	add_action('woocommerce_after_add_to_cart_button', array('WC_Email_Inquiry_Hook_Filter', 'details_after_hide_add_to_cart_button'), 1 );
		
	// Add Email Inquiry Button on Shop page
	$wc_email_inquiry_button_position = esc_attr(get_option('wc_email_inquiry_button_position'));
	if ($wc_email_inquiry_button_position == 'above' )
		add_action('woocommerce_before_template_part', array('WC_Email_Inquiry_Hook_Filter', 'shop_add_email_inquiry_button_above'), 9, 3);
	else
		add_action('woocommerce_after_shop_loop_item', array('WC_Email_Inquiry_Hook_Filter', 'shop_add_email_inquiry_button_below'), 12);
	
	// Add Email Inquiry Button on Product Details page
	if ($wc_email_inquiry_button_position == 'above' )
		add_action('woocommerce_before_add_to_cart_button', array('WC_Email_Inquiry_Hook_Filter', 'details_add_email_inquiry_button_above'), 9 );
	else
		add_action('woocommerce_after_template_part', array('WC_Email_Inquiry_Hook_Filter', 'details_add_email_inquiry_button_below'), 2, 3);
	
	// Include script admin plugin
	add_action('admin_head', array('WC_Email_Inquiry_Hook_Filter', 'admin_footer_scripts') );
	add_action('admin_footer', array('WC_Email_Inquiry_Hook_Filter', 'wp_admin_footer_scripts') );
	
	// Add meta boxes to product page
	add_action( 'admin_menu', array('WC_Email_Inquiry_MetaBox', 'add_meta_boxes') );

	update_option('a3rev_wc_email_inquiry_version', '1.0.0');
	
	global $wc_email_inquiry_settimgs;
	$wc_email_inquiry_settimgs = new WC_Email_Inquiry_Settings();
?>