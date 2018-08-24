<?php

/*dynamic custom post*/
function custom_post_type() {

	$custom_post_type_array = array(
		array(
			'post_type' => 'barrister',
			'singular_name' => 'Barrister',
			'plural_name' => 'Barristers',
			'menu_icon' => 'dashicons-businessman',
			'taxonomies' => array('chamber', 'areas-of-practice')
		)
	);

	foreach($custom_post_type_array as $key => $value) {
		$labels = array(
			'name'                  => _x( $value['plural_name'], 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( $value['singular_name'], 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( $value['plural_name'], 'text_domain' ),
			'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent '.$value['singular_name'].':', 'text_domain' ),
			'all_items'             => __( 'All '.$value['plural_name'].'', 'text_domain' ),
			'add_new_item'          => __( 'Add New '.$value['singular_name'].'', 'text_domain' ),
			'add_new'               => __( 'New '.$value['singular_name'].'', 'text_domain' ),
			'new_item'              => __( 'New Item', 'text_domain' ),
			'edit_item'             => __( 'Edit '.$value['singular_name'].'', 'text_domain' ),
			'update_item'           => __( 'Update '.$value['singular_name'].'', 'text_domain' ),
			'view_item'             => __( 'View '.$value['singular_name'].'', 'text_domain' ),
			'search_items'          => __( 'Search '.$value['singular_name'].'', 'text_domain' ),
			'not_found'             => __( 'No '.strtolower($value['singular_name']).' found', 'text_domain' ),
			'not_found_in_trash'    => __( 'No '.strtolower($value['singular_name']).' found in Trash', 'text_domain' ),
			'items_list'            => __( 'Items list', 'text_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
		);
		$args = array(
			'label'                 => __( $value['singular_name'], 'text_domain' ),
			'description'           => __( $value['singular_name'].' information pages', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_icon'             => $value['menu_icon'],
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'taxonomies'            => $value['taxonomies']
		);
		register_post_type( $value['post_type'], $args );
		// Register Taxonomies for Category
		//register_taxonomy_for_object_type('category', $value['post_type']);
		//register_taxonomy_for_object_type('post_tag', $value['post_type']);
		
		$custom_taxonomy_array = array(
			array('slug' => 'chamber','singular_name' => 'Chamber','plural_name' => 'Chambers'),
			array('slug' => 'areas-of-practice','singular_name' => 'Areas Of Practice','plural_name' => 'Areas Of Practice')
		);

		barristers_taxonomy($custom_taxonomy_array,$value['post_type']);
	}
}
add_action( 'init', 'custom_post_type', 0 );
function barristers_taxonomy($taxonomy,$post_type){
	foreach($taxonomy as $key => $value) {
		$labels = array(
			'name'              => _x( $value['plural_name'], 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( $value['singular_name'], 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search '.$value['plural_name'], 'textdomain' ),
			'all_items'         => __( 'All '.$value['plural_name'], 'textdomain' ),
			'parent_item'       => __( 'Parent '.$value['singular_name'], 'textdomain' ),
			'parent_item_colon' => __( 'Parent '.$value['singular_name'].":", 'textdomain' ),
			'edit_item'         => __( 'Edit '.$value['singular_name'], 'textdomain' ),
			'update_item'       => __( 'Update '.$value['singular_name'], 'textdomain' ),
			'add_new_item'      => __( 'Add New '.$value['singular_name'], 'textdomain' ),
			'new_item_name'     => __( 'New '.$value['singular_name'], 'textdomain' ),
			'menu_name'         => __( $value['singular_name'], 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $value['slug']),
		);

		register_taxonomy( $value['slug'], array( $post_type ), $args );
	}
}
?>