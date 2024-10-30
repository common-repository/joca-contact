<?php
/**
 * Plugin Name: Joca Contact
 * Plugin URI: http://www.jocawp.com/joca-contact/
 * Description: Adds a contact form on your web site where the short code <strong>[joca_contact]</strong> is put. Emails will automatically be sent to the site admin email address. Extremely light weight (8 kb), fast/safe plugin with no jQuery, external domain library or settings page.
 * Version: 1.0.2
 * Author: Joca
 * Author URI: http://www.jocawp.com
 * Text Domain: joca-contact
 * Domain Path: /languages/
 */

// Security: Exit if accessed directly
if (!defined('ABSPATH')) exit;

function joca_contact_load_plugin_textdomain() {
    $loaded = load_plugin_textdomain( 'joca-contact', FALSE, basename(dirname(__FILE__)).'/languages/');
}
add_action( 'plugins_loaded', 'joca_contact_load_plugin_textdomain' );

function joca_contact_start() {
    if (current_user_can('manage_options')==true && is_admin()) {
        // Add links to plugin page
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'joca_contact_add_action_links');
        function joca_contact_add_action_links ( $links ) {
            $mylinks = array(
            '<a href="http://www.jocawp.com" target="_blank">Joca Plugins</a>',
            '<a href="http://www.jocawp.com/joca-contact/#pro" target="_blank">Get Pro</a>'
            );
            return array_merge( $links, $mylinks );
        }
    } elseif (!is_admin()) {
        require_once dirname(__FILE__) . '/public.php';
    }
}
add_action ('init', 'joca_contact_start');
?>
