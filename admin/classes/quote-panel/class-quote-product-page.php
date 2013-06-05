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
class WC_Email_Inquiry_Quote_Product_Page
{
	public static function get_settings_default() {
		$default_settings = array(
			'quote_button_text'						=> __('Add to Quote', 'wc_email_inquiry'),
			
			'quote_view_button_text'				=> __('View Quote &rarr;', 'wc_email_inquiry'),
			'quote_continue_button_text'			=> __('Continue Request &rarr;', 'wc_email_inquiry'),
			
			'quote_success_message'					=> __('&quot;%s&quot; was successfully added to your quote.', 'wc_email_inquiry'),
			'quote_group_success_message'			=> __('Added &quot;%s&quot; to your quote.', 'wc_email_inquiry'),
			
			'quote_error_quantity_message'			=> __( 'Please choose the quantity of items you wish to add to your quote&hellip;', 'wc_email_inquiry' ),
			'quote_error_no_product_add_message'	=> __( 'Please choose a product to add to your quote&hellip;', 'wc_email_inquiry' ),
			'quote_error_out_stock_message'			=> __( 'You cannot add &quot;%s&quot; to the quote because the product is out of stock.', 'wc_email_inquiry' ),
			'quote_error_product_already_message'	=> __( 'You already have this item in your quote.', 'wc_email_inquiry' ),
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_quote_product_page';
		
		$default_settings = WC_Email_Inquiry_Quote_Product_Page::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_quote_product_page;
		$wc_email_inquiry_quote_product_page = WC_Email_Inquiry_Quote_Product_Page::get_settings_default();
		
		return $wc_email_inquiry_quote_product_page;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_quote_product_page';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_Quote_Product_Page::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Quote_Product_Page::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = WC_Email_Inquiry_Quote_Product_Page::get_settings_default();
		
		extract($customized_settings);
				
		?>
        <h3><?php _e('Quote Feature on Product Page', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_button_text"><?php _e( 'Button Text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $quote_button_text ) ); ?>" name="<?php echo $option_name; ?>[quote_button_text]" id="quote_button_text" style="width:300px;"  /> <div class="description"><?php _e("Text that shows instead of 'Add to Cart'. Default 'Add to Quote'", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_view_button_text"><?php _e( 'View Quote Button Text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $quote_view_button_text ) ); ?>" name="<?php echo $option_name; ?>[quote_view_button_text]" id="quote_view_button_text" style="width:300px;"  /> <div class="description"><?php _e("Text that shows instead of 'View Cart &rarr;'. Default 'View Quote &rarr;'", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_continue_button_text"><?php _e( 'Continue Request Button Text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $quote_continue_button_text ) ); ?>" name="<?php echo $option_name; ?>[quote_continue_button_text]" id="quote_continue_button_text" style="width:300px;"  /> <div class="description"><?php _e("Text that shows instead of 'Continue Shopping &rarr;'. Default 'Continue Request &rarr;'", 'wc_email_inquiry');?></div>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('Success Message', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_success_message"><?php _e( 'Success Message', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $quote_success_message ) ); ?>" name="<?php echo $option_name; ?>[quote_success_message]" id="quote_success_message" style="width:300px;"  /> <div class="description">%s : <?php _e("Replace by Product name", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_group_success_message"><?php _e( 'Group Added Success Message', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $quote_group_success_message ) ); ?>" name="<?php echo $option_name; ?>[quote_group_success_message]" id="quote_group_success_message" style="width:300px;"  /> <div class="description">%s : <?php _e("Replace by Product name", 'wc_email_inquiry');?></div>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('Error Message', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_error_quantity_message"><?php _e( 'Quantity Error', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <textarea name="<?php echo $option_name; ?>[quote_error_quantity_message]" id="quote_error_quantity_message" style="width:300px; height:60px;"><?php esc_attr_e( stripslashes( $quote_error_quantity_message ) ); ?></textarea> <div class="description"><?php _e("Replace for :", 'wc_email_inquiry');?> '<?php _e( 'Please choose the quantity of items you wish to add to your cart&hellip;', 'woocommerce' ); ?>'</div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_error_no_product_add_message"><?php _e( 'No Product Added Error', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <textarea name="<?php echo $option_name; ?>[quote_error_no_product_add_message]" id="quote_error_no_product_add_message" style="width:300px; height:60px;" ><?php esc_attr_e( stripslashes( $quote_error_no_product_add_message ) ); ?></textarea> <div class="description"><?php _e("Replace for :", 'wc_email_inquiry');?> '<?php _e( 'Please choose a product to add to your cart&hellip;', 'woocommerce' ); ?>'</div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_error_out_stock_message"><?php _e( 'Product Is Out of Stock Error', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <textarea name="<?php echo $option_name; ?>[quote_error_out_stock_message]" id="quote_error_out_stock_message" style="width:300px; height:60px;" ><?php esc_attr_e( stripslashes( $quote_error_out_stock_message ) ); ?></textarea> <div class="description">%s : <?php _e("Replace by Product name", 'wc_email_inquiry');?></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="quote_error_product_already_message"><?php _e( 'Product Existed In Quote', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $quote_error_product_already_message ) ); ?>" name="<?php echo $option_name; ?>[quote_error_product_already_message]" id="quote_error_product_already_message" style="width:300px;"  /> <div class="description"><?php _e("Replace for :", 'wc_email_inquiry');?> '<?php _e( 'You already have this item in your cart.', 'woocommerce' ); ?>'</div>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>