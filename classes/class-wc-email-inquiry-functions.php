<?php
/**
 * WC Email Inquiry Functions
 *
 * Table Of Contents
 *
 * check_hide_add_cart_button()
 * check_add_email_inquiry_button()
 * check_add_email_inquiry_button_on_shoppage()
 * reset_products_to_global_settings()
 * email_inquiry()
 * get_from_address()
 * get_from_name()
 * get_content_type()
 * plugin_extension()
 * wc_ei_yellow_message_dontshow()
 * wc_ei_yellow_message_dismiss()
 * upgrade_version_1_0_3()
 * lite_upgrade_version_1_0_8()
 */
class WC_Email_Inquiry_Functions 
{	
	
	public static function check_hide_add_cart_button ($product_id) {
		global $wc_email_inquiry_rules_roles_settings;
			
		$wc_email_inquiry_hide_addcartbt = $wc_email_inquiry_rules_roles_settings['hide_addcartbt'] ;
		
		// dont hide add to cart button if setting is not checked and not logged in users
		if ($wc_email_inquiry_hide_addcartbt == 'no' && !is_user_logged_in() ) return false;
		
		// hide add to cart button if setting is checked and not logged in users
		if ($wc_email_inquiry_hide_addcartbt != 'no' &&  !is_user_logged_in()) return true;
		
		$wc_email_inquiry_hide_addcartbt_after_login = $wc_email_inquiry_rules_roles_settings['hide_addcartbt_after_login'] ;

		// don't hide add to cart if for logged in users is deacticated
		if ( $wc_email_inquiry_hide_addcartbt_after_login != 'yes' ) return false;
		
		$role_apply_hide_cart = (array) $wc_email_inquiry_rules_roles_settings['role_apply_hide_cart'];
		
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
		
	public static function check_add_email_inquiry_button ($product_id) {
		global $wc_email_inquiry_global_settings;
			
		$wc_email_inquiry_show_button = $wc_email_inquiry_global_settings['show_button'];
		
		// dont show email inquiry button if setting is not checked and not logged in users
		if ($wc_email_inquiry_show_button == 'no' && !is_user_logged_in() ) return false;
		
		// alway show email inquiry button if setting is checked and not logged in users
		if ($wc_email_inquiry_show_button != 'no' && !is_user_logged_in()) return true;
		
		$wc_email_inquiry_show_button_after_login = $wc_email_inquiry_global_settings['show_button_after_login'] ;

		// don't show email inquiry button if for logged in users is deacticated
		if ( $wc_email_inquiry_show_button_after_login != 'yes' ) return false;
		
		$role_apply_show_inquiry_button = (array) $wc_email_inquiry_global_settings['role_apply_show_inquiry_button'];		
		
		$user_login = wp_get_current_user();		
		if (is_array($user_login->roles) && count($user_login->roles) > 0) {
			$user_role = '';
			foreach ($user_login->roles as $role_name) {
				$user_role = $role_name;
				break;
			}
			// show email inquiry button if current user role in list apply role
			if ( in_array($user_role, $role_apply_show_inquiry_button) ) return true;
		}
		
		return false;
		
	}
	
	public static function check_add_email_inquiry_button_on_shoppage ($product_id=0) {
		global $wc_email_inquiry_global_settings;
			
		$wc_email_inquiry_single_only = $wc_email_inquiry_global_settings['inquiry_single_only'];
		
		if ($wc_email_inquiry_single_only == 'yes') return false;
		
		return WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id);
		
	}
	
	public static function reset_products_to_global_settings() {
		global $wpdb;
		$wpdb->query( "DELETE FROM ".$wpdb->postmeta." WHERE meta_key='_wc_email_inquiry_settings_custom' " );
	}
	
