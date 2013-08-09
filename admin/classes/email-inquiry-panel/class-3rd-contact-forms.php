<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry 3RD Contact Forms
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_3RD_ContactForms_Settings
{
	public static function get_settings_default() {
		$default_settings = array(		
			'enable_3rd_contact_form_plugin'		=> 'no',
			'contact_form_shortcode'				=> '',
			'product_page_open_form_type'			=> 'new_page',
			'category_page_open_form_type'			=> 'new_page',
			
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_3rd_contactforms_settings';
		
		$default_settings = WC_Email_Inquiry_3RD_ContactForms_Settings::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_3rd_contactforms_settings;
		$wc_email_inquiry_3rd_contactforms_settings = WC_Email_Inquiry_3RD_ContactForms_Settings::get_settings_default();
		
		return $wc_email_inquiry_3rd_contactforms_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_3rd_contactforms_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_3RD_ContactForms_Settings::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_3RD_ContactForms_Settings::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = WC_Email_Inquiry_3RD_ContactForms_Settings::get_settings_default();
		
		extract($customized_settings);
		
		$pages = get_pages('title_li=&orderby=name');
		
		?>
        <h3><?php _e('Use 3RD Party Contact Form Shortcode', 'wc_email_inquiry'); ?></h3>
        <p><?php _e('Current this plugin support for shortcode of <strong>Gravityform</strong> and <strong>Contact Form 7</strong> plugins', 'wc_email_inquiry'); ?></p>
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="enable_3rd_contact_form_plugin"><?php _e( 'Use Contact Form Shortcodes', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[enable_3rd_contact_form_plugin]" id="enable_3rd_contact_form_plugin" style="width:120px;">
                        <option value="no" selected="selected"><?php _e( 'No', 'wc_email_inquiry' ); ?> (<?php _e('Default', 'wc_email_inquiry');?>)</option>
                        <option value="yes"><?php _e( 'Yes', 'wc_email_inquiry' ); ?></option>
                    </select> <span class="description"><?php _e( 'Select Yes to use 3rd Contact Form Shortcodes instead of Default form from plugin.', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="contact_form_shortcode"><?php _e( 'Enter Global Form Shortcode', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" disabled="disabled" value="<?php esc_attr_e( stripslashes( $contact_form_shortcode ) ); ?>" name="<?php echo $option_name; ?>[contact_form_shortcode]" id="contact_form_shortcode" style="width:300px;"  /><span class="description"><?php _e( 'Can add unique form shortcode on each product page.', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row" colspan="2"><strong><?php _e( 'Custom Form Open Options', 'wc_email_inquiry' );?></strong></th>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label><?php _e('Product Page', 'wc_email_inquiry'); ?></label></th>
				<td class="forminp">
                	<label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[product_page_open_form_type]" value="new_page" checked="checked" /> <?php _e('Open contact form on new page', 'wc_email_inquiry'); ?> - <?php _e('new window', 'wc_email_inquiry'); ?>. <span class="description">(<?php _e('Default', 'wc_email_inquiry');?>)</span></label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[product_page_open_form_type]" value="new_page_same_window" /> <?php _e('Open contact form on new page', 'wc_email_inquiry'); ?> - <?php _e('same window', 'wc_email_inquiry'); ?>.</label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[product_page_open_form_type]" value="popup" /> <?php _e('Open contact form by Pop-up', 'wc_email_inquiry'); ?>.</label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[product_page_open_form_type]" value="inner_page" /> <?php _e('Open contact form on page (form opens by ajax under the inquiry button).', 'wc_email_inquiry'); ?></label> 
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label><?php _e('Grid View', 'wc_email_inquiry'); ?></label></th>
				<td class="forminp">
                	<label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[category_page_open_form_type]" value="new_page" checked="checked" /> <?php _e('Open contact form on new page', 'wc_email_inquiry'); ?> - <?php _e('new window', 'wc_email_inquiry'); ?>. <span class="description">(<?php _e('Default', 'wc_email_inquiry');?>)</span></label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[category_page_open_form_type]" value="new_page_same_window" /> <?php _e('Open contact form on new page', 'wc_email_inquiry'); ?> - <?php _e('same window', 'wc_email_inquiry'); ?>.</label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[category_page_open_form_type]" value="popup" /> <?php _e('Open contact form by Pop-up', 'wc_email_inquiry'); ?>.</label>
			</tr>
		</table>
        
        <h3><?php _e('Email Inquiry New Page', 'woo_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
				<tr valign="top">
					<td class="forminp" colspan="2"><?php printf( __("A 'Email Inquiry' page with the shortcode %s inserted should have been auto created on install. If not you need to manually create a new page and add the shortcode. Then set that page below so the plugin knows where to find it.", 'wc_email_inquiry'), '[wc_email_inquiry_page]'); ?></td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label><?php _e('Email Inquiry Page','wc_email_inquiry'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" size="1" name="wc_email_inquiry_page_id" id="wc_email_inquiry_page_id" style="width:300px">
									<option selected='selected' value='0'><?php _e('Select Page','wc_email_inquiry'); ?></option>
                                    <?php foreach ( $pages as $page ) { ?>
                                    <option value='<?php echo $page->ID; ?>'><?php echo $page->post_title; ?></option>
                                    <?php }?>
						</select>
						<span class="description"><?php _e('Page contents', 'wc_email_inquiry');?>: [wc_email_inquiry_page]</span>
					</td>
				</tr>
        	</tbody>
        </table>
        
        <h3><?php _e('Global Re-Set', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="wc_email_inquiry_reset_products_options2"><?php _e( 'Global Re-Set', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="wc_email_inquiry_reset_products_options2" name="wc_email_inquiry_reset_products_options2" /> <span class=""><?php _e('Check to reset ALL products that have custom Form Shortcode to the settings made above.', 'wc_email_inquiry');?></span></label>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>