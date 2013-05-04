<style>
<?php
// Email Inquiry Button Style
global $wc_email_inquiry_global_settings, $wc_email_inquiry_customize_email_button;
extract($wc_email_inquiry_global_settings);
extract($wc_email_inquiry_customize_email_button);
?>
@charset "UTF-8";
/* CSS Document */

/* Email Inquiry Button Style */
.wc_email_inquiry_button_container { 
<?php if ($inquiry_button_position == 'above') { ?>
	margin-bottom: <?php echo $inquiry_button_padding; ?>px !important;
<? } else { ?>
	margin-top: <?php echo $inquiry_button_padding; ?>px !important;
<?php } ?>
}
body .wc_email_inquiry_button_container .wc_email_inquiry_button {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
}
body .wc_email_inquiry_button_container .wc_email_inquiry_email_button {
	padding: 7px 10px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $inquiry_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $inquiry_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $inquiry_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $inquiry_button_bg_colour_from; ?> 20%,
					<?php echo $inquiry_button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	border: <?php echo $inquiry_button_border_size; ?> <?php echo $inquiry_button_border_style; ?> <?php echo $inquiry_button_border_colour; ?> !important;
<?php if ($inquiry_button_rounded_corner == 'rounded') { ?>
	-webkit-border-radius: <?php echo $inquiry_button_rounded_value; ?>px !important;
	-moz-border-radius: <?php echo $inquiry_button_rounded_value; ?>px !important;
	border-radius: <?php echo $inquiry_button_rounded_value; ?>px !important;
<?php } else { ?>
	-webkit-border-radius: 0px !important;
	-moz-border-radius: 0px !important;
	border-radius: 0px !important;
<?php } ?>
	
	/* Font */
	font-family: <?php echo $inquiry_button_font; ?> !important;
	font-size: <?php echo $inquiry_button_font_size; ?> !important;
	color: <?php echo $inquiry_button_font_colour; ?> !important;
<?php if ( stristr($inquiry_button_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($inquiry_button_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $inquiry_button_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}

<?php
// Email Inquiry Form Button Style
global $wc_email_inquiry_customize_email_popup;
extract($wc_email_inquiry_customize_email_popup);
?>

/* Email Inquiry Form Button Style */
body .wc_email_inquiry_form_button, .wc_email_inquiry_form_button {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
}
body .wc_email_inquiry_form_button, .wc_email_inquiry_form_button {
	padding: 7px 10px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $inquiry_contact_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $inquiry_contact_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $inquiry_contact_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $inquiry_contact_button_bg_colour_from; ?> 20%,
					<?php echo $inquiry_contact_button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	border: <?php echo $inquiry_contact_button_border_size; ?> <?php echo $inquiry_contact_button_border_style; ?> <?php echo $inquiry_contact_button_border_colour; ?> !important;
<?php if ($inquiry_contact_button_rounded_corner == 'rounded') { ?>
	-webkit-border-radius: <?php echo $inquiry_contact_button_rounded_value; ?>px !important;
	-moz-border-radius: <?php echo $inquiry_contact_button_rounded_value; ?>px !important;
	border-radius: <?php echo $inquiry_contact_button_rounded_value; ?>px !important;
<?php } else { ?>
	-webkit-border-radius: 0px !important;
	-moz-border-radius: 0px !important;
	border-radius: 0px !important;
<?php } ?>
	
	/* Font */
	font-family: <?php echo $inquiry_contact_button_font; ?> !important;
	font-size: <?php echo $inquiry_contact_button_font_size; ?> !important;
	color: <?php echo $inquiry_contact_button_font_colour; ?> !important;
<?php if ( stristr($inquiry_contact_button_font_style, 'bold') !== FALSE) { ?>
	font-weight: bold !important;
<?php } ?>
<?php if ( stristr($inquiry_contact_button_font_style, 'italic') !== FALSE) { ?>
	font-style:italic !important;
<?php } ?>
<?php if ( $inquiry_contact_button_font_style == 'normal') { ?>
	font-weight: normal !important;
	font-style: normal !important;
<?php } ?>
	
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}


/* Contact Form Heading */
h1.wc_email_inquiry_result_heading {
	color: <?php echo $inquiry_contact_button_bg_colour; ?> !important;
}
</style>