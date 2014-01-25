<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Orders Mode New Account Email Settings

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

class WC_EI_Orders_Mode_New_Account_Email_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'orders-emails';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_order_new_account_email_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_order_new_account_email_settings';
	
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
	
	public $template_html = 'emails/order-new-account.php';
	public $template_plain = 'emails/plain/order-new-account.php';
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'New Account Email Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: New Account Email Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'New Account Email Settings successfully reseted.', 'wc_email_inquiry' ),
			);
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ), 11 );
		
		add_action( $this->plugin_name . '-' . trim( $this->form_key ) . '_settings_end', array( $this, 'settings_end' )  );
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
			'name'				=> 'new-account',
			'label'				=> __( 'New Account', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_orders_mode_new_account_email_settings_form',
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
		unset( $roles['manual_quote'] );
		unset( $roles['auto_quote'] );
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
            	'name' 		=> __( "New Account Role", 'wc_email_inquiry' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Set Role for New Acccount", 'wc_email_inquiry' ),
				'id' 		=> 'order_new_account_role',
				'css' 		=> 'min-width:300px;',
				'type' 		=> 'select',
				'default'	=> 'customer',
				'options'	=> $roles,
			),
			
			array(
            	'name' 		=> __( "New User Account Email", 'wc_email_inquiry' ),
				'desc'		=> __( "A new user account is created (if none exists) when a order request is submitted. Customize the New user account notification email that is auto sent to the user.", 'wc_email_inquiry' ),
				'id'		=> 'order_new_account_email_table',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Email Subject', 'wc_email_inquiry' ),
				'desc' 		=> __( "Defaults to <code>Your account on {blogname}</code>.", 'wc_email_inquiry' ),
				'id' 		=> 'order_new_account_email_subject',
				'type' 		=> 'text',
				'default'	=> __( 'Your account on {blogname}', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Email Heading', 'wc_email_inquiry' ),
				'desc' 		=> __( "Defaults to <code>Welcome to {blogname}</code>.", 'wc_email_inquiry' ),
				'id' 		=> 'order_new_account_email_heading',
				'type' 		=> 'text',
				'default'	=> __( 'Welcome to {blogname}', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Email Content', 'wc_email_inquiry' ),
				'id' 		=> 'wc_email_inquiry_order_new_account_email_content',
				'type' 		=> 'wp_editor',
				'textarea_rows'	=> 4,
				'default'	=> __( '<p>Hello {first_name},</p><p>Your login link and credentials are:</p><p>{account_url}</p><p>Username: {username}<br />Password: {password}</p><p>Please login and change the WordPress generated password to something you can remember.</p>', 'wc_email_inquiry' ),
				'separate_option'	=> true,
			),
			array(  
				'name' 		=> __( 'Email Type', 'wc_email_inquiry' ),
				'desc' 		=> __( "Choose which format of email to send", 'wc_email_inquiry' ),
				'class'		=> 'order_new_account_email_type',
				'id' 		=> 'order_new_account_email_type',
				'type' 		=> 'onoff_radio',
				'default'	=> 'html',
				'onoff_options' => array(
					array(
						'val' => 'html',
						'text' => __( 'HTML', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'YES', 'wc_email_inquiry' ),
						'unchecked_label' 	=> __( 'NO', 'wc_email_inquiry' ),
					),
					array(
						'val' => 'plain',
						'text' => __( 'Plain text', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'YES', 'wc_email_inquiry' ),
						'unchecked_label' 	=> __( 'NO', 'wc_email_inquiry' ),
					),
					array(
						'val' => 'multipart',
						'text' => __( 'Multipart', 'wc_email_inquiry' ),
						'checked_label'		=> __( 'YES', 'wc_email_inquiry' ),
						'unchecked_label' 	=> __( 'NO', 'wc_email_inquiry' ),
					),
				),
				
			),
			
        ));
	}
	
	public function settings_end() {
	?>
    	<style>
		.email_type_content div p .button {
			float: right;
			margin-left: 10px;
			margin-top: -4px;	
		}
		.email_type_content div .editor textarea {
			margin-bottom: 8px;
		}
		.email_type_content textarea {
			background: none repeat scroll 0 0 #F9F9F9;
			font-family: Consolas,Monaco,monospace;
			font-size: 12px;
			outline: 0 none;
			width: 97%;
		}
		.email_type_content textarea[disabled="disabled"] {
			background: none repeat scroll 0 0 #DFDFDF !important;
		}
		</style>
			<div id="" class="email_type_content">
			<?php
				$templates = array(
					'template_html' 	=> __( 'HTML template', 'wc_email_inquiry' ),
					'template_plain' 	=> __( 'Plain text template', 'wc_email_inquiry' )
				);
				foreach ( $templates as $template => $title ) :
					if ( empty( $this->$template ) )
						continue;

					$local_file = get_stylesheet_directory() . '/woocommerce/' . $this->$template;
					$core_file 	= WC_EMAIL_INQUIRY_TEMPLATE_PATH . '/' . $this->$template;
					?>
					<div class="template <?php echo $template; ?>">

						<h4><?php echo wp_kses_post( $title ); ?></h4>

						<?php if ( file_exists( $local_file ) ) : ?>

							<p>
								<a href="#" class="button toggle_editor"></a>

								<?php if ( is_writable( $local_file ) ) : ?>
									<a href="<?php echo remove_query_arg( array( 'move_template', 'saved' ), add_query_arg( 'delete_template', $template ) ); ?>" class="delete_template button"><?php _e( 'Delete template file', 'woocommerce' ); ?></a>
								<?php endif; ?>

								<?php printf( __( 'This template has been overridden by your theme and can be found in: <code>%s</code>.', 'woocommerce' ), 'yourtheme/woocommerce/' . $this->$template ); ?>
							</p>

							<div class="editor" style="display:none">

								<textarea class="code" cols="25" rows="4" <?php if ( ! is_writable( $local_file ) ) : ?>readonly="readonly" disabled="disabled"<?php else : ?>data-name="<?php echo $template . '_code'; ?>"<?php endif; ?>><?php echo file_get_contents( $local_file ); ?></textarea>

							</div>

						<?php elseif ( file_exists( $core_file ) ) : ?>

							<p>
								<a href="#" class="button toggle_editor"></a>

								<?php if ( ( is_dir( get_stylesheet_directory() . '/woocommerce/emails/' ) && is_writable( get_stylesheet_directory() . '/woocommerce/emails/' ) ) || is_writable( get_stylesheet_directory() ) ) : ?>
									<a href="<?php echo remove_query_arg( array( 'delete_template', 'saved' ), add_query_arg( 'move_template', $template ) ); ?>" class="button"><?php _e( 'Copy file to theme', 'woocommerce' ); ?></a>
								<?php endif; ?>

								<?php printf( __( 'To override and edit this email template copy <code>%s</code> to your theme folder: <code>%s</code>.', 'woocommerce' ), plugin_basename( $core_file ) , 'yourtheme/woocommerce/' . $this->$template ); ?>
							</p>

							<div class="editor" style="display:none">

								<textarea class="code" readonly="readonly" disabled="disabled" cols="25" rows="4"><?php echo file_get_contents( $core_file ); ?></textarea>

							</div>

						<?php else : ?>

							<p><?php _e( 'File was not found.', 'woocommerce' ); ?></p>

						<?php endif; ?>

					</div>
					<?php
				endforeach;
			?>
			</div>
<script>
(function($) {
$(document).ready(function() {
	$('.template_plain, .template_html').show();
	if ( $("input.order_new_account_email_type:checked").val() != 'multipart' && $("input.order_new_account_email_type:checked").val() != 'html' ) {
		$('.template_html').hide();
	}
	
	if ( $("input.order_new_account_email_type:checked").val() != 'multipart' && $("input.order_new_account_email_type:checked").val() != 'plain' ) {
		$('.template_plain').hide();
	}
	$(document).on( "a3rev-ui-onoff_radio-switch", '.order_new_account_email_type', function( event, value, status ) {
		if ( value == 'multipart' && status == 'true' ) {
			$('.template_plain, .template_html').show( 'slow' );
		} else if ( value == 'html' && status == 'true' ) {
			$('.template_html').show( 'slow' );
			$('.template_plain').hide( 'slow' );
		}
		else if ( value == 'plain' && status == 'true' ) {
			$('.template_plain').show( 'slow' );
			$('.template_html').hide( 'slow' );
		}
	});
				
				var view = '<?php echo esc_js( __( 'View template', 'woocommerce' ) ) ?>';
				var hide = '<?php echo esc_js( __( 'Hide template', 'woocommerce' ) ) ?>';

				$('a.toggle_editor').text( view ).toggle( function() {
					$( this ).text( hide ).closest('.template').find('.editor').slideToggle();
					return false;
				}, function() {
					$( this ).text( view ).closest('.template').find('.editor').slideToggle();
					return false;
				} );

				$('a.delete_template').click(function(){
					var answer = confirm('<?php echo esc_js( __( 'Are you sure you want to delete this template file?', 'woocommerce' ) ) ?>');

					if (answer)
						return true;

					return false;
				});

				$('.editor textarea').change(function(){
					var name = $(this).attr( 'data-name' );

					if ( name )
						$(this).attr( 'name', name );
				});
});
})(jQuery);
</script>
    <?php
	}
}

global $wc_ei_orders_mode_new_account_email_settings;
$wc_ei_orders_mode_new_account_email_settings = new WC_EI_Orders_Mode_New_Account_Email_Settings();

/** 
 * wc_ei_orders_mode_new_account_email_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_orders_mode_new_account_email_settings_form() {
	global $wc_ei_orders_mode_new_account_email_settings;
	$wc_ei_orders_mode_new_account_email_settings->settings_form();
}

?>
