<?php
/**
 * WC Email Inquiry Settings Class
 *
 * Table Of Contents
 *
 * set_settings_default()
 * __construct()
 * on_add_tab()
 * settings_tab_action()
 * add_settings_fields()
 * get_tab_in_view()
 * save_settings()
 * setting()
 * init_form_fields()
 * plugin_pro_notice()
 */
class WC_Email_Inquiry_Settings {
	
	public function custom_types() {
		$custom_type = array('wc_email_inquiry_multi_select', 'wc_email_inquiry_border_rounded');
		
		return $custom_type;
	}
	
	public function set_settings_default($reset=false, $free_version=false) {
		if ( ( esc_attr(get_option('wc_email_inquiry_hide_addcartbt')) == '' || $reset ) && !$free_version ) {
			update_option('wc_email_inquiry_hide_addcartbt', 'yes');
		}
		if ( esc_attr(get_option('wc_email_inquiry_hide_price')) == '' || $reset ) {
			update_option('wc_email_inquiry_hide_price', 'no');
		}
		if ( ( esc_attr(get_option('wc_email_inquiry_show_button')) == '' || $reset ) && !$free_version ) {
			update_option('wc_email_inquiry_show_button', 'yes');
		}
		if ( esc_attr(get_option('wc_email_inquiry_button_padding')) == '' || $reset ) {
			update_option('wc_email_inquiry_button_padding', 5);
		}
		if ( ( esc_attr(get_option('wc_email_inquiry_email_to')) == '' || $reset ) && !$free_version ) {
			update_option('wc_email_inquiry_email_to', get_bloginfo('admin_email') );
		}
		if ( esc_attr(get_option('wc_email_inquiry_email_from_name')) == '' || $reset ) {
			update_option('wc_email_inquiry_email_from_name', get_bloginfo('blogname') );
		}
		if ( esc_attr(get_option('wc_email_inquiry_email_from_address')) == '' || $reset ) {
			update_option('wc_email_inquiry_email_from_address', get_bloginfo('admin_email') );
		}
		if ( esc_attr(get_option('wc_email_inquiry_send_copy')) == '' || $reset ) {
			update_option('wc_email_inquiry_send_copy', 'no' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_hyperlink_text')) == '' || $reset ) {
			update_option('wc_email_inquiry_hyperlink_text', __('Click Here', 'wc_email_inquiry') );
		}
		if ( esc_attr(get_option('wc_email_inquiry_button_title')) == '' || $reset ) {
			update_option('wc_email_inquiry_button_title', __('Product Enquiry', 'wc_email_inquiry') );
		}
		if( ( esc_attr(get_option('wc_email_inquiry_popup_type')) == '' || $reset ) && !$free_version ){
			update_option('wc_email_inquiry_popup_type','prettyphoto');
		}
		if ( ( esc_attr(get_option('wc_email_inquiry_contact_heading')) == '' || $reset ) && !$free_version ) {
			update_option('wc_email_inquiry_contact_heading', __('Product Enquiry', 'wc_email_inquiry') );
		}
		if ( ( esc_attr(get_option('wc_email_inquiry_contact_text_button')) == '' || $reset ) && !$free_version ) {
			update_option('wc_email_inquiry_contact_text_button', __('SEND', 'wc_email_inquiry') );
		}
		if ( esc_attr(get_option('wc_email_inquiry_button_bg_colour')) == '' || $reset ) {
			update_option('wc_email_inquiry_button_bg_colour', '#ee2b2b' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_button_border_colour')) == '' || $reset ) {
			update_option('wc_email_inquiry_button_border_colour', '#ee2b2b' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_contact_button_bg_colour')) == '' || $reset ) {
			update_option('wc_email_inquiry_contact_button_bg_colour', '#ee2b2b' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_contact_button_border_colour')) == '' || $reset ) {
			update_option('wc_email_inquiry_contact_button_border_colour', '#ee2b2b' );
		}
		if ( ( esc_attr(get_option('wc_email_inquiry_contact_success')) == '' || $reset ) && !$free_version ) {
			update_option('wc_email_inquiry_contact_success', __("Thanks for your inquiry - we'll be in touch with you as soon as possible!", "wc_email_inquiry") );
		}
		if ( esc_attr(get_option('wc_email_inquiry_rounded_value')) == '' || $reset ) {
			update_option('wc_email_inquiry_rounded_value',15 );
		}
		if ( esc_attr(get_option('wc_email_inquiry_button_text_style')) == '' || $reset ) {
			update_option('wc_email_inquiry_button_text_style', 'bold' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_button_text_colour')) == '' || $reset ) {
			update_option('wc_email_inquiry_button_text_colour', '#FFFFFF' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_contact_rounded_value')) == '' || $reset ) {
			update_option('wc_email_inquiry_contact_rounded_value',15 );
		}
		if ( esc_attr(get_option('wc_email_inquiry_contact_button_text_style')) == '' || $reset ) {
			update_option('wc_email_inquiry_contact_button_text_style', 'bold' );
		}
		if ( esc_attr(get_option('wc_email_inquiry_contact_button_text_colour')) == '' || $reset ) {
			update_option('wc_email_inquiry_contact_button_text_colour', '#FFFFFF' );
		}
		
		if ( $reset ) {
			update_option('wc_email_inquiry_role_apply_hide_price', array());
			update_option('wc_email_inquiry_text_before', '' );
			update_option('wc_email_inquiry_trailing_text', '' );
			update_option('wc_email_inquiry_button_class', '' );
			
			update_option('wc_email_inquiry_button_position', '');
			update_option('wc_email_inquiry_single_only', 'yes');
			
			update_option('wc_email_inquiry_border_rounded', '');
			update_option('wc_email_inquiry_contact_border_rounded', '');
			update_option('wc_email_inquiry_button_text_size', '');
			update_option('wc_email_inquiry_contact_button_text_size', '');
			
			update_option('wc_email_inquiry_contact_button_class', '' );
			update_option('wc_email_inquiry_contact_form_class', '' );
		}
		
	}
	
	public function __construct() {
   		$this->current_tab = ( isset($_GET['tab']) ) ? $_GET['tab'] : 'general';
    	$this->settings_tabs = array(
        	'inquiry_cart_options' => __('Email & Cart', 'wp_email_template')
        );
        add_action('woocommerce_settings_tabs', array(&$this, 'on_add_tab'), 10);
		
		// add custom type to woocommerce fields
		foreach ($this->custom_types() as $custom_type) {
			add_action('woocommerce_admin_field_'.$custom_type, array(&$this, $custom_type) );
		}

        // Run these actions when generating the settings tabs.
        foreach ( $this->settings_tabs as $name => $label ) {
        	add_action('woocommerce_settings_tabs_' . $name, array(&$this, 'settings_tab_action'), 10);
			if (get_option('a3rev_wc_email_inquiry_just_confirm') == 1) {
          		update_option('a3rev_wc_email_inquiry_just_confirm', 0);
			} else {
				add_action('woocommerce_update_options_' . $name, array(&$this, 'save_settings'), 10);
			}
        }
		
		add_action( 'woocommerce_settings_email_inquiry_page_settings_end_after', array(&$this, 'email_inquiry_page_settings_end_after') );
		add_action( 'woocommerce_settings_email_inquiry_delivery_end_after', array(&$this, 'email_inquiry_delivery_end_after') );
		add_action( 'woocommerce_settings_email_inquiry_button_end_after', array(&$this, 'email_inquiry_button_end_after') );
				
		add_action( 'woocommerce_settings_email_inquiry_popup_lite_end_after', array(&$this, 'email_inquiry_popup_lite_end_after') );
		add_action( 'woocommerce_settings_email_inquiry_popup_end_after', array(&$this, 'email_inquiry_popup_end_after') );
		
        // Add the settings fields to each tab.
        add_action('woocommerce_inquiry_cart_options', array(&$this, 'add_settings_fields'), 10);
				
	}
	
	/*
    * Admin Functions
    */

    /* ----------------------------------------------------------------------------------- */
    /* Admin Tabs */
    /* ----------------------------------------------------------------------------------- */
	function on_add_tab() {
    	foreach ( $this->settings_tabs as $name => $label ) :
        	$class = 'nav-tab';
      		if ( $this->current_tab == $name )
            	$class .= ' nav-tab-active';
      		echo '<a href="' . admin_url('admin.php?page=woocommerce&tab=' . $name) . '" class="' . $class . '">' . $label . '</a>';
     	endforeach;
	}
	
	function email_inquiry_delivery_end_after() {
		echo '</div><div class="section" id="customize-email-button"><div class="pro_feature_fields">';	
	}
	
	function email_inquiry_button_end_after() {
		echo '</div></div><div class="section" id="customize-email-popup">';	
	}
	
	function email_inquiry_popup_lite_end_after() {
		echo '<div class="pro_feature_fields">';
	}
	
	function email_inquiry_popup_end_after() {
	?>
    	</div>
    	<table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="row"><label for="wc_email_inquiry_contact_success"><?php _e('Success Message','wc_email_inquiry'); ?></label></th>
					<td class="forminp forminp-text">
						<?php //wp_editor(get_option('wc_email_inquiry_contact_success'), 'wc_email_inquiry_contact_success', array('textarea_name' => 'wc_email_inquiry_contact_success', 'wpautop' => true, 'textarea_rows' => 15, 'tinymce' => array('plugins' => 'safari, inlinepopups, spellchecker, tabfocus, paste, media, fullscreen, wordpress, wpeditimage, wpgallery') ) ); ?>
						<?php wp_editor(get_option('wc_email_inquiry_contact_success'), 'wc_email_inquiry_contact_success', array('textarea_name' => 'wc_email_inquiry_contact_success', 'wpautop' => true, 'textarea_rows' => 15 ) ); ?>
						<span class="description"><?php _e('Message that user sees on page after form is submitted', 'wc_email_inquiry'); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
    <?php
	}
	
	function email_inquiry_page_settings_end_after() {
		global $wp_roles, $woocommerce;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();
	?>
    <div class="pro_feature_fields">
    <table class="form-table">
    	<tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_hide_price"><?php _e('Rule: Hide Price','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<fieldset><label for="wc_email_inquiry_hide_price"><input disabled="disabled" type="checkbox" value="1" id="wc_email_inquiry_hide_price" name="wc_email_inquiry_hide_price" /> <?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry'); ?></label></fieldset>
			</td>
		</tr>
        <tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_role_apply_hide_price"><?php _e('Apply Rule to logged in roles', 'wc_email_inquiry');?></label></th>
			<td class="forminp">
                <select multiple="multiple" name="wc_email_inquiry_role_apply_hide_price[]" data-placeholder="<?php _e( 'Choose Roles', 'wc_email_inquiry' ); ?>" style="display:none; width:300px;" class="chzn-select">
                <?php
				if ($roles) {
					foreach($roles as $key => $value) {
				?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } } ?>
                </select>
			</td>
		</tr>
		<tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_reset_products_options"><?php _e('Reset Products Options','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<fieldset><label for="wc_email_inquiry_reset_products_options"><input disabled="disabled" type="checkbox" value="1" id="wc_email_inquiry_reset_products_options" name="wc_email_inquiry_reset_products_options" /> <?php _e('Check to reset ALL products that have custom Email & Cart settings to the Global Rules settings.', 'wc_email_inquiry'); ?></label></fieldset>
			</td>
		</tr>
    </table>
    <h3><?php _e('Email Inquiry Button / Hyperlink', 'wc_email_inquiry'); ?></h3>
    <table class="form-table">
    	<tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_button_type"><?php _e('Button or Hyperlink Text','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<select name="wc_email_inquiry_button_type" style="display:none; width:300px;" class="chzn-select">
                    <option value="" selected="selected"><?php _e('Button','wc_email_inquiry'); ?></option>
                    <option value="link"><?php _e('Link','wc_email_inquiry'); ?></option>
                </select>
			</td>
		</tr>
        <tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_button_position"><?php _e('Relative Position','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<select name="wc_email_inquiry_button_position" style="display:none; width:300px;" class="chzn-select">
                    <option value="" selected="selected"><?php _e('Below (Default)','wc_email_inquiry'); ?></option>
                    <option value="above"><?php _e('Above','wc_email_inquiry'); ?></option>
                </select> <div class="description"><?php _e('Position relative to add to cart button location', 'wc_email_inquiry'); ?></div>
			</td>
		</tr>
		<tr valign="top">
			<th class="titledesc" scope="row">
				<label for="wc_email_inquiry_button_padding"><?php _e('Padding','wc_email_inquiry'); ?></label>
				<img width="16" height="16" src="<?php echo $woocommerce->plugin_url(); ?>/assets/images/help.png" class="help_tip" data-tip="<?php _e('Default padding is <code>5px</code>. If you see padding between the add to cart button and the email button before adding a value here that padding is added by your theme. Increasing the padding here will add to the themes default button padding.', 'wc_email_inquiry'); ?>">
			</th>
			<td class="forminp forminp-text">
				<input disabled="disabled" type="text" class="" value="5" style="width:80px;" id="wc_email_inquiry_button_padding" name="wc_email_inquiry_button_padding"> <span class="description">px</span>
			</td>
		</tr>
        <tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_single_only"><?php _e('Single Product Page only','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<select name="wc_email_inquiry_single_only" style="display:none; width:300px;" class="chzn-select">
                    <option value="yes" selected="selected"><?php _e('Yes','wc_email_inquiry'); ?></option>
                    <option value="no"><?php _e('No','wc_email_inquiry'); ?></option>
                </select> <div class="description"><?php _e('Default =  Yes. Button / Link text shows on single products pages as well as products list view, grid view, category and tag pages.', 'wc_email_inquiry'); ?></div>
			</td>
		</tr>
	</table>
    </div>
    </div>
    <div class="section" id="email-options">
    <div class="pro_feature_fields">
    <h3><?php _e('Email Sender', 'wc_email_inquiry'); ?></h3>
    <p><?php _e('The following options affect the sender (email address and name) used in WooCommerce Product Email Inquiries.', 'wc_email_inquiry'); ?></p>
    <table class="form-table">
    	<tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_email_from_name"><?php _e('"From" Name','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<input disabled="disabled" type="text" class="" value="<?php echo get_bloginfo('blogname'); ?>" style="min-width:300px;" id="wc_email_inquiry_email_from_name" name="wc_email_inquiry_email_from_name">
			</td>
		</tr>
    	<tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_email_from_address"><?php _e('"From" Email Address','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<input disabled="disabled" type="text" class="" value="<?php echo get_bloginfo('admin_email'); ?>" style="min-width:300px;" id="wc_email_inquiry_email_from_address" name="wc_email_inquiry_email_from_address">
			</td>
		</tr>
        <tr valign="top">
			<th class="titledesc" scope="row"><label for="wc_email_inquiry_send_copy"><?php _e('Send Copy to Sender','wc_email_inquiry'); ?></label></th>
			<td class="forminp">
				<fieldset><label for="wc_email_inquiry_send_copy"><input disabled="disabled" type="checkbox" value="1" id="wc_email_inquiry_send_copy" name="wc_email_inquiry_send_copy" /> <?php _e('Checked adds opt in/out option to the bottom of the email inquiry form.', 'wc_email_inquiry'); ?></label></fieldset>
			</td>
		</tr>
    </table>
    </div>
	<?php
	}
	
    /**
     * settings_tab_action()
     *
     * Do this when viewing our custom settings tab(s). One function for all tabs.
    */
    function settings_tab_action() {
    	global $woocommerce_settings;
		
		// Determine the current tab in effect.
        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_settings_tabs_');

        // Hook onto this from another function to keep things clean.
        // do_action( 'woocommerce_newsletter_settings' );

		if(isset($_REQUEST['saved']) && get_option("a3rev_wc_email_inquiry_message") != ''){
			echo '<div id="message" class="updated fade"><p>'.get_option("a3rev_wc_email_inquiry_message").'</p></div>';
			update_option('a3rev_wc_email_inquiry_message', '');
		}
		?>
        <style type="text/css">
		input.colorpick{text-transform:uppercase;}
		.form-table { margin:0; }
		#wc_email_inquiry_panel_container { position:relative; margin-top:10px;}
		#wc_email_inquiry_panel_fields {width:60%; float:left;}
		#wc_email_inquiry_upgrade_area { position:relative; margin-left: 60%; padding-left:10px;}
		#wc_email_inquiry_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3, .pro_feature_fields p { margin-left:5px; }
        </style>
        <div id="wc_email_inquiry_panel_container">
            <div id="wc_email_inquiry_panel_fields" class="a3_subsubsub_section">
                <ul class="subsubsub">
                    <li><a href="#global-settings" class="current"><?php _e('Visibility Options', 'wc_email_inquiry'); ?></a> | </li>
                    <li><a href="#email-options"><?php _e('Email Options', 'wc_email_inquiry'); ?></a> | </li>
                    <li><a href="#customize-email-button"><?php _e('Email Button/Link Style', 'wc_email_inquiry'); ?></a> | </li>
                    <li><a href="#customize-email-popup"><?php _e('Email Pop-Up Style', 'wc_email_inquiry'); ?></a></li>
                </ul>
                <br class="clear">
                <div class="section" id="global-settings">
                <?php
                do_action('woocommerce_inquiry_cart_options');
                // Display settings for this tab (make sure to add the settings to the tab).
                woocommerce_admin_fields($woocommerce_settings[$current_tab]);
                ?>
                </div>
            </div>
            <div id="wc_email_inquiry_upgrade_area"><?php echo $this->plugin_pro_notice(); ?></div>
        </div>
        <div style="clear:both;"></div>
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

					<?php if (isset($_GET['subtab']) && $_GET['subtab']) echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href=#'.$_GET['subtab'].']").click();'; ?>
					
					jQuery("#wc_email_inquiry_text_before").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_hyperlink_text").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_trailing_text").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_button_title").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_button_bg_colour").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_button_border_colour").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_border_rounded1").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_rounded_value").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_border_rounded2").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_button_text_colour").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_button_class").attr('disabled', 'disabled');
					
					jQuery("#wc_email_inquiry_contact_button_bg_colour").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_button_border_colour").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_border_rounded1").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_border_rounded2").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_rounded_value").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_button_text_colour").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_button_class").attr('disabled', 'disabled');
					jQuery("#wc_email_inquiry_contact_form_class").attr('disabled', 'disabled');
				});
			</script>
		<?php
		
		add_action('admin_footer', array(&$this, 'add_scripts'), 10);
	}

	/**
     * add_settings_fields()
     *
     * Add settings fields for each tab.
    */
    function add_settings_fields() {
    	global $woocommerce_settings;

        // Load the prepared form fields.
        $this->init_form_fields();

        if ( is_array($this->fields) ) :
        	foreach ( $this->fields as $k => $v ) :
                $woocommerce_settings[$k] = $v;
            endforeach;
        endif;
	}

    /**
    * get_tab_in_view()
    *
    * Get the tab current in view/processing.
    */
    function get_tab_in_view($current_filter, $filter_base) {
    	return str_replace($filter_base, '', $current_filter);
    }
	
	 /**
     * save_settings()
     *
     * Save settings in a single field in the database for each tab's fields (one field per tab).
     */
     function save_settings() {
     	global $woocommerce_settings;

        // Make sure our settings fields are recognised.
        $this->add_settings_fields();

        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_update_options_');
		
		woocommerce_update_options($woocommerce_settings[$current_tab]);
		
		// save custom type value
		update_option('wc_email_inquiry_contact_success', stripslashes($_REQUEST['wc_email_inquiry_contact_success']));
		update_option('wc_email_inquiry_role_apply_hide_cart', (array) $_REQUEST['wc_email_inquiry_role_apply_hide_cart']);
		update_option('wc_email_inquiry_role_apply_show_inquiry_button', (array) $_REQUEST['wc_email_inquiry_role_apply_show_inquiry_button']);
		
		$this->set_settings_default(true, true);
		
	}

    /** Helper functions ***************************************************** */
         
    /**
     * Gets a setting
     */
    public function setting($key) {
		return get_option($key);
	}
	
	/**
     * init_form_fields()
     *
     * Prepare form fields to be used in the various tabs.
     */
	function init_form_fields() {
		global $wpdb;
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();
		
		$font_sizes = array(__('Select Size', 'wc_email_inquiry'));
		for( $i = 9 ; $i <= 40 ; $i++ ){
			$font_sizes[$i] = $i.'px';
		}
		$font_styles = array( 
				'normal'		=> __('Normal', 'wc_email_inquiry'),
				'italic'		=> __('Italic', 'wc_email_inquiry'),
				'bold'			=> __('Bold', 'wc_email_inquiry'),
				'bold_italic'	=> __('Bold/Italic', 'wc_email_inquiry'),
			);
		
  		// Define settings			
     	$this->fields['inquiry_cart_options'] = apply_filters('woocommerce_inquiry_cart_options_fields', array(
      		array(
            	'name' 		=> __( 'Global Visibility Settings', 'wc_email_inquiry' ),
                'type' 		=> 'title',
                'desc' 		=> __( "Set Rules that apply to all site visitors. Use 'Apply Rules to Roles'  to control what users can see and access when they log into their account. PRO version users can over-ride these settings on a per product basis.",'wc_email_inquiry'),
          		'id' 		=> 'email_inquiry_page_settings_start'
           	),
			array(  
				'name' 		=> __( "Rule: Hide 'Add to Cart'", 'wc_email_inquiry' ),
				'desc' 		=> __( 'Yes. Applies to all users who are not logged in.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_hide_addcartbt',
				'type' 		=> 'checkbox',
				'std' 		=> 1,
				'default'	=> 'yes',
			),
			array(  
				'name' 		=> __( 'Apply Rule to logged in roles', 'wc_email_inquiry' ),
				'desc' 		=> '',
				'id' 		=> 'wc_email_inquiry_role_apply_hide_cart',
				'type' 		=> 'wc_email_inquiry_multi_select',
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'options'	=> $roles,
			),
			array(  
				'name' 		=> __( 'Rule: Show Email Inquiry Button', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Yes. Applies to all users who are not logged in.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_show_button',
				'type' 		=> 'checkbox',
				'std' 		=> 1,
				'default'	=> 'yes',
			),
			array(  
				'name' 		=> __( 'Apply Rule to logged in roles', 'wc_email_inquiry' ),
				'desc' 		=> '',
				'id' 		=> 'wc_email_inquiry_role_apply_show_inquiry_button',
				'type' 		=> 'wc_email_inquiry_multi_select',
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'options'	=> $roles,
			),
			
			array('type' => 'sectionend', 'id' => 'email_inquiry_page_settings_end'),
			
			array(
            	'name' 		=> __( 'Email Delivery', 'wc_email_inquiry' ),
                'type' 		=> 'title',
                'desc' 		=> '',
          		'id' 		=> 'email_inquiry_delivery_start'
           	),
			array(  
				'name' 		=> __( 'Inquiry Email goes to', 'wc_email_inquiry' ),
				'desc' 		=> __( '&lt;empty&gt; defaults to WordPress admin email address', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_email_to',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'std' 		=> get_bloginfo('admin_email'),
				'default'	=> get_bloginfo('admin_email'),
			),
			array(  
				'name' 		=> __( 'CC', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; defaults to 'no copy sent' or add an email address", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_email_cc',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array('type' => 'sectionend', 'id' => 'email_inquiry_delivery_end'),
			
			array(
            	'name' 		=> __( 'Customize Hyperlink text', 'wc_email_inquiry' ),
                'type' 		=> 'title',
                'desc' 		=> '',
          		'id' 		=> 'email_inquiry_hyperlink_start'
           	),
			array(  
				'name' 		=> __( 'Text before', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default 'no text' or add text to prepent link text", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_text_before',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array(  
				'name' 		=> __( 'Hyperlink text', 'wc_email_inquiry' ),
				'desc' 		=> __("&lt;empty&gt; for default 'Click Here' or your own text", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_hyperlink_text',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'std' 		=> __( 'Click Here', 'wc_email_inquiry' ),
				'default'	=> __( 'Click Here', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Trailing text', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default 'no text' or add text to trail linked text", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_trailing_text',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array('type' => 'sectionend', 'id' => 'email_inquiry_hyperlink_end'),
			
			array(
            	'name' 		=> __( 'Customize Email Inquiry Button', 'wc_email_inquiry' ),
                'type' 		=> 'title',
                'desc' 		=> '',
          		'id' 		=> 'email_inquiry_button_start'
           	),
			array(  
				'name' 		=> __( 'Button Title', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default 'Product Enquiry' or enter text", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_title',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'std' 		=> __( 'Product Enquiry', 'wc_email_inquiry' ),
				'default'	=> __( 'Product Enquiry', 'wc_email_inquiry' ),
			),
			
			array(  
				'name' 		=> __( 'Button Background Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Button colour. Default <code>#EE2B2B</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_bg_colour',
				'type' 		=> 'color',
				'css' 		=> 'width:80px;text-transform: uppercase;',
				'std' 		=> '#EE2B2B',
				'default'	=> '#EE2B2B',
			),
			array(  
				'name' 		=> __( 'Button Border', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Border colour. Default <code>#EE2B2B</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_border_colour',
				'type' 		=> 'color',
				'css' 		=> 'width:80px;text-transform: uppercase;',
				'std' 		=> '#EE2B2B',
				'default'	=> '#EE2B2B',
			),
			array(  
				'name' 		=> __( 'Border Rounded', 'wc_email_inquiry' ),
				'id' 		=> 'wc_email_inquiry_border_rounded',
				'rounded_value'	=> 'wc_email_inquiry_rounded_value',
				'type' 		=> 'wc_email_inquiry_border_rounded',
			),
			array(  
				'name' 		=> __( 'Button Font Size', 'wc_email_inquiry' ),
				'desc' 		=> __( '&lt;empty&gt; to use theme style', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_text_size',
				'css' 		=> 'min-width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => $font_sizes,
			),
			array(  
				'name' 		=> __( 'Button Font style', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default <code>Bold</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_text_style',
				'css' 		=> 'min-width:120px;',
				'std' 		=> 'bold',
				'default'	=> 'bold',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => $font_styles,
			),
			array(  
				'name' 		=> __( 'Button Font Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default <code>#FFFFFF</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_text_colour',
				'type' 		=> 'color',
				'css' 		=> 'width:80px;text-transform: uppercase;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF',
			),
			array(  
				'name' 		=> __( 'CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __( "Enter your own button CSS class", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_button_class',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array('type' => 'sectionend', 'id' => 'email_inquiry_button_end'),
			
			array(
            	'name' 		=> __( 'Customize Email Pop-up', 'wc_email_inquiry' ),
                'type' 		=> 'title',
                'desc' 		=> '',
          		'id' 		=> 'email_inquiry_popup_start'
           	),
			array(  
				'name' => __( 'Email popup tool', 'wc_email_inquiry' ),
				'desc' 		=> __('PrettyPhoto is WooCommerce default pop up tool. Some bespoke themes use Fancybox or ColorBox.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_popup_type',
				'css' 		=> 'min-width:120px;',
				'std' 		=> 'prettyphoto',
				'default'	=> 'prettyphoto',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array(
					'prettyphoto'		=> __( 'PrettyPhoto', 'wc_email_inquiry' ), 
					'fb'		=> __( 'Fancybox', 'wc_email_inquiry' ),
					'colorbox'		=> __( 'ColorBox', 'wc_email_inquiry' ),
				),
				'desc_tip'	=>  false,
			),
			array(  
				'name' 		=> __( 'Header title', 'wc_email_inquiry' ),
				'desc' 		=> __( '&lt;empty&gt; and the form title will be the Button title', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_heading',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array(  
				'name' 		=> __( 'Send Button Title', 'wc_email_inquiry' ),
				'desc' 		=> __( '&lt;empty&gt; for default SEND', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_text_button',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
				'std' 		=> __( 'SEND', 'wc_email_inquiry' ),
				'default'	=> __( 'SEND', 'wc_email_inquiry' ),
			),
			array('type' => 'sectionend', 'id' => 'email_inquiry_popup_lite_end'),
			
			array(
            	'name' 		=> '',
                'type' 		=> 'title',
                'desc' 		=> '',
           	),
			array(  
				'name' 		=> __( 'Button Background Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Button colour. Default <code>#EE2B2B</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_button_bg_colour',
				'type' 		=> 'color',
				'css' 		=> 'width:80px;text-transform: uppercase;',
				'std' 		=> '#EE2B2B',
				'default'	=> '#EE2B2B',
			),
			array(  
				'name' 		=> __( 'Button Border', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Border colour. Default <code>#EE2B2B</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_button_border_colour',
				'type' 		=> 'color',
				'css' 		=> 'width:80px;text-transform: uppercase;',
				'std' 		=> '#EE2B2B',
				'default'	=> '#EE2B2B',
			),
			array(  
				'name' 		=> __( 'Border Rounded', 'wc_email_inquiry' ),
				'id' 		=> 'wc_email_inquiry_contact_border_rounded',
				'rounded_value'	=> 'wc_email_inquiry_contact_rounded_value',
				'type' 		=> 'wc_email_inquiry_border_rounded',
			),
			array(  
				'name' 		=> __( 'Button Font Size', 'wc_email_inquiry' ),
				'desc' 		=> __( '&lt;empty&gt; to use theme style', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_button_text_size',
				'css' 		=> 'min-width:120px;',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => $font_sizes,
			),
			array(  
				'name' 		=> __( 'Button Font style', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default <code>Bold</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_button_text_style',
				'css' 		=> 'min-width:120px;',
				'std' 		=> 'bold',
				'default'	=> 'bold',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => $font_styles,
			),
			array(  
				'name' 		=> __( 'Button Font Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default <code>#FFFFFF</code>.', 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_button_text_colour',
				'type' 		=> 'color',
				'css' 		=> 'width:80px;text-transform: uppercase;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF',
			),
			array(  
				'name' 		=> __( 'Button CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __("Enter your own button CSS class", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_button_class',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array(  
				'name' 		=> __( 'Form CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default or enter custom form CSS", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_form_class',
				'type' 		=> 'text',
				'css' 		=> 'min-width:300px;',
			),
			array(  
				'name' 		=> __( 'Form CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default or enter custom form CSS", 'wc_email_inquiry'),
				'id' 		=> 'wc_email_inquiry_contact_success',
				'css' 		=> 'min-width:300px;',
			),
			array('type' => 'sectionend', 'id' => 'email_inquiry_popup_end'),
        ) );
	}
	
	function wc_email_inquiry_multi_select($value) {
		if ( $value['desc_tip'] === true ) {
    		$description = '<img class="help_tip" data-tip="' . esc_attr( $value['desc'] ) . '" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" />';
    	} elseif ( $value['desc_tip'] ) {
    		$description = '<img class="help_tip" data-tip="' . esc_attr( $value['desc_tip'] ) . '" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" />';
    	} else {
    		$description = '<span class="description">' . $value['desc'] . '</span>';
    	}
		$selections = (array) get_option($value['id']);
	?>
    	<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo $value['name']; ?></label>
		</th>
		<td class="forminp">
			<select multiple="multiple" name="<?php echo esc_attr( $value['id'] ); ?>[]" data-placeholder="<?php echo $value['placeholder']; ?>" style="display:none; width:300px; <?php echo esc_attr( $value['css'] ); ?>" class="chzn-select <?php if (isset($value['class'])) echo $value['class']; ?>">
			<?php
			foreach ($value['options'] as $key => $val) {
			?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( in_array($key, $selections), true ); ?>><?php echo $val ?></option>
			<?php
			}
			?>
			</select> <?php echo $description; ?>
		</td>
		</tr>
    <?php
	}
	
	function wc_email_inquiry_border_rounded($value) {
		$value_data = get_option($value['id']);
		$rounded_value = get_option($value['rounded_value']);
	?>
    	<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo $value['name']; ?></label>
		</th>
		<td class="forminp">
			<input type="radio" name="<?php echo esc_attr( $value['id'] ); ?>" value="" id="<?php echo esc_attr( $value['id'] ); ?>1" checked="checked" /> <label for="<?php echo esc_attr( $value['id'] ); ?>1"><?php _e('Rounded Corners','wc_email_inquiry'); ?></label> <span class="description">(<?php _e('Default', 'wc_email_inquiry');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
			<label for="<?php echo esc_attr( $value['rounded_value'] ); ?>"><?php _e('Rounded Value','wc_email_inquiry'); ?></label> <input type="text" name="<?php echo esc_attr( $value['rounded_value'] ); ?>" id="<?php echo esc_attr( $value['rounded_value'] ); ?>" value="<?php esc_attr_e( stripslashes($rounded_value) );?>" style="width:80px;" />px <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code>15</code>px</span>
			<br />
			<input type="radio" name="<?php echo esc_attr( $value['id'] ); ?>" value="square" id="<?php echo esc_attr( $value['id'] ); ?>2" <?php if($value_data == 'square'){ echo 'checked="checked"'; } ?> /> <label for="<?php echo esc_attr( $value['id'] ); ?>2"><?php _e('Square Corners','wc_email_inquiry'); ?></label>
		</td>
		</tr>
    <?php
	}
	
	function add_scripts(){
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script('jquery');
		
		wp_enqueue_style( 'a3rev-chosen-style', WC_EMAIL_INQUIRY_JS_URL . '/chosen/chosen.css' );
		wp_enqueue_script( 'chosen', WC_EMAIL_INQUIRY_JS_URL . '/chosen/chosen.jquery'.$suffix.'.js', array(), false, true );
		
		wp_enqueue_script( 'a3rev-chosen-script-init', WC_EMAIL_INQUIRY_JS_URL.'/init-chosen.js', array(), false, true );
	}
	
	function plugin_pro_notice() {
		$html = '';
		$html .= '<div id="wc_email_inquiry_extensions">';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.WC_EMAIL_INQUIRY_IMAGES_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade to Email Inquiry & Cart Options Pro', 'wc_email_inquiry').'</h3>';
		$html .= '<p>'.__("<strong>NOTE:</strong> Settings inside the Yellow border are Pro Version advanced Features and are not activated. Visit the", 'wc_email_inquiry').' <a href="'.WC_EMAIL_AUTHOR_URI.'" target="_blank">'.__("a3rev site", 'wc_email_inquiry').'</a> '.__("if you wish to upgrade to activate these features", 'wc_email_inquiry').':</p>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Activate Rule: Hide Product Prices.", 'wc_email_inquiry').'</li>';
		$html .= '<li>2. '.__('Activate Email and Cart Product Page Meta.', 'wc_email_inquiry').'</li>';
		$html .= '<li>3. '.__("Enables setting up a mixed 'add to cart' and product brochure store.", 'wc_email_inquiry').'</li>';
		$html .= '<li>4. '.__('Activate WYSIWYG Email Inquiry button creator.', 'wc_email_inquiry').'</li>';
		$html .= '<li>5. '.__('Activate WYSIWYG pop-up form creator.', 'wc_email_inquiry').'</li>';
		$html .= '<li>6. '.__('Activate hyperlinked text instead of a Button.', 'wc_email_inquiry').'</li>';
		$html .= '<li>7. '.__('Activate Email Inquiry products grid view store listings.', 'wc_email_inquiry').'</li>';
		$html .= '<li>8. '.__("Activate Send a copy to myself feature.", 'wc_email_inquiry').'</li>';
		$html .= '<li>9. '.__("Activate email 'From Name' and 'From Email Address'", 'wc_email_inquiry').'</li>';
		$html .= '<li>10. '.__("Activate lifetime same day priority support", 'wc_email_inquiry').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('Plugin Documentation', 'wc_email_inquiry').'</h3>';
		$html .= '<p>'.__('All of our plugins have comprehensive online documentation. Please refer to the plugins docs before raising a support request', 'wc_email_inquiry').'. <a href="http://docs.a3rev.com/user-guides/woocommerce/woo-email-inquiry-cart-options/" target="_blank">'.__('Visit the a3rev wiki.', 'wc_email_inquiry').'</a></p>';
		$html .= '<h3>'.__('More a3rev Quality Plugins', 'wc_email_inquiry').'</h3>';
		$html .= '<p>'.__('Below is a list of the a3rev plugins that are available for free download from wordpress.org', 'wc_email_inquiry').'</p>';
		$html .= '<h3>'.__('WooCommerce Plugins', 'wc_email_inquiry').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woo-widget-product-slideshow/" target="_blank">'.__('WooCommerce Widget Product Slideshow', 'wc_email_inquiry').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WordPress Plugins', 'wc_email_inquiry').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'wc_email_inquiry').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('Help spread the Word about this plugin', 'wc_email_inquiry').'</h3>';
		$html .= '<p>'.__("Things you can do to help others find this plugin", 'wc_email_inquiry');
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-email-inquiry-cart-options/" target="_blank">'.__('Rate this plugin 5', 'wc_email_inquiry').' <img src="'.WC_EMAIL_INQUIRY_IMAGES_URL.'/stars.png" align="top" /> '.__('on WordPress.org', 'wc_email_inquiry').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-email-inquiry-cart-options/" target="_blank">'.__('Mark the plugin as a fourite', 'wc_email_inquiry').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '</div>';
		return $html;
	}
}
?>