	public static function email_inquiry($product_id, $your_name, $your_email, $your_phone, $your_message, $send_copy_yourself = 1) {
		global $wc_email_inquiry_contact_form_settings;
		$wc_email_inquiry_contact_success = stripslashes( get_option( 'wc_email_inquiry_contact_success', '' ) );
		
		if ( WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
			
			if ( trim( $wc_email_inquiry_contact_success ) != '') $wc_email_inquiry_contact_success = wpautop(wptexturize( $wc_email_inquiry_contact_success ));
			else $wc_email_inquiry_contact_success = __("Thanks for your inquiry - we'll be in touch with you as soon as possible!", 'wc_email_inquiry');
		
			$to_email = $wc_email_inquiry_contact_form_settings['inquiry_email_to'];
			if (trim($to_email) == '') $to_email = get_option('admin_email');
			
			if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'] == '' )
				$from_email = get_option('admin_email');
			else
				$from_email = $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'];
				
			if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'] == '' )
				$from_name = get_option('blogname');
			else
				$from_name = $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'];
			
			$cc_emails = $wc_email_inquiry_contact_form_settings['inquiry_email_cc'];
			if (trim($cc_emails) == '') $cc_emails = '';
			
			$headers = array();
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset='. get_option('blog_charset');
			$headers[] = 'From: '.$from_name.' <'.$from_email.'>';
			$headers_yourself = $headers;
			
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
			$subject_yourself = __('[Copy]: Email inquiry for', 'wc_email_inquiry').' '.$product_name;
			
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
			$your_message = str_replace( '://', ':&#173;­//', $your_message );
			$your_message = str_replace( '.com', '&#173;.com', $your_message );
			$your_message = str_replace( '.net', '&#173;.net', $your_message );
			$your_message = str_replace( '.info', '&#173;.info', $your_message );
			$your_message = str_replace( '.org', '&#173;.org', $your_message );
			$your_message = str_replace( '.au', '&#173;.au', $your_message );
			$content = str_replace('[your_message]', wpautop( $your_message ), $content);
			
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
	
	public static function get_from_address() {
		global $wc_email_inquiry_contact_form_settings;
		if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'] == '' )
			$from_email = get_option('admin_email');
		else
			$from_email = $wc_email_inquiry_contact_form_settings['inquiry_email_from_address'];
			
		return $from_email;
	}
	
	public static function get_from_name() {
		global $wc_email_inquiry_contact_form_settings;
		if ( $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'] == '' )
			$from_name = get_option('blogname');
		else
			$from_name = $wc_email_inquiry_contact_form_settings['inquiry_email_from_name'];
			
		return $from_name;
	}
	
	public static function get_content_type() {
		return 'text/html';
	}
	
	
	public static function plugin_extension() {
		$html = '';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><div class="a3-plugin-ui-icon a3-plugin-ui-a3-rev-logo"></div></a>';
		$html .= '<h3>'.__('Upgrades available for Extra Functionality', 'wc_email_inquiry').'</h3>';
		$html .= '<p>'.__("<strong>NOTE:</strong> All the functions inside the Yellow border are extra functionality that is only avaiable by upgrading to one of 3 fully supported Pro Version plugins.", 'wc_email_inquiry').':</p>';
		$html .= '<h3>* <a href="http://a3rev.com/shop/woocommerce-email-inquiry-and-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options Pro', 'wc_email_inquiry').'</a> '.__('Features', 'wc_email_inquiry').':</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Rule: Hide Product Prices.", 'wc_email_inquiry').'</li>';
		$html .= '<li>2. '.__('Email and Cart Product Page Meta.', 'wc_email_inquiry').'</li>';
		$html .= '<li>3. '.__("Create a mixed 'add to cart' and product brochure store.", 'wc_email_inquiry').'</li>';
		$html .= '<li>4. '.__('WYSIWYG Email Inquiry button creator.', 'wc_email_inquiry').'</li>';
		$html .= '<li>5. '.__('WYSIWYG pop-up form creator.', 'wc_email_inquiry').'</li>';
		$html .= '<li>6. '.__('Hyperlinked text instead of a Button.', 'wc_email_inquiry').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>* <a href="http://a3rev.com/shop/woocommerce-email-inquiry-ultimate/" target="_blank">'.__('WooCommerce Email Inquiry Ultimate', 'wc_email_inquiry').'</a> '.__('Features', 'wc_email_inquiry').':</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Includes all Email Inquiry and Cart Option Pro features.", 'wc_email_inquiry').'</li>';
		$html .= '<li>2. '.__('Full integration with Gravity Forms, Conatct Form 7.', 'wc_email_inquiry').'</li>';
		$html .= '<li>3. '.__("Custom Inquiry forms with Gravity Forms shortcode.", 'wc_email_inquiry').'</li>';
		$html .= '<li>4. '.__('Custom Inquiry forms using Contact Form 7 shortcode.', 'wc_email_inquiry').'</li>';
		$html .= '<li>5. '.__('Inquiry form opens On Page below button.', 'wc_email_inquiry').'</li>';
		$html .= '<li>6. '.__('Open Email Inquiry form on new page option.', 'wc_email_inquiry').'</li>';
		$html .= '<li>7. '.__('Open Gravity / Contact 7 form by pop-up.', 'wc_email_inquiry').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>* <a href="http://a3rev.com/shop/woocommerce-quotes-and-orders/" target="_blank">'.__('WooCommerce Quotes and Orders', 'wc_email_inquiry').'</a> '.__('Features', 'wc_email_inquiry').':</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Includes all features listed above.", 'wc_email_inquiry').'</li>';
		$html .= '<li>2. '.__('Extends WooCommerce add to cart mode to 3 new modes.', 'wc_email_inquiry').'</li>';
		$html .= '<li>3. '.__("Converts add to cart function into an add to Quote function.", 'wc_email_inquiry').'</li>';
		$html .= '<li>4. '.__("Manual' Quote Mode - quote prices off-line after request.", 'wc_email_inquiry').'</li>';
		$html .= '<li>5. '.__('Auto Quote Mode - Auto sends full quote to user.', 'wc_email_inquiry').'</li>';
		$html .= '<li>6. '.__('Converts add to cart function into add to Order function.', 'wc_email_inquiry').'</li>';
		$html .= '<li>7. '.__('Full integration with WooCommerce.', 'wc_email_inquiry').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('View this plugins', 'wc_email_inquiry').' <a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce/woo-email-inquiry-cart-options/" target="_blank">'.__('documentation', 'wc_email_inquiry').'</a></h3>';
		$html .= '<h3>'.__('Visit this plugins', 'wc_email_inquiry').' <a href="http://wordpress.org/support/plugin/woocommerce-email-inquiry-cart-options" target="_blank">'.__('support forum', 'wc_email_inquiry').'</a></h3>';
		$html .= '<h3>'.__('More FREE a3rev WooCommerce Plugins', 'wc_email_inquiry').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/woocommerce-product-sort-and-display/" target="_blank">'.__('WooCommerce Product Sort and Display', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woo-widget-product-slideshow/" target="_blank">'.__('WooCommerce Widget Product Slideshow', 'wc_email_inquiry').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('More FREE a3rev WordPress plugins', 'wc_email_inquiry').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/contact-us-page-contact-people/" target="_blank">'.__('Contact Us Page - Contact People', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'wc_email_inquiry').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';

		return $html;
	}
	
	public static function wc_ei_yellow_message_dontshow() {
		check_ajax_referer( 'wc_ei_yellow_message_dontshow', 'security' );
		$option_name   = $_REQUEST['option_name'];
		update_option( $option_name, 1 );
		die();
	}
	
	public static function wc_ei_yellow_message_dismiss() {
		check_ajax_referer( 'wc_ei_yellow_message_dismiss', 'security' );
		$session_name   = $_REQUEST['session_name'];
		if ( !isset($_SESSION) ) { session_start(); } 
		$_SESSION[$session_name] = 1 ;
		die();
	}
	
	public static function upgrade_version_1_0_3() {}
	
	public static function lite_upgrade_version_1_0_8() {
		
		$wc_email_inquiry_rules_roles_settings = get_option( 'wc_email_inquiry_rules_roles_settings', array() );
		$wc_email_inquiry_global_settings = get_option( 'wc_email_inquiry_global_settings', array() );
		$wc_email_inquiry_email_options = get_option( 'wc_email_inquiry_email_options', array() );
		$wc_email_inquiry_3rd_contactforms_settings = get_option( 'wc_email_inquiry_3rd_contactforms_settings', array() );
		$wc_email_inquiry_customize_email_popup = get_option( 'wc_email_inquiry_customize_email_popup', array() );
		$wc_email_inquiry_customize_email_button = get_option( 'wc_email_inquiry_customize_email_button', array() );
		
		$wc_email_inquiry_contact_form_settings = array(
			
			'inquiry_email_from_name'			=> $wc_email_inquiry_email_options['inquiry_email_from_name'],
			'inquiry_email_from_address'		=> $wc_email_inquiry_email_options['inquiry_email_from_address'],
			'inquiry_send_copy'					=> $wc_email_inquiry_email_options['inquiry_send_copy'],
			'inquiry_email_to'					=> $wc_email_inquiry_email_options['inquiry_email_to'],
			'inquiry_email_cc'					=> $wc_email_inquiry_email_options['inquiry_email_cc'],
			
		);
		update_option( 'wc_email_inquiry_contact_form_settings', $wc_email_inquiry_contact_form_settings );
		
		$wc_email_inquiry_global_settings = array(
			'inquiry_popup_type'				=> $wc_email_inquiry_customize_email_popup['inquiry_popup_type'],
		);
		update_option( 'wc_email_inquiry_global_settings', $wc_email_inquiry_global_settings );
		
		$wc_email_inquiry_customize_email_button_new = array_merge( $wc_email_inquiry_customize_email_button, array( 
			'inquiry_button_type'				=> $wc_email_inquiry_global_settings['inquiry_button_type'],
			'inquiry_button_position'			=> $wc_email_inquiry_global_settings['inquiry_button_position'],
			'inquiry_button_margin_top'			=> $wc_email_inquiry_global_settings['inquiry_button_padding_top'],
			'inquiry_button_margin_bottom'		=> $wc_email_inquiry_global_settings['inquiry_button_padding_bottom'],
			'inquiry_single_only'				=> $wc_email_inquiry_global_settings['inquiry_single_only'],
			
		) );
		update_option( 'wc_email_inquiry_customize_email_button', $wc_email_inquiry_customize_email_button_new );
		
		$wc_email_inquiry_customize_email_popup_new = array_merge( $wc_email_inquiry_customize_email_popup, array( 
			'inquiry_contact_popup_text_font'	=> array(
						'size'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font_size'],
						'face'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font'],
						'style'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font_style'],
						'color'		=> $wc_email_inquiry_customize_email_popup['inquiry_contact_popup_text_font_colour'],
			),
			
		) );
		update_option( 'wc_email_inquiry_customize_email_popup', $wc_email_inquiry_customize_email_popup_new );
	}
	
	public static function upgrade_version_1_0_9_2() {
		$wc_email_inquiry_rules_roles_settings = get_option( 'wc_email_inquiry_rules_roles_settings', array() );
		$wc_email_inquiry_global_settings = get_option( 'wc_email_inquiry_global_settings', array() );
		$wc_email_inquiry_customize_email_button = get_option( 'wc_email_inquiry_customize_email_button', array('inquiry_single_only' => 'no') );
		
		$wc_email_inquiry_global_settings['show_button'] = $wc_email_inquiry_rules_roles_settings['show_button'];
		$wc_email_inquiry_global_settings['show_button_after_login'] = $wc_email_inquiry_rules_roles_settings['show_button_after_login'];
		$wc_email_inquiry_global_settings['role_apply_show_inquiry_button'] = $wc_email_inquiry_rules_roles_settings['role_apply_show_inquiry_button'];
		$wc_email_inquiry_global_settings['inquiry_single_only'] = $wc_email_inquiry_customize_email_button['inquiry_single_only'];
		
		update_option( 'wc_email_inquiry_global_settings', $wc_email_inquiry_global_settings );
	}
}

?>
