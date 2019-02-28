<?php
if (!function_exists('get_breadcrumb')) {
	function get_breadcrumb($home_text = 'Home', $delimiter = '-') {
		$enable_breadcrumb = get_field('enable_breadcrumb', 'options');
		if(!$enable_breadcrumb) { return; }
		
		global $post;
		$breadcrumb = '<div class="breadcrumb">';
		if(is_front_page()){
			$breadcrumb .= esc_html('Front Page', 'excitor');
		}elseif(is_home()){
			$breadcrumb .= esc_html('Blog', 'excitor');
		}else{
			$breadcrumb .= '<a href="' . esc_url(home_url('/')) . '" rel="nofollow">' . $home_text . '</a> ' . $delimiter . ' ';
		}

		if(is_category()){
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) $breadcrumb .= get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
			$breadcrumb .= '<span class="current">' . single_cat_title(esc_html__('Archive by category: ', 'excitor'), false) . '</span>';
		}elseif ( is_tag() ) {
			$breadcrumb .= '<span class="current">' . single_tag_title(esc_html__('Posts tagged: ', 'excitor'), false) . '</span>';
		}elseif(is_tax()){
			$breadcrumb .= '<span class="current">' . single_term_title(esc_html__('Archive by taxonomy: ', 'excitor'), false) . '</span>';
		}elseif(is_search()){
			$breadcrumb .= '<span class="current">' . esc_html__('Search results for: ', 'excitor') . get_search_query() . '</span>';
		}elseif(is_day()){
			$breadcrumb .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F').' '. get_the_time('Y') . '</a> ' . $delimiter . ' ';
			$breadcrumb .= '<span class="current">' . get_the_time('d') . '</span>';
		}elseif(is_month()){
			$breadcrumb .= '<span class="current">' . get_the_time('F'). ' '. get_the_time('Y') . '</span>';
		}elseif(is_single() && !is_attachment()){
			if(get_post_type() != 'post'){
				if(get_post_type() == 'team'){
					$terms = get_the_terms(get_the_ID(), 'team_category', '' , '' );
					if(!empty($terms) && !is_wp_error($terms)) {
						the_terms(get_the_ID(), 'team_category', '' , ', ' );
						$breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
					}else{
						$breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
					}
				}elseif(get_post_type() == 'testimonial'){
					$terms = get_the_terms(get_the_ID(), 'testimonial_category', '' , '' );
					if(!empty($terms) && !is_wp_error($terms)) {
						the_terms(get_the_ID(), 'testimonial_category', '' , ', ' );
						$breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
					}else{
						$breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
					}
				}elseif(get_post_type() == 'services'){
					$terms = get_the_terms(get_the_ID(), 'services_category', '' , '' );
					if(!empty($terms) && !is_wp_error($terms)) {
						the_terms(get_the_ID(), 'services_category', '' , ', ' );
						$breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
					}else{
						$breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
					}
				}else{
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					$breadcrumb .= '<a href="' . esc_url(home_url('/')) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
					$breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
				}
			}else{
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				$breadcrumb .= ''.$cats;
				$breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
			}
		}elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			if($post_type) $breadcrumb .= '<span class="current">' . $post_type->labels->singular_name . '</span>';
		}elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$breadcrumb .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			$breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
		}elseif ( is_page() && !is_front_page() && !$post->post_parent ) {
			$breadcrumb .= '<span class="current">' . get_the_title() . '</span>';
		}elseif ( is_page() && !is_front_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				$breadcrumb .= ''.$breadcrumbs[$i];
				if ($i != count($breadcrumbs) - 1)
					$breadcrumb .= ' ' . $delimiter . ' ';
			}
			$breadcrumb .= ' ' . $delimiter . ' ' . '<span class="current">' . get_the_title() . '</span>';
		}elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			$breadcrumb .= '<span class="current">' . esc_html__('Articles posted by ', 'excitor') . $userdata->display_name . '</span>';
		}elseif ( is_404() ) {
			$breadcrumb .= '<span class="current">' . esc_html__('Error 404', 'excitor') . '</span>';
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $breadcrumb .= ' (';
			$breadcrumb .= ' ' . $delimiter . ' ' . esc_html__('Page', 'excitor') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $breadcrumb .= ')';
		}

		$breadcrumb .= '</div>';
		return $breadcrumb;
	}
}

$default_page_header = get_field('default_page_header', 'options');
$header_img = get_field('page_header_image', 'options'); ?>
<div class="page-header" style="background-image: url('<?php echo (!empty($header_img) ? $header_img : $default_page_header); ?>');">
	<div class="container text-center">
		<div class="row row-reverse">
			<div class="col-md-6 pull-right">
				<div class="heading-strip">
					<h1 class="wow fadeInDown">
						<?php if(is_404()):
							echo "Page not found";
						elseif(is_search()):
							$total_results = $wp_query->found_posts;
							$items = ( $total_results == '1' ) ? ' item.' : ' items.';
							$title = get_search_query() . ', ' . $total_results . $items;
							echo $title;
						else:
							echo get_the_title();
						endif; ?>
					</h1>
				</div>
			</div>
			<div class="col-md-6 pull-left">
				<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
/** inner page header **/
.page-header {
	height: 200px;
	width: 100%;
	position: relative;
	overflow: hidden;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	background-size: cover;
	background-position: center center;
	background-repeat: no-repeat;
	background-color: #00a7d5;
	padding: 25px 0;
	margin: 0;
}
.page-header::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	display: block;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.2);
	z-index: 0;
}
.page-header h1 {
	font-family: 'Oswald-DemiBold', sans-serif;
	font-weight: normal;
	font-size: 34px;
	line-height: 1.2;
	letter-spacing: 0.02em;
	color: #fff;
	text-transform: uppercase;
	position: relative;
	margin-top: 0;
	margin-bottom: 10px;
	z-index: 1;
}
.breadcrumb {
	display: inline-block;
	position: relative;
	z-index: 1;
	color: #fff;
	font-family: 'Lato-Regular';
	font-size: 13px;
	font-weight: 500;
	line-height: 1.5;
	padding: 5px 15px 5px;
	background: #444;
	margin-bottom: 0;
}
.breadcrumb a { color: #fff;  }
.breadcrumb a:hover { color: #00b9ec  }

.inner-page {  }
.inner-page .content-section { padding-top: 60px; }
</style>
?>