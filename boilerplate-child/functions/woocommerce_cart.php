<?php 
//Header
add_filter( 'woocommerce_add_to_cart_fragments', 'op_update_cart_count' ); 
function op_update_cart_count( $fragments ) {
 
	global $woocommerce; 
	$fragments['#cart_count'] = '<span id="cart_count" class="menu_count">' . $woocommerce->cart->cart_contents_count . '</span>';
 	return $fragments;
 
} 

//form
add_filter( 'woocommerce_cart_item_thumbnail', 'op_change_cart_thumbnail', 10, 3);
function op_change_cart_thumbnail($product_get_image, $cart_item, $cart_item_key){

	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	return  $_product->get_image('gallery_thumb');

}

add_action( 'woocommerce_cart_item_quantity', 'op_add_quanitiy_button', 10, 3 ); 
function op_add_quanitiy_button($product_quantity, $cart_item_key, $cart_item ) {
	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	
	echo '<div class="quantity_wrapper_cart">';
	if(!$_product->is_sold_individually()):							
		echo '<button type="button" class="chart_quantity_btn minus" data-type="minus" data-field="cart['.$cart_item_key.'][qty]">
				 <i class="far fa-minus"></i>
			  </button>';
	endif;

	echo $product_quantity;

	if(!$_product->is_sold_individually()):							
		echo '<button type="button" class="chart_quantity_btn plus" data-type="plus" data-field="cart['.$cart_item_key.'][qty]">
				 <i class="far fa-plus"></i>
			  </button>';
	endif;
	echo '</div>';
 
}



?>