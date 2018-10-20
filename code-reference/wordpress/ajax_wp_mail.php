<?php
/* AJAX MAIL
================================================== */
add_action('wp_ajax_mail_action', 'sending_mail');
add_action('wp_ajax_nopriv_mail_action', 'sending_mail');
function sending_mail() {
	$site     = get_site_url();
	$subject  = __('New Message!', 'hbthemes');
	$email    = $_POST['contact_email'];
	$email_s  = filter_var($email, FILTER_SANITIZE_EMAIL);
	$comments = stripslashes($_POST['contact_comments']);
	$name     = stripslashes($_POST['contact_name']);
	$to       = hb_options('hb_contact_settings_email');
	$message  = "Name: $name \n\nEmail: $email \n\nMessage: $comments \n\nThis email was sent from $site";
	$headers  = 'From: ' . $name . ' <' . $email_s . '>' . "\r\n" . 'Reply-To: ' . $email_s;
	wp_mail($to, $subject, $message, $headers);
	exit();
}
?>