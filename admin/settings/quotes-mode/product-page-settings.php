<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Quotes Mode Product Page Settings

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

class WC_EI_Quotes_Mode_Product_Page_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_quote_product_page';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_quote_product_page';
	
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
				'success_message'	=> __( 'Product Page Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Product Page Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Product Page Settings successfully reseted.', 'wc_email_inquiry' ),
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
			'name'				=> 'product-page',
			'label'				=> __( 'Product Page', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_quotes_mode_product_page_settings_form',
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
            	'name' 		=> __( 'Quote Feature on Product Page', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Button Text', 'wc_email_inquiry' ),
				'desc' 		=> __( "Text that shows instead of 'Add to Cart'. Default 'Add to Quote'", 'wc_email_inquiry' ),
				'id' 		=> 'quote_button_text',
				'type' 		=> 'text',
				'default'	=> __( 'Add to Quote', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'View Quote Button Text', 'wc_email_inquiry' ),
				'desc' 		=> __( "Text that shows instead of 'View Cart &rarr;'. Default 'View Quote &rarr;'", 'wc_email_inquiry' ),
				'id' 		=> 'quote_view_button_text',
				'type' 		=> 'text',
				'default'	=> __( 'View Quote &rarr;', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Continue Request Button Text', 'wc_email_inquiry' ),
				'desc' 		=> __( "Text that shows instead of 'Continue Shopping &rarr;'. Default 'Continue Request &rarr;'", 'wc_email_inquiry' ),
				'id' 		=> 'quote_continue_button_text',
				'type' 		=> 'text',
				'default'	=> __( 'Continue Request &rarr;', 'wc_email_inquiry' ),
			),
			
			array(
            	'name' 		=> __( 'Success Message', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Success Message', 'wc_email_inquiry' ),
				'desc' 		=> '%s : ' . __( "Replace by Product name", 'wc_email_inquiry' ),
				'id' 		=> 'quote_success_message',
				'type' 		=> 'text',
				'default'	=> __( '&quot;%s&quot; was successfully added to your quote.', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Group Added Success Message', 'wc_email_inquiry' ),
				'desc' 		=> '%s : ' . __( "Replace by Product name", 'wc_email_inquiry' ),
				'id' 		=> 'quote_group_success_message',
				'type' 		=> 'text',
				'default'	=> __( 'Added &quot;%s&quot; to your quote.', 'wc_email_inquiry' ),
			),
			
			array(
            	'name' 		=> __( 'Error Message', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Quantity Error', 'wc_email_inquiry' ),
				'desc' 		=> __( "Replace for :", 'wc_email_inquiry' ) . " '" . __( 'Please choose the quantity of items you wish to add to your cart&hellip;', 'woocommerce' ) . "'",
				'id' 		=> 'quote_error_quantity_message',
				'type' 		=> 'textarea',
				'default'	=> __( 'Please choose the quantity of items you wish to add to your quote&hellip;', 'wc_email_inquiry' ),
				'css'		=> 'width:300px; height:60px;',
			),
			array(  
				'name' 		=> __( 'No Product Added Error', 'wc_email_inquiry' ),
				'desc' 		=> __( "Replace for :", 'wc_email_inquiry' ) . " '" . __( 'Please choose a product to add to your cart&hellip;', 'woocommerce' ) . "'",
				'id' 		=> 'quote_error_no_product_add_message',
				'type' 		=> 'textarea',
				'default'	=> __( 'Please choose a product to add to your quote&hellip;', 'wc_email_inquiry' ),
				'css'		=> 'width:300px; height:60px;',
			),
			array(  
				'name' 		=> __( 'Product Is Out of Stock Error', 'wc_email_inquiry' ),
				'desc' 		=> '%s : ' . __( "Replace by Product name", 'wc_email_inquiry' ),
				'id' 		=> 'quote_error_out_stock_message',
				'type' 		=> 'textarea',
				'default'	=> __( 'You cannot add &quot;%s&quot; to the quote because the product is out of stock.', 'wc_email_inquiry' ),
				'css'		=> 'width:300px; height:60px;',
			),
			array(  
				'name' 		=> __( 'Product Existed In Quote', 'wc_email_inquiry' ),
				'desc' 		=> __( "Replace for :", 'wc_email_inquiry' ) . " '" . __( 'You already have this item in your cart.', 'woocommerce' ) . "'",
				'id' 		=> 'quote_error_product_already_message',
				'type' 		=> 'text',
				'default'	=> __( 'You already have this item in your quote.', 'wc_email_inquiry' ),
			),
			
        ));
	}
}

global $wc_ei_quotes_mode_product_page_settings;
$wc_ei_quotes_mode_product_page_settings = new WC_EI_Quotes_Mode_Product_Page_Settings();

/** 
 * wc_ei_quotes_mode_product_page_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_quotes_mode_product_page_settings_form() {
	global $wc_ei_quotes_mode_product_page_settings;
	$wc_ei_quotes_mode_product_page_settings->settings_form();
}

?>