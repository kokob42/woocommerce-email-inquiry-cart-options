<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Admin Email Inquiry Cart Page

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

class WC_EI_Rules_Roles_Page extends WC_Email_Inquiry_Admin_UI
{	
	/**
	 * @var string
	 */
	private $menu_slug = 'email-cart-options';
	
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
			array(
				'type'				=> 'menu',
				'page_title'		=> __( 'Email & Cart Options', 'wc_email_inquiry' ),
				'menu_title'		=> __( 'Email & Cart Options', 'wc_email_inquiry' ),
				'capability'		=> 'manage_options',
				'menu_slug'			=> $this->menu_slug,
				'function'			=> 'wc_ei_rules_roles_page_show',
				'icon_url'			=> '',
				'position'			=> '30.2456',
				'admin_url'			=> 'admin.php',
				'callback_function' => '',
				'script_function' 	=> '',
				'view_doc'			=> '',
			),
			array(
				'type'				=> 'submenu',
				'parent_slug'		=> $this->menu_slug,
				'page_title'		=> __( 'Rules & Roles', 'wc_email_inquiry' ),
				'menu_title'		=> __( 'Rules & Roles', 'wc_email_inquiry' ),
				'capability'		=> 'manage_options',
				'menu_slug'			=> $this->menu_slug,
				'function'			=> 'wc_ei_rules_roles_page_show',
				'admin_url'			=> 'admin.php',
				'callback_function' => 'wc_ei_rules_roles_tab_manager',
				'script_function' 	=> '',
				'view_doc'			=> '',
			),
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
		$admin_menu = array_merge( $this->page_data(), $admin_menu );
		
		return $admin_menu;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* tabs_include() */
	/* Include all tabs into this page
	/*-----------------------------------------------------------------------------------*/
	public function tabs_include() {
		
		include_once( $this->admin_plugin_dir() . '/tabs/rules-roles-tab.php' );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* admin_settings_page() */
	/* Show Settings Page */
	/*-----------------------------------------------------------------------------------*/
	public function admin_settings_page() {
		global $wc_ei_admin_init;
		$my_page_data = $this->page_data();
		$my_page_data = array_values( $my_page_data );
		$wc_ei_admin_init->admin_settings_page( $my_page_data[1] );
	}
	
}

global $wc_ei_rules_roles_page;
$wc_ei_rules_roles_page = new WC_EI_Rules_Roles_Page();

/** 
 * wc_ei_rules_roles_page_show()
 * Define the callback function to show page content
 */
function wc_ei_rules_roles_page_show() {
	global $wc_ei_rules_roles_page;
	$wc_ei_rules_roles_page->admin_settings_page();
}

?>