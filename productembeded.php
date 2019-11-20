<?php 
/** 
* Template Name: Product Embeded Page
**/
require fs_get_wp_config_path();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) ?>css/bootstrap.css" type="text/css" />
	<style type="text/css">
		body {
		    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		    font-size: 14px;
		    color: #333333;
		    background-color: #ffffff;
		}
	</style>
</head>
<body>
	<?php echo do_shortcode("[productembeded]"); ?>
</body>
</html>
<?php

function fs_get_wp_config_path() {
    $base = dirname(__FILE__);
    $path = false;

    if (@file_exists(dirname(dirname($base))."/wp-load.php")) {
        $path = dirname(dirname($base))."/wp-load.php";
    }
    else if (@file_exists(dirname(dirname(dirname($base)))."/wp-load.php")) {
        $path = dirname(dirname(dirname($base)))."/wp-load.php";
    }
    else
        $path = false;

    if ($path != false) {
        $path = str_replace("\\", "/", $path);
    }
    return $path;
}

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

	
	// jQuery( ".listing__detail--wrapper" ).load( "https://topnakup.si/productembeded-page/", function() {
	//   alert( "Load was performed." );
	// });

	
	// jQuery( ".listing__detail--wrapper" ).load( "http://localhost/wp-plugin-tasks/productembeded", function() {
	//   alert( "Load was performed." );
	// });

</script>