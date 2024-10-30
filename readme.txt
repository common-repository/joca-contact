=== Joca Contact ===
Contributors: jnetsolutions
Donate link: http://jocawp.com/joca-contact/
Tags: contact,form,contact form,light weight,light,quick,fast,small,optimized,email,email form
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Adds a contact form on your web site. Extremely light weight code (8 kb), fast/safe plugin with no jQuery, external domain library or settings page.

== Description ==

Joca Contact makes it easy to set up a contact form on your WordPress web site. Only install the plugin and then add the
shortcode <strong>[joca_contact]</strong> to any page where you want to add the contact form.

All email will automatically be sent to the email address of the WordPress Admin with the subject of the web site and
including an URL to the page where the form was submitted from. This means, no settings needed and still very easy to
use if you are administrating a big number of WordPress web sites.

Basic form check is integrated so no empty forms can be sent and visualized by background colors on the input fields.

Joca Contact is translation ready and currently available in English and Swedish.

Not tested on old WordPress versions, but we see no reason why it would not work on them so feel free to test it on any version you want.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/joca-contact` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the shortcode <strong>[joca_contact]</strong> at any place you want to use show the contact form


== Frequently Asked Questions ==

= Can I change the text in the contact form? =

Yes, just add or edit the translation files in the /languages/ folder below the theme folder.


= Can I change the style of the contact form? =

Yes, use your normal way to edit the CSS of your site. In many cases Joca Contact will automatically be styled to the
look of your web site if the theme is programmed that way.

Here is an example of CSS code to add to your normal CSS-file:<br><br>
.joca_contact_field { padding:5px; width:60%; min-width:240px; border:1px dotted #ccc; border-radius:10px; color:#000; }<br>
.joca_contact_field:focus { border:1px dotted #999; }<br>
.joca_contact_textarea { padding:5px; width:60%; min-width:240px; border:1px dotted #ccc; border-radius:10px; }<br>
.joca_contact_textarea:focus { border:1px dotted #999; }<br>
.joca_contact_submit { padding:5px; background:#65ccff; border:none; color:#fff; text-transform:uppercase; border-radius:3px; }<br>
.joca_contact_message_ok { color:green; }<br>
.joca_contact_message_error { color:red; }<br>


== Screenshots ==

1. An example of a Joca Contact form that is automatically styled from the web site theme.


== Changelog ==

= 1.0.2 =
* Basic form validation to see if input fields were filled in
* Submit button is now hidden when pressed

= 1.0.1 =
* We now hide the contact form after it is submitted, only showing the thank you message

= 1.0.0 =
* Initial release
