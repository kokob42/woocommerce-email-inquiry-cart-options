<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Global Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Global_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'inquiry_button_type'					=> 'button',
			'inquiry_button_position'				=> 'below',
			'inquiry_button_padding'				=> 5,
			'inquiry_single_only'					=> 'yes',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_global_settings';		
		$default_settings = WC_Email_Inquiry_Global_Settings::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_global_settings;
		$wc_email_inquiry_global_settings = WC_Email_Inquiry_Global_Settings::get_settings_default();
		
		return $wc_email_inquiry_global_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_global_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_Global_Settings::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Global_Settings::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = WC_Email_Inquiry_Global_Settings::get_settings_default();
		
		extract($customized_settings);
		
		?>
        <h3><?php _e('Email Inquiry Button / Hyperlink', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_type"><?php _e( 'Button or Hyperlink Text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[inquiry_button_type]" id="inquiry_button_type" style="width:120px;">
                        <option value="button" <?php selected( $inquiry_button_type, 'button' ); ?>><?php _e( 'Button', 'wc_email_inquiry' ); ?></option>
                        <option value="link" <?php selected( $inquiry_button_type, 'link' ); ?>><?php _e( 'Link', 'wc_email_inquiry' ); ?></option>
                    </select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_position"><?php _e( 'Relative Position', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[inquiry_button_position]" id="inquiry_button_position" style="width:120px;">
                        <option value="below" <?php selected( $inquiry_button_position, 'button' ); ?>><?php _e( 'Below (Default)', 'wc_email_inquiry' ); ?></option>
                        <option value="above" <?php selected( $inquiry_button_position, 'link' ); ?>><?php _e( 'Above', 'wc_email_inquiry' ); ?></option>
                    </select> <span class="description"><?php _e( 'Position relative to add to cart button location', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_padding"><?php _e( 'Padding', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_button_padding ) ); ?>" name="<?php echo $option_name; ?>[inquiry_button_padding]" id="inquiry_button_padding" style="width:120px;"  />px <span class="description"><?php _e( 'Default padding is <code>5px</code>. If you see padding between the add to cart button and the email button before adding a value here that padding is added by your theme. Increasing the padding here will add to the themes default button padding.', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_single_only"><?php _e( 'Single Product Page only', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[inquiry_single_only]" id="inquiry_single_only" style="width:120px;">
                        <option value="yes" <?php selected( $inquiry_single_only, 'yes' ); ?>><?php _e( 'Yes', 'wc_email_inquiry' ); ?></option>
                        <option value="no" <?php selected( $inquiry_single_only, 'no' ); ?>><?php _e( 'No', 'wc_email_inquiry' ); ?></option>
                    </select> <span class="description"><?php _e( 'Default =  No. Button / Link text shows on single products pages as well as products list view, grid view, category and tag pages.', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wc_email_inquiry_reset_products_options"><?php _e( 'Global Re-Set', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="wc_email_inquiry_reset_products_options" name="wc_email_inquiry_reset_products_options" /> <span class=""><?php _e('Check to reset ALL products that have custom Button or Hyperlink Text settings to the settings made above.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>