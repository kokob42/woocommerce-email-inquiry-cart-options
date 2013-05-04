<?php
/**
 * WC Email Inquiry Hook Filter
 *
 * Table Of Contents
 *
 * shop_before_hide_add_to_cart_button()
 * shop_after_hide_add_to_cart_button()
 * details_before_hide_add_to_cart_button()
 * details_after_hide_add_to_cart_button()
 * add_email_inquiry_button()
 * details_add_email_inquiry_button_above()
 * details_add_email_inquiry_button_below()
 * wc_email_inquiry_popup()
 * wc_email_inquiry_action()
 * add_style_header()
 * include_customized_style()
 * footer_print_scripts()
 * script_contact_popup()
 * admin_header_script()
 * admin_footer_scripts()
 * plugin_extra_links()
 */
class WC_Email_Inquiry_Hook_Filter
{
	
	public static function add_admin_menu() {
		$woo_page = 'woocommerce';
		$admin_page = add_submenu_page( $woo_page , __( 'Email & Cart Options', 'wc_email_inquiry' ), __( 'Email & Cart Options', 'wc_email_inquiry' ), 'manage_options', 'email-cart-options', 'woo_email_cart_options_dashboard' );
	}
	
	public static function shop_before_hide_add_to_cart_button($template_name, $template_path, $located) {
		global $post;
		global $product;
		if ($template_name == 'loop/add-to-cart.php') {
			$product_id = $product->id;
			
			if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id))
				ob_start();
		}
	}
	
	public static function shop_after_hide_add_to_cart_button($template_name, $template_path, $located) {
		global $post;
		global $product;
		if ($template_name == 'loop/add-to-cart.php') {
			$product_id = $product->id;
			
			if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id))
				ob_end_clean();
		}
	}
	
	public static function details_before_hide_add_to_cart_button() {
		global $post, $product;
		$product_id = $product->id;
		
		if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id) )
			ob_start();
	}
	
	public static function details_after_hide_add_to_cart_button() {
		global $post, $product;
		$product_id = $product->id;
		
		if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id)){
			ob_end_clean();
			
			if ($product->is_type('variable')) {
				?>
					<div class="single_variation_wrap" style="display:none;">
						<div class="single_variation"></div>
						<div class="variations_button"><input type="hidden" name="variation_id" value="" /></div>
					</div>
					<div><input type="hidden" name="product_id" value="<?php echo $post->ID; ?>" /></div>
				<?php
			}
		}
	}
	
	public static function add_email_inquiry_button($product_id) {
		global $post;
		global $wc_email_inquiry_global_settings;
		global $wc_email_inquiry_customize_email_button;
		$wc_email_inquiry_settings_custom = get_post_meta( $product_id, '_wc_email_inquiry_settings_custom', true);
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_button_type'])) $wc_email_inquiry_button_type = $wc_email_inquiry_global_settings['inquiry_button_type'];
		else $wc_email_inquiry_button_type = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_button_type']);
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_text_before'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_text_before'])) == '') $wc_email_inquiry_text_before = $wc_email_inquiry_customize_email_button['inquiry_text_before'];
		else $wc_email_inquiry_text_before = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_text_before']);
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_hyperlink_text'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_hyperlink_text'])) == '') $wc_email_inquiry_hyperlink_text = $wc_email_inquiry_customize_email_button['inquiry_hyperlink_text'];
		else $wc_email_inquiry_hyperlink_text = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_hyperlink_text']);
		if (trim($wc_email_inquiry_hyperlink_text) == '') $wc_email_inquiry_hyperlink_text = __('Click Here', 'wc_email_inquiry');
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_trailing_text'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_trailing_text'])) == '') $wc_email_inquiry_trailing_text = $wc_email_inquiry_customize_email_button['inquiry_trailing_text'];
		else $wc_email_inquiry_trailing_text = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_trailing_text']);
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_button_title'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_button_title'])) == '') $wc_email_inquiry_button_title = $wc_email_inquiry_customize_email_button['inquiry_button_title'];
		else $wc_email_inquiry_button_title = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_button_title']);
		if (trim($wc_email_inquiry_button_title) == '') $wc_email_inquiry_button_title = __('Product Enquiry', 'wc_email_inquiry');
		
		$wc_email_inquiry_button_position = $wc_email_inquiry_global_settings['inquiry_button_position'];
		
		$wc_email_inquiry_button_class = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_class'))) != '') $wc_email_inquiry_button_class = $wc_email_inquiry_customize_email_button['inquiry_button_class'];
		
		$button_button = '<a class="wc_email_inquiry_email_button wc_email_inquiry_button_'.$product_id.' wc_email_inquiry_button '.$wc_email_inquiry_button_class.'" id="wc_email_inquiry_button_'.$product_id.'" product_name="'.addslashes(get_the_title($product_id) ).'" product_id="'.$product_id.'">'.$wc_email_inquiry_button_title.'</a>';

			add_action('wp_footer', array('WC_Email_Inquiry_Hook_Filter', 'footer_print_scripts') );
			$button_ouput = '<span class="wc_email_inquiry_button_container">';
			$button_ouput .= $button_button;
			
			$button_ouput .= '</span>';
			
		return $button_ouput;
	}
			
	public static function details_add_email_inquiry_button_above() {
		global $post;
		global $product;
		$product_id = $product->id;
		
		if (($post->post_type == 'product' || $post->post_type == 'product_variation') && WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
			echo WC_Email_Inquiry_Hook_Filter::add_email_inquiry_button($product_id);
		}
	}
	
	public static function details_add_email_inquiry_button_below($template_name, $template_path, $located){
		global $post;
		global $product;
		if (in_array($template_name, array('single-product/add-to-cart/simple.php', 'single-product/add-to-cart/grouped.php', 'single-product/add-to-cart/external.php', 'single-product/add-to-cart/variable.php'))) {
			$product_id = $product->id;
			
			if (($post->post_type == 'product' || $post->post_type == 'product_variation') && WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
				echo WC_Email_Inquiry_Hook_Filter::add_email_inquiry_button($product_id);
			}
		}
	}
	
	public static function wc_email_inquiry_popup() {
		check_ajax_referer( 'wc_email_inquiry_popup', 'security' );
		global $wc_email_inquiry_global_settings;
		global $wc_email_inquiry_email_options;
		global $wc_email_inquiry_customize_email_button;
		global $wc_email_inquiry_customize_email_popup;
		
		$wc_email_inquiry_action = wp_create_nonce("wc_email_inquiry_action");
		$product_id = $_REQUEST['product_id'];
		$product_name = get_the_title($product_id);
		
		$wc_email_inquiry_settings_custom = get_post_meta( $product_id, '_wc_email_inquiry_settings_custom', true);
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_button_title'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_button_title'])) == '') $wc_email_inquiry_button_title = $wc_email_inquiry_customize_email_button['inquiry_button_title'];
		else $wc_email_inquiry_button_title = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_button_title']);
		if (trim($wc_email_inquiry_button_title) == '') $wc_email_inquiry_button_title = __('Product Enquiry', 'wc_email_inquiry');
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_text_before'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_text_before'])) == '') $wc_email_inquiry_text_before = $wc_email_inquiry_customize_email_button['inquiry_text_before'];
		else $wc_email_inquiry_text_before = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_text_before']);
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_hyperlink_text'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_hyperlink_text'])) == '') $wc_email_inquiry_hyperlink_text = $wc_email_inquiry_customize_email_button['inquiry_hyperlink_text'];
		else $wc_email_inquiry_hyperlink_text = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_hyperlink_text']);
		if (trim($wc_email_inquiry_hyperlink_text) == '') $wc_email_inquiry_hyperlink_text = __('Click Here', 'wc_email_inquiry');
		
		if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_trailing_text'])  || trim(esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_trailing_text'])) == '') $wc_email_inquiry_trailing_text = $wc_email_inquiry_customize_email_button['inquiry_trailing_text'];
		else $wc_email_inquiry_trailing_text = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_trailing_text']);
		
		if ( trim( $wc_email_inquiry_customize_email_popup['inquiry_contact_heading'] ) != '') {
			$wc_email_inquiry_contact_heading = $wc_email_inquiry_customize_email_popup['inquiry_contact_heading'];
		} else {
			if (!isset($wc_email_inquiry_settings_custom['wc_email_inquiry_button_type'])) $wc_email_inquiry_button_type = $wc_email_inquiry_global_settings['inquiry_button_type'];
			else $wc_email_inquiry_button_type = esc_attr($wc_email_inquiry_settings_custom['wc_email_inquiry_button_type']);
			
			$wc_email_inquiry_contact_heading = $wc_email_inquiry_button_title;
		}
		
		if ( trim( $wc_email_inquiry_customize_email_popup['inquiry_contact_text_button'] ) != '') $wc_email_inquiry_contact_text_button = $wc_email_inquiry_customize_email_popup['inquiry_contact_text_button'];
		else $wc_email_inquiry_contact_text_button = __('SEND', 'wc_email_inquiry');
				
		$wc_email_inquiry_contact_button_class = '';
		$wc_email_inquiry_contact_form_class = '';
		if ( trim( $wc_email_inquiry_customize_email_popup['inquiry_contact_button_class'] ) != '') $wc_email_inquiry_contact_button_class = $wc_email_inquiry_customize_email_popup['inquiry_contact_button_class'];
		if ( trim( $wc_email_inquiry_customize_email_popup['inquiry_contact_form_class'] ) != '') $wc_email_inquiry_contact_form_class = $wc_email_inquiry_customize_email_popup['inquiry_contact_form_class'];
		
		$wc_email_inquiry_send_copy = false;
		
		
	?>	
<div class="wc_email_inquiry_form <?php echo $wc_email_inquiry_contact_form_class; ?>">
	<h1 class="wc_email_inquiry_result_heading"><?php echo $wc_email_inquiry_contact_heading; ?></h1>
	<div class="wc_email_inquiry_content" id="wc_email_inquiry_content_<?php echo $product_id; ?>">
		<div class="wc_email_inquiry_field">
        	<label class="wc_email_inquiry_label" for="your_name_<?php echo $product_id; ?>"><?php _e('Name','wc_email_inquiry'); ?> <span class="wc_email_inquiry_required">*</span></label> 
			<input type="text" class="your_name" name="your_name" id="your_name_<?php echo $product_id; ?>" value="" /></div>
		<div class="wc_email_inquiry_field">
        	<label class="wc_email_inquiry_label" for="your_email_<?php echo $product_id; ?>"><?php _e('Email Address','wc_email_inquiry'); ?> <span class="wc_email_inquiry_required">*</span></label>
			<input type="text" class="your_email" name="your_email" id="your_email_<?php echo $product_id; ?>" value="" /></div>
		<div class="wc_email_inquiry_field">
        	<label class="wc_email_inquiry_label" for="your_phone_<?php echo $product_id; ?>"><?php _e('Phone','wc_email_inquiry'); ?> <span class="wc_email_inquiry_required">*</span></label> 
			<input type="text" class="your_phone" name="your_phone" id="your_phone_<?php echo $product_id; ?>" value="" /></div>
		<div class="wc_email_inquiry_field">
        	<label class="wc_email_inquiry_label"><?php _e('Subject','wc_email_inquiry'); ?> </label> 
			<?php echo $product_name; ?></div>
		<div class="wc_email_inquiry_field">
        	<label class="wc_email_inquiry_label" for="your_message_<?php echo $product_id; ?>"><?php _e('Message','wc_email_inquiry'); ?></label> 
			<textarea class="your_message" name="your_message" id="your_message_<?php echo $product_id; ?>"></textarea></div>
        <div class="wc_email_inquiry_field">
        	<label class="wc_email_inquiry_label">&nbsp;</label>
            <a class="wc_email_inquiry_form_button wc_email_inquiry_bt_<?php echo $product_id; ?> <?php echo $wc_email_inquiry_contact_button_class; ?>" id="wc_email_inquiry_bt_<?php echo $product_id; ?>" product_id="<?php echo $product_id; ?>"><?php echo $wc_email_inquiry_contact_text_button; ?></a> <span class="wc_email_inquiry_loading" id="wc_email_inquiry_loading_<?php echo $product_id; ?>"><img src="<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/ajax-loader.gif" /></span>
        </div>
	</div>
</div>
	<?php		
		die();
	}
	
	public static function wc_email_inquiry_action() {
		check_ajax_referer( 'wc_email_inquiry_action', 'security' );
		$product_id 	= $_REQUEST['product_id'];
		$your_name 		= $_REQUEST['your_name'];
		$your_email 	= $_REQUEST['your_email'];
		$your_phone 	= $_REQUEST['your_phone'];
		$your_message 	= $_REQUEST['your_message'];
		$send_copy_yourself	= $_REQUEST['send_copy'];
		
		$email_result = WC_Email_Inquiry_Functions::email_inquiry($product_id, $your_name, $your_email, $your_phone, $your_message, $send_copy_yourself);
		echo json_encode($email_result );
		die();
	}
		
	public static function add_style_header() {
		wp_enqueue_style('a3_wc_email_inquiry_style', WC_EMAIL_INQUIRY_CSS_URL . '/wc_email_inquiry_style.css');
	}
	
	public static function include_customized_style() {
		include( WC_EMAIL_INQUIRY_DIR. '/templates/customized_style.php' );
	}
	
	public static function footer_print_scripts() {
		global $woocommerce;
		global $wc_email_inquiry_customize_email_popup;
		$current_db_version = get_option( 'woocommerce_db_version', null );
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_script('jquery');
		$wc_email_inquiry_popup_type = $wc_email_inquiry_customize_email_popup['inquiry_popup_type'];
		if ($wc_email_inquiry_popup_type == 'colorbox') {
			wp_enqueue_style( 'a3_colorbox_style', WC_EMAIL_INQUIRY_JS_URL . '/colorbox/colorbox.css' );
			wp_enqueue_script( 'colorbox_script', WC_EMAIL_INQUIRY_JS_URL . '/colorbox/jquery.colorbox'.$suffix.'.js', array(), false, true );
		} elseif ($wc_email_inquiry_popup_type == 'fb') {
			wp_enqueue_style( 'woocommerce_fancybox_styles', WC_EMAIL_INQUIRY_JS_URL . '/fancybox/fancybox.css' );
			wp_enqueue_script( 'fancybox', WC_EMAIL_INQUIRY_JS_URL . '/fancybox/fancybox'.$suffix.'.js', array(), false, true );
		} else {
			if ( version_compare( $current_db_version, '2.0', '<' ) && null !== $current_db_version ) {
				wp_enqueue_style( 'woocommerce_prettyPhoto_css', WC_EMAIL_INQUIRY_JS_URL . '/prettyPhoto/prettyPhoto.css');
				wp_enqueue_script( 'prettyPhoto', WC_EMAIL_INQUIRY_JS_URL . '/prettyPhoto/jquery.prettyPhoto'.$suffix.'.js', array(), false, true);
			} else {
				wp_enqueue_style( 'woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
				wp_enqueue_script( 'prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array(), false, true );
			}
		}
	}
	
	public static function script_contact_popup() {
		global $wc_email_inquiry_customize_email_popup;
		$current_db_version = get_option( 'woocommerce_db_version', null );
		$wc_email_inquiry_popup = wp_create_nonce("wc_email_inquiry_popup");
		$wc_email_inquiry_action = wp_create_nonce("wc_email_inquiry_action");
	?>
<script type="text/javascript">
(function($){
	$(function(){
		var ajax_url = "<?php echo ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin-ajax.php' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin-ajax.php' ) ) ); ?>";
		$(document).on("click", ".wc_email_inquiry_button", function(){
			var product_id = $(this).attr("product_id");
			var product_name = $(this).attr("product_name");
		<?php
			$wc_email_inquiry_popup_type = $wc_email_inquiry_customize_email_popup['inquiry_popup_type'];
			if ($wc_email_inquiry_popup_type == 'colorbox') {
		?>
			$.colorbox({
				href		: ajax_url+"?action=wc_email_inquiry_popup&product_id="+product_id+"&security=<?php echo $wc_email_inquiry_popup; ?>",
				scrolling	: true,
				innerWidth	: 520,
				innerHeight	: 400,
				fixed		: true,
				maxWidth  	: "100%",
				maxHeight	: "100%",
			});
		<?php } elseif ($wc_email_inquiry_popup_type == 'fb') { ?> 
			$.fancybox({
				href: ajax_url+"?action=wc_email_inquiry_popup&product_id="+product_id+"&security=<?php echo $wc_email_inquiry_popup; ?>",
				padding: 20,
				maxWidth: 600,
				maxHeight: 400,
				openEffect	: "none",
				closeEffect	: "none"
			});
		<?php } else { 
				if ( version_compare( $current_db_version, '2.0', '<' ) && null !== $current_db_version ) {
		?>
			$().prettyPhoto({modals: "true", social_tools: false, theme: "light_square"});
			$.prettyPhoto.open(ajax_url+"?action=wc_email_inquiry_popup&product_id="+product_id+"&security=<?php echo $wc_email_inquiry_popup; ?>&ajax=true&width=600&height=380", "", "");
		<?php } else { ?>
			$().prettyPhoto({modals: "true", social_tools: false, theme: "pp_woocommerce"});
			$.prettyPhoto.open(ajax_url+"?action=wc_email_inquiry_popup&product_id="+product_id+"&security=<?php echo $wc_email_inquiry_popup; ?>&ajax=true&width=600&height=380", "", "");
		<?php } } ?>
		});
		
		$(document).on("click", ".wc_email_inquiry_form_button", function(){
			var product_id = $(this).attr("product_id");
			var your_name = $("#your_name_"+product_id).val();
			var your_email = $("#your_email_"+product_id).val();
			var your_phone = $("#your_phone_"+product_id).val();
			var your_message = $("#your_message_"+product_id).val();
			var send_copy = 0;
			
			var wc_email_inquiry_error = "";
			var wc_email_inquiry_have_error = false;
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
			if (your_name == "") {
				wc_email_inquiry_error += "<?php _e('Please enter your Name', 'wc_email_inquiry'); ?>\n";
				wc_email_inquiry_have_error = true;
			}
			if (your_email == "" || !filter.test(your_email)) {
				wc_email_inquiry_error += "<?php _e('Please enter valid Email address', 'wc_email_inquiry'); ?>\n";
				wc_email_inquiry_have_error = true;
			}
			if (your_phone == "") {
				wc_email_inquiry_error += "<?php _e('Please enter your Phone', 'wc_email_inquiry'); ?>\n";
				wc_email_inquiry_have_error = true;
			}
			if (wc_email_inquiry_have_error) {
				alert(wc_email_inquiry_error);
				return false;
			}
			$(this).attr("disabled", "disabled");
			$("#wc_email_inquiry_loading_"+product_id).show();
			
			var data = {
				action: 		"wc_email_inquiry_action",
				product_id: 	product_id,
				your_name: 		your_name,
				your_email: 	your_email,
				your_phone: 	your_phone,
				your_message: 	your_message,
				send_copy:		send_copy,
				security: 		"<?php echo $wc_email_inquiry_action; ?>"
			};
			$.post( ajax_url, data, function(response) {
				wc_email_inquiry_response = $.parseJSON( response );
				$("#wc_email_inquiry_loading_"+product_id).hide();
				$("#wc_email_inquiry_content_"+product_id).html(wc_email_inquiry_response);
			});
		});
	});
})(jQuery);
</script>
    <?php
	}
	
	public static function admin_header_script() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
	}
	
	public static function admin_footer_scripts() {
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_script('jquery');
		
		wp_enqueue_style( 'a3rev-chosen-style', WC_EMAIL_INQUIRY_JS_URL . '/chosen/chosen.css' );
		wp_enqueue_script( 'chosen', WC_EMAIL_INQUIRY_JS_URL . '/chosen/chosen.jquery'.$suffix.'.js', array(), false, true );
		wp_enqueue_script( 'a3rev-chosen-script-init', WC_EMAIL_INQUIRY_JS_URL.'/init-chosen.js', array(), false, true );
	?>
<script type="text/javascript">
jQuery(window).load(function(){
	// Subsubsub tabs
	jQuery('div.a3_subsubsub_section ul.subsubsub li a:eq(0)').addClass('current');
	jQuery('div.a3_subsubsub_section .section:gt(0)').hide();
	jQuery('div.a3_subsubsub_section ul.subsubsub li a').click(function(){
		var $clicked = jQuery(this);
		var $section = $clicked.closest('.a3_subsubsub_section');
		var $target  = $clicked.attr('href');
	
		$section.find('a').removeClass('current');
	
		if ( $section.find('.section:visible').size() > 0 ) {
			$section.find('.section:visible').fadeOut( 100, function() {
				$section.find( $target ).fadeIn('fast');
			});
		} else {
			$section.find( $target ).fadeIn('fast');
		}
	
		$clicked.addClass('current');
		jQuery('#last_tab').val( $target );
	
		return false;
	});
	<?php if (isset($_REQUEST['subtab']) && $_REQUEST['subtab']) echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href='.$_REQUEST['subtab'].']").click();'; ?>
});
(function($){
	$(function(){
		// Color picker
		$('.colorpick').each(function(){
			$('.colorpickdiv', $(this).parent()).farbtastic(this);
			$(this).click(function() {
				if ( $(this).val() == "" ) $(this).val('#000000');
				$('.colorpickdiv', $(this).parent() ).show();
			});	
		});
		$(document).mousedown(function(){
			$('.colorpickdiv').hide();
		});
	});
})(jQuery);
</script>
    <?php
	}
	
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_EMAIL_INQUIRY_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/woocommerce/woo-email-inquiry-cart-options/" target="_blank">'.__('Documentation', 'wc_email_inquiry').'</a>';
		$links[] = '<a href="'.WC_EMAIL_AUTHOR_URI.'#help_tab" target="_blank">'.__('Support', 'wc_email_inquiry').'</a>';
		return $links;
	}
}
?>