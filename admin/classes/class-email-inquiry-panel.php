<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 * panel_manager()
 */
class WC_Email_Inquiry_Panel
{	
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Email Inquiry Successfully saved.', 'wc_email_inquiry').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Email Inquiry Successfully reseted.', 'wc_email_inquiry').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="wc_email_inquiry_panel_container">
		<div id="wc_email_inquiry_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
            	<li><a href="#global-settings" class="current"><?php _e('Settings', 'wc_email_inquiry'); ?></a> | </li>
                <li><a href="#email-options"><?php _e('Email Options', 'wc_email_inquiry'); ?></a> | </li>
                <li><a href="#customize-email-button"><?php _e('Email Button/Link Style', 'wc_email_inquiry'); ?></a> | </li>
                <li><a href="#customize-email-popup"><?php _e('Email Pop-Up Style', 'wc_email_inquiry'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="global-settings">
            	<div class="pro_feature_fields">
            	<?php WC_Email_Inquiry_Global_Settings::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="email-options">
            	<?php WC_Email_Inquiry_Email_Options::panel_page(); ?>
            </div>
            <div class="section" id="customize-email-button">
            	<div class="pro_feature_fields">
            	<?php WC_Email_Inquiry_Customize_Email_Button::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="customize-email-popup">
            	<?php WC_Email_Inquiry_Customize_Email_Popup::panel_page(); ?>
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