<?php
/*list current page child pages*/

/*function file*/
function has_children() {
	global $post;
	$pages = get_pages('child_of=' . $post->ID);
	if (count($pages) > 0):
		return true;
	else:
		return false;
	endif;
}
function is_top_level() {
	global $post, $wpdb;
	$current_page = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE ID = " . $post->ID);
	return $current_page;
}

/*list code*/
$base_args = array(
	'hierarchical' => 0
);
if (has_children()):
	$args = array(
		'child_of' => $post->ID,
		'parent' => $post->ID
	);
else:
	if (is_top_level()):
		$args = array(
			'parent' => $post->post_parent
		);
	else:
		$args = array(
			'parent' => 0
		);
	endif;
endif;
$args = array_merge($base_args, $args);
$pages = get_pages($args);
foreach ($pages as $page){ ?>
	<a href="<?php echo get_permalink($page->ID);?>" class="sidebar-navlink<?php if($page->ID == $post->ID) { echo ' w--current'; } ?>"><?php echo $page->post_title; ?></a>
<?php } ?>