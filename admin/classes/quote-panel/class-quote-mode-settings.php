<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Quote Product Page
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Quote_Mode_Settings
{
	
	public static function panel_page() {
		?>
        <h3><?php _e('Quote Mode Payment Gateway', 'wc_email_inquiry'); ?></h3>
		<p><?php printf( __('Quotes Mode payment gateway is automatically activated when the feature is activated. Go to <a href="%s">WooCommerce Payment Gateways</a> to customize.', 'wc_email_inquiry'), admin_url( 'admin.php?page=woocommerce_settings&tab=payment_gateways&section=WC_Email_Inquiry_Gateway_Quotes' ) ); ?></p>
        
        <h3><?php _e('Shipping', 'wc_email_inquiry'); ?></h3>
		<p><?php printf( __('The Shipping Options set in <a href="%s">WooCommerce Shipping</a> apply to all Quotes Mode templates.', 'wc_email_inquiry'), admin_url( 'admin.php?page=woocommerce_settings&tab=shipping' ) ); ?></p>
	<?php
	}
}
?>