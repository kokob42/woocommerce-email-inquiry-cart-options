<?php
/**
 * WPEC PCF MetaBox
 *
 * Table Of Contents
 *
 * add_meta_boxes()
 * the_meta_forms()
 * save_meta_boxes()
 */
class WC_Email_Inquiry_MetaBox{
	
	function add_meta_boxes(){
		global $post;
		$pagename = 'product';
		add_meta_box( 'wc_email_inquiry_meta', __('Email & Cart', 'wc_email_inquiry'), array('WC_Email_Inquiry_MetaBox', 'the_meta_forms'), $pagename, 'normal', 'high' );
	}
	
	function the_meta_forms() {
		global $post;
		add_action('admin_footer', array('WC_Email_Inquiry_Settings', 'add_scripts'), 10);
		global $wp_roles;
		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		$roles = $wp_roles->get_names();
		
		$wc_email_inquiry_hide_addcartbt = esc_attr(get_option('wc_email_inquiry_hide_addcartbt'));
		
		$wc_email_inquiry_show_button = esc_attr(get_option('wc_email_inquiry_show_button'));
				
		$role_apply_hide_cart = (array) get_option('wc_email_inquiry_role_apply_hide_cart');
		$role_apply_show_inquiry_button = (array) get_option('wc_email_inquiry_role_apply_show_inquiry_button');
				
		$wc_email_inquiry_email_to = esc_attr(get_option('wc_email_inquiry_email_to'));
		
		$wc_email_inquiry_email_cc = esc_attr(get_option('wc_email_inquiry_email_cc'));
		
		$wc_email_inquiry_button_title = esc_attr(get_option('wc_email_inquiry_button_title'));
		
		?>
        <style>
			#wc_email_inquiry_upgrade_area_box { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:10px; position:relative}
			#wc_email_inquiry_upgrade_area_box legend {margin-left:4px; font-weight:bold;}
		</style>
        <fieldset id="wc_email_inquiry_upgrade_area_box"><legend><?php _e('Upgrade to','wc_email_inquiry'); ?> <a href="<?php echo WC_EMAIL_AUTHOR_URI; ?>" target="_blank"><?php _e('Pro Version', 'woops'); ?></a> <?php _e('to activate', 'wc_email_inquiry'); ?></legend>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_reset_product_options"><?php _e('Reset Product Options','wc_email_inquiry'); ?></label></th>
                    <td class="forminp">
                        <fieldset><label for="wc_email_inquiry_reset_product_options"><input disabled="disabled" type="checkbox" value="1" id="wc_email_inquiry_reset_product_options" name="wc_email_inquiry_reset_product_options" /> <?php _e('Check to reset this product setting to the Global Settings', 'wc_email_inquiry'); ?></label></fieldset>
                    </td>
                </tr>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw" colspan="2"><strong><?php _e('Customize setting for this product', 'wc_email_inquiry'); ?></strong></th>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_hide_addcartbt"><?php _e("Rule: Hide 'Add to Cart'",'wc_email_inquiry'); ?></label></th>
                    <td class="forminp"><input disabled="disabled" type="checkbox" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_hide_addcartbt]" id="wc_email_inquiry_hide_addcartbt" value="yes" <?php if ($wc_email_inquiry_hide_addcartbt == 'yes') echo 'checked="checked"'; ?> /> <?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry'); ?>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="role_apply_hide_cart"><?php _e('Apply Rule to logged in roles','wc_email_inquiry'); ?></label></th>
                    <td class="forminp">
                    	<select multiple="multiple" id="role_apply_hide_cart" name="_wc_email_inquiry_settings_custom[role_apply_hide_cart][]" data-placeholder="<?php _e( 'Choose Roles', 'wc_email_inquiry' ); ?>" style="display:none; width:300px;" class="chzn-select">
						<?php
                        foreach ($roles as $key => $val) {
                        ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( in_array($key, $role_apply_hide_cart), true ); ?>><?php echo $val ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_show_button"><?php _e('Rule: Show Email Inquiry Button','wc_email_inquiry'); ?></label></th>
                    <td class="forminp">
                    <input disabled="disabled" type="checkbox" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_show_button]" id="wc_email_inquiry_show_button" value="yes" <?php if ($wc_email_inquiry_show_button == 'yes') echo 'checked="checked"'; ?> /> <?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry'); ?>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="role_apply_show_inquiry_button"><?php _e('Apply Rule to logged in roles','wc_email_inquiry'); ?></label></th>
                    <td class="forminp">
                    	<select multiple="multiple" id="role_apply_show_inquiry_button" name="_wc_email_inquiry_settings_custom[role_apply_show_inquiry_button][]" data-placeholder="<?php _e( 'Choose Roles', 'wc_email_inquiry' ); ?>" style="display:none; width:300px;" class="chzn-select">
						<?php
                        foreach ($roles as $key => $val) {
                        ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( in_array($key, $role_apply_show_inquiry_button), true ); ?>><?php echo $val ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_hide_price"><?php _e("Rule: Hide Price",'wc_email_inquiry'); ?></label></th>
                    <td class="forminp"><input disabled="disabled" type="checkbox" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_hide_price]" id="wc_email_inquiry_hide_price" value="yes" /> <?php _e('Yes. Applies to all users who are not logged in.', 'wc_email_inquiry'); ?>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="role_apply_hide_price"><?php _e('Apply Rule to logged in roles','wc_email_inquiry'); ?></label></th>
                    <td class="forminp">
                    	<select multiple="multiple" id="role_apply_hide_price" name="_wc_email_inquiry_settings_custom[role_apply_hide_price][]" data-placeholder="<?php _e( 'Choose Roles', 'wc_email_inquiry' ); ?>" style="display:none; width:300px;" class="chzn-select">
						<?php
                        foreach ($roles as $key => $val) {
                        ?>
                            <option value="<?php echo esc_attr( $key ); ?>"><?php echo $val ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_email_to"><?php _e('Inquiry Email goes to','wc_email_inquiry'); ?></label></th>
                    <td class="forminp"><input disabled="disabled" type="text" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_email_to]" id="wc_email_inquiry_email_to" value="<?php echo $wc_email_inquiry_email_to;?>" style="min-width:300px" /> 
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_email_cc"><?php _e('Copy to','wc_email_inquiry'); ?></label></th>
                    <td class="forminp"><input disabled="disabled" type="text" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_email_cc]" id="wc_email_inquiry_email_cc" value="<?php echo $wc_email_inquiry_email_cc;?>" style="min-width:300px" /> 
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Button or Hyperlink Text','wc_email_inquiry'); ?></label></th>
                    <td class="forminp">
                    <input disabled="disabled" type="radio" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_button_type]" id="wc_email_inquiry_button" class="wc_email_inquiry_button_type" value="" checked="checked" /> <label for="wc_email_inquiry_button"><?php _e('Button', 'wc_email_inquiry'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input disabled="disabled" type="radio" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_button_type]" id="wc_email_inquiry_link" class="wc_email_inquiry_button_type" value="link" /> <label for="wc_email_inquiry_link"><?php _e('Link', 'wc_email_inquiry'); ?></label>
                    </td>
               	</tr>
                <tr valign="top" class="button_type_button">
                    <th class="titledesc" scope="rpw"><label for="wc_email_inquiry_button_title"><?php _e('Button Title','wc_email_inquiry'); ?></label></th>
                    <td class="forminp"><input disabled="disabled" type="text" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_button_title]" id="wc_email_inquiry_button_title" value="<?php echo $wc_email_inquiry_button_title;?>" style="min-width:300px" /> 
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Single Product Page only','wc_email_inquiry'); ?></label></th>
                    <td class="forminp"><input disabled="disabled" type="radio" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_single_only]" id="wc_email_inquiry_single_only_yes" value="yes" checked="checked" /> <label for="wc_email_inquiry_single_only_yes"><?php _e('Yes', 'wc_email_inquiry'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input disabled="disabled" type="radio" name="_wc_email_inquiry_settings_custom[wc_email_inquiry_single_only]" id="wc_email_inquiry_single_only_no" value="" /> <label for="wc_email_inquiry_single_only_no"><?php _e('No', 'wc_email_inquiry'); ?></label>
                    </td>
               	</tr>
			</tbody>
		</table>
        </fieldset>
		<?php
	}
}
?>