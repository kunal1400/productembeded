<?php 
/** 
* Template Name: Product Embeded Page
**/

// require('./wp-load.php');
wp_head();
// echo do_shortcode("[productembeded ids='817,816']");
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		the_content();
	}
}
wp_footer();