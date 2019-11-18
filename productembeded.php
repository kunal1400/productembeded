<?php 
require('./wp-load.php');
wp_head();
echo do_shortcode("[productembeded ids='610,610']");
wp_footer();