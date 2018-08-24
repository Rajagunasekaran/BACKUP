<?php
/*function.php*/
wp_localize_script( 'script', 'ajax_posts', array(
	'ajaxurl'     => admin_url( 'admin-ajax.php' ),
	'homeurl'     => home_url( '/' )
));

function load_more_post_ajax() {
	$postPerPage = (isset($_POST["postPerPage"])) ? $_POST["postPerPage"] : 10;
	$page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
	header("Content-Type: text/html");
	$args = array(
		'post_type'      => 'post',
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => 'publish',
		'posts_per_page' => $postPerPage,
		'paged'          => $page
	);

	$postRes = new WP_Query( $args );
	$postResHtml = '';
	if ($postRes->have_posts()):
		while ($postRes->have_posts() ) : $postRes->the_post();
			$name = get_the_title();
			$link = get_the_permalink();
			$id   = get_the_ID();
			$postResHtml .= '<li data-id="'.$id.'"><a href="'.$link.'">'.$name.'</a></li>';
		endwhile;
	endif;
	wp_reset_postdata();
	echo $postResHtml;
	exit();
}
add_action('wp_ajax_nopriv_load_more_post_ajax', 'load_more_post_ajax');
add_action('wp_ajax_load_more_post_ajax', 'load_more_post_ajax');
/*function.php*/

/*page*/
$count_post = wp_count_posts('barrister');
$total_posts = $count_post->publish;

$args = array(
	'post_type'      => 'post',
	'orderby'        => 'title',
	'order'          => 'ASC',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
);
$posts = new WP_Query( $args );

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if ( $posts->have_posts() ) { ?>
		<div class="">
			<ul class="">
				<?php while ( $posts->have_posts() ) : $posts->the_post();
					$name = get_the_title();
					$link = get_the_permalink();
					$id   = get_the_ID(); ?>
					<li data-id="<?php echo $id; ?>"><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
				<?php endwhile; ?> 
			</ul>
			<div class="">
				<a href="javascript:void(0);" class="load-more-post" data-barrister-count="<?php echo $total_posts; ?>" data-loading="Loading..."><span>More posts</span></a>
			</div>
		</div>
	<?php } else { ?>
		<div class="alert alert-warning mt-4" role="alert">Sorry, there are no results that match your search!</div>
	<?php }
	wp_reset_postdata(); ?>
</div>
<?php } ?>

<script type="text/javascript">
	var postPerPage = 10;
	var postPageNumber = 1;
	$(document).on("click", ".load-more-posts", function() {
		var total_post_count = $(this).attr("data-post-count");
		total_post_count = parseInt(total_post_count);
		var ajax_post_count = $("ul li").length;
		var $this = $(this),
			btnText = $this.find('span');
		btnText.text($this.attr('data-loading'));
		$this.attr("disabled", true);

		postPageNumber++;
		var inputData = {
			'pageNumber': postPageNumber,
			'postPerPage': postPerPage,
			'action': 'load_more_post_ajax'
		};
		$.ajax({
			type: "POST",
			dataType: "html",
			url: ajax_posts.ajaxurl,
			data: inputData,
			success: function(data) {
				var $data = $(data);
				if ($data.length) {
					$("ul").append(data);
					ajax_post_count = $("ul li").length;
					console.log(total_post_count, ajax_post_count)
					if(total_post_count == ajax_post_count){
						$this.fadeOut();
					}
				} else {
					$this.fadeOut();
				}
				setTimeout(function() {
					$this.attr("disabled", false);
					btnText.text('More Posts');
				}, 100);
			}
		});
		return false;
	});
</script>
</body>
</html>