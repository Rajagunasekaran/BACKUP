<?php
/*function.php*/
add_image_size( 'custom-size', 750, 330, true );

/*file*/
get_the_post_thumbnail_url($post_id, 'custom-size');
?>