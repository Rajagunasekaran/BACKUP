<?php
if(function_exists('acf_add_options_page')){
	$args = array(
		'page_title' => 'WA BAR Settings',
		'menu_title' => '',
		'menu_slug' => '',
		'capability' => 'edit_posts',
		'position' => false,
		'parent_slug' => '',
		'icon_url' => false,
		'redirect' => true,
		'post_id' => 'options',
		'autoload' => false
	);
	acf_add_options_page($args);
}


/** GET COPYRIGHT YEAR **/
function getYear(){
echo Date('Y');	
}
add_shortcode("y", "getYear");

/* UPDATE WP_ADMIN SECTION */
add_action("login_head", "generic_login_head");
function generic_login_head() {
	if(!is_user_logged_in()){
		$admin_login_logo = get_field('admin_logo','option');
		$admin_background_color = get_field('admin_background_colour','option');
		$admin_logo = ($admin_login_logo != '') ? $admin_login_logo : get_stylesheet_directory_uri()."/img/logo.png";
		$admin_background_color = ($admin_background_color != '') ? $admin_background_color : "#FFF";
		echo"<style>
		.login #login h1 a,.login h1 a {
			background-image: url('".$admin_logo."') !important;
			height:82px !important;
			width: 236px !important;
			background-size:100% !important;
			background-position:left;
		}
		html,body{ background:".$admin_background_color." !important; }
		.login .message,.login form{ box-shadow:2px 0 4px 4px rgba(0, 0, 0, 0.1) !important; }
		</style>";
	}
}
/*UPDATE Favicon SECTION */
add_action('wp_head','favicon');
add_action( 'admin_head', 'favicon' );
add_action( 'login_head', 'favicon' );
function favicon() {
	$fav_icon = get_field('fav_icon','option');
	$favicon = ($fav_icon['url'] != '') ? $fav_icon['url'] : get_stylesheet_directory_uri()."/img/favicon.png";
	if($favicon != '') {
		echo '<link rel="apple-touch-icon" sizes="180x180" href="'.$favicon.'"><link rel="shortcut icon" type="image/png" href="'.$favicon.'"/>';
	}
}

function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

?>