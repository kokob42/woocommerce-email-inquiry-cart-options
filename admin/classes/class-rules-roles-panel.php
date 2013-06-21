<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Rules and Roles Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 * panel_manager()
 */
class WC_Email_Inquiry_Rules_Roles_Panel
{
	public static function get_settings_default() {
		$default_settings = array(
			'hide_addcartbt'						=> 'yes',
			'role_apply_hide_cart'					=> array(),
			'show_button'							=> 'yes',
			'role_apply_show_inquiry_button'		=> array(),
			
			'request_a_quote'						=> 'no',
			
			'quote_mode_rule'						=> 'manual',
			'role_apply_manual_quote'				=> array(),
			'role_apply_auto_quote'					=> array(),
			
			'add_to_order'							=> 'no',
			'activate_order_logged_in'				=> 'no',
			'role_apply_activate_order_logged_in'	=> array(),
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_rules_roles_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = WC_Email_Inquiry_Rules_Roles_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_rules_roles_settings;
		$customized_settings = get_option('wc_email_inquiry_rules_roles_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = WC_Email_Inquiry_Rules_Roles_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$wc_email_inquiry_rules_roles_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_rules_roles_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			$customized_settings = $_REQUEST[$option_name];
			
			if (!isset($customized_settings['hide_addcartbt'])) $customized_settings['hide_addcartbt'] = 'no';
			if (!isset($customized_settings['role_apply_hide_cart'])) $customized_settings['role_apply_hide_cart'] = array();
			if (!isset($customized_settings['show_button'])) $customized_settings['show_button'] = 'no';
			if (!isset($customized_settings['role_apply_show_inquiry_button'])) $customized_settings['role_apply_show_inquiry_button'] = array();
			
			$customized_settings['request_a_quote'] = 'no';
			$customized_settings['quote_mode_rule'] = 'manual';
			$customized_settings['role_apply_manual_quote'] = array();
			$customized_settings['role_apply_auto_quote'] = array();
			$customized_settings['add_to_order'] = 'no';
			$customized_settings['activate_order_logged_in'] = 'no';
			$customized_settings['role_apply_activate_order_logged_in'] = array();
			
			update_option($option_name, $customized_settings);
			
		} elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Rules_Roles_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = WC_Email_Inquiry_Rules_Roles_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
				
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();
		
		?>
        <h3><?php _e('Global Visibility Settings', 'wc_email_inquiry'); ?></h3>
        <p><?php _e( "Set Rules that apply to all site visitors. Use 'Apply Rules to Roles'  to control what users can see and access when they log into their account. PRO version users can over-ride these settings on a per product basis.",'wc_email_inquiry'); ?></p>
		<table class="form-table">
			<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="hide_addcartbt"><?php _e( "Rule: Hide 'Add to Cart'", 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input type="checkbox" <?php checked( $hide_addcartbt, 'yes' ); ?> value="yes" id="hide_addcartbt" name="<?php echo $option_name; ?>[hide_addcartbt]" /> <span class=""><?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="role_apply_hide_cart"><?php _e( 'Apply Rule to logged in roles', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" multiple="multiple" data-placeholder="<?php _e('Choose Roles', 'wc_email_inquiry'); ?>" name="<?php echo $option_name; ?>[role_apply_hide_cart][]" id="role_apply_hide_cart" style="width:300px; min-height:80px; display:none;">
                    <?php foreach ($roles as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( in_array($key, (array) $role_apply_hide_cart), true ); ?>><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="show_button"><?php _e( 'Rule: Show Email Inquiry Button', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input type="checkbox" <?php checked( $show_button, 'yes' ); ?> value="yes" id="show_button" name="<?php echo $option_name; ?>[show_button]" /> <span class=""><?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="role_apply_show_inquiry_button"><?php _e( 'Apply Rule to logged in roles', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" multiple="multiple" data-placeholder="<?php _e('Choose Roles', 'wc_email_inquiry'); ?>" name="<?php echo $option_name; ?>[role_apply_show_inquiry_button][]" id="role_apply_show_inquiry_button" style="width:300px; min-height:80px; display:none;">
                    <?php foreach ($roles as $key => $val) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( in_array($key, (array) $role_apply_show_inquiry_button), true ); ?>><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
		</table>
        <div class="pro_feature_fields" style="z-index:11;">
        <table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="hide_price"><?php _e( 'Rule: Hide Price', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="hide_price" name="<?php echo $option_name; ?>[hide_price]" /> <span class=""><?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="role_apply_hide_price"><?php _e( 'Apply Rule to logged in roles', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" multiple="multiple" data-placeholder="<?php _e('Choose Roles', 'wc_email_inquiry'); ?>" name="<?php echo $option_name; ?>[role_apply_hide_price][]" id="role_apply_hide_price" style="width:300px; min-height:80px; display:none;">
                    <?php foreach ($roles as $key => $val) { ?>
                        <option value="<?php echo $key; ?>"><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wc_email_inquiry_reset_products_options"><?php _e( 'Global Re-Set', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="wc_email_inquiry_reset_products_options" name="wc_email_inquiry_reset_products_options" /> <span class=""><?php _e('Check to reset ALL products that have custom Roles & Rules settings to the settings made above.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
		</table>
        </div>
        
        <div class="pro_feature_fields" style="margin-top:15px;">
		<h3><?php _e('Request A Quote Mode', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="request_a_quote"><?php _e( "Rule: 'Request a Quote'", 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" class="replace_add_to_cart" type="checkbox" value="yes" id="request_a_quote" name="<?php echo $option_name; ?>[request_a_quote]" /> <span class=""><?php _e('If activated this setting over-rides all other Rules for users who are not logged in.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="manual_quote_rule"><?php _e( "Manual Quote Rule", 'wc_email_inquiry' );?></label> <img width="16" height="16" src="<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/help.png" class="help_tip" tip="<?php _e('Hide prices everywhere including on order email and order details. If you have shipping costs configured it does not hide shipping costs.', 'wc_email_inquiry'); ?>" /></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="radio" value="manual" id="manual_quote_rule" name="<?php echo $option_name; ?>[quote_mode_rule]" /> <span class=""><?php _e('Check to manually send prices either off-line or via edit order.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="role_apply_manual_quote"><?php _e( 'Apply Rule to logged in roles', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" multiple="multiple" data-placeholder="<?php _e('Choose Roles', 'wc_email_inquiry'); ?>" name="<?php echo $option_name; ?>[role_apply_manual_quote][]" id="role_apply_manual_quote" style="width:300px; min-height:80px; display:none;">
                    	<option disabled="disabled" value="manual_quote" selected="selected"><?php _e( 'Manual Quote', 'wc_email_inquiry' ); ?></option>
                    <?php foreach ($roles as $key => $val) { ?>
                    	<?php if ( in_array( $key, array('manual_quote', 'auto_quote') ) ) continue; ?>
                        <option value="<?php echo $key; ?>"><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="auto_quote_rule"><?php _e( "Auto Quote Rule", 'wc_email_inquiry' );?></label> <img width="16" height="16" src="<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/help.png" class="help_tip" tip="<?php _e('Hide prices on shop page, product detail page, sidebar, cart widget, cart page, checkout page. Prices including shipping show in order email, order details when subscriber send the quote request.', 'wc_email_inquiry'); ?>" /></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="radio" value="auto" id="auto_quote_rule" name="<?php echo $option_name; ?>[quote_mode_rule]" /> <span class=""><?php _e('Check to auto include system prices in the quote request email.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="role_apply_auto_quote"><?php _e( 'Apply Rule to logged in roles', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" multiple="multiple" data-placeholder="<?php _e('Choose Roles', 'wc_email_inquiry'); ?>" name="<?php echo $option_name; ?>[role_apply_auto_quote][]" id="role_apply_auto_quote" style="width:300px; min-height:80px; display:none;">
                    	<option disabled="disabled" value="auto_quote" selected="selected"><?php _e( 'Auto Quote', 'wc_email_inquiry' ); ?></option>
                    <?php foreach ($roles as $key => $val) { ?>
                    	<?php if ( in_array( $key, array('manual_quote', 'auto_quote') ) ) continue; ?>
                        <option value="<?php echo $key; ?>"><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
        </table>
        
        <h3><?php _e('Add to Order Mode', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="add_to_order"><?php _e( "Rule: 'Add to Order'", 'wc_email_inquiry' );?></label> <img width="16" height="16" src="<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/help.png" class="help_tip" tip="<?php _e('Product Prices show as usual. Client places order and does not see the WooCommerce generated requests for payment.', 'wc_email_inquiry'); ?>" /></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" class="replace_add_to_cart" type="checkbox" value="yes" id="add_to_order" name="<?php echo $option_name; ?>[add_to_order]" /> <span class=""><?php _e('If activated this setting over-rides all other Rules for users who are not logged in.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="activate_order_logged_in"><?php _e( "Activate Rule", 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="activate_order_logged_in" name="<?php echo $option_name; ?>[activate_order_logged_in]" /> <span class=""><?php _e('Activate this Rule to apply it to a Role for logged in users.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="role_apply_activate_order_logged_in"><?php _e( 'Apply Rule to logged in roles', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" multiple="multiple" data-placeholder="<?php _e('Choose Roles', 'wc_email_inquiry'); ?>" name="<?php echo $option_name; ?>[role_apply_activate_order_logged_in][]" id="role_apply_activate_order_logged_in" style="width:300px; min-height:80px; display:none;">
                    <?php foreach ($roles as $key => $val) { ?>
                    	<?php if ( in_array( $key, array('manual_quote', 'auto_quote') ) ) continue; ?>
                        <option value="<?php echo $key; ?>"><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
        </table>
        </div>
		<script type="text/javascript">
			(function($){		
				$(function(){	
					$('.replace_add_to_cart').click(function(){
						if ($(this).is(':checked')) {
							if ($(this).attr('id') == 'request_a_quote') {
								$('#add_to_order').attr('checked', false);
							} else {
								$('#request_a_quote').attr('checked', false);	
							}
						}
					});
				});		  
			})(jQuery);
		</script>
	<?php
	}
	
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Rules & Roles Successfully saved.', 'wc_email_inquiry').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Rules & Roles Successfully reseted.', 'wc_email_inquiry').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
	<div id="wc_email_inquiry_panel_container">
		<div id="wc_email_inquiry_panel_fields" class="a3_subsubsub_section">
            <div class="section">
            	<?php WC_Email_Inquiry_Rules_Roles_Panel::panel_page(); ?>
            </div>            
		</div>
        <div id="wc_email_inquiry_upgrade_area"><?php echo WC_Email_Inquiry_Functions::plugin_pro_notice(); ?></div>
    </div>
    <div style="clear:both;"></div>
			<p class="submit">
                <input type="submit" value="<?php _e('Save changes', 'wc_email_inquiry'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
				<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button" value="<?php _e('Reset Settings', 'wc_email_inquiry'); ?>"  />
        		<input type="hidden" id="last_tab" name="subtab" />
            </p>
    </form>
	<?php
	}
}
?>