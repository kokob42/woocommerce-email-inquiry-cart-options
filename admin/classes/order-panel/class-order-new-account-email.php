<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Order New Account Email Settings
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Order_New_Account_Email_Settings
{
	public static $template_html = 'emails/order-new-account.php';
	public static $template_plain = 'emails/plain/order-new-account.php';
	
	public static function get_settings_default() {
		$default_settings = array(
			'order_new_account_role'				=> 'customer',
			'order_new_account_email_subject'		=> __('Your account on {blogname}', 'wc_email_inquiry'),
			'order_new_account_email_heading'		=> __('Welcome to {blogname}', 'wc_email_inquiry'),
			'order_new_account_email_type'			=> 'html',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_order_new_account_email_settings';
		
		$default_settings = WC_Email_Inquiry_Order_New_Account_Email_Settings::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
			update_option('wc_email_inquiry_order_new_account_email_content', __('<p>Hello {first_name},</p><p>Your login link and credentials are:</p><p>{account_url}</p><p>Username: {username}<br />Password: {password}</p><p>Please login and change the WordPress generated password to something you can remember.</p>', 'wc_email_inquiry') );
		} else {
			update_option($option_name, $default_settings);
			update_option('wc_email_inquiry_order_new_account_email_content', __('<p>Hello {first_name},</p><p>Your login link and credentials are:</p><p>{account_url}</p><p>Username: {username}<br />Password: {password}</p><p>Please login and change the WordPress generated password to something you can remember.</p>', 'wc_email_inquiry') );
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_order_new_account_email_settings;
		global $wc_email_inquiry_order_new_account_email_content;
		$wc_email_inquiry_order_new_account_email_settings = WC_Email_Inquiry_Order_New_Account_Email_Settings::get_settings_default();
		
		$wc_email_inquiry_order_new_account_email_content = get_option('wc_email_inquiry_order_new_account_email_content');
		if ($wc_email_inquiry_order_new_account_email_content === false) $wc_email_inquiry_order_new_account_email_content = '';
		
		return $wc_email_inquiry_order_new_account_email_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_order_new_account_email_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_Order_New_Account_Email_Settings::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Order_New_Account_Email_Settings::set_settings_default(true);
		}
				
		$customized_settings = $default_settings = WC_Email_Inquiry_Order_New_Account_Email_Settings::get_settings_default();
		
		extract($customized_settings);
		
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();
				
		?>
        <h3><?php _e("'Pending Order' Email", 'wc_email_inquiry'); ?></h3>
        <p><?php printf( __("When the order is submitted a WooCommerce 'Pending Order' email is auto sent to the customer. Customize that template on <a href='%s'>WooCommerce Emails</a>.", 'wc_email_inquiry'), admin_url( 'admin.php?page=woocommerce_settings&tab=email&section=WC_Email_Inquiry_Customer_Pending_Order' ) ); ?></p>
        
        <h3><?php _e('New Account Role', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_new_account_role"><?php _e( 'Set Role for New Acccount', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" name="<?php echo $option_name; ?>[order_new_account_role]" id="order_new_account_role" style="width:120px;">
                        <?php foreach ($roles as $key => $val) { ?>
                    	<?php if ( in_array( $key, array('manual_quote', 'auto_quote') ) ) continue; ?>
                        <option value="<?php echo $key; ?>" <?php selected( $key, $order_new_account_role ); ?>><?php esc_attr_e( stripslashes( $val) ); ?></option>
                    <?php } ?>
                    </select>
				</td>
			</tr>
		</table>
        
		<h3><?php _e('New User Account Email', 'wc_email_inquiry'); ?></h3>
        <p><?php _e("A new user account is created (if none exists) when a order request is submitted. Customize the New user account notification email that is auto sent to the user.", 'wc_email_inquiry'); ?></p>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="order_new_account_email_subject"><?php _e( 'Email Subject', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $order_new_account_email_subject ) ); ?>" name="<?php echo $option_name; ?>[order_new_account_email_subject]" id="order_new_account_email_subject" style="width:300px;"  /> <div class="description"><?php echo sprintf( __( 'Defaults to <code>%s</code>.', 'wc_email_inquiry' ), $default_settings['order_new_account_email_subject'] );?></div>
				</td>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="order_new_account_email_heading"><?php _e('Email Heading','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" value="<?php esc_attr_e( stripslashes( $order_new_account_email_heading ) ); ?>" name="<?php echo $option_name; ?>[order_new_account_email_heading]" id="order_new_account_email_heading" style="width:300px;"  /> <div class="description"><?php echo sprintf( __( 'Defaults to <code>%s</code>.', 'wc_email_inquiry' ), $default_settings['order_new_account_email_heading'] );?></div>
				</td>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="wc_email_inquiry_order_new_account_email_content"><?php _e('Email Content','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<?php wp_editor(get_option('wc_email_inquiry_order_new_account_email_content'), 'wc_email_inquiry_order_new_account_email_content', array('textarea_name' => 'wc_email_inquiry_order_new_account_email_content', 'wpautop' => true, 'textarea_rows' => 2 ) ); ?>
				</td>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="order_new_account_email_type"><?php _e('Email Type','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<select class="email_type" name="<?php echo $option_name; ?>[order_new_account_email_type]" id="order_new_account_email_type" style="width:120px;">
                        <option value="plain" <?php selected( $order_new_account_email_type, 'plain' ); ?>><?php _e( 'Plain text', 'wc_email_inquiry' ); ?></option>
                        <option value="html" <?php selected( $order_new_account_email_type, 'html' ); ?>><?php _e( 'HTML', 'wc_email_inquiry' ); ?></option>
                        <option value="multipart" <?php selected( $order_new_account_email_type, 'multipart' ); ?>><?php _e( 'Multipart', 'wc_email_inquiry' ); ?></option>
                    </select> <div class="description"><?php _e( 'Choose which format of email to send.', 'wc_email_inquiry' );?></div>
				</td>
			</tr>
		</table>
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
					if ( empty( WC_Email_Inquiry_Order_New_Account_Email_Settings::$$template ) )
						continue;

					$local_file = get_stylesheet_directory() . '/woocommerce/' . WC_Email_Inquiry_Order_New_Account_Email_Settings::$$template;
					$core_file 	= WC_EMAIL_INQUIRY_TEMPLATE_PATH . '/' . WC_Email_Inquiry_Order_New_Account_Email_Settings::$$template;
					?>
					<div class="template <?php echo $template; ?>">

						<h4><?php echo wp_kses_post( $title ); ?></h4>

						<?php if ( file_exists( $local_file ) ) : ?>

							<p>
								<a href="#" class="button toggle_editor"></a>

								<?php if ( is_writable( $local_file ) ) : ?>
									<a href="<?php echo remove_query_arg( array( 'move_template', 'saved' ), add_query_arg( 'delete_template', $template ) ); ?>" class="delete_template button"><?php _e( 'Delete template file', 'woocommerce' ); ?></a>
								<?php endif; ?>

								<?php printf( __( 'This template has been overridden by your theme and can be found in: <code>%s</code>.', 'woocommerce' ), 'yourtheme/woocommerce/' . WC_Email_Inquiry_Order_New_Account_Email_Settings::$$template ); ?>
							</p>

							<div class="editor" style="display:none">

								<textarea class="code" cols="25" rows="20" <?php if ( ! is_writable( $local_file ) ) : ?>readonly="readonly" disabled="disabled"<?php else : ?>data-name="<?php echo $template . '_code'; ?>"<?php endif; ?>><?php echo file_get_contents( $local_file ); ?></textarea>

							</div>

						<?php elseif ( file_exists( $core_file ) ) : ?>

							<p>
								<a href="#" class="button toggle_editor"></a>

								<?php if ( ( is_dir( get_stylesheet_directory() . '/woocommerce/emails/' ) && is_writable( get_stylesheet_directory() . '/woocommerce/emails/' ) ) || is_writable( get_stylesheet_directory() ) ) : ?>
									<a href="<?php echo remove_query_arg( array( 'delete_template', 'saved' ), add_query_arg( 'move_template', $template ) ); ?>" class="button"><?php _e( 'Copy file to theme', 'woocommerce' ); ?></a>
								<?php endif; ?>

								<?php printf( __( 'To override and edit this email template copy <code>%s</code> to your theme folder: <code>%s</code>.', 'woocommerce' ), plugin_basename( $core_file ) , 'yourtheme/woocommerce/' . WC_Email_Inquiry_Order_New_Account_Email_Settings::$$template ); ?>
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
			jQuery(function(){
				jQuery('select.email_type').change(function(){

					var val = jQuery( this ).val();

					jQuery('.template_plain, .template_html').show();

					if ( val != 'multipart' && val != 'html' )
						jQuery('.template_html').hide();

					if ( val != 'multipart' && val != 'plain' )
						jQuery('.template_plain').hide();

				}).change();

				var view = '<?php echo esc_js( __( 'View template', 'woocommerce' ) ) ?>';
				var hide = '<?php echo esc_js( __( 'Hide template', 'woocommerce' ) ) ?>';

				jQuery('a.toggle_editor').text( view ).toggle( function() {
					jQuery( this ).text( hide ).closest('.template').find('.editor').slideToggle();
					return false;
				}, function() {
					jQuery( this ).text( view ).closest('.template').find('.editor').slideToggle();
					return false;
				} );

				jQuery('a.delete_template').click(function(){
					var answer = confirm('<?php echo esc_js( __( 'Are you sure you want to delete this template file?', 'woocommerce' ) ) ?>');

					if (answer)
						return true;

					return false;
				});

				jQuery('.editor textarea').change(function(){
					var name = jQuery(this).attr( 'data-name' );

					if ( name )
						jQuery(this).attr( 'name', name );
				});
			});
			</script>
		<?php
	}
}
?>