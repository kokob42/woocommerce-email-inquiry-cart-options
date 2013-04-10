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
 * shop_add_email_inquiry_button_above()
 * shop_add_email_inquiry_button_below()
 * details_add_email_inquiry_button_above()
 * details_add_email_inquiry_button_below()
 * wc_email_inquiry_popup()
 * wc_email_inquiry_action()
 * add_style_header()
 * footer_print_scripts()
 * script_contact_popup()
 * admin_footer_scripts()
 * wp_admin_footer_scripts()
 * plugin_extra_links()
 */
class WC_Email_Inquiry_Hook_Filter{
	
	function shop_before_hide_add_to_cart_button($template_name, $template_path, $located) {
		global $post;
		global $product;
		if ($template_name == 'loop/add-to-cart.php') {
			$product_id = $product->id;
			
			if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id))
				ob_start();
		}
	}
	
	function shop_after_hide_add_to_cart_button($template_name, $template_path, $located) {
		global $post;
		global $product;
		if ($template_name == 'loop/add-to-cart.php') {
			$product_id = $product->id;
			
			if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id))
				ob_end_clean();
		}
	}
	
	function details_before_hide_add_to_cart_button() {
		global $post, $product;
		$product_id = $product->id;
		
		if (WC_Email_Inquiry_Functions::check_hide_add_cart_button($product_id) )
			ob_start();
	}
	
	function details_after_hide_add_to_cart_button() {
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
	
	function add_email_inquiry_button($product_id) {
		global $post;
		$wc_email_inquiry_button_type = esc_attr(get_option('wc_email_inquiry_button_type'));
		
		$wc_email_inquiry_text_before = esc_attr(get_option('wc_email_inquiry_text_before'));
		
		$wc_email_inquiry_hyperlink_text = esc_attr(get_option('wc_email_inquiry_hyperlink_text'));
		if (trim($wc_email_inquiry_hyperlink_text) == '') $wc_email_inquiry_hyperlink_text = __('Click Here', 'wc_email_inquiry');
		
		$wc_email_inquiry_trailing_text = esc_attr(get_option('wc_email_inquiry_trailing_text'));
		
		$wc_email_inquiry_button_title = esc_attr(get_option('wc_email_inquiry_button_title'));
		if (trim($wc_email_inquiry_button_title) == '') $wc_email_inquiry_button_title = __('Product Enquiry', 'wc_email_inquiry');
		
		$wc_email_inquiry_button_position = esc_attr(get_option('wc_email_inquiry_button_position'));
		
		$wc_email_inquiry_button_class = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_class'))) != '') $wc_email_inquiry_button_class = esc_attr(get_option('wc_email_inquiry_button_class'));
		
		$button_link = '';
		if (trim($wc_email_inquiry_text_before) != '') $button_link .= '<span class="wc_email_inquiry_text_before wc_email_inquiry_text_before_'.$product_id.'">'.trim($wc_email_inquiry_text_before).'</span> ';
		$button_link .= '<a class="wc_email_inquiry_hyperlink_text wc_email_inquiry_hyperlink_text_'.$product_id.' wc_email_inquiry_buton" id="wc_email_inquiry_button_'.$product_id.'" product_name="'.addslashes($post->post_title).'" product_id="'.$product_id.'">'.$wc_email_inquiry_hyperlink_text.'</a>';
		if (trim($wc_email_inquiry_trailing_text) != '') $button_link .= ' <span class="wc_email_inquiry_trailing_text wc_email_inquiry_trailing_text_'.$product_id.'">'.trim($wc_email_inquiry_trailing_text).'</span>';
		
		$button_button = '<a class="wc_email_inquiry_button_button wc_email_inquiry_email_button wc_email_inquiry_button_'.$product_id.' wc_email_inquiry_buton '.$wc_email_inquiry_button_class.'" id="wc_email_inquiry_button_'.$product_id.'" product_name="'.addslashes(get_the_title($product_id) ).'" product_id="'.$product_id.'"><span>'.$wc_email_inquiry_button_title.'</span></a>';

			add_action('wp_footer', array('WC_Email_Inquiry_Hook_Filter', 'footer_print_scripts') );
			$button_ouput = '<span class="wc_email_inquiry_button_container">';
			if ($wc_email_inquiry_button_type == 'link') $button_ouput .= $button_link;
			else $button_ouput .= $button_button;
			
			$button_ouput .= '</span>';
			
		return $button_ouput;
	}
	
	function shop_add_email_inquiry_button_above($template_name, $template_path, $located) {
		global $post;
		global $product;
		if ($template_name == 'loop/add-to-cart.php') {
			$product_id = $product->id;
			
			$wc_email_inquiry_single_only = esc_attr(get_option('wc_email_inquiry_single_only'));
			
			if ( ($post->post_type == 'product' || $post->post_type == 'product_variation') && $wc_email_inquiry_single_only == 'no' && WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
				echo WC_Email_Inquiry_Hook_Filter::add_email_inquiry_button($product_id);
			}
		}
	}
	
	function shop_add_email_inquiry_button_below() {
		global $post;
		global $product;
		$product_id = $product->id;
			
		$wc_email_inquiry_single_only = esc_attr(get_option('wc_email_inquiry_single_only'));
			
		if ( ($post->post_type == 'product' || $post->post_type == 'product_variation') && $wc_email_inquiry_single_only == 'no' && WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
			echo WC_Email_Inquiry_Hook_Filter::add_email_inquiry_button($product_id);
		}
	}
	
	function details_add_email_inquiry_button_above() {
		global $post;
		global $product;
		$product_id = $product->id;
		
		if (($post->post_type == 'product' || $post->post_type == 'product_variation') && WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
			echo WC_Email_Inquiry_Hook_Filter::add_email_inquiry_button($product_id);
		}
	}
	
	function details_add_email_inquiry_button_below($template_name, $template_path, $located){
		global $post;
		global $product;
		if (in_array($template_name, array('single-product/add-to-cart/simple.php', 'single-product/add-to-cart/grouped.php', 'single-product/add-to-cart/external.php', 'single-product/add-to-cart/variable.php'))) {
			$product_id = $product->id;
			
			if (($post->post_type == 'product' || $post->post_type == 'product_variation') && WC_Email_Inquiry_Functions::check_add_email_inquiry_button($product_id) ) {
				echo WC_Email_Inquiry_Hook_Filter::add_email_inquiry_button($product_id);
			}
		}
	}
	
	function wc_email_inquiry_popup() {
		check_ajax_referer( 'wc_email_inquiry_popup', 'security' );
		
		$wc_email_inquiry_action = wp_create_nonce("wc_email_inquiry_action");
		$product_id = $_REQUEST['product_id'];
		$product_name = get_the_title($product_id);
				
		$wc_email_inquiry_button_title = esc_attr(get_option('wc_email_inquiry_button_title'));
		if (trim($wc_email_inquiry_button_title) == '') $wc_email_inquiry_button_title = __('Product Enquiry', 'wc_email_inquiry');
		
		$wc_email_inquiry_text_before = esc_attr(get_option('wc_email_inquiry_text_before'));
		
		$wc_email_inquiry_hyperlink_text = esc_attr(get_option('wc_email_inquiry_hyperlink_text'));
		if (trim($wc_email_inquiry_hyperlink_text) == '') $wc_email_inquiry_hyperlink_text = __('Click Here', 'wc_email_inquiry');
		
		$wc_email_inquiry_trailing_text = esc_attr(get_option('wc_email_inquiry_trailing_text'));
		
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_heading'))) != '') {
			$wc_email_inquiry_contact_heading = esc_attr(get_option('wc_email_inquiry_contact_heading'));
		} else {
			$wc_email_inquiry_button_type = esc_attr(get_option('wc_email_inquiry_button_type'));
			
			if ($wc_email_inquiry_button_type == 'link') $wc_email_inquiry_contact_heading = $wc_email_inquiry_text_before .' '. $wc_email_inquiry_hyperlink_text .' '.$wc_email_inquiry_trailing_text;
			else $wc_email_inquiry_contact_heading = $wc_email_inquiry_button_title;
		}
		
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_text_button'))) != '') $wc_email_inquiry_contact_text_button = esc_attr(get_option('wc_email_inquiry_contact_text_button'));
		else $wc_email_inquiry_contact_text_button = __('SEND', 'wc_email_inquiry');
				
		$wc_email_inquiry_contact_button_class = '';
		$wc_email_inquiry_contact_form_class = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_button_class'))) != '') $wc_email_inquiry_contact_button_class = esc_attr(get_option('wc_email_inquiry_contact_button_class'));
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_form_class'))) != '') $wc_email_inquiry_contact_form_class = esc_attr(get_option('wc_email_inquiry_contact_form_class'));		
		
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
            <a class="wc_email_inquiry_button_button wc_email_inquiry_form_button wc_email_inquiry_bt_<?php echo $product_id; ?> <?php echo $wc_email_inquiry_contact_button_class; ?>" id="wc_email_inquiry_bt_<?php echo $product_id; ?>" product_id="<?php echo $product_id; ?>"><span><?php echo $wc_email_inquiry_contact_text_button; ?></span></a> <span class="wc_email_inquiry_loading" id="wc_email_inquiry_loading_<?php echo $product_id; ?>"><img src="<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/ajax-loader.gif" /></span>
        </div>
	</div>
</div>
	<?php		
		die();
	}
	
	function wc_email_inquiry_action() {
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
		
	function add_style_header() {
		wp_enqueue_style('a3_wc_email_inquiry_style', WC_EMAIL_INQUIRY_CSS_URL . '/wc_email_inquiry_style.css');
	}
	
	function footer_print_scripts() {
		global $woocommerce;
		$current_db_version = get_option( 'woocommerce_db_version', null );
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$wc_email_inquiry_button_padding = 5;
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_padding'))) != '') $wc_email_inquiry_button_padding = intval(esc_attr(get_option('wc_email_inquiry_button_padding')));
		
		$wc_email_inquiry_button_bg_colour = '';		
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_bg_colour'))) != '') $wc_email_inquiry_button_bg_colour = esc_attr(get_option('wc_email_inquiry_button_bg_colour'));
		
		$wc_email_inquiry_button_border_colour = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_border_colour'))) != '') $wc_email_inquiry_button_border_colour = esc_attr(get_option('wc_email_inquiry_button_border_colour'));
		
		$wc_email_inquiry_border_rounded = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_border_rounded'))) != '') $wc_email_inquiry_border_rounded = esc_attr(get_option('wc_email_inquiry_border_rounded'));
		
		$wc_email_inquiry_rounded_value = 15;
		if ( trim(esc_attr(get_option('wc_email_inquiry_rounded_value'))) != '') $wc_email_inquiry_rounded_value = esc_attr(get_option('wc_email_inquiry_rounded_value'));
		
		$wc_email_inquiry_button_text_size = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_text_size'))) != '') $wc_email_inquiry_button_text_size = esc_attr(get_option('wc_email_inquiry_button_text_size'));
		
		$wc_email_inquiry_button_text_style = 'bold';
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_text_style'))) != '') $wc_email_inquiry_button_text_style = esc_attr(get_option('wc_email_inquiry_button_text_style'));
		
		$wc_email_inquiry_button_text_colour = '#FFFFFF';
		if ( trim(esc_attr(get_option('wc_email_inquiry_button_text_colour'))) != '') $wc_email_inquiry_button_text_colour = esc_attr(get_option('wc_email_inquiry_button_text_colour'));
		
		$wc_email_inquiry_contact_button_bg_colour = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_button_bg_colour'))) != '') $wc_email_inquiry_contact_button_bg_colour = esc_attr(get_option('wc_email_inquiry_contact_button_bg_colour'));
		
		$wc_email_inquiry_contact_button_border_colour = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_button_border_colour'))) != '') $wc_email_inquiry_contact_button_border_colour = esc_attr(get_option('wc_email_inquiry_contact_button_border_colour'));
		
		$wc_email_inquiry_contact_border_rounded = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_border_rounded'))) != '') $wc_email_inquiry_contact_border_rounded = esc_attr(get_option('wc_email_inquiry_contact_border_rounded'));
		
		$wc_email_inquiry_contact_rounded_value = 15;
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_rounded_value'))) != '') $wc_email_inquiry_contact_rounded_value = esc_attr(get_option('wc_email_inquiry_contact_rounded_value'));
		
		$wc_email_inquiry_contact_button_text_size = '';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_button_text_size'))) != '') $wc_email_inquiry_contact_button_text_size = esc_attr(get_option('wc_email_inquiry_contact_button_text_size'));
		
		$wc_email_inquiry_contact_button_text_style = 'bold';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_button_text_style'))) != '') $wc_email_inquiry_contact_button_text_style = esc_attr(get_option('wc_email_inquiry_contact_button_text_style'));
		
		$wc_email_inquiry_contact_button_text_colour = '#FFFFFF';
		if ( trim(esc_attr(get_option('wc_email_inquiry_contact_button_text_colour'))) != '') $wc_email_inquiry_contact_button_text_colour = esc_attr(get_option('wc_email_inquiry_contact_button_text_colour'));
	?>
		<style type="text/css">
		h1.wc_email_inquiry_result_heading {
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_contact_button_bg_colour)) != '') { ?>
			color: <?php echo $wc_email_inquiry_contact_button_bg_colour; ?> !important;
			<?php } ?>
		}
		.wc_email_inquiry_button_container { padding-top:<?php echo $wc_email_inquiry_button_padding ?>px !important; padding-bottom:<?php echo $wc_email_inquiry_button_padding ?>px !important; }
		body a.wc_email_inquiry_email_button, body a.wc_email_inquiry_email_button:hover, body a.wc_email_inquiry_email_button.hover, body a.wc_email_inquiry_email_button.active {
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_button_bg_colour)) != '') { ?>
			background: <?php echo $wc_email_inquiry_button_bg_colour; ?>  !important;
			<?php } ?>
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_button_border_colour)) != '') { ?>
			border-color: <?php echo $wc_email_inquiry_button_border_colour; ?>  !important;
			<?php } ?>
			<?php if (trim($wc_email_inquiry_border_rounded) == 'square') { ?>
			-webkit-border-radius: 0px !important;
			-moz-border-radius: 0px !important;
			border-radius: 0px !important;
			<?php } else { ?>
			-webkit-border-radius: <?php echo $wc_email_inquiry_rounded_value; ?>px !important;
			-moz-border-radius: <?php echo $wc_email_inquiry_rounded_value; ?>px !important;
			border-radius: <?php echo $wc_email_inquiry_rounded_value; ?>px !important;
			<?php } ?>
		}
		body a.wc_email_inquiry_email_button span, body a.wc_email_inquiry_email_button:hover span, body a.wc_email_inquiry_email_button.hover span, body a.wc_email_inquiry_email_button.active span {
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_button_text_colour)) != '') { ?>
			color: <?php echo $wc_email_inquiry_button_text_colour; ?>  !important;
			<?php } ?>
			<?php if (trim($wc_email_inquiry_button_text_size) != '' && $wc_email_inquiry_button_text_size > 0) { ?>
			font-size: <?php echo $wc_email_inquiry_button_text_size; ?>px  !important;
			<?php } ?>
			<?php if ($wc_email_inquiry_button_text_style == 'italic' || $wc_email_inquiry_button_text_style == 'bold_italic') { ?>
			font-style:italic !important;
			<?php } ?>
			<?php if ($wc_email_inquiry_button_text_style == '' || $wc_email_inquiry_button_text_style == 'bold' || $wc_email_inquiry_button_text_style == 'bold_italic') { ?>
			font-weight:bold !important;
			<?php } ?>
			<?php if ($wc_email_inquiry_button_text_style == 'normal') { ?>
			font-weight:normal !important;
			font-style:normal !important;
			<?php } ?>
		}
		<?php if (trim(str_replace('#', '', $wc_email_inquiry_button_bg_colour)) != '' || trim(str_replace('#', '', $wc_email_inquiry_button_border_colour)) != '') { ?>
		body a.wc_email_inquiry_email_button:hover {
			opacity:0.85;	
		}
		<?php } ?>
		body a.wc_email_inquiry_form_button, body a.wc_email_inquiry_form_button:hover, body a.wc_email_inquiry_form_button.hover, body a.wc_email_inquiry_form_button.active {
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_contact_button_bg_colour)) != '') { ?>
			background: <?php echo $wc_email_inquiry_contact_button_bg_colour; ?>  !important;
			<?php } ?>
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_contact_button_border_colour)) != '') { ?>
			border-color: <?php echo $wc_email_inquiry_contact_button_border_colour; ?>  !important;
			<?php } ?>
			<?php if (trim($wc_email_inquiry_contact_border_rounded) == 'square') { ?>
			-webkit-border-radius: 0px !important;
			-moz-border-radius: 0px !important;
			border-radius: 0px !important;
			<?php } else { ?>
			-webkit-border-radius: <?php echo $wc_email_inquiry_contact_rounded_value; ?>px !important;
			-moz-border-radius: <?php echo $wc_email_inquiry_contact_rounded_value; ?>px !important;
			border-radius: <?php echo $wc_email_inquiry_contact_rounded_value; ?>px !important;
			<?php } ?>
		}
		body a.wc_email_inquiry_form_button span, body a.wc_email_inquiry_form_button:hover span, body a.wc_email_inquiry_form_button.hover span, body a.wc_email_inquiry_form_button.active span {
			<?php if (trim(str_replace('#', '', $wc_email_inquiry_contact_button_text_colour)) != '') { ?>
			color: <?php echo $wc_email_inquiry_contact_button_text_colour; ?>  !important;
			<?php } ?>
			<?php if (trim($wc_email_inquiry_contact_button_text_size) != '' && $wc_email_inquiry_contact_button_text_size > 0) { ?>
			font-size: <?php echo $wc_email_inquiry_contact_button_text_size; ?>px  !important;
			<?php } ?>
			<?php if ($wc_email_inquiry_contact_button_text_style == 'italic' || $wc_email_inquiry_contact_button_text_style == 'bold_italic') { ?>
			font-style:italic !important;
			<?php } ?>
			<?php if ($wc_email_inquiry_contact_button_text_style == '' || $wc_email_inquiry_contact_button_text_style == 'bold' || $wc_email_inquiry_contact_button_text_style == 'bold_italic') { ?>
			font-weight:bold !important;
			<?php } ?>
			<?php if ($wc_email_inquiry_contact_button_text_style == 'normal') { ?>
			font-weight:normal !important;
			font-style:normal !important;
			<?php } ?>
		}
		<?php if (trim(str_replace('#', '', $wc_email_inquiry_contact_button_bg_colour)) != '' || trim(str_replace('#', '', $wc_email_inquiry_contact_button_border_colour)) != '') { ?>
		body a.wc_email_inquiry_form_button:hover {
			opacity:0.85;	
		}
		<?php } ?>
		</style>
    <?php
		wp_enqueue_script('jquery');
		$wc_email_inquiry_popup_type = get_option('wc_email_inquiry_popup_type');
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
	
	function script_contact_popup() {
		$current_db_version = get_option( 'woocommerce_db_version', null );
		$wc_email_inquiry_popup = wp_create_nonce("wc_email_inquiry_popup");
		$wc_email_inquiry_action = wp_create_nonce("wc_email_inquiry_action");
	?>
<script type="text/javascript">
(function($){
	$(function(){
		var ajax_url = "<?php echo ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin-ajax.php' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin-ajax.php' ) ) ); ?>";
		$(".wc_email_inquiry_buton").live("click", function(){
			var product_id = $(this).attr("product_id");
			var product_name = $(this).attr("product_name");
		<?php
			$wc_email_inquiry_popup_type = get_option('wc_email_inquiry_popup_type');
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
		
		$(".wc_email_inquiry_form_button").live("click", function(){
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
	
	function admin_footer_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
	?>
    <script type="text/javascript">
		(function($){		
			$(function(){	
				// Color picker
				$('.colorpick').each(function(){
					$('.colorpickdiv', $(this).parent()).farbtastic(this);
					$(this).live('click',function() {
						if ( $(this).val() == "" ) $(this).val('#ee2b2b');
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
	
	function wp_admin_footer_scripts() {
	?>
    <script type="text/javascript">
		(function($){		
			$(function(){	
				$("a.nav-tab").click(function(){
					if($(this).attr('data-tab-id') == 'inquiry_cart_options'){
						window.location.href=$(this).attr('href');
						return false;
					}
				});
			});		  
		})(jQuery);
	</script>
    <?php
	}
	
	function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WC_EMAIL_INQUIRY_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/woocommerce/woo-email-inquiry-cart-options/" target="_blank">'.__('Documentation', 'wc_email_inquiry').'</a>';
		$links[] = '<a href="'.WC_EMAIL_AUTHOR_URI.'#help_tab" target="_blank">'.__('Support', 'wc_email_inquiry').'</a>';
		return $links;
	}
}
?>