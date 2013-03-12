<?php
/**
 * WC Email Inquiry Functions
 *
 * Table Of Contents
 *
 * check_hide_add_cart_button()
 * check_add_email_inquiry_button()
 * email_inquiry()
 * get_from_address()
 * get_from_name()
 * get_content_type()
 */
class WC_Email_Inquiry_Functions {
	
	function check_hide_add_cart_button ($product_id) {
			
		$wc_email_inquiry_hide_addcartbt = esc_attr(get_option('wc_email_inquiry_hide_addcartbt'));
		
		$role_apply_hide_cart = (array) get_option('wc_email_inquiry_role_apply_hide_cart');
		// dont hide add to cart button if setting is not checked
		if ($wc_email_inquiry_hide_addcartbt == 'no') return false;
		// alway hide add to cart button if not logged in
		if (!is_user_logged_in()) return true;
		$user_login = wp_get_current_user();
		if (is_array($user_login->roles) && count($user_login->roles) > 0) {
			$user_role = '';
			foreach ($user_login->roles as $role_name) {
				$user_role = $role_name;
				break;
			}
			// hide add to cart button if current user role in list apply role
			if ( in_array($user_role, $role_apply_hide_cart) ) return true;
		}
		return false;
		
	}
	
	function check_add_email_inquiry_button ($product_id) {
			
		$wc_email_inquiry_show_button = esc_attr(get_option('wc_email_inquiry_show_button'));
		
		$role_apply_show_inquiry_button = (array) get_option('wc_email_inquiry_role_apply_show_inquiry_button');
			
		// dont hide add to cart button if setting is not checked
		if ($wc_email_inquiry_show_button == 'no') return false;
		
		// alway hide add to cart button if not logged in
		if (!is_user_logged_in()) return true;
		
		$user_login = wp_get_current_user();		
		if (is_array($user_login->roles) && count($user_login->roles) > 0) {
			$user_role = '';
			foreach ($user_login->roles as $role_name) {
				$user_role = $role_name;
				break;
			}
			// hide add to cart button if current user role in list apply role
			if ( in_array($user_role, $role_apply_show_inquiry_button) ) return true;
		}
		
		return false;
		
	}
		
	function email_inquiry($product_id, $your_name, $your_email, $your_phone, $your_message, $send_copy_yourself = 1) {
		
		if ( WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
			
			$wc_email_inquiry_contact_success = wpautop(wptexturize(get_option('wc_email_inquiry_contact_success')));
		
			$to_email = esc_attr(get_option('wc_email_inquiry_email_to'));
			if (trim($to_email) == '') $to_email = get_option('admin_email');
			
			if ( esc_attr(get_option('wc_email_inquiry_email_from_address')) == '' )
				$from_email = get_option('admin_email');
			else
				$from_email = esc_attr(get_option('wc_email_inquiry_email_from_address'));
				
			if ( esc_attr(get_option('wc_email_inquiry_email_from_name')) == '' )
				$from_name = get_option('blogname');
			else
				$from_name = esc_attr(get_option('wc_email_inquiry_email_from_name'));
			
			$cc_emails = esc_attr(get_option('wc_email_inquiry_email_cc'));
			if (trim($cc_emails) == '') $cc_emails = '';
			
			$headers = array();
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';
			$headers[] = 'From: '.$from_name.' <'.$from_email.'>';
			
			if (trim($cc_emails) != '') {
				$cc_emails_a = explode("," , $cc_emails);
				if (is_array($cc_emails_a) && count($cc_emails_a) > 0) {
					foreach ($cc_emails_a as $cc_email) {
						$headers[] = 'Cc: '.$cc_email;
					}
				} else {
					$headers[] = 'Cc: '.$cc_emails;
				}
			}
			
			$product_name = get_the_title($product_id);
			$product_url = get_permalink($product_id);
			$subject = __('Email inquiry for', 'wc_email_inquiry').' '.$product_name;
			
			$content = '
	<table width="99%" cellspacing="0" cellpadding="1" border="0" bgcolor="#eaeaea"><tbody>
	  <tr>
		<td>
		  <table width="100%" cellspacing="0" cellpadding="5" border="0" bgcolor="#ffffff"><tbody>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Name', 'wc_email_inquiry').'</strong></font> 
			  </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[your_name]</font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Email Address', 'wc_email_inquiry').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><a target="_blank" href="mailto:[your_email]">[your_email]</a></font> 
			  </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Phone', 'wc_email_inquiry').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[your_phone]</font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Product Name', 'wc_email_inquiry').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><a target="_blank" href="[product_url]">[product_name]</a></font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Message', 'wc_email_inquiry').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[your_message]</font> 
		  </td></tr></tbody></table></td></tr></tbody></table>';
		  
			$content = str_replace('[your_name]', $your_name, $content);
			$content = str_replace('[your_email]', $your_email, $content);
			$content = str_replace('[your_phone]', $your_phone, $content);
			$content = str_replace('[product_name]', $product_name, $content);
			$content = str_replace('[product_url]', $product_url, $content);
			$content = str_replace('[your_message]', wpautop($your_message), $content);
			
			$content = apply_filters('wc_email_inquiry_inquiry_content', $content);
			
			// Filters for the email
			add_filter( 'wp_mail_from', array( 'WC_Email_Inquiry_Functions', 'get_from_address' ) );
			add_filter( 'wp_mail_from_name', array( 'WC_Email_Inquiry_Functions', 'get_from_name' ) );
			add_filter( 'wp_mail_content_type', array( 'WC_Email_Inquiry_Functions', 'get_content_type' ) );
			
			wp_mail( $to_email, $subject, $content, $headers, '' );
						
			// Unhook filters
			remove_filter( 'wp_mail_from', array( 'WC_Email_Inquiry_Functions', 'get_from_address' ) );
			remove_filter( 'wp_mail_from_name', array( 'WC_Email_Inquiry_Functions', 'get_from_name' ) );
			remove_filter( 'wp_mail_content_type', array( 'WC_Email_Inquiry_Functions', 'get_content_type' ) );
			
			return $wc_email_inquiry_contact_success;
		} else {
			return __("Sorry, this product don't enable email inquiry.", 'wc_email_inquiry');
		}
	}
	
	function get_from_address() {
		if ( esc_attr(get_option('wc_email_inquiry_email_from_address')) == '' )
			$from_email = get_option('admin_email');
		else
			$from_email = esc_attr(get_option('wc_email_inquiry_email_from_address'));
			
		return $from_email;
	}
	
	function get_from_name() {
		if ( esc_attr(get_option('wc_email_inquiry_email_from_name')) == '' )
			$from_name = get_option('blogname');
		else
			$from_name = esc_attr(get_option('wc_email_inquiry_email_from_name'));
			
		return $from_name;
	}
	
	function get_content_type() {
		return 'text/html';
	}
}
?>