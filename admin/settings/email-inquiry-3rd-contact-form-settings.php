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

class WC_EI_3RD_Contact_Form_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = '3rd-contact-form';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_3rd_contact_form_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_3rd_contact_form_settings';
	
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
		//$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Custom Form Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Custom Form Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Custom Form Settings successfully reseted.', 'wc_email_inquiry' ),
			);
		
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
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
			'name'				=> '3rd-contact-form',
			'label'				=> __( 'Custom Form', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_3rd_contact_form_settings_form',
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
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
					
			array(
            	'name' 		=> __( 'Contact Form from another Plugin', 'wc_email_inquiry' ),
				'desc'		=> __( 'Create a contact form that applies to all Products by adding a form shortcode from the Contact Form 7 or Gravity Forms plugins.', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Enter Global Form Shortcode', 'wc_email_inquiry' ),
				'desc'		=> __( 'Can add unique form shortcode on each product page.', 'wc_email_inquiry' ),
				'id' 		=> 'contact_form_shortcode',
				'type' 		=> 'text',
				'default'	=> '',
			),
			
			array(
				'name' 		=> __( 'Custom Form Open Options', 'wc_email_inquiry' ),
				'class'		=> '3rd_contact_form_options',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Product Page', 'wc_email_inquiry' ),
				'id' 		=> 'product_page_open_form_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'new_page',
				'onoff_options' => array(
					array(
						'val' 				=> 'new_page',
						'text' 				=> __( 'Open contact form on new page', 'wc_email_inquiry' ) . ' - ' . __( 'new window', 'wc_email_inquiry' ) . '<span class="description">(' . __( 'Default', 'wc_email_inquiry' ) . ')</span>',
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
					array(
						'val' 				=> 'new_page_same_window',
						'text' 				=> __( 'Open contact form on new page', 'wc_email_inquiry' ) . ' - ' . __( 'same window', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
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
				'name' 		=> __( 'Grid View', 'wc_email_inquiry' ),
				'id' 		=> 'category_page_open_form_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'new_page',
				'onoff_options' => array(
					array(
						'val' 				=> 'new_page',
						'text' 				=> __( 'Open contact form on new page', 'wc_email_inquiry' ) . ' - ' . __( 'new window', 'wc_email_inquiry' ) . '<span class="description">(' . __( 'Default', 'wc_email_inquiry' ) . ')</span>',
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
					array(
						'val' 				=> 'new_page_same_window',
						'text' 				=> __( 'Open contact form on new page', 'wc_email_inquiry' ) . ' - ' . __( 'same window', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
					array(
						'val' 				=> 'popup',
						'text' 				=> __( 'Open contact form by Pop-up', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'ON', 'wc_email_inquiry') ,
						'unchecked_label' 	=> __( 'OFF', 'wc_email_inquiry') ,
					),
				),			
			),
			
			array(
            	'name' 		=> __( 'Page For Displaying shortcode Forms', 'wc_email_inquiry' ),
				'class'		=> '3rd_contact_form_options',
				'desc'		=> sprintf( __("A 'Email Inquiry' page with the shortcode %s inserted should have been auto created on install. If not you need to manually create a new page and add the shortcode. Then set that page below so the plugin knows where to find it.", 'wc_email_inquiry'), '[wc_email_inquiry_page]' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Email Inquiry Page', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Page contents:', 'wc_email_inquiry' ).' [wc_email_inquiry_page]',
				'id' 		=> 'wc_email_inquiry_page_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'separate_option'	=> true,
				'placeholder'		=> __( 'Select Page', 'wc_email_inquiry' ),
				'css'		=> 'width:300px;',
			),
			
			array(
            	'name' 		=> __( 'Reset Products Contact Form Shortcodes', 'wc_email_inquiry' ),
				'class'		=> '3rd_contact_form_options',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Global Re-Set', 'wc_email_inquiry' ),
				'desc' 		=> __( "Set to Yes and Save Changes will reset all products that have a unique contact form shortcode to the form shortcode set on this page.", 'wc_email_inquiry' ),
				'id' 		=> 'wc_email_inquiry_reset_products_shortcode_options',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'separate_option'	=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'YES', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'NO', 'wc_email_inquiry' ),
			),
			
        ));
	}
	
}

global $wc_ei_3rd_contact_form_settings;
$wc_ei_3rd_contact_form_settings = new WC_EI_3RD_Contact_Form_Settings();

/** 
 * wc_ei_3rd_contact_form_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_3rd_contact_form_settings_form() {
	global $wc_ei_3rd_contact_form_settings;
	$wc_ei_3rd_contact_form_settings->settings_form();
}

?>