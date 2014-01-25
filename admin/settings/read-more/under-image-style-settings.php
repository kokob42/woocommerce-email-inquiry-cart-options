<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Read More Above or Below Add To Cart Button Style Settings

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

class WC_EI_Read_More_Under_Image_Style_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'button-style';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_ei_read_more_under_image_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_ei_read_more_under_image_style';
	
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
				'success_message'	=> __( 'Under Image Style successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Under Image Style can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Under Image Style successfully reseted.', 'wc_email_inquiry' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
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
			'name'				=> 'under-image-style',
			'label'				=> __( 'Under Image Style', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_read_more_under_image_style_settings_form',
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
		return __( 'Ultimate Version', 'wc_email_inquiry' );
	}
	
	public function get_ultimate_page_url( $pro_plugin_page_url ) {
		return $this->ultimate_plugin_page_url;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
            	'name' => __( 'Button/Hyperlink Show under Image', 'wc_email_inquiry' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Type', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_type',
				'class' 	=> 'under_image_bt_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'button',
				'checked_value'		=> 'button',
				'unchecked_value'	=> 'link',
				'checked_label'		=> __( 'Button', 'wc_email_inquiry' ),
				'unchecked_label' 	=> __( 'Hyperlink', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Relative Position', 'wc_email_inquiry' ),
				'desc'		=> __( 'Position relative to Add to Cart button location', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_position',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'below',
				'checked_value'		=> 'below',
				'unchecked_value'	=> 'above',
				'checked_label' 	=> __( 'Below', 'wc_email_inquiry' ),
				'unchecked_label'	=> __( 'Above', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Button or Hyperlink Magrin', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'under_image_bt_margin_top',
	 										'name' 		=> __( 'Top', 'wc_email_inquiry' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'under_image_bt_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wc_email_inquiry' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'under_image_bt_margin_left',
	 										'name' 		=> __( 'Left', 'wc_email_inquiry' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'under_image_bt_margin_right',
	 										'name' 		=> __( 'Right', 'wc_email_inquiry' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			
			array(
            	'name' 		=> __( 'Hyperlink Styling', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
          		'class'		=> 'show_under_image_hyperlink_styling'
           	),
			array(  
				'name' => __( 'Hyperlink Text', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Text for Hyperlink show under image', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_link_text',
				'type' 		=> 'text',
				'default'	=> __('Read More', 'wc_email_inquiry')
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial', 'style' => 'bold', 'color' => '#000000' )
			),
			
			array(  
				'name' 		=> __( 'Hyperlink hover Colour', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_link_font_hover_color',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			
			array(
            	'name' 		=> __( 'Button Styling', 'wc_email_inquiry' ),
                'type' 		=> 'heading',
          		'class' 	=> 'show_under_image_button_styling'
           	),
			array(  
				'name' 		=> __( 'Button Text', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Text for Button show under image', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_text',
				'type' 		=> 'text',
				'default'	=> __('Read More', 'wc_email_inquiry')
			),
			array(  
				'name' 		=> __( 'Button Padding', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Padding from Button text to Button border show under image', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'under_image_bt_padding_tb',
	 										'name' 		=> __( 'Top/Bottom', 'wc_email_inquiry' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
	 
	 								array(  'id' 		=> 'under_image_bt_padding_lr',
	 										'name' 		=> __( 'Left/Right', 'wc_email_inquiry' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Background Colour', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'under_image_bt_bg',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'under_image_bt_bg_from',
				'type' 		=> 'color',
				'default'	=> '#FBCACA'
			),
			
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Default', 'wc_email_inquiry' ) . ' [default_value]',
				'id' 		=> 'under_image_bt_bg_to',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B'
			),
			array(  
				'name' 		=> __( 'Button Border', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#EE2B2B', 'corner' => 'rounded' , 'rounded_value' => 3 ),
			),
			array(  
				'name' 		=> __( 'Button Font', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial', 'style' => 'bold', 'color' => '#FFFFFF' )
			),
			array(  
				'name' => __( 'Button Shadow', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			array(  
				'name' 		=> __( 'CSS Class', 'wc_email_inquiry' ),
				'desc' 		=> __( 'Enter your own button CSS class', 'wc_email_inquiry' ),
				'id' 		=> 'under_image_bt_class',
				'type' 		=> 'text',
				'default'	=> ''
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.under_image_bt_type:checked").val() == 'button') {
		$(".show_under_image_button_styling").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".show_under_image_hyperlink_styling").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".show_under_image_button_styling").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".show_under_image_hyperlink_styling").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.under_image_bt_type', function( event, value, status ) {
		$(".show_under_image_button_styling").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".show_under_image_hyperlink_styling").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true') {
			$(".show_under_image_button_styling").slideDown();
			$(".show_under_image_hyperlink_styling").slideUp();
		} else {
			$(".show_under_image_button_styling").slideUp();
			$(".show_under_image_hyperlink_styling").slideDown();
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wc_ei_read_more_under_image_style_settings;
$wc_ei_read_more_under_image_style_settings = new WC_EI_Read_More_Under_Image_Style_Settings();

/** 
 * wc_ei_read_more_under_image_style_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_read_more_under_image_style_settings_form() {
	global $wc_ei_read_more_under_image_style_settings;
	$wc_ei_read_more_under_image_style_settings->settings_form();
}

?>
