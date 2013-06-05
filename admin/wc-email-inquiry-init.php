<?php
function wc_email_inquiry_install(){
	update_option('a3rev_wc_email_inquiry_version', '1.0.3.1');

	WC_Email_Inquiry_Rules_Roles_Panel::set_settings_default();
	
	WC_Email_Inquiry_Global_Settings::set_settings_default();
	WC_Email_Inquiry_Email_Options::set_settings_default();
	WC_Email_Inquiry_Customize_Email_Button::set_settings_default();
	WC_Email_Inquiry_Customize_Email_Popup::set_settings_default();
	
	WC_Email_Inquiry_Functions::reset_products_to_global_settings();
		
	update_option('a3rev_wc_email_inquiry_just_installed', true);
}

update_option('a3rev_wc_email_inquiry_plugin', 'wc_email_inquiry');

/**
 * Load languages file
 */
function wc_email_inquiry_init() {
	if ( get_option('a3rev_wc_email_inquiry_just_installed') ) {
		delete_option('a3rev_wc_email_inquiry_just_installed');
		wp_redirect( ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin.php?page=email-cart-options' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin.php?page=email-cart-options' ) ) ) );
		exit;
	}
	load_plugin_textdomain( 'wc_email_inquiry', false, WC_EMAIL_INQUIRY_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wc_email_inquiry_init');

// Plugin loaded
add_action( 'plugins_loaded', array( 'WC_Email_Inquiry_Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Email_Inquiry_Hook_Filter', 'plugin_extra_links'), 10, 2 );

	
	// Add Admin Menu
	add_action('admin_menu', array( 'WC_Email_Inquiry_Hook_Filter', 'add_admin_menu'), 11);
				
	// Include style into header
	add_action('get_header', array('WC_Email_Inquiry_Hook_Filter', 'add_style_header') );
	
	// Add Custom style on frontend
	add_action( 'wp_head', array( 'WC_Email_Inquiry_Hook_Filter', 'include_customized_style'), 11);
	
	// Include script into footer
	add_action('get_footer', array('WC_Email_Inquiry_Hook_Filter', 'script_contact_popup'), 1);
	
	// AJAX wc_email_inquiry contact popup
	add_action('wp_ajax_wc_email_inquiry_popup', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_popup') );
	add_action('wp_ajax_nopriv_wc_email_inquiry_popup', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_popup') );
	
	// AJAX wc_email_inquiry_action
	add_action('wp_ajax_wc_email_inquiry_action', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_action') );
	add_action('wp_ajax_nopriv_wc_email_inquiry_action', array('WC_Email_Inquiry_Hook_Filter', 'wc_email_inquiry_action') );
	
	// Hide Add to Cart button on Shop page
	add_action('woocommerce_before_template_part', array('WC_Email_Inquiry_Hook_Filter', 'shop_before_hide_add_to_cart_button'), 100, 3 );
	add_action('woocommerce_after_template_part', array('WC_Email_Inquiry_Hook_Filter', 'shop_after_hide_add_to_cart_button'), 1, 3 );
	
	// Hide Add to Cart button on Details page
	add_action('woocommerce_before_add_to_cart_button', array('WC_Email_Inquiry_Hook_Filter', 'details_before_hide_add_to_cart_button'), 100 );
	add_action('woocommerce_after_add_to_cart_button', array('WC_Email_Inquiry_Hook_Filter', 'details_after_hide_add_to_cart_button'), 1 );
		
	add_action('woocommerce_after_template_part', array('WC_Email_Inquiry_Hook_Filter', 'details_add_email_inquiry_button_below'), 2, 3);
	
	// Add meta boxes to product page
	add_action( 'admin_menu', array('WC_Email_Inquiry_MetaBox', 'add_meta_boxes') );
	
	// Include script admin plugin
	if ( in_array( basename ($_SERVER['PHP_SELF']), array('admin.php', 'edit.php') ) && isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array('email-cart-options') ) ) {
		add_action('admin_head', array('WC_Email_Inquiry_Hook_Filter', 'admin_header_script'));
		add_action('admin_footer', array('WC_Email_Inquiry_Hook_Filter', 'admin_footer_scripts'));
	}
	
	// Upgrade to 1.1.0
	if(version_compare(get_option('a3rev_wc_email_inquiry_version'), '1.0.3') === -1){
		WC_Email_Inquiry_Functions::upgrade_version_1_0_3();
		WC_Email_Inquiry_Functions::reset_products_to_global_settings();
		update_option('a3rev_wc_email_inquiry_version', '1.0.3');
	}

	update_option('a3rev_wc_email_inquiry_version', '1.0.3.1');	


function woo_email_cart_options_dashboard() {
?>
	<style>
    .code, code{font-family:inherit;font-size:inherit;}
    .form-table{margin:0;border-collapse:separate;}
    .icon32-email-cart-options {background:url(<?php echo WC_EMAIL_INQUIRY_IMAGES_URL; ?>/a3-plugins.png) no-repeat left top !important;}
    .subsubsub{white-space:normal;}
    .subsubsub li{ white-space:nowrap;}
	img.help_tip{float: right; margin: 0 -10px 0 0;}
	#wc_email_inquiry_panel_container { position:relative; margin-top:10px;}
	#wc_email_inquiry_panel_fields {width:60%; float:left;}
	#wc_email_inquiry_upgrade_area { position:relative; margin-left: 60%; padding-left:10px;}
	#wc_email_inquiry_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px 10px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
	.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
	.pro_feature_fields h3 { margin:8px 5px; }
	.pro_feature_fields p { margin-left:5px; }
	.pro_feature_fields  .form-table td { padding:4px 10px; }
    </style>
    <div class="wrap">
    	<?php if( isset($_POST['wc_email_inquiry_pin_submit']) ) echo '<div id="message" class="updated fade"><p>'.get_option("a3rev_wc_email_inquiry_message").'</p></div>'; ?>
    	<div class="icon32 icon32-email-cart-options" id="icon32-email-cart-options"><br></div>
        <h2 class="nav-tab-wrapper">
		<?php
		$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : '';
		$tabs = array(
			'rules-roles'			=> __( 'Rules & Roles', 'wc_email_inquiry' ),
			'email-inquiry'			=> __( 'Email Inquiry', 'wc_email_inquiry' ),
			'quotes-mode'			=> __( 'Quotes Mode', 'wc_email_inquiry' ),
			'orders-mode'			=> __( 'Orders Mode', 'wc_email_inquiry' ),
		);
	
		foreach ($tabs as $name => $label) :
			echo '<a href="' . admin_url( 'admin.php?page=email-cart-options&tab=' . $name ) . '" class="nav-tab ';
			if ( $current_tab == '' && $name == 'rules-roles' ) echo 'nav-tab-active';
			if ( $current_tab == $name ) echo 'nav-tab-active';
			echo '">' . $label . '</a>';
		endforeach;
		?>
		</h2>
        <div style="width:100%; float:left;">
		<?php
		switch ($current_tab) :
			case 'email-inquiry':
				WC_Email_Inquiry_Panel::panel_manager();
				break;
			case 'quotes-mode':
				WC_Email_Inquiry_Quote_Panel::panel_manager();
				break;
			case 'orders-mode':
				WC_Email_Inquiry_Order_Panel::panel_manager();
				break;
			default :
				WC_Email_Inquiry_Rules_Roles_Panel::panel_manager();
				break;
		endswitch;
		?>
        </div>
        <div style="clear:both; margin-bottom:20px;"></div>
    </div>
<?php
}
?>