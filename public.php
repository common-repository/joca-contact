<?php
// Public functionality

// Security: Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Enable shortcode in widgets
if ( !is_admin() ){
    add_filter('widget_text', 'do_shortcode', 11);
}

if (!isset($GLOBALS["joca_contact_was_sent"])) {
  $GLOBALS["joca_contact_was_sent"]=False;
  $GLOBALS["joca_contact_had_error"]=False;
}

function html_form_code() {
    echo '<form name="joca_contact_form" id="joca_contact_form" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo __("Your Name", 'joca-contact') . ' <font style="opacity:0.5;">' . __("(required)", 'joca-contact') . '</font><br />';
    echo '<input type="text" name="joca_contact_name" value="' . ( isset( $_POST["joca_contact_name"] ) ? esc_attr( $_POST["joca_contact_name"] ) : '' ) . '" class="joca_contact_field joca_contact_field_name" style="max-width:100%;" size="40" onblur="joca_contact_form_changed(this);" />';
    echo '</p>';
    echo '<p>';
    echo __("Your Email", 'joca-contact') . ' <font style="opacity:0.5;">' . __("(required)", 'joca-contact') . '</font><br />';
    echo '<input type="email" name="joca_contact_email" value="' . ( isset( $_POST["joca_contact_email"] ) ? esc_attr( $_POST["joca_contact_email"] ) : '' ) . '" class="joca_contact_field joca_contact_field_email" style="max-width:100%;" size="40" onblur="joca_contact_form_changed(this);" />';
    echo '</p>';
    echo '<p>';
    echo __("Your Phone Number", 'joca-contact') . '<br />';
    echo '<input type="text" name="joca_contact_phone" value="' . ( isset( $_POST["joca_contact_phone"] ) ? esc_attr( $_POST["joca_contact_phone"] ) : '' ) . '" class="joca_contact_field joca_contact_field_phone" style="max-width:100%;" size="40" onblur="joca_contact_form_changed(this);" />';
    echo '</p>';
    echo '<p>';
    echo __("Your Message", 'joca-contact') . ' <font style="opacity:0.5;">' . __("(required)", 'joca-contact') . '</font><br />';
    echo '<textarea rows="10" cols="35" name="joca_contact_message" class="joca_contact_textarea" style="max-width:100%;" onblur="joca_contact_form_changed(this);">' . ( isset( $_POST["joca_contact_message"] ) ? esc_attr( $_POST["joca_contact_message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><span id="joca_contact_area_info"></span></p>';
    echo '<p><span id="joca_contact_area_button"><input type="submit" name="joca_contact_submit" value="' . __("Send message", 'joca-contact') . '" class="joca_contact_submit" /></span></p>';
    echo '</form>';
    echo '<script type="text/javascript">';
    echo 'var jocaContactForm=document.getElementById(\'joca_contact_form\');';
    echo 'jocaContactForm.addEventListener(\'submit\',function(event) {';
    echo '  joca_contact_send=true;';
    echo '  if (jocaContactForm.joca_contact_name.value.length<3) { jocaContactForm.joca_contact_name.style=\'max-width:100% !important;background-color:#ffcccc !important;\'; joca_contact_send=false; }';
    echo '  if (jocaContactForm.joca_contact_email.value.indexOf("@")<1 | jocaContactForm.joca_contact_email.value.indexOf(\'.\')<1) { jocaContactForm.joca_contact_email.style=\'max-width:100% !important;background-color:#ffcccc !important;\'; joca_contact_send=false; }';
    echo '  if (jocaContactForm.joca_contact_message.value.length<4) { jocaContactForm.joca_contact_message.style=\'max-width:100% !important;background-color:#ffcccc !important;\'; joca_contact_send=false; }';
    echo '  if (joca_contact_send!=true) { event.preventDefault(); document.getElementById(\'joca_contact_area_info\').innerHTML=\'' . __("Form not filled in correctly. Please check your input above.", 'joca-contact') . '\'; jocaContactForm.joca_contact_submit.blur(); }';
    echo '  else { document.getElementById(\'joca_contact_area_button\').innerHTML=\'\'; document.getElementById(\'joca_contact_area_info\').innerHTML=\'<img src="' . plugin_dir_url( __FILE__ ) . 'sending.gif" width=160 height=20 border=0><br>' . __("Sending message, please wait...", 'joca-contact') . '\'; }';
    echo '},false);';
    echo 'function joca_contact_form_changed(obj) {';
    echo '  if (obj.value.length>2) { obj.style=\'max-width:100% !important;background-color:#ccffcc !important;\'; }';
    echo '}';
    echo '</script>';
}

function joca_contact_shortcode() {
    ob_start();
    deliver_mail();
    if ($GLOBALS["joca_contact_was_sent"]!=true) {
      html_form_code();
    }
    return ob_get_clean();
}
add_shortcode( 'joca_contact', 'joca_contact_shortcode' );

function deliver_mail() {
    if ( isset( $_POST['joca_contact_message'] ) ) {
        $joca_contact_name    = sanitize_text_field( $_POST["joca_contact_name"] );
        $joca_contact_email   = sanitize_email( $_POST["joca_contact_email"] );
        $joca_contact_phone   = sanitize_text_field( $_POST["joca_contact_phone"] );
        $joca_contact_message = esc_textarea( $_POST["joca_contact_message"] );
        $joca_contact_sendto  = get_option('admin_email');
        if (strpos($joca_contact_email,"@")!=false && strlen($joca_contact_message)>3) {
            if (!empty($joca_contact_phone)) {
              $joca_contact_message=__("Phone", 'joca-contact').": " . $joca_contact_phone . "\r\n\r\n" . $joca_contact_message;
            }
            $joca_contact_headers = "From: $joca_contact_name <$joca_contact_email>\r\n";
            if (is_ssl()) {
              $joca_contact_sentfrom = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            } else {
              $joca_contact_sentfrom = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }
            if ($GLOBALS["joca_contact_was_sent"]!=true && $GLOBALS["joca_contact_had_error"]!=true) {
              if ( wp_mail( $joca_contact_sendto, __("Contact from", 'joca-contact') . " " . get_bloginfo('$joca_contact_name'), $joca_contact_message . "\r\n\r\n" . __("Sent from URL:", 'joca-contact') . "\r\n" . $joca_contact_sentfrom, $joca_contact_headers ) ) {
                $GLOBALS["joca_contact_was_sent"]=true;
              } else {
                $GLOBALS["joca_contact_had_error"]=true;
              }
            }
            if ($GLOBALS["joca_contact_was_sent"]==true) {
              echo '<div><p class="joca_contact_message_ok">' . __("Your message was sent!", 'joca-contact') . '</p></div>';
            } else {
              echo '<div><p class="joca_contact_message_error">' . __("An unexpected error occurred, please try again later.", 'joca-contact') . '</p></div>';
            }
        }
    }
}
?>
