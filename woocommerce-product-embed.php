<?php
/*
Plugin Name: Woocommerce product embed
Plugin URI: https://www.facebook.com/lucky.kunalmalviya
Description: Plugin to embeded products to other site
Version: 2.2.4
Author: Kunal Malviya
Author URI: https://www.facebook.com/lucky.kunalmalviya
*/

// add_action('wp_enqueue_scripts', 'productembeded_enqueue_script');
// function productembeded_enqueue_script(){
// 	wp_enqueue_style( 'productembeded_css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css' );
// }

/**
* Adding shortcode for this plugin
**/
add_shortcode( 'productembeded', 'productembeded_shortcode_callback' );
function productembeded_shortcode_callback( $atts ) {
	add_filter('show_admin_bar', '__return_false');

	// Get shortcodes
	$a = shortcode_atts( array(
		"ids" => "",
	), $atts );

	$productFeedUrl = 'https://topnakup.si/wp-content/uploads/woo-product-feed-pro/xml/7Oqy1OO12CzQTBGJc6QH5VlXBGUECyBT.xml';
	libxml_use_internal_errors(true);

	$curl = curl_init();
	curl_setopt_array($curl, Array(
	    CURLOPT_URL            => $productFeedUrl,
	    CURLOPT_RETURNTRANSFER => TRUE,
	    CURLOPT_ENCODING       => 'UTF-8'
	));
	$data = curl_exec($curl);
	curl_close($curl);
	$xml = simplexml_load_string($data);

	if ($xml === false) {
	    echo "Failed loading XML\n";
	    foreach(libxml_get_errors() as $error) {
	        echo "\t", $error->message;
	    }
	} 
	else {
		$jsonEncode = json_encode($xml);
		$products = json_decode($jsonEncode,true);
		if(count($products['product']) > 0) {
			$onlyProducts = $products['product'];
			$string = '<div class="container"><div class="row">';
			for ($i=0; $i < count($onlyProducts) ; $i++) { 
				$data = $onlyProducts[$i];				
				$string .= sendHtml($data);
			}
			return $string .= '</div></div>';
		} else {
			return;
		}
	}
}

// /**
// * Adding shortcode for this plugin
// **/
// add_shortcode( 'productembeded', 'productembeded_shortcode_callback' );
// function productembeded_shortcode_callback( $atts ) {
// 	// Get shortcodes
// 	$a = shortcode_atts( array(
// 		"ids" => "",
// 	), $atts );

// 	// If region code is set in url
// 	if( !empty($a['ids']) ) {
// 		$productIds = $a['ids'];		
// 		$ids = explode(",", $productIds);
// 		$ids = array_unique($ids);
// 		$string = '<div class="container"><div class="row">';
// 		foreach ($ids as $i => $id) {
// 			// Get $product object from product ID source https://businessbloomer.com/woocommerce-easily-get-product-info-title-sku-desc-product-object/
// 			$product = wc_get_product( $id );			
// 			$string .= sendHtml($product);
// 		}
// 		$string .= '</div></div>';
// 		return $string;
// 	} else {
// 		return;
// 	}
// }

function sendHtml($product) {	
	$name = $product['title'];
	$image = $product['image_link'];
	$description = $product['description'];
	$regularPrice = $product['price'];
	$symbol = get_woocommerce_currency_symbol();
	$saleprice = $product['discount'];
	$is_on_sale = true;
	$permalink = $product['link'];
	$discount = ((($product['price']-$product['discount'])/$product['price'])*100);

	if($is_on_sale) {
		$is_on_sale ='<span class="btn-donate">'.round($discount).'%</span>';		
	} else {
		$is_on_sale ='';
	}
	return '<div class="col-md-3 col-sm-6">
	        <div class="card" >
	        	<a target="_blank" href="'.$permalink.'">
	        		<img src="'.$image.'" style="width:100%;max-height:200px;" />
	        		'.$is_on_sale.'
	        	</a>
	        	<div class="productInfo clearfix">	        		
		        	<h3><b><a target="_blank" href="'.$permalink.'">'.$name.'</a></b></h3>		        	
		        	<div class="cancel price leftalign"><strike><small>'.$symbol.$regularPrice.'</small></strike></div>	        	
		        	<div class="inline-block">
		        		<div class="price leftalign"><b>'.$symbol.$saleprice.'</b></div>
		        		<div class="rightalign"><a target="_blank" href="'.$permalink.'" class="iframeBtn">Info</a></div>
		        	</div>
	        	</div>
	        </div>
        </div>';
}

add_filter( 'page_template', 'wpa3396_page_template' );
function wpa3396_page_template( $page_template ) {
	global $post;
    $post_slug = $post->post_name;

    // appending the dash at first position so that we will not get 0
    $stringPresent = strpos('-'.$post_slug, 'productembeded');

    if ( $stringPresent ) {
        $page_template = dirname( __FILE__ ) . '/productembeded.php';
    }
    return $page_template;
}

/**
* Adding columns for events post type in admin area
**/
add_filter( 'manage_edit-product_columns', 'simple_events_filter_posts_columns' );
add_filter( 'manage_product_posts_custom_column', 'simple_events_realestate_column', 10, 2 );
function simple_events_filter_posts_columns( $columns ) {	
	$columns['product_views'] = esc_html__( 'Total Views', 'woocommerce' );
	return $columns;
}

/**
* Populating columns for events post type in admin area
**/
function simple_events_realestate_column( $column, $post_id ) {
	if ( 'product_views' === $column ) {
        $meta = get_post_meta( $post_id, '_views_count', TRUE );
        if(empty($meta)) {
            echo 0;
        }
        else {
        	echo $meta; 
        }
	}
}

add_action('admin_head', 'my_column_width');
function my_column_width() {
    echo '<style type="text/css">';
    echo 'table.wp-list-table #product_views { width: 47px; text-align: left!important;padding: 5px;}';
    echo '</style>';
}

// add_action('admin_notices', 'blackhole_tools_admin_notice');
// function blackhole_tools_admin_notice() {
// 	$screen = get_current_screen();	
// 	if($screen->post_type == 'page'){
// 		echo '<div class="notice notice-info">
// 		    <p>For generating an embedded link: <br/>1) Add <b><i>productembeded</i></b> string in your slug <br/>2) Add shortcode <b><i>[productembeded ids="x, y, z"]</i></b> in editor where x, y, z are product ids.</p>
// 		</div>';
// 	}	
// }

add_action('wp', function() {
	global $post;
	$metaKeyName = '_views_count';
	if($post->post_type == 'product') {
		if ( is_product() ) {
			$counter = get_post_meta( $post->ID, $metaKeyName, TRUE );		
			if(empty($counter)) {
				update_post_meta( $post->ID, $metaKeyName, 1 );
			} else {
				$counter++;
				update_post_meta( $post->ID, $metaKeyName, $counter );
			}
		}		
	}
});
