<?php
// Register HTML5 Blank Navigation
function register_html5_menu()
{
	register_nav_menus(array( // Using array to specify more menus if needed
		'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
		'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
		'extra-menu' => __('Extra Menu', 'html5blank'), // Extra Navigation if needed (duplicate as many as you need!)
		'sitemap-menu' => __('Sitemap Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
	));
}
?>