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
			'inquiry_button_padding_top'			=> 5,
			'inquiry_button_padding_bottom'			=> 5,
			'inquiry_single_only'					=> 'no',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_global_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = WC_Email_Inquiry_Global_Settings::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_global_settings;
		$customized_settings = get_option('wc_email_inquiry_global_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = WC_Email_Inquiry_Global_Settings::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$wc_email_inquiry_global_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_global_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			$customized_settings = $_REQUEST[$option_name];
						
			update_option($option_name, $customized_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Global_Settings::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = WC_Email_Inquiry_Global_Settings::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
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
                        <option value="below" <?php selected( $inquiry_button_position, 'below' ); ?>><?php _e( 'Below (Default)', 'wc_email_inquiry' ); ?></option>
                        <option value="above" <?php selected( $inquiry_button_position, 'above' ); ?>><?php _e( 'Above', 'wc_email_inquiry' ); ?></option>
                    </select> <span class="description"><?php _e( 'Position relative to add to cart button location', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_padding_top"><?php _e( 'Padding Top', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $inquiry_button_padding_top ) ); ?>" name="<?php echo $option_name; ?>[inquiry_button_padding_top]" id="inquiry_button_padding_top" style="width:120px;"  />px <span class="description"><?php _e( 'Default padding top is <code>5px</code>. If you see padding between the add to cart button and the email button before adding a value here that padding is added by your theme. Increasing the padding here will add to the themes default button padding.', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_padding_bottom"><?php _e( 'Padding Bottom', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $inquiry_button_padding_bottom ) ); ?>" name="<?php echo $option_name; ?>[inquiry_button_padding_bottom]" id="inquiry_button_padding_bottom" style="width:120px;"  />px <span class="description"><?php _e( 'Default padding bottom is <code>5px</code>. If you see padding between the add to cart button and the email button before adding a value here that padding is added by your theme. Increasing the padding here will add to the themes default button padding.', 'wc_email_inquiry'); ?></span>
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
		</table>
        
        <div class="pro_feature_fields">
        <h3><?php _e('Global Re-Set', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wc_email_inquiry_reset_products_options"><?php _e( 'Global Re-Set', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="wc_email_inquiry_reset_products_options" name="wc_email_inquiry_reset_products_options" /> <span class=""><?php _e('Check to reset ALL products that have custom Button or Hyperlink Text settings to the settings made above.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
		</table>
        </div>
	<?php
	}
}
?>