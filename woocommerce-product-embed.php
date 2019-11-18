<?php
/*
Plugin Name: Woocommerce product embed
Plugin URI: https://www.facebook.com/lucky.kunalmalviya
Description: Plugin to embeded products to other site
Version: 2.2.4
Author: Kunal Malviya
Author URI: https://www.facebook.com/lucky.kunalmalviya
*/

add_action('wp_enqueue_scripts', 'productembeded_enqueue_script');
function productembeded_enqueue_script(){
	wp_enqueue_style( 'productembeded_css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css' );
}

/**
* Adding shortcode for this plugin
**/
add_shortcode( 'productembeded', 'productembeded_shortcode_callback' );
function productembeded_shortcode_callback( $atts ) {
	// Get shortcodes
	$a = shortcode_atts( array(
		"ids" => "",
	), $atts );

	// If region code is set in url
	if( !empty($a['ids']) ) {
		$productIds = $a['ids'];		
		$ids = explode(",", $productIds);
		$ids = array_unique($ids);
		$string = '<div class="container bodyPadding"><div class="row">';
		foreach ($ids as $i => $id) {
			// Get $product object from product ID source https://businessbloomer.com/woocommerce-easily-get-product-info-title-sku-desc-product-object/
			$product = wc_get_product( $id );			
			$string .= sendHtml($product);
		}
		$string .= '</div></div>';
		return $string;
	} else {
		return;
	}
}

function sendHtml($product) {
	// $product->get_image_id();
	// $product->get_gallery_image_ids();
	// $product->get_type();
	// echo  get_option('woocommerce_currency');
	// echo  get_woocommerce_currency_symbol("USD");

	$name = $product->get_name();
	$image = $product->get_image();
	$description = $product->get_short_description();
	$price = $product->get_price();
	$regularPrice = $product->get_regular_price();
	$saleprice = $product->get_sale_price();
	$is_on_sale = $product->is_on_sale();
	$symbol = get_woocommerce_currency_symbol();
	$permalink = get_permalink( $product->get_id() );
	if($is_on_sale) {
		$is_on_sale ='<span class="onsale">Sale!</span>';		
	} else {
		$is_on_sale ='';
	}
	return '<div class="col-md-3 shadow p-3 mb-5 bg-white rounded">
	        <div class="">'.$image.$is_on_sale.'</div>
	        <div class=""><b>'.$name.'</b></div>
	        <div class=""><strike>'.$symbol.$regularPrice.'</strike></div>
	        <div class="row">
	        	<div class="col-md-6">'.$symbol.$saleprice.'</div>
	        	<div class="col-md-6"><a target="_blank" href="'.$permalink.'" class="iframeBtn">Info</a></div>
	        </div>
        </div>';
}