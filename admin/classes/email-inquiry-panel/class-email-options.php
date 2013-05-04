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
class WC_Email_Inquiry_Email_Options
{
	public static function get_settings_default() {
		$default_settings = array(
			'inquiry_email_from_name'				=> get_bloginfo('blogname'),
			'inquiry_email_from_address'			=> get_bloginfo('admin_email'),
			'inquiry_send_copy'						=> 'yes',
			'inquiry_email_to'						=> get_bloginfo('admin_email'),
			'inquiry_email_cc'						=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_email_options';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = WC_Email_Inquiry_Email_Options::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		$free_default_settings = $default_settings;
		unset($free_default_settings['inquiry_email_to']);
		unset($free_default_settings['inquiry_email_cc']);
		$customized_settings = array_merge($customized_settings, $free_default_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_email_options;
		$customized_settings = get_option('wc_email_inquiry_email_options');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = WC_Email_Inquiry_Email_Options::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$wc_email_inquiry_email_options = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_email_options';
		if (isset($_REQUEST['bt_save_settings'])) {
			$customized_settings = $_REQUEST[$option_name];
									
			update_option($option_name, $customized_settings);
			WC_Email_Inquiry_Email_Options::set_settings_default();
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Email_Options::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = WC_Email_Inquiry_Email_Options::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		?>
        <div class="pro_feature_fields">
        <h3><?php _e('Email Sender', 'wc_email_inquiry'); ?></h3>
        <p><?php _e('The following options affect the sender (email address and name) used in WooCommerce Product Email Inquiries.', 'wc_email_inquiry'); ?></p>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_email_from_name"><?php _e( '"From" Name', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_email_from_name ) ); ?>" name="inquiry_email_from_name" id="inquiry_email_from_name" style="width:300px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_email_from_address"><?php _e( '"From" Email Address', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_email_from_address ) ); ?>" name="inquiry_email_from_address" id="inquiry_email_from_address" style="width:300px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_send_copy"><?php _e( 'Send Copy to Sender', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="inquiry_send_copy" name="inquiry_send_copy" /> <span class=""><?php _e('Checked adds opt in/out option to the bottom of the email inquiry form.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
		</table>
        </div>
        
        <h3><?php _e('Email Delivery', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_email_to"><?php _e( 'Inquiry Email goes to', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $inquiry_email_to ) ); ?>" name="<?php echo $option_name; ?>[inquiry_email_to]" id="inquiry_email_to" style="width:300px;"  /> <span class="description"><?php _e('&lt;empty&gt; defaults to WordPress admin email address', 'wc_email_inquiry');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_email_cc"><?php _e( 'CC', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $inquiry_email_cc ) ); ?>" name="<?php echo $option_name; ?>[inquiry_email_cc]" id="inquiry_email_cc" style="width:300px;"  /> <span class="description"><?php _e("&lt;empty&gt; defaults to 'no copy sent' or add an email address", 'wc_email_inquiry');?></span>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>