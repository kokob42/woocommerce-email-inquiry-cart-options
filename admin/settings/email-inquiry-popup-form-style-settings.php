<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Default Form Style Settings

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

class WC_EI_Popup_Form_Style_Settings extends WC_Email_Inquiry_Admin_UI
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
	public $option_name = 'wc_email_inquiry_customize_email_popup';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_customize_email_popup';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 2;
	
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
				'success_message'	=> __( 'Default Form Style Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Default Form Style Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Default Form Style Settings successfully reseted.', 'wc_email_inquiry' ),
			);
				
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		// Add yellow border for pro fields
		add_action( $this->plugin_name . '_settings_pro_form_title_font_before', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '_settings_pro_product_url_after', array( $this, 'pro_fields_after' ) );
		
		add_action( $this->plugin_name . '_settings_pro_email_subject_name_before', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '_settings_pro_form_input_field_style_after', array( $this, 'pro_fields_after' ) );
		
		add_action( $this->plugin_name . '_settings_pro_send_button_style_before', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '_settings_pro_popup_class_after', array( $this, 'pro_fields_after' ) );
		
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
			'name'				=> 'default-form-style',
			'label'				=> __( 'Default Form Style', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_popup_form_style_settings_form',
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
            	'name' 		=> __( 'Form Background Colour', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'class'		=> 'pro_feature_fields',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'inquiry_form_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			
			array(
            	'name' 		=> __( 'Form Title', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Header Title', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; and the form title will be the Button title", 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_heading',
				'type' 		=> 'text',
				'free_version'		=> true,
				'default'	=> ''
			),
			array(
                'type' 		=> 'heading',
				'id'		=> 'pro_form_title_font',
           	),
			array(  
				'name' 		=> __( 'Title Font', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_heading_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '18px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Product Name', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Product Name Font', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_form_product_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '26px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#29577F' )
			),
			
			array(
            	'name' 		=> __( 'Product URL', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_product_url',
           	),
			array(  
				'name' 		=> __( 'Product URL Font', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_form_product_url_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#29577F' )
			),
			
			array(
            	'name' 		=> __( 'Form Content Font', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Content Font', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_popup_text',
				'type' 		=> 'typography',
				'free_version'		=> true,
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Email Subject Name', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_email_subject_name',
           	),
			array(  
				'name' 		=> __( 'Subject Name Font', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_form_subject_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Form Input Field Style', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_form_input_field_style',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FAFAFA'
			),
			array(  
				'name' 		=> __( 'Font Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_font_colour',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			array(  
				'name' 		=> __( 'Input Field Borders', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_input_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#CCCCCC', 'corner' => 'square' , 'rounded_value' => 0 ),
			),
			
			array(
            	'name' 		=> __( 'Form Send / Submit Button', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Send Button Title', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default SEND", 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_text_button',
				'type' 		=> 'text',
				'free_version'		=> true,
				'default'	=> __( 'SEND', 'wc_email_inquiry' ),
			),
			array(
                'type' 		=> 'heading',
				'id'		=> 'pro_send_button_style',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#FBCACA'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B'
			),
			array(  
				'name' 		=> __( 'Button Border', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#EE2B2B', 'corner' => 'rounded' , 'rounded_value' => 3 ),
			),
			array(  
				'name' 		=> __( 'Button Font', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#FFFFFF' )
			),
			
			array(
            	'name' 		=> __( 'Style Form With Theme CSS', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
				'id'		=> 'pro_popup_class',
           	),
			array(  
				'name' 		=> __( 'Form CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __( "&lt;empty&gt; for default or enter custom form CSS", 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_form_class',
				'type' 		=> 'text',
				'default'	=> ''
			),
			array(  
				'name' 		=> __( 'Button CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Enter your own button CSS class', 'wc_email_inquiry' ),
				'id' 		=> 'inquiry_contact_button_class',
				'type' 		=> 'text',
				'default'	=> ''
			),
			
        ));
	}
	
}

global $wc_ei_popup_form_style_settings;
$wc_ei_popup_form_style_settings = new WC_EI_Popup_Form_Style_Settings();

/** 
 * wc_ei_popup_form_style_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_popup_form_style_settings_form() {
	global $wc_ei_popup_form_style_settings;
	$wc_ei_popup_form_style_settings->settings_form();
}

?>