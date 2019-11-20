<?php 
/** 
* Template Name: Product Embeded Page
**/

wp_head();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		// echo do_shortcode("[productembeded]");
		the_content();
	}
}
wp_footer();


?>

<script type="text/javascript">
	// var x = new XMLHttpRequest();
	// x.open("GET", "http://localhost/wp-plugin-tasks/productembeded/", true);
	// // x.setRequestHeader( 'Access-Control-Allow-Origin', '*');
	// x.onreadystatechange = function () {
	//   if (x.readyState == 4 && x.status == 200) {	    
	//     console.log(doc);
	//   }
	// };
	// x.onerror = function(XMLHttpRequest, textStatus, errorThrown) {
	// 	console.log( 'The data failed to load :(' );
	// 	console.log(JSON.stringify(XMLHttpRequest));
	// };
	// x.onload = function() {
	// 	console.log('SUCCESS!');
	// }
	// x.send(null);

	// $.post('https://topnakup.si/wp-content/uploads/woo-product-feed-pro/xml/7Oqy1OO12CzQTBGJc6QH5VlXBGUECyBT.xml', { url: url }, function(data) {
	//     document.getElementById('somediv').innerHTML = data;        
	// });
</script>