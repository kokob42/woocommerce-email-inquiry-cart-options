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
class WC_Email_Inquiry_Order_Mode_Settings
{
	
	public static function panel_page() {
		?>
        <h3><?php _e('Order Mode Payment Gateway', 'wc_email_inquiry'); ?></h3>
		<p><?php printf( __('Orders Mode payment gateway is automatically activated when the feature is activated. Go to <a href="%s">WooCommerce Payment Gateways</a> to customize.', 'wc_email_inquiry'), admin_url( 'admin.php?page=woocommerce_settings&tab=payment_gateways&section=WC_Email_Inquiry_Gateway_Orders' ) ); ?></p>
	<?php
	}
}
?>