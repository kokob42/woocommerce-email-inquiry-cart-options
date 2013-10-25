<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Rules & Roles Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_EI_Rules_Roles_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'rules-roles';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_rules_roles_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_rules_roles_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	public function custom_types() {
		$custom_type = array( 'hide_addtocart_yellow_message', 'hide_inquiry_button_yellow_message', 'hide_price_yellow_message', 'manual_quote_yellow_message' );
		
		return $custom_type;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		// add custom type
		foreach ( $this->custom_types() as $custom_type ) {
			add_action( $this->plugin_name . '_admin_field_' . $custom_type, array( $this, $custom_type ) );
		}
		
		$this->init_form_fields();
		//$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Rules & Roles Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Rules & Roles Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Rules & Roles Settings successfully reseted.', 'wc_email_inquiry' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . trim( $this->form_key ) . '_settings_init', array( $this, 'after_settings_save' ) );
		
		add_action( $this->plugin_name . '-' . trim( $this->form_key ) . '_before_settings_save', array( $this, 'before_settings_save' ) );
		
		// Add yellow border for pro fields
		add_action( $this->plugin_name . '_settings_pro_store_rules_before', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '_settings_pro_add_to_order_after', array( $this, 'pro_fields_after' ) );
		
		add_action( $this->plugin_name . '_settings_pro_hide_price_before', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '_settings_pro_global_reset_after', array( $this, 'pro_fields_after' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_ei_admin_interface;
		
		$wc_ei_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_ei_admin_interface;
		
		$wc_ei_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* before_settings_save()
	/* Process before settings is saved */
	/*-----------------------------------------------------------------------------------*/
	public function before_settings_save() {
		$validate_roles = true;
		$error_message = '';
		global $wc_ei_admin_interface;
		
		if ( isset( $_POST['bt_save_settings'] ) ) {
			if ( ! isset( $_POST[$this->option_name]['role_apply_manual_quote'] ) ) $_POST[$this->option_name]['role_apply_manual_quote'] = array();
			if ( ! isset( $_POST[$this->option_name]['role_apply_auto_quote'] ) ) $_POST[$this->option_name]['role_apply_auto_quote'] = array();
			if ( ! isset( $_POST[$this->option_name]['role_apply_activate_order_logged_in'] ) ) $_POST[$this->option_name]['role_apply_activate_order_logged_in'] = array();
			
			/*
			 * Rules & Roles Schema when javascript is has error
			 */
			// Process for Auto Quote rule
			$_POST[$this->option_name]['role_apply_auto_quote'] = array_diff ( (array) $_POST[$this->option_name]['role_apply_auto_quote'], (array) $_POST[$this->option_name]['role_apply_manual_quote'] );
			
			// Process for Add to Order rule
			$_POST[$this->option_name]['role_apply_activate_order_logged_in'] = array_diff ( (array) $_POST[$this->option_name]['role_apply_activate_order_logged_in'], (array) $_POST[$this->option_name]['role_apply_manual_quote'] );
			$_POST[$this->option_name]['role_apply_activate_order_logged_in'] = array_diff ( (array) $_POST[$this->option_name]['role_apply_activate_order_logged_in'], (array) $_POST[$this->option_name]['role_apply_auto_quote'] );
			
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* after_settings_save()
	/* Process after settings is saved */
	/*-----------------------------------------------------------------------------------*/
	public function after_settings_save() {
		if ( isset( $_POST['bt_save_settings'] ) ) {
			$customized_settings = get_option( $this->option_name, array() );
			
			$customized_settings['role_apply_manual_quote'] = array( 'manual_quote' );
				
			$customized_settings['role_apply_auto_quote'] = array( 'auto_quote' );
				
			update_option( $this->option_name, $customized_settings );
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_ei_admin_interface;
		
		$wc_ei_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'rules-roles',
			'label'				=> __( 'Settings', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_rules_roles_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_ei_admin_interface;
		
		$output = '';
		$output .= $wc_ei_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();
		$roles_hide_cart = $roles;
		unset( $roles_hide_cart['manual_quote'] );
		unset( $roles_hide_cart['auto_quote'] );
		$roles_activate_order = $roles_auto_quote = $roles_manual_quote = $roles_hide_price = $roles_hide_cart;
		$roles_manual_quote = array_merge( array( 'manual_quote' => __( 'Manual Quote', 'wc_email_inquiry' ) ), $roles_manual_quote );
		$roles_auto_quote = array_merge( array( 'auto_quote' => __( 'Auto Quote', 'wc_email_inquiry' ) ), $roles_auto_quote );
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			array(
            	'name' 		=> __( 'Store Rules:', 'wc_email_inquiry' ),
				'desc'		=> __( "Store Rules apply a set of Rules that determine how users use your store BEFORE and AFTER they log in.", 'wc_email_inquiry' ),
				'id'		=> 'pro_store_rules',
                'type' 		=> 'heading',
           	),
			
			array(
            	'name' 		=> __( 'Store Rule: Manual Quote', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Apply for all users before log in", 'wc_email_inquiry' ),
				'desc'		=> __( 'Check to manually send prices either off-line or via edit order.', 'wc_email_inquiry' ) ,
				'desc_tip'	=> __( 'Hide prices everywhere including on order email and order details. If you have shipping costs configured it does not hide shipping costs.', 'wc_email_inquiry' ),
				'class'		=> 'apply_manual_quote_rule quote_mode_rule',
				'id' 		=> 'manual_quote_rule',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
				
			),
			array(  
				'name' 		=> __( 'Apply by user role after log in', 'wc_email_inquiry' ),
				'desc' 		=> '',
				'class'		=> 'chzn-select role_apply_manual_quote',
				'id' 		=> 'role_apply_manual_quote',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'css'		=> 'width:450px; min-height:80px; max-width:100%;',
				'options'	=> $roles_manual_quote,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container manual_quote_yellow_message_container',
           	),
			array(
                'type' 		=> 'manual_quote_yellow_message',
           	),
			array(
				'name' 		=> __( 'Store Rule: Auto Quote', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Apply for all users before log in", 'wc_email_inquiry' ),
				'desc'		=> __( 'Check to auto include system prices in the quote request email.', 'wc_email_inquiry' ) ,
				'desc_tip'	=> __( 'Hide prices on shop page, product detail page, sidebar, cart widget, cart page, checkout page. Prices including shipping show in order email, order details when subscriber send the quote request.', 'wc_email_inquiry' ),
				'class'		=> 'apply_auto_quote_rule quote_mode_rule',
				'id' 		=> 'auto_quote_rule',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Apply by user role after log in', 'wc_email_inquiry' ),
				'desc' 		=> '',
				'class' 	=> 'chzn-select role_apply_auto_quote',
				'id' 		=> 'role_apply_auto_quote',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'css'		=> 'width:450px; min-height:80px; max-width:100%;',
				'options'	=> $roles_auto_quote,
			),
			
			array(
				'name' 		=> __( 'Store Rule: Add to Order', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Apply for all users before log in", 'wc_email_inquiry' ),
				'desc'		=> __( 'If activated this setting over-rides all other Rules for users who are not logged in.', 'wc_email_inquiry' ),
				'class'		=> 'apply_add_to_order_rule',
				'id' 		=> 'add_to_order_rule',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			
			array(  
				'name' 		=> __( "Apply by user role after log in", 'wc_email_inquiry' ),
				'class' 	=> 'activate_order_logged_in',
				'id' 		=> 'activate_order_logged_in',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(
				'class'		=> 'role_apply_activate_order_logged_in_container',
                'type' 		=> 'heading',
           	),
			array(  
				'class' 	=> 'chzn-select role_apply_activate_order_logged_in',
				'id' 		=> 'role_apply_activate_order_logged_in',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'css'		=> 'width:450px; min-height:80px; max-width:100%;',
				'options'	=> $roles_activate_order,
			),
			array(
                'type' 		=> 'heading',
				'id'		=> 'pro_add_to_order',
           	),
			
			array(
            	'name' 		=> __( 'Conditional Logic', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'class'		=> 'conditional_logic_container',
           	),
			array(  
				'name' 		=> __( "Rules & Roles Explanation", 'wc_email_inquiry' ),
				'class'		=> 'rules_roles_explanation',
				'id' 		=> 'rules_roles_explanation',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'show',
				'free_version'		=> true,
				'checked_value'		=> 'show',
				'unchecked_value' 	=> 'hide',
				'checked_label'		=> __( 'SHOW', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'HIDE', 'wc_email_inquiry' ),
			),
			array(
				'desc'		=> '<table class="form-table"><tbody><tr valign="top"><th class="titledesc" scope="row"><label>' . __( "Apply for all users before log in", 'wc_email_inquiry' ) . ':</label></th><td class="forminp">' . __( "Activating any Store Rule auto deactivates Product Page Rules 'Add to Cart' and 'Hide Price'", 'wc_email_inquiry' ) . '</td></tr><tr valign="top"><th class="titledesc" scope="row"><label>' . __( "Apply by user role after log in",'wc_email_inquiry') . ':</label></th><td class="forminp">' . __( "User Roles do not show in Rule drop downs IF they exist in other Rules that conflict. Removing Roles from conflicting Rules makes them instantly available for adding to the new Rule.",'wc_email_inquiry') . '</td></tr></tbody></table>',
                'type' 		=> 'heading',
				'class'		=> 'rules_roles_explanation_container',
           	),
			
			array(
            	'name' 		=> __( 'Product Page Rules:', 'wc_email_inquiry' ),
				'desc'		=> __( "Product Page Rules apply a single action Rule to all product pages which can be filtered on a per User Role basis. These Rules can also be varied on a product by product basis from each product edit page.", 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			
			array(
				'name' 		=> __( "Product Page Rule: Hide Price", 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_hide_price',
           	),
			array(  
				'name' 		=> __( "Apply for all users before log in", 'wc_email_inquiry' ),
				'class'		=> 'email_inquiry_hide_price_before_login',
				'id' 		=> 'hide_price',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( "Apply by user role after log in", 'wc_email_inquiry' ),
				'class'		=> 'email_inquiry_hide_price_after_login',
				'id' 		=> 'hide_price_after_login',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(
				'class'		=> 'email_inquiry_hide_price_after_login_container',
                'type' 		=> 'heading',
           	),
			array(  
				'class' 	=> 'chzn-select role_apply_hide_price',
				'id' 		=> 'role_apply_hide_price',
				'type' 		=> 'multiselect',
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'css'		=> 'width:450px; min-height:80px; max-width:100%;',
				'options'	=> $roles_hide_price,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container hide_price_yellow_message_container',
           	),
			array(
                'type' 		=> 'hide_price_yellow_message',
           	),
			array(
				'name'		=> __( 'Product Page Rules Reset:', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_global_reset',
           	),
			array(  
				'name' 		=> __( "Reset All Products", 'wc_email_inquiry' ),
				'desc' 		=> __( "Set to Yes and Save Changes will reset ALL products that have custom Individual Rules to the Individual Rules and Roles set above.", 'wc_email_inquiry' ),
				'id' 		=> 'wc_email_inquiry_reset_products_options',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'separate_option'	=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			
			array(
            	'name' 		=> __( "Product Page Rule: Hide 'Add to Cart'", 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Apply for all users before log in", 'wc_email_inquiry' ),
				'class'		=> 'hide_addcartbt_before_login',
				'id' 		=> 'hide_addcartbt',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( "Apply by user role after log in", 'wc_email_inquiry' ),
				'class'		=> 'hide_addcartbt_after_login',
				'id' 		=> 'hide_addcartbt_after_login',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(
				'class'		=> 'hide_addcartbt_after_login_container',
                'type' 		=> 'heading',
           	),
			array(  
				'class' 	=> 'chzn-select role_apply_hide_cart',
				'id' 		=> 'role_apply_hide_cart',
				'type' 		=> 'multiselect',
				'free_version'		=> true,
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'css'		=> 'width:450px; min-height:80px; max-width:100%;',
				'options'	=> $roles_hide_cart,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container hide_addtocart_yellow_message_container',
           	),
			array(
                'type' 		=> 'hide_addtocart_yellow_message',
           	),
			array(
            	'name' 		=> __( "Product Page Rule: Show Email Inquiry Button", 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Apply for all users before log in", 'wc_email_inquiry' ),
				'class'		=> 'show_email_inquiry_button_before_login',
				'id' 		=> 'show_button',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( "Apply by user role after log in", 'wc_email_inquiry' ),
				'class'		=> 'show_email_inquiry_button_after_login',
				'id' 		=> 'show_button_after_login',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'ON', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry' ),
			),
			array(
				'class'		=> 'show_email_inquiry_button_after_login_container',
                'type' 		=> 'heading',
           	),
			array(  
				'desc' 		=> '',
				'id' 		=> 'role_apply_show_inquiry_button',
				'type' 		=> 'multiselect',
				'free_version'		=> true,
				'placeholder' => __( 'Choose Roles', 'wc_email_inquiry' ),
				'css'		=> 'width:450px; min-height:80px; max-width:100%;',
				'options'	=> $roles,
			),
			array(
                'type' 		=> 'heading',
				'class'		=> 'yellow_message_container hide_inquiry_button_yellow_message_container',
           	),
			array(
                'type' 		=> 'hide_inquiry_button_yellow_message',
           	),
			
        ));
	}
	
	public function hide_addtocart_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="hide_addtocart_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <div style="width:450px;">
            <?php 
				$hide_addtocart_blue_message = '<div><strong>'.__( 'Note', 'wc_email_inquiry' ).':</strong> '.__( "If you do not apply Rules to your role i.e. 'administrator' you will need to either log out or open the site in another browser where you are not logged in to see the Rule feature is activated.", 'wc_email_inquiry' ).'</div>
                <div style="clear:both"></div>
                <a class="hide_addtocart_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'wc_email_inquiry' ).'</a>
                <a class="hide_addtocart_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'wc_email_inquiry' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $hide_addtocart_blue_message ); 
			?>
            </div>
<style>
.a3rev_panel_container .hide_addtocart_yellow_message_container {
<?php if ( $customized_settings['hide_addcartbt'] == 'no' && $customized_settings['hide_addcartbt_after_login'] == 'no' ) echo 'display: none;'; ?>
<?php if ( get_option( 'wc_ei_hide_addtocart_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { session_start(); } if ( isset( $_SESSION['wc_ei_hide_addtocart_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.hide_addcartbt_after_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_addtocart_yellow_message_container").slideDown();
		} else if( $("input.hide_addcartbt_before_login").prop( "checked" ) == false ) {
			$(".hide_addtocart_yellow_message_container").slideUp();
		}
	});
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.hide_addcartbt_before_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_addtocart_yellow_message_container").slideDown();
		} else if( $("input.hide_addcartbt_after_login").prop( "checked" ) == false ) {
			$(".hide_addtocart_yellow_message_container").slideUp();
		}
	});
	
	$(document).on( "click", ".hide_addtocart_yellow_message_dontshow", function(){
		$(".hide_addtocart_yellow_message_tr").slideUp();
		$(".hide_addtocart_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_hide_addtocart_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".hide_addtocart_yellow_message_dismiss", function(){
		$(".hide_addtocart_yellow_message_tr").slideUp();
		$(".hide_addtocart_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_hide_addtocart_message_dismiss",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dismiss"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
});
})(jQuery);
</script>
			</td>
		</tr>
    <?php
	
	}
	
	public function hide_inquiry_button_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="hide_inquiry_button_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <div style="width:450px;">
            <?php 
				$hide_inquiry_button_blue_message = '<div><strong>'.__( 'Note', 'wc_email_inquiry' ).':</strong> '.__( "If you do not apply Rules to your role i.e. 'administrator' you will need to either log out or open the site in another browser where you are not logged in to see the Rule feature is activated.", 'wc_email_inquiry' ).'</div>
                <div style="clear:both"></div>
                <a class="hide_inquiry_button_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'wc_email_inquiry' ).'</a>
                <a class="hide_inquiry_button_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'wc_email_inquiry' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $hide_inquiry_button_blue_message ); 
			?>
            </div>
<style>
.a3rev_panel_container .hide_inquiry_button_yellow_message_container {
<?php if ( $customized_settings['show_button'] == 'no' && $customized_settings['show_button_after_login'] == 'no' ) echo 'display: none;'; ?>
<?php if ( get_option( 'wc_ei_hide_inquiry_button_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { session_start(); } if ( isset( $_SESSION['wc_ei_hide_inquiry_button_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_email_inquiry_button_after_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_inquiry_button_yellow_message_container").slideDown();
		} else if( $("input.show_email_inquiry_button_before_login").prop( "checked" ) == false ) {
			$(".hide_inquiry_button_yellow_message_container").slideUp();
		}
	});
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_email_inquiry_button_before_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_inquiry_button_yellow_message_container").slideDown();
		} else if( $("input.show_email_inquiry_button_after_login").prop( "checked" ) == false ) {
			$(".hide_inquiry_button_yellow_message_container").slideUp();
		}
	});
	
	$(document).on( "click", ".hide_inquiry_button_yellow_message_dontshow", function(){
		$(".hide_inquiry_button_yellow_message_tr").slideUp();
		$(".hide_inquiry_button_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_hide_inquiry_button_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".hide_inquiry_button_yellow_message_dismiss", function(){
		$(".hide_inquiry_button_yellow_message_tr").slideUp();
		$(".hide_inquiry_button_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_hide_inquiry_button_message_dismiss",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dismiss"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
});
})(jQuery);
</script>
			</td>
		</tr>
    <?php
	
	}
	
	public function hide_price_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="hide_price_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <div style="width:450px;">
            <?php 
				$hide_inquiry_button_blue_message = '<div><strong>'.__( 'Note', 'wc_email_inquiry' ).':</strong> '.__( "If you do not apply Rules to your role i.e. 'administrator' you will need to either log out or open the site in another browser where you are not logged in to see the Rule feature is activated.", 'wc_email_inquiry' ).'</div>
                <div style="clear:both"></div>
                <a class="hide_price_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'wc_email_inquiry' ).'</a>
                <a class="hide_price_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'wc_email_inquiry' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $hide_inquiry_button_blue_message ); 
			?>
            </div>
<style>
.a3rev_panel_container .hide_price_yellow_message_container {
<?php if ( $customized_settings['hide_price'] == 'no' && $customized_settings['hide_price_after_login'] == 'no' ) echo 'display: none;'; ?>
<?php if ( get_option( 'wc_ei_hide_price_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { session_start(); } if ( isset( $_SESSION['wc_ei_hide_price_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.email_inquiry_hide_price_after_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_price_yellow_message_container").slideDown();
		} else if( $("input.email_inquiry_hide_price_before_login").prop( "checked" ) == false ) {
			$(".hide_price_yellow_message_container").slideUp();
		}
	});
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.email_inquiry_hide_price_before_login', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".hide_price_yellow_message_container").slideDown();
		} else if( $("input.email_inquiry_hide_price_after_login").prop( "checked" ) == false ) {
			$(".hide_price_yellow_message_container").slideUp();
		}
	});
	
	$(document).on( "click", ".hide_price_yellow_message_dontshow", function(){
		$(".hide_price_yellow_message_tr").slideUp();
		$(".hide_price_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_hide_price_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".hide_price_yellow_message_dismiss", function(){
		$(".hide_price_yellow_message_tr").slideUp();
		$(".hide_price_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_hide_price_message_dismiss",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dismiss"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
});
})(jQuery);
</script>
			</td>
		</tr>
    <?php
	
	}
	
	public function manual_quote_yellow_message( $value ) {
		$customized_settings = get_option( $this->option_name, array() );
	?>
    	<tr valign="top" class="manual_quote_yellow_message_tr" style=" ">
			<th scope="row" class="titledesc">&nbsp;</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
            <div style="width:450px;">
            <?php 
				$manual_quote_blue_message = '<div><strong>'.__( 'Tip', 'wc_email_inquiry' ).':</strong> '.__( "When you assign the Administrator Role to Manual Quotes and create a test Manual Quote Request you will get 2 Quote Request Received emails - the site admins copy and the customers copy", 'wc_email_inquiry' ).'. <strong>'.__( 'Note', 'wc_email_inquiry' ).':</strong> '.__( "The admin email shows the order sub total amount. This is not a bug. Check the customers copy and you will see it shows no prices for each product and no sub total amount.", 'wc_email_inquiry' ).'</div>
				<div style="clear:both"></div>
                <a class="manual_quote_yellow_message_dontshow" style="float:left;" href="javascript:void(0);">'.__( "Don't show again", 'wc_email_inquiry' ).'</a>
                <a class="manual_quote_yellow_message_dismiss" style="float:right;" href="javascript:void(0);">'.__( "Dismiss", 'wc_email_inquiry' ).'</a>
                <div style="clear:both"></div>';
            	echo $this->blue_message_box( $manual_quote_blue_message ); 
			?>
            </div>
<style>
.a3rev_panel_container .manual_quote_yellow_message_container {
<?php if ( get_option( 'wc_ei_manual_quote_message_dontshow', 0 ) == 1 ) echo 'display: none !important;'; ?>
<?php if ( !isset($_SESSION) ) { session_start(); } if ( isset( $_SESSION['wc_ei_manual_quote_message_dismiss'] ) ) echo 'display: none !important;'; ?>
}
</style>
<script>
(function($) {
$(document).ready(function() {
	
	$(document).on( "click", ".manual_quote_yellow_message_dontshow", function(){
		$(".manual_quote_yellow_message_tr").slideUp();
		$(".manual_quote_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dontshow",
				option_name: 	"wc_ei_manual_quote_message_dontshow",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dontshow"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
	
	$(document).on( "click", ".manual_quote_yellow_message_dismiss", function(){
		$(".manual_quote_yellow_message_tr").slideUp();
		$(".manual_quote_yellow_message_container").slideUp();
		var data = {
				action: 		"wc_ei_yellow_message_dismiss",
				session_name: 	"wc_ei_manual_quote_message_dismiss",
				security: 		"<?php echo wp_create_nonce("wc_ei_yellow_message_dismiss"); ?>"
			};
		$.post( "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>", data);
	});
});
})(jQuery);
</script>
			</td>
		</tr>
    <?php
	
	}
	
	public function include_script() {
	?>
<style>
.conditional_logic_container table th {
	padding-left:0px;
	padding-right:20px;	
}
.conditional_logic_container label {
	font-weight:bold;
	font-size: 1.17em;
}
.yellow_message_container {
	margin-top: -15px;	
}
.yellow_message_container a {
	text-decoration:none;	
}
.yellow_message_container th, .yellow_message_container td, .hide_addcartbt_after_login_container th, .hide_addcartbt_after_login_container td, .show_email_inquiry_button_after_login_container th, .show_email_inquiry_button_after_login_container td, .email_inquiry_hide_price_after_login_container th, .email_inquiry_hide_price_after_login_container td, .role_apply_activate_order_logged_in_container th, .role_apply_activate_order_logged_in_container td {
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}
</style>
<script>
(function($) {
	
	a3revEIRulesRoles = {
		
		initRulesRoles: function () {
			// Disabled Manual Quote role for Manual Quote rule to admin can't remove this role for Manual Quote rule
			$("select.role_apply_manual_quote option:first").attr('disabled', 'disabled');
			
			// Disabled Auto Quote role for Auto Quote rule to admin can't remove this role for Auto Quote rule
			$("select.role_apply_auto_quote option:first").attr('disabled', 'disabled');
			
			if ( $("input.rules_roles_explanation").is(':checked') == false ) {
				$(".rules_roles_explanation_container").hide();
			}
			
			/* 
			 * Condition logic for activate apply rule to logged in users
			 * Show Roles dropdown for : Hide Add to Cart, Show Email Inquiry Button, Hide Price, Add to Order rules
			 * Apply when page is loaded
			 */
			if ( $("input.hide_addcartbt_after_login:checked").val() == 'yes' ) {
				$(".hide_addcartbt_after_login_container").show();
			} else {
				$(".hide_addcartbt_after_login_container").hide();
			}
			if ( $("input.show_email_inquiry_button_after_login:checked").val() == 'yes') {
				$(".show_email_inquiry_button_after_login_container").show();
			} else {
				$(".show_email_inquiry_button_after_login_container").hide();
			}
			if ( $("input.email_inquiry_hide_price_after_login:checked").val() == 'yes') {
				$(".email_inquiry_hide_price_after_login_container").show();
			} else {
				$(".email_inquiry_hide_price_after_login_container").hide();
			}
			if ( $("input.activate_order_logged_in:checked").val() == 'yes') {
				$(".role_apply_activate_order_logged_in_container").show();
			} else {
				$(".role_apply_activate_order_logged_in_container").hide();
			}
			
		},
		
		conditionLogicEvent: function () {
			
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.rules_roles_explanation', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".rules_roles_explanation_container").slideDown();
				} else {
					$(".rules_roles_explanation_container").slideUp();
				}
			});
			
			/* 
			 * Condition logic for not logged in users
			 */
			// Manual Quote Rule is activated :
			// deactivate Auto Quote Rule, Add to Order Rule
			// deactivate Hide Add to Cart Rule, activated Hide Price Rule and disabled both to admin can't change the status
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.apply_manual_quote_rule', function( event, value, status ) {
				if ( status == 'true' ) {
					$('input.apply_auto_quote_rule').removeAttr('checked').iphoneStyle("refresh");
					$('input.apply_add_to_order_rule').removeAttr('checked').iphoneStyle("refresh");
				}
			});
			
			// Auto Quote Rule is activated :
			// deactivate Manual Quote Rule, Add to Order Rule
			// deactivate Hide Add to Cart Rule, activated Hide Price Rule and disabled both to admin can't change the status
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.apply_auto_quote_rule', function( event, value, status ) {
				if ( status == 'true' ) {
					$('input.apply_manual_quote_rule').removeAttr('checked').iphoneStyle("refresh");
					$('input.apply_add_to_order_rule').removeAttr('checked').iphoneStyle("refresh");
				}
			});
			
			// Add to Order Rule is activated :
			// deactivate Manual Quote Rule, Auto Quote Rule
			// deactivate Hide Add to Cart Rule, Hide Price Rule and disabled them
			$(document).on( "a3rev-ui-onoff_checkbox-switch-end", '.apply_add_to_order_rule', function( event, value, status ) {
				if ( status == 'true' ) {
					$('input.apply_manual_quote_rule').removeAttr('checked').iphoneStyle("refresh");
					$('input.apply_auto_quote_rule').removeAttr('checked').iphoneStyle("refresh");
				}
			});

			
			/* 
			 * Condition logic for activate apply rule to logged in users
			 * Show Roles dropdown for : Hide Add to Cart, Show Email Inquiry Button, Hide Price, Add to Order rules
			 */
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.hide_addcartbt_after_login', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".hide_addcartbt_after_login_container").slideDown();
				} else {
					$(".hide_addcartbt_after_login_container").slideUp();
				}
			});
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_email_inquiry_button_after_login', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".show_email_inquiry_button_after_login_container").slideDown();
				} else {
					$(".show_email_inquiry_button_after_login_container").slideUp();
				}
			});
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.email_inquiry_hide_price_after_login', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".email_inquiry_hide_price_after_login_container").slideDown();
				} else {
					$(".email_inquiry_hide_price_after_login_container").slideUp();
				}
			});
			$(document).on( "a3rev-ui-onoff_checkbox-switch", '.activate_order_logged_in', function( event, value, status ) {
				if ( status == 'true' ) {
					$(".role_apply_activate_order_logged_in_container").slideDown();
				} else {
					$(".role_apply_activate_order_logged_in_container").slideUp();
				}
			});
		},
		
		/* 
		 * Rules & Roles Schema
		 */
		rulesRolesSchema: function () {
			
			var role_manual_quote = $("select.role_apply_manual_quote").val();
			var role_auto_quote = $("select.role_apply_auto_quote").val();
			var role_add_to_order = $("select.role_apply_activate_order_logged_in").val();
			
			role_auto_quote = $(role_auto_quote).not(role_manual_quote).get();
			role_add_to_order = $(role_add_to_order).not(role_manual_quote).not(role_auto_quote).get();
			
			$("select.role_apply_activate_order_logged_in option").removeAttr("disabled");
			$("select.role_apply_activate_order_logged_in option").filter(function () {
			   if( $.inArray( $(this).val(), role_manual_quote) != -1 ) return true;
			   if( $.inArray( $(this).val(), role_auto_quote) != -1 ) return true;
			}).removeAttr("selected").attr("disabled", "disabled");
			
			$("select.role_apply_auto_quote option").not(":first").removeAttr("disabled");
			$("select.role_apply_auto_quote option").filter(function () {
			   if( $.inArray( $(this).val(), role_manual_quote) != -1 ) return true;
			   if( $.inArray( $(this).val(), role_add_to_order) != -1 ) return true;
			}).removeAttr("selected").attr("disabled", "disabled");
			
			$("select.role_apply_manual_quote option").not(":first").removeAttr("disabled");
			$("select.role_apply_manual_quote option").filter(function () {
			  if( $.inArray( $(this).val(), role_auto_quote) != -1 ) return true;
			   if( $.inArray( $(this).val(), role_add_to_order) != -1 ) return true;
			}).removeAttr("selected").attr("disabled", "disabled");
			
		},
		
		rulesRolesSchemaEvent: function () {
			
			$("select.role_apply_manual_quote").on( 'change', function() {
				a3revEIRulesRoles.rulesRolesSchema();
				$("select.role_apply_auto_quote").trigger("liszt:updated");
				$("select.role_apply_activate_order_logged_in").trigger("liszt:updated");
			});
			
			$("select.role_apply_auto_quote").on( 'change', function() {
				a3revEIRulesRoles.rulesRolesSchema();
				$("select.role_apply_manual_quote").trigger("liszt:updated");
				$("select.role_apply_activate_order_logged_in").trigger("liszt:updated");
			});
			
			$("select.role_apply_activate_order_logged_in").on( 'change', function() {
				a3revEIRulesRoles.rulesRolesSchema();
				$("select.role_apply_manual_quote").trigger("liszt:updated");
				$("select.role_apply_auto_quote").trigger("liszt:updated");
			});
		}
	}
	
	$(document).ready(function() {
		
		a3revEIRulesRoles.initRulesRoles();
		a3revEIRulesRoles.conditionLogicEvent();
		
		a3revEIRulesRoles.rulesRolesSchema();
		a3revEIRulesRoles.rulesRolesSchemaEvent();
		
	});
	
})(jQuery);
</script>
    <?php	
	}
}

global $wc_ei_rules_roles_settings;
$wc_ei_rules_roles_settings = new WC_EI_Rules_Roles_Settings();

/** 
 * wc_ei_rules_roles_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_rules_roles_settings_form() {
	global $wc_ei_rules_roles_settings;
	$wc_ei_rules_roles_settings->settings_form();
}

?>