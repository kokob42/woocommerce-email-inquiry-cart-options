<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Order Widget Cart
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Order_Widget_Cart
{
	public static function get_settings_default() {
		$default_settings = array(
			'order_widget_cart_title'				=> __('Your Order Content', 'wc_email_inquiry'),
			'order_widget_view_cart_button'			=> __('View Order &rarr;', 'wc_email_inquiry'),
			'order_widget_checkout_button'			=> __('Send Order &rarr;', 'wc_email_inquiry'),
			'order_widget_no_product'				=> __('No products in the order.', 'wc_email_inquiry'),
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_order_widget_cart';
		
		$default_settings = WC_Email_Inquiry_Order_Widget_Cart::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_order_widget_cart;
		$wc_email_inquiry_order_widget_cart = WC_Email_Inquiry_Order_Widget_Cart::get_settings_default();
		
		return $wc_email_inquiry_order_widget_cart;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_order_widget_cart';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_Order_Widget_Cart::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Order_Widget_Cart::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = WC_Email_Inquiry_Order_Widget_Cart::get_settings_default();
		
		extract($customized_settings);
				
		?>
        <h3><?php _e('Widget Cart', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_widget_cart_title"><?php _e( 'Widget Cart Title', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_widget_cart_title ) ); ?>" name="<?php echo $option_name; ?>[order_widget_cart_title]" id="order_widget_cart_title" style="width:300px;"  /> <div class="description"><?php _e("Text that shows at top of widget", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_widget_view_cart_button"><?php _e( 'View Order Button', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_widget_view_cart_button ) ); ?>" name="<?php echo $option_name; ?>[order_widget_view_cart_button]" id="order_widget_view_cart_button" style="width:300px;"  /> <div class="description"><?php _e("Text that shows instead of 'View Cart &rarr;' on the button.", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_widget_checkout_button"><?php _e( 'Send Order', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_widget_checkout_button ) ); ?>" name="<?php echo $option_name; ?>[order_widget_checkout_button]" id="order_widget_checkout_button" style="width:300px;"  /> <div class="description"><?php _e("Text that displays instead of 'Checkout &rarr;' on the button", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_widget_no_product"><?php _e( 'No Product Text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_widget_no_product ) ); ?>" name="<?php echo $option_name; ?>[order_widget_no_product]" id="order_widget_no_product" style="width:300px;"  /> <div class="description"><?php _e("Text that shows instead of 'No products in the cart.'.", 'wc_email_inquiry');?></div>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>