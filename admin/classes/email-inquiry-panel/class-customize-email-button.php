<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Email Inquiry Customize Email Button
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class WC_Email_Inquiry_Customize_Email_Button
{
	public static function get_settings_default() {
		$default_settings = array(
			'inquiry_text_before'					=> '',
			'inquiry_hyperlink_text'				=> __('Click Here', 'wc_email_inquiry'),
			'inquiry_trailing_text'					=> '',
			
			'inquiry_button_title'					=> __('Product Enquiry', 'wc_email_inquiry'),
			'inquiry_button_bg_colour'				=> '#EE2B2B',
			'inquiry_button_bg_colour_from'			=> '#FBCACA',
			'inquiry_button_bg_colour_to'			=> '#EE2B2B',
			'inquiry_button_border_size'			=> '1px',
			'inquiry_button_border_style'			=> 'solid',
			'inquiry_button_border_colour'			=> '#EE2B2B',
			'inquiry_button_rounded_corner'			=> 'rounded',
			'inquiry_button_rounded_value'			=> 3,
			
			'inquiry_button_font'					=> '',
			'inquiry_button_font_size'				=> '',
			'inquiry_button_font_style'				=> 'bold',
			'inquiry_button_font_colour'			=> '#FFFFFF',
			'inquiry_button_class'					=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'wc_email_inquiry_customize_email_button';		
		$default_settings = WC_Email_Inquiry_Customize_Email_Button::get_settings_default();
	
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $wc_email_inquiry_customize_email_button;
		$wc_email_inquiry_customize_email_button = WC_Email_Inquiry_Customize_Email_Button::get_settings_default();
		
		return $wc_email_inquiry_customize_email_button;
	}
	
	public static function panel_page() {
		$option_name = 'wc_email_inquiry_customize_email_button';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Email_Inquiry_Customize_Email_Button::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Email_Inquiry_Customize_Email_Button::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = WC_Email_Inquiry_Customize_Email_Button::get_settings_default();
		
		extract($customized_settings);
		
		$fonts = WC_Email_Inquiry_Functions::get_font();
		
		?>
        <h3><?php _e('Customize Hyperlink text', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_text_before"><?php _e( 'Text before', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_text_before ) ); ?>" name="<?php echo $option_name; ?>[inquiry_text_before]" id="inquiry_text_before" style="width:300px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_hyperlink_text"><?php _e( 'Hyperlink text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_hyperlink_text ) ); ?>" name="<?php echo $option_name; ?>[inquiry_hyperlink_text]" id="inquiry_hyperlink_text" style="width:300px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_trailing_text"><?php _e( 'Trailing text', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_trailing_text ) ); ?>" name="<?php echo $option_name; ?>[inquiry_trailing_text]" id="inquiry_trailing_text" style="width:300px;"  />
				</td>
			</tr>
		</table>
        
        <h3><?php _e('Customize Email Inquiry Button', 'wc_email_inquiry'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_title"><?php _e( 'Button Title', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_button_title ) ); ?>" name="<?php echo $option_name; ?>[inquiry_button_title]" id="inquiry_button_title" style="width:120px;"  /> <span class="description"><?php _e("&lt;empty&gt; for default 'Product Enquiry' or enter text", 'wc_email_inquiry');?></span>
				</td>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_bg_colour"><?php _e('Button Background Colour','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_button_bg_colour ) );?>" style="width:120px;" id="inquiry_button_bg_colour" name="<?php echo $option_name; ?>[inquiry_button_bg_colour]" /> <span class="description"><?php _e('Button colour. Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_bg_colour']; ?></code></span>
					<div id="colorPickerDiv_inquiry_button_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_bg_colour_from"><?php _e('Button BG Colour Gradient From','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_button_bg_colour_from ) );?>" style="width:120px;" id="inquiry_button_bg_colour_from" name="<?php echo $option_name; ?>[inquiry_button_bg_colour_from]" /> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_bg_colour_from']; ?></code></span>
					<div id="colorPickerDiv_inquiry_button_bg_colour_from" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_bg_colour_to"><?php _e('Button BG Colour Gradient To','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_button_bg_colour_to ) );?>" style="width:120px;" id="inquiry_button_bg_colour_to" name="<?php echo $option_name; ?>[inquiry_button_bg_colour_to]" /> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_bg_colour_to']; ?></code></span>
					<div id="colorPickerDiv_inquiry_button_bg_colour_to" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_border_size"><?php _e('Button Border Size','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_button_border_size" name="<?php echo $option_name; ?>[inquiry_button_border_size]">
						<option value="" selected="selected"><?php _e('Select Size', 'wc_email_inquiry');?></option>
							<?php for( $i = 0 ; $i <= 10 ; $i++ ){ ?>
							<option value="<?php echo ($i); ?>px" <?php selected( $inquiry_button_border_size, $i.'px' ); ?>><?php echo $i; ?>px</option>
							<?php } ?>                                  
					</select> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_border_size'] ?></code></span>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_button_border_style"><?php _e('Button Border Style', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_button_border_style" name="<?php echo $option_name; ?>[inquiry_button_border_style]">
						<option selected="selected" value="solid"><?php _e('Solid', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_border_style, 'double' ); ?> value="double"><?php _e('Double', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_border_style, 'dashed' ); ?> value="dashed"><?php _e('Dashed', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_border_style, 'dotted' ); ?> value="dotted"><?php _e('Dotted', 'wc_email_inquiry');?></option>
					</select> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php _e('Solid', 'wc_email_inquiry');?></code></span>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_border_colour"><?php _e('Button Border Colour','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $inquiry_button_border_colour ) );?>" style="width:120px;" id="inquiry_button_border_colour" name="<?php echo $option_name; ?>[inquiry_button_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_border_colour']; ?></code></span>
					<div id="colorPickerDiv_inquiry_button_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_rounded_corner"><?php _e('Button Border Rounded','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[inquiry_button_rounded_corner]" value="rounded" checked="checked" /> <?php _e('Rounded Corners','wc_email_inquiry'); ?></label> <span class="description">(<?php _e('Default', 'wc_email_inquiry');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><?php _e('Rounded Value','wc_email_inquiry'); ?></label> <input disabled="disabled" type="text" name="<?php echo $option_name; ?>[inquiry_button_rounded_value]" value="<?php esc_attr_e( stripslashes( $inquiry_button_rounded_value) );?>" style="width:120px;" />px <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_rounded_value']; ?></code>px</span>
                    <br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[inquiry_button_rounded_corner]" value="square" /> <?php _e('Square Corners','wc_email_inquiry'); ?></label>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_button_font"><?php _e('Button Font', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_button_font" name="<?php echo $option_name; ?>[inquiry_button_font]">
						<option value="" selected="selected"><?php _e('Select Font', 'wc_email_inquiry');?></option>
						<?php foreach($fonts as $key=>$value){ ?>
                        <option <?php selected( htmlspecialchars( $inquiry_button_font ), htmlspecialchars($key) ); ?> value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option>
						<?php } ?>                                  
					</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wc_email_inquiry');?></span>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_button_font_size"><?php _e('Button Font Size', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_button_font_size" name="<?php echo $option_name; ?>[inquiry_button_font_size]">
						<option value="" selected="selected"><?php _e('Select Size', 'wc_email_inquiry');?></option>
                        <?php for( $i = 9 ; $i <= 40 ; $i++ ){ ?>
                        <option value="<?php echo ($i); ?>px" <?php selected( $inquiry_button_font_size, $i.'px' ); ?>><?php echo $i; ?>px</option>
                        <?php } ?>                                  
					</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'wc_email_inquiry');?></span>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="inquiry_button_font_style"><?php _e('Button Font Style', 'wc_email_inquiry');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="inquiry_button_font_style" name="<?php echo $option_name; ?>[inquiry_button_font_style]">
						<option value="" selected="selected"><?php _e('Select Style', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_font_style, 'normal' ); ?> value="normal"><?php _e('Normal', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_font_style, 'italic' ); ?> value="italic"><?php _e('Italic', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_font_style, 'bold' ); ?> value="bold"><?php _e('Bold', 'wc_email_inquiry');?></option>
						<option <?php selected( $inquiry_button_font_style, 'bold_italic' ); ?> value="bold_italic"><?php _e('Bold/Italic', 'wc_email_inquiry');?></option>
					</select> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php _e('Bold', 'wc_email_inquiry');?></code></span>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="inquiry_button_font_colour"><?php _e('Button Font Colour','wc_email_inquiry'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" name="<?php echo $option_name; ?>[inquiry_button_font_colour]" id="inquiry_button_font_colour" value="<?php esc_attr_e( stripslashes( $inquiry_button_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'wc_email_inquiry');?> <code><?php echo $default_settings['inquiry_button_font_colour'] ?></code></span>
					<div id="colorPickerDiv_inquiry_button_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="inquiry_button_class"><?php _e( 'Button CSS Class', 'wc_email_inquiry' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $inquiry_button_class ) ); ?>" name="<?php echo $option_name; ?>[inquiry_button_class]" id="inquiry_button_class" style="width:300px;"  />
				</td>
			</tr>
		</table>
	<?php
	}
}
?>