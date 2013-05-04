<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Customize Email Popup
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Customize_Email_Popup
{
	public static function get_settings_default() {
		$default_settings = array(
			'inquiry_popup_type'					=> 'prettyphoto',
			'inquiry_contact_heading'				=> '',
			
			'inquiry_contact_text_button'			=> __('SEND', 'wc_email_inquiry'),
			'inquiry_contact_button_bg_colour'		=> '#EE2B2B',
			'inquiry_contact_button_bg_colour_from'	=> '#FBCACA',
			'inquiry_contact_button_bg_colour_to'	=> '#EE2B2B',
			'inquiry_contact_button_border_size'	=> '1px',
			'inquiry_contact_button_border_style'	=> 'solid',
			'inquiry_contact_button_border_colour'	=> '#EE2B2B',
			'inquiry_contact_button_rounded_corner'	=> 'rounded',
			'inquiry_contact_button_rounded_value'	=> 3,
			
			'inquiry_contact_button_font'			=> '',
			'inquiry_contact_button_font_size'		=> '',
			'inquiry_contact_button_font_style'		=> 'bold',
			'inquiry_contact_button_font_colour'	=> '#FFFFFF',
			'inquiry_contact_button_class'			=> '',
			
			'inquiry_contact_form_class'			=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_customize_email_popup';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = WC_Email_Inquiry_Customize_Email_Popup::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		$free_default_settings = $default_settings;
		unset($free_default_settings['inquiry_popup_type']);
		unset($free_default_settings['inquiry_contact_heading']);
		unset($free_default_settings['inquiry_contact_text_button']);
		$customized_settings = array_merge($customized_settings, $free_default_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
			update_option('wc_email_inquiry_contact_success', __("Thanks for your inquiry - we'll be in touch with you as soon as possible!", "wc_email_inquiry") );
		} else {
			update_option($option_name, $customized_settings);
			$wc_email_inquiry_contact_success = get_option('wc_email_inquiry_contact_success');
			if ($wc_email_inquiry_contact_success === false) update_option('wc_email_inquiry_contact_success', __("Thanks for your inquiry - we'll be in touch with you as soon as possible!", "wc_email_inquiry") );
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_customize_email_popup;
		global $wc_email_inquiry_contact_success;
		$customized_settings = get_option('wc_email_inquiry_customize_email_popup');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = WC_Email_Inquiry_Customize_Email_Popup::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$wc_email_inquiry_customize_email_popup = $customized_settings;
		$wc_email_inquiry_contact_success = get_option('wc_email_inquiry_contact_success');
		if ($wc_email_inquiry_contact_success === false) $wc_email_inquiry_contact_success = __("Thanks for your inquiry - we'll be in touch with you as soon as possible!", "wc_email_inquiry");
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_customize_email_popup';
		if (isset($_REQUEST['bt_save_settings'])) {
			$customized_settings = $_REQUEST[$option_name];
						
			update_option($option_name, $customized_settings);
			
			update_option('wc_email_inquiry_contact_success', stripslashes($_REQUEST['wc_email_inquiry_contact_success']));
			WC_Email_Inquiry_Customize_Email_Popup::set_settings_default();
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Customize_Email_Popup::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = WC_Email_Inquiry_Customize_Email_Popup::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		$fonts = WC_Email_Inquiry_Functions::get_font();
		
		?>
        <h3><?php _e('Customize Email Pop-up', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
        	<tr>
				<th class="titledesc" scope="row"><label for="inquiry_popup_type"><?php _e('Email Popup Tool', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_popup_type" name="<?php echo $option_name; ?>[inquiry_popup_type]">
						<option selected="selected" value="prettyphoto"><?php _e('PrettyPhoto', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_popup_type, 'fb' ); ?> value="fb"><?php _e('Fancybox', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_popup_type, 'colorbox' ); ?> value="colorbox"><?php _e('ColorBox', 'wc_email_inquiry');?></option>
					</select> <span class="description"><?php _e('PrettyPhoto is WooCommerce default pop up tool. Some bespoke themes use Fancybox or ColorBox.', 'wc_email_inquiry');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_contact_heading"><?php _e( 'Header Title', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $inquiry_contact_heading ) ); ?>" name="<?php echo $option_name; ?>[inquiry_contact_heading]" id="inquiry_contact_heading" style="width:300px;"  /> <span class="description"><?php _e("&lt;empty&gt; and the form title will be the Button title", 'wc_email_inquiry');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_contact_text_button"><?php _e( 'Send Button Title', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $inquiry_contact_text_button ) ); ?>" name="<?php echo $option_name; ?>[inquiry_contact_text_button]" id="inquiry_contact_text_button" style="width:300px;"  /> <span class="description"><?php _e("&lt;empty&gt; for default SEND", 'wc_email_inquiry');?></span>
				</td>
			</tr>
		</table>
        
        <div class="pro_feature_fields">
        <table class="form-table">
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_bg_colour"><?php _e('Button Background Colour','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_bg_colour ) );?>" style="width:120px;" id="inquiry_contact_button_bg_colour" name="inquiry_contact_button_bg_colour" /> <span class="description"><?php _e('Button colour. Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_bg_colour']; ?></code></span>
					<div id="colorPickerDiv_inquiry_contact_button_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_bg_colour_from"><?php _e('Button BG Colour Gradient From','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_bg_colour_from ) );?>" style="width:120px;" id="inquiry_contact_button_bg_colour_from" name="inquiry_contact_button_bg_colour_from" /> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_bg_colour_from']; ?></code></span>
					<div id="colorPickerDiv_inquiry_contact_button_bg_colour_from" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_bg_colour_to"><?php _e('Button BG Colour Gradient To','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_bg_colour_to ) );?>" style="width:120px;" id="inquiry_contact_button_bg_colour_to" name="inquiry_contact_button_bg_colour_to" /> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_bg_colour_to']; ?></code></span>
					<div id="colorPickerDiv_inquiry_contact_button_bg_colour_to" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_border_size"><?php _e('Button Border Size','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_contact_button_border_size" name="inquiry_contact_button_border_size">
						<option value="" selected="selected"><?php _e('Select Size', 'wc_email_inquiry');?></option>
							<?php for( $i = 0 ; $i <= 10 ; $i++ ){ ?>
							<option value="<?php echo ($i); ?>px" <?php selected( $inquiry_contact_button_border_size, $i.'px' ); ?>><?php echo $i; ?>px</option>
							<?php } ?>                                  
					</select> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_border_size'] ?></code></span>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_contact_button_border_style"><?php _e('Button Border Style', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_contact_button_border_style" name="inquiry_contact_button_border_style">
						<option selected="selected" value="solid"><?php _e('Solid', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_border_style, 'double' ); ?> value="double"><?php _e('Double', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_border_style, 'dashed' ); ?> value="dashed"><?php _e('Dashed', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_border_style, 'dotted' ); ?> value="dotted"><?php _e('Dotted', 'wc_email_inquiry');?></option>
					</select> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php _e('Solid', 'wc_email_inquiry');?></code></span>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_border_colour"><?php _e('Button Border Colour','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_border_colour ) );?>" style="width:120px;" id="inquiry_contact_button_border_colour" name="inquiry_contact_button_border_colour" /> <span class="description"><?php _e('Border colour. Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_border_colour']; ?></code></span>
					<div id="colorPickerDiv_inquiry_contact_button_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_rounded_corner"><?php _e('Button Border Rounded','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
                    <label><input disabled="disabled" type="radio" name="inquiry_contact_button_rounded_corner" value="rounded" checked="checked" /> <?php _e('Rounded Corners','wc_email_inquiry'); ?></label> <span class="description">(<?php _e('Default', 'wc_email_inquiry');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><?php _e('Rounded Value','wc_email_inquiry'); ?></label> <input disabled="disabled" type="text" name="inquiry_contact_button_rounded_value" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_rounded_value) );?>" style="width:120px;" />px <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_rounded_value']; ?></code>px</span>
                    <br />
                    <label><input disabled="disabled" type="radio" name="inquiry_contact_button_rounded_corner" value="square" /> <?php _e('Square Corners','wc_email_inquiry'); ?></label>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_contact_button_font"><?php _e('Button Font', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_contact_button_font" name="inquiry_contact_button_font">
						<option value="" selected="selected"><?php _e('Select Font', 'wc_email_inquiry');?></option>
						<?php foreach($fonts as $key=>$value){ ?>
                        <option <?php selected( htmlspecialchars( $inquiry_contact_button_font ), htmlspecialchars($key) ); ?> value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option>
						<?php } ?>                                  
					</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wc_email_inquiry');?></span>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_contact_button_font_size"><?php _e('Button Font Size', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_contact_button_font_size" name="inquiry_contact_button_font_size">
						<option value="" selected="selected"><?php _e('Select Size', 'wc_email_inquiry');?></option>
                        <?php for( $i = 9 ; $i <= 40 ; $i++ ){ ?>
                        <option value="<?php echo ($i); ?>px" <?php selected( $inquiry_contact_button_font_size, $i.'px' ); ?>><?php echo $i; ?>px</option>
                        <?php } ?>                                  
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wc_email_inquiry');?></span>
                    </td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_contact_button_font_style"><?php _e('Button Font Style', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_contact_button_font_style" name="inquiry_contact_button_font_style">
						<option value="" selected="selected"><?php _e('Select Style', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_font_style, 'normal' ); ?> value="normal"><?php _e('Normal', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_font_style, 'italic' ); ?> value="italic"><?php _e('Italic', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_font_style, 'bold' ); ?> value="bold"><?php _e('Bold', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_contact_button_font_style, 'bold_italic' ); ?> value="bold_italic"><?php _e('Bold/Italic', 'wc_email_inquiry');?></option>
					</select> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php _e('Bold', 'wc_email_inquiry');?></code></span>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_contact_button_font_colour"><?php _e('Button Font Colour','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" name="inquiry_contact_button_font_colour" id="inquiry_contact_button_font_colour" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_contact_button_font_colour'] ?></code></span>
					<div id="colorPickerDiv_inquiry_contact_button_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_contact_button_class"><?php _e( 'Button CSS Class', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input  disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_contact_button_class ) ); ?>" name="inquiry_contact_button_class" id="inquiry_contact_button_class" style="width:300px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_contact_form_class"><?php _e( 'Form CSS Class', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_contact_form_class ) ); ?>" name="inquiry_contact_form_class" id="inquiry_contact_form_class" style="width:300px;"  />
				</td>
			</tr>
		</table>
        </div>
        
        <table class="form-table">
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="wc_email_inquiry_contact_success"><?php _e('Success Message','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<?php //wp_editor(get_option('wc_email_inquiry_contact_success'), 'wc_email_inquiry_contact_success', array('textarea_name' => 'wc_email_inquiry_contact_success', 'wpautop' => true, 'textarea_rows' => 15, 'tinymce' => array('plugins' => 'safari, inlinepopups, spellchecker, tabfocus, paste, media, fullscreen, wordpress, wpeditimage, wpgallery') ) ); ?>
					<?php wp_editor(get_option('wc_email_inquiry_contact_success'), 'wc_email_inquiry_contact_success', array('textarea_name' => 'wc_email_inquiry_contact_success', 'wpautop' => true, 'textarea_rows' => 15 ) ); ?>
					<span class="description"><?php _e('Message that user sees on page after form is submitted', 'wc_email_inquiry'); ?></span>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>