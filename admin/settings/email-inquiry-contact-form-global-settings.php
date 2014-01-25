<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Contact Form Settings

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

class WC_EI_Contact_Form_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'default-contact-form';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_contact_form_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_contact_form_settings';
	
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
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Default Form Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Default Form Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Default Form Settings successfully reseted.', 'wc_email_inquiry' ),
			);
		
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		// Add yellow border for pro fields
		add_action( $this->plugin_name . '_settings_pro_email_from_settings_before', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '_settings_pro_send_copy_after', array( $this, 'pro_fields_after' ) );
		
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
			'name'				=> 'settings',
			'label'				=> __( 'Settings', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_contact_form_settings_form',
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
		
		add_filter( $this->plugin_name . '_pro_version_name', array( $this, 'get_ultimate_version_name' ) );
		add_filter( $this->plugin_name . '_pro_plugin_page_url', array( $this, 'get_ultimate_page_url' ) );
		
		$output = '';
		$output .= $wc_ei_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	public function get_ultimate_version_name( $pro_version_name ) {
		return __( 'Email & Cart Pro Version', 'wc_email_inquiry' );
	}
	
	public function get_ultimate_page_url( $pro_plugin_page_url ) {
		return $this->profirst_plugin_page_url;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
            	'name' 		=> __( 'Built-in Contact Form', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( "Email 'From' Settings", 'wc_email_inquiry' ),
				'desc'		=> __( 'The following options affect the sender (email address and name) used in WooCommerce Product Email Inquiries.', 'wc_email_inquiry' ),
				'class'		=> 'default_contact_form_options',
                'type' 		=> 'heading',
				'id'		=> 'pro_email_from_settings',
           	),
			array(  
				'name' 		=> __( '"From" Name', 'wc_email_inquiry' ),
				'desc'		=> __( '&lt;empty&gt; defaults to Site Title', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_email_from_name',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('blogname'),
			),
			array(  
				'name' 		=> __( '"From" Email Address', 'wc_email_inquiry' ),
				'desc'		=> __( '&lt;empty&gt; defaults to WordPress admin email address', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_email_from_address',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('admin_email'),
			),
			array(
				'name' 		=> __( "Sender 'Request A Copy'", 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_send_copy',
           	),
			array(  
				'name' 		=> __( 'Send Copy to Sender', 'wc_email_inquiry' ),
				'desc' 		=> __( "Gives users a checkbox option to send a copy of the Inquiry email to themselves", 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_send_copy',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'YES', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'NO', 'wc_email_inquiry' ),
			),
			
			array(
				'name' 		=> __( 'Email Delivery', 'wc_email_inquiry' ),
				'class'		=> 'default_contact_form_options',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Inquiry Email goes to', 'wc_email_inquiry' ),
				'desc'		=> __( '&lt;empty&gt; defaults to WordPress admin email address', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_email_to',
				'type' 		=> 'text',
				'free_version'		=> true,
				'default'	=> get_bloginfo('admin_email'),
			),
			array(  
				'name' 		=> __( 'CC', 'wc_email_inquiry' ),
				'desc'		=> __( "&lt;empty&gt; defaults to 'no copy sent' or add an email address", 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_email_cc',
				'type' 		=> 'text',
				'free_version'		=> true,
				'default'	=> '',
			),
			
			array(
				'name' 		=> __( 'Open Default Contact Form Method', 'wc_email_inquiry' ),
				'class'		=> 'default_contact_form_options',
                'type' 		=> 'heading',
				'class'		=> 'pro_feature_fields',
           	),
			array(  
				'name' 		=> __( 'Product Page', 'wc_email_inquiry' ),
				'id' 		=> 'defaul_product_page_open_form_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'popup',
				'onoff_options' => array(
					array(
						'val' 				=> 'popup',
						'text' 				=> __( 'Open contact form by Pop-up', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
					array(
						'val' 				=> 'inner_page',
						'text' 				=> __( 'Open contact form on page (form opens by ajax under the inquiry button).', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
				),			
			),
			array(  
				'name' 		=> __( 'Product Card', 'wc_email_inquiry' ),
				'id' 		=> 'defaul_category_page_open_form_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'popup',
				'onoff_options' => array(
					array(
						'val' 				=> 'popup',
						'text' 				=> __( 'Open contact form by Pop-up', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
				),
				'custom_attributes'	=> 'disabled="disabled" ',		
			),
			
        ));
	}
	
}

global $wc_ei_contact_form_settings;
$wc_ei_contact_form_settings = new WC_EI_Contact_Form_Settings();

/** 
 * wc_ei_contact_form_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_contact_form_settings_form() {
	global $wc_ei_contact_form_settings;
	$wc_ei_contact_form_settings->settings_form();
}

?>
