<?php 
/**
 * Post pagination
 */
if(!( function_exists('post_pagination') )){
	function post_pagination($pages = '', $range = 2){
		$showitems = ($range * 2)+1;

		global $paged;
		if(empty($paged)) $paged = 1;

		if($pages == ''){
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}

		$output = '';

		if(1 != $pages){

			$output .= '<nav class="pagination clearfix">';
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<a href='".get_pagenum_link(1)."'><i class=\"fa fa-angle-left\"></i></a>";
			
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					$output .= ($paged == $i)? "<span class=\"page-numbers current\">".$i."</span>":"<a href='".get_pagenum_link($i)."'>".$i."</a>";
				}
			}

			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $output .= "<a href='".get_pagenum_link($pages)."'><i class=\"fa fa-angle-right\"></i></a>";
			$output.= "</nav>";
		}

		return $output;
	}
}


/*usage in templage*/
echo function_exists( 'post_pagination' ) ? post_pagination() : html5wp_pagination(); ?>

?>