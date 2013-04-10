=== WooCommerce Email Inquiry & Cart Options ===
Contributors: a3rev, A3 Revolution Software Development team
Tags: WooCommerce, WooCommerce Email Inquiry, WooCommerce Catalog Visibility, WooCommerce add to cart, WooCommerce Brochure Page, WooCommerce product Emails
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Turn WooCommerce products into a brochure page. Give logged in users add to cart functionality. Add Email Inquiry pop-up form to any product.
  
== Description ==

WooCommerce Email Inquiry & Cart Options allows you to fine tune the e-commerce accessibility on your WooCommerce site by setting 'Rules' that apply to all site visitors. Fine tune access to the e-commerce function for logged in users by assigning the Rules to WordPress user roles, including the WooCommerce Customer and Store manager Roles. Add a beautifully elegant Email Inquiry button to your products pages with a space saving and impressive pop up email inquiry form. 

= Catalog Visibility Rules =

* Rule: Hide 'Add to Cart'
* Rule: Show Email Inquiry Button

=  Apply Rules to Roles =

Fine tune your entire Catalog visibility by
* 'Apply Rules to Roles' - Configure which user roles each Rule is to Apply too. Fine grained control over what your account holders can see and access once they are logged into your site.

= Email Inquiry =

WooCommerce Email Inquiry & Cart Options PRO uses the WordPress email config and requires no external email plugin. Features

* Add a Email Inquiry button to every product page.
* Email Inquiry form is a pop up form. its a beautifully elegant Email Product Inquiry solution that takes up no room on your product page.
* Use 'Rules and Roles' setting to customize who can see the Email Inquiry button once they are logged in.
* Set the receiver email address.
* Set a receiver cc email address 
* Fully customizable Sent success message shows as a pop-up on screen after inquiry is submitted.
* Use the WordPress text editor (WYSIWYG and HTML) to style the success message (see image under the Screenshots tab on this page). 

= WooCommerce V2.0 Compatible =

WooCommerce Email Inquiry & Cart Options is 100% WooCommerce V2.0 compatible with backward version compatibility. No matter if you have upgraded or not the plugin will be compatible with the WooCommerce version you are using.

= View Demo Site =

We have a demo site set up with an out of the box version of the Woothemes Canvas theme - [see it here](http://compare.a3rev.com/shop/plain-t-shirts). For more detailed explanation of all the backend working of the plugin visit the WooCommerce Widget Product Slideshow documents 
http://docs.a3rev.com/user-guides/woocommerce/woo-email-inquiry-cart-options/

= Support =

If you have any problem with setting up the Free lite version please post your support request here on the WordPress support forum. PLEASE if you have a problem DO NOT just give the plugin a bad star rating and review without first requesting support. Giving the plugin a bagging without affording us the opportunity to help solve the issue is in our opinion very unfair.

Once you have the plugin installed and activated please refer to the plugins [Comprehensive Online Documentation](http://docs.a3rev.com/user-guides/woocommerce/woo-email-inquiry-cart-options/) and guide to setting up the WooCommerce Email Inquiry & Cart Options plugin on your WooCommerce store. If you have questions - again please post them to the support forum here.

= Pro Version Upgrade =

This plugin has a Pro version upgrade available. You will see all of the available upgrade features on the widget admin panel. Those Pro features include:

* Hide Products Prices. The Pro Version includes the additional Rule: Hide Product Prices.
* Per Product Page Customization. Rules are applied Globally across your entire store. With the Pro Version you can customize those Global Rules settings for every individual product from the Product page Email and cart meta. Gives you tremendous flexibility in setting up a mixed 'add to cart' and product brochure store.
* WYSIWYG Email Inquiry button creator - allows you to style the button anyway you like without writing a line of code.
* WYSIWYG pop-up form creator allows you to style your email pop-up form without writing a line of code.
* Option to use hyperlinked text instead of a Button.
* Option to show the Email Inquiry Button or Hyperlink text on products store and category extracts as well as the product pages
* Option to allow the sender to send a copy of the form they are submitting to themselves.
* Option to set Email Sender Options - Set the email 'From Name' and 'From Email Address' 


= Localization =

* English (default) - always included.
* .po file (wc_email_inquiry.po) in languages folder for translations.
* If you do a translation for your site please send it to us for inclusion in the plugin language folder. We'll acknowledge your work here. [Go here](http://a3rev.com/contact/) to send your translation files to us.

= Plugin Resources =

[PRO Version](http://a3rev.com/shop/woocommerce-email-inquiry-and-cart-options/) |
[Documentation](http://docs.a3rev.com/user-guides/woocommerce/woo-email-inquiry-cart-options/)


== Installation ==

= Minimum Requirements =

* WordPress 3.4.1
* WooCommerce v2.0 and backwards.
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater
 
= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't even need to leave your web browser. To do an automatic install of WooCommerce Email Inquiry & Cart Options, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New. 

In the search field type "WooCommerce Email Inquiry & Cart Options" and click Search Plugins. Once you have found our plugin you can install it by simply clicking Install Now. After clicking that link you will be asked if you are sure you want to install the plugin. Click yes and WordPress will automatically complete the installation. 

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favorite FTP application.

1. Download the plugin file to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installations wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.


== Screenshots ==

1. Transform your WooCommerce store into a brochure site with email inquiry pop up for front end users. 
2. Set Rules that apply to all front end users and then select user Roles that the Rule is to apply to.
3. The on page Email pop-up form
4. The on page Email sent success message also shows in the pop up.
5. Use the WordPress text editor to fully customize your success message.
 
== Usage ==

1. Install and activate the plugin

2. Go to WooCommerce > Settings > Email & Cart tab

3. Select the global settings you require.

4. Scroll to the bottom and click save.
 
5. Have fun.

== Frequently Asked Questions ==

= When can I use this plugin? =

You can use this plugin only when you have installed the WooCommerce plugin.
 
 
== Changelog ==

= 1.0.2 - 2013/04/10 =
* Fixed: WooCommerce Reviews form opening in duplicate popup tools, PrettyPhoto and Fancybox caused by our old WooCommerce v1.6 fancybox lib.
* Fixed: Bug for users who have https: (SSL) on their sites wp-admin but have http on sites front end. This was causing a -1 to show when email pop-up form is called. wp-admin with SSL applied only allows https: but the url of admin-ajax.php is http: and it is denied hence returning the ajax -1 error. Fixed by writing a filter to recognize when https is configured on wp-admin and parsing correctly.

= 1.0.1 - 2013/03/14 =
* Fixed : Can't activate the plugin on some sites . The problem was in php configuration differences .It was caused by php configuration related to short <?php syntax which allows to use <? instead.

= 1.0.0 - 2013/03/07 =
* First working release 