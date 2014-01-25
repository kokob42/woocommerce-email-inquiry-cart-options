<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC EI Quotes Mode Send Quote Email Settings

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

class WC_EI_Quotes_Mode_Send_Quote_Email_Settings extends WC_Email_Inquiry_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'quotes-emails';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wc_email_inquiry_quote_send_quote_email_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_email_inquiry_quote_send_quote_email_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 3;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	public $template_html = 'emails/send-quote.php';
	public $template_plain = 'emails/plain/send-quote.php';
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Send Quote Email Settings successfully saved.', 'wc_email_inquiry' ),
				'error_message'		=> __( 'Error: Send Quote Email Settings can not save.', 'wc_email_inquiry' ),
				'reset_message'		=> __( 'Send Quote Email Settings successfully reseted.', 'wc_email_inquiry' ),
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
			'name'				=> 'send-quote',
			'label'				=> __( 'Send Quote', 'wc_email_inquiry' ),
			'callback_function'	=> 'wc_ei_quotes_mode_send_quote_email_settings_form',
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
            	'name' 		=> __( "Send Quote Email", 'wc_email_inquiry' ),
				'desc'		=> sprintf( __( "Manual Quote Rule auto creates the Quote Request as 'quote' order status. <a href='%s'>On any Order</a> with 'quote' status you can edit prices, shipping, tax, add a personalized customer note and email the completed quote to the customer. The email uses this template.", 'wc_email_inquiry' ), admin_url( 'edit.php?post_type=shop_order', 'relative' ) ),
				'id'		=> 'quote_send_quote_email_table',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Email Subject', 'wc_email_inquiry' ),
				'desc' 		=> __( "Defaults to <code>[default_value]</code>.", 'wc_email_inquiry' ),
				'id' 		=> 'email_subject',
				'type' 		=> 'text',
				'default'	=> __( 'Quote Request - Pricing', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Email Heading', 'wc_email_inquiry' ),
				'desc' 		=> __( "Defaults to <code>[default_value]</code>.", 'wc_email_inquiry' ),
				'id' 		=> 'email_heading',
				'type' 		=> 'text',
				'default'	=> __( 'Quote Request - Pricing', 'wc_email_inquiry' ),
			),
			array(  
				'name' 		=> __( 'Message Content', 'wc_email_inquiry' ),
				'id' 		=> 'quote_send_quote_email_description',
				'type' 		=> 'wp_editor',
				'desc_tip'	=> __( 'The message you create here is hard coded into the top of all Submit Quote Emails. It is your Quote introduction, explanation. Add a personalized order / customer note on the Send Quote function and it will show under this message and above the quote.', 'wc_email_inquiry' ),
				'textarea_rows'	=> 10,
				'default'	=> '',
				'separate_option'	=> true,
			),
			array(  
				'name' 		=> __( 'Email Type', 'wc_email_inquiry' ),
				'desc' 		=> __( "Choose which format of email to send", 'wc_email_inquiry' ),
				'class'		=> 'send_quote_email_type',
				'id' 		=> 'email_type',
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
					<div class="template send_quote_<?php echo $template; ?>">

						<h4><?php echo wp_kses_post( $title ); ?></h4>

						<?php if ( file_exists( $local_file ) ) : ?>

							<p>
								<a href="#" class="button send_quote_toggle_editor"></a>

								<?php if ( is_writable( $local_file ) ) : ?>
									<a href="<?php echo remove_query_arg( array( 'send_quote_move_template', 'saved' ), add_query_arg( 'send_quote_delete_template', $template ) ); ?>" class="send_quote_delete_template button"><?php _e( 'Delete template file', 'woocommerce' ); ?></a>
								<?php endif; ?>

								<?php printf( __( 'This template has been overridden by your theme and can be found in: <code>%s</code>.', 'woocommerce' ), 'yourtheme/woocommerce/' . $this->$template ); ?>
							</p>

							<div class="editor" style="display:none">

								<textarea class="code" cols="25" rows="4" <?php if ( ! is_writable( $local_file ) ) : ?>readonly="readonly" disabled="disabled"<?php else : ?>data-name="<?php echo $template . '_code'; ?>"<?php endif; ?>><?php echo file_get_contents( $local_file ); ?></textarea>

							</div>

						<?php elseif ( file_exists( $core_file ) ) : ?>

							<p>
								<a href="#" class="button send_quote_toggle_editor"></a>

								<?php if ( ( is_dir( get_stylesheet_directory() . '/woocommerce/emails/' ) && is_writable( get_stylesheet_directory() . '/woocommerce/emails/' ) ) || is_writable( get_stylesheet_directory() ) ) : ?>
									<a href="<?php echo remove_query_arg( array( 'send_quote_delete_template', 'saved' ), add_query_arg( 'send_quote_move_template', $template ) ); ?>" class="button"><?php _e( 'Copy file to theme', 'woocommerce' ); ?></a>
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
	$('.send_quote_template_plain, .send_quote_template_html').show();
	if ( $("input.send_quote_email_type:checked").val() != 'multipart' && $("input.send_quote_email_type:checked").val() != 'html' ) {
		$('.send_quote_template_html').hide();
	}
	
	if ( $("input.send_quote_email_type:checked").val() != 'multipart' && $("input.send_quote_email_type:checked").val() != 'plain' ) {
		$('.send_quote_template_plain').hide();
	}
	$(document).on( "a3rev-ui-onoff_radio-switch", '.send_quote_email_type', function( event, value, status ) {
		if ( value == 'multipart' && status == 'true' ) {
			$('.send_quote_template_plain, .send_quote_template_html').slideDown();
		} else if ( value == 'html' && status == 'true' ) {
			$('.send_quote_template_html').slideDown();
			$('.send_quote_template_plain').slideUp();
		}
		else if ( value == 'plain' && status == 'true' ) {
			$('.send_quote_template_plain').slideDown();
			$('.send_quote_template_html').slideUp();
		}
	});
				
				var view = '<?php echo esc_js( __( 'View template', 'woocommerce' ) ) ?>';
				var hide = '<?php echo esc_js( __( 'Hide template', 'woocommerce' ) ) ?>';

				$('a.send_quote_toggle_editor').text( view ).toggle( function() {
					$( this ).text( hide ).closest('.template').find('.editor').slideToggle();
					return false;
				}, function() {
					$( this ).text( view ).closest('.template').find('.editor').slideToggle();
					return false;
				} );

				$('a.send_quote_delete_template').click(function(){
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

global $wc_ei_quotes_mode_send_quote_email_settings;
$wc_ei_quotes_mode_send_quote_email_settings = new WC_EI_Quotes_Mode_Send_Quote_Email_Settings();

/** 
 * wc_ei_quotes_mode_send_quote_email_settings_form()
 * Define the callback function to show subtab content
 */
function wc_ei_quotes_mode_send_quote_email_settings_form() {
	global $wc_ei_quotes_mode_send_quote_email_settings;
	$wc_ei_quotes_mode_send_quote_email_settings->settings_form();
}

?>