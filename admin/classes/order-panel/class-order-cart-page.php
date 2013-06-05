<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Order Cart Page
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Order_Cart_Page
{
	public static function get_settings_default() {
		$default_settings = array(
			'order_cart_page_name'					=> __('Order', 'wc_email_inquiry'),
			'order_update_cart_button'				=> __('Update Order', 'wc_email_inquiry'),
			'order_goto_checkout'					=> __('Add Details and Send &rarr;', 'wc_email_inquiry'),
			'order_cart_empty'						=> __('Your order is currently empty.', 'wc_email_inquiry'),
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_order_cart_page';
		
		$default_settings = WC_Email_Inquiry_Order_Cart_Page::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
			update_option('wc_email_inquiry_order_cart_note', __("Note: Shipping and taxes are estimated and will be updated during checkout based on your billing and shipping information.", "wc_email_inquiry") );
		} else {
			update_option($option_name, $default_settings);
			update_option('wc_email_inquiry_order_cart_note', __("Note: Shipping and taxes are estimated and will be updated during checkout based on your billing and shipping information.", "wc_email_inquiry") );
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_order_cart_page;
		global $wc_email_inquiry_order_cart_note;
		$wc_email_inquiry_order_cart_page = WC_Email_Inquiry_Order_Cart_Page::get_settings_default();
		
		$wc_email_inquiry_order_cart_note = get_option('wc_email_inquiry_order_cart_note');
		if ($wc_email_inquiry_order_cart_note === false) $wc_email_inquiry_order_cart_note = '';
		
		return $wc_email_inquiry_order_cart_page;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_order_cart_page';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_Order_Cart_Page::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Order_Cart_Page::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = WC_Email_Inquiry_Order_Cart_Page::get_settings_default();
		
		extract($customized_settings);
				
		?>
        <h3><?php _e('Customize the Order (Cart) Page', 'wc_email_inquiry'); ?></h3>
        <p><?php _e("Order Mode creates its own template that replaces the WooCommerce Cart page.", 'wc_email_inquiry'); ?></p>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_cart_page_name"><?php _e( 'Order Page Title', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_cart_page_name ) ); ?>" name="<?php echo $option_name; ?>[order_cart_page_name]" id="order_cart_page_name" style="width:300px;"  /> <div class="description"><?php _e("Replace Cart page name", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_update_cart_button"><?php _e( 'Update Order Button', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_update_cart_button ) ); ?>" name="<?php echo $option_name; ?>[order_update_cart_button]" id="order_update_cart_button" style="width:300px;"  /> <div class="description"><?php _e("Text that displays instead of ' Update Cart' on the button.", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_goto_checkout"><?php _e( 'Details and Send Button', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_goto_checkout ) ); ?>" name="<?php echo $option_name; ?>[order_goto_checkout]" id="order_goto_checkout" style="width:300px;"  /> <div class="description"><?php _e("Text that displays instead of 'Proceed to Checkout &rarr;' on the button", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="wc_email_inquiry_order_cart_note"><?php _e('Order Note','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<?php wp_editor(get_option('wc_email_inquiry_order_cart_note'), 'wc_email_inquiry_order_cart_note', array('textarea_name' => 'wc_email_inquiry_order_cart_note', 'wpautop' => true, 'textarea_rows' => 8 ) ); ?>
					<div class="description"><?php _e('Message that user sees on bottom of cart page', 'wc_email_inquiry'); ?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_cart_empty"><?php _e( 'Empty Cart Message', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_cart_empty ) ); ?>" name="<?php echo $option_name; ?>[order_cart_empty]" id="order_cart_empty" style="width:300px;"  /> <div class="description"><?php _e("Text that shows instead of 'Your cart is currently empty.'.", 'wc_email_inquiry');?></div>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>