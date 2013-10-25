<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Quotes Mode Page

TABLE OF CONTENTS

- var menu_slug
- var page_data

- __construct()
- page_init()
- page_data()
- add_admin_menu()
- tabs_include()
- admin_settings_page()

-----------------------------------------------------------------------------------*/

class WC_EI_Quotes_Mode_Page extends WC_Email_Inquiry_Admin_UI
{	
	/**
	 * @var string
	 */
	private $menu_slug = 'wc-ei-quotes-mode';
	
	/**
	 * @var array
	 */
	private $page_data;
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->page_init();
		$this->tabs_include();
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_init() */
	/* Page Init */
	/*-----------------------------------------------------------------------------------*/
	public function page_init() {
		
		add_filter( $this->plugin_name . '_add_admin_menu', array( $this, 'add_admin_menu' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_data() */
	/* Get Page Data */
	/*-----------------------------------------------------------------------------------*/
	public function page_data() {
		
		$page_data = array(
			'type'				=> 'submenu',
			'parent_slug'		=> 'email-cart-options',
			'page_title'		=> __( 'Quotes Mode', 'wc_email_inquiry' ),
			'menu_title'		=> __( 'Quotes Mode', 'wc_email_inquiry' ),
			'capability'		=> 'manage_options',
			'menu_slug'			=> $this->menu_slug,
			'function'			=> 'wc_ei_quotes_mode_page_show',
			'admin_url'			=> 'admin.php',
			'callback_function' => '',
			'script_function' 	=> '',
			'view_doc'			=> '',
		);
		
		if ( $this->page_data ) return $this->page_data;
		return $this->page_data = $page_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_admin_menu() */
	/* Add This page to menu on left sidebar */
	/*-----------------------------------------------------------------------------------*/
	public function add_admin_menu( $admin_menu ) {
		
		if ( ! is_array( $admin_menu ) ) $admin_menu = array();
		$admin_menu[] = $this->page_data();
		
		return $admin_menu;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* tabs_include() */
	/* Include all tabs into this page
	/*-----------------------------------------------------------------------------------*/
	public function tabs_include() {
		
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/global-settings-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/product-page-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/widget-cart-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/cart-page-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/checkout-page-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/order-received-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/quotes-mode/quotes-emails-tab.php' );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* admin_settings_page() */
	/* Show Settings Page */
	/*-----------------------------------------------------------------------------------*/
	public function admin_settings_page() {
		global $wc_ei_admin_init;
		
		$wc_ei_admin_init->admin_settings_page( $this->page_data() );
	}
	
}

global $wc_ei_quotes_mode_page;
$wc_ei_quotes_mode_page = new WC_EI_Quotes_Mode_Page();

/** 
 * wc_ei_quotes_mode_page_show()
 * Define the callback function to show page content
 */
function wc_ei_quotes_mode_page_show() {
	global $wc_ei_quotes_mode_page;
	$wc_ei_quotes_mode_page->admin_settings_page();
}

?>