<?php
add_action('woocommerce_checkout_before_customer_details', 'checkout_left_start', 0);
function checkout_left_start(){
    echo '<div class="checkout_left">';
}

add_action('woocommerce_checkout_after_customer_details', 'checkout_left_end', 1000);
function checkout_left_end(){
    echo '</div>'; //end checkout_left
}

add_action('woocommerce_checkout_before_order_review_heading', 'checkout_right_start', 0);
function checkout_right_start(){
    echo '<div class="checkout_right">';
}

add_action('woocommerce_checkout_after_order_review', 'checkout_right_end', 1000);
function wrap_right_end(){
    echo '</div>'; //end checkout_left
}


//Woocommerce giftcards
remove_action('woocommerce_proceed_to_checkout', array(WC_GC()->cart, 'display_form'), 9); 

add_action('woocommerce_review_order_before_submit', 'woocommerce_giftcard', 8); //plugin use number 9
function woocommerce_giftcard(){

    if(is_plugin_active('woocommerce-gift-cards/woocommerce-gift-cards.php')):       
        echo '<div class="giftcard_toggle">';						
            wc_print_notice( esc_html__( 'Har ud et gavekort?', 'op-theme' ) . ' <a href="#" id="showgiftcard">' . esc_html__( 'Klik her for at indtaste dit gavekort', 'op-theme' ) . '</a>', 'notice' );
        echo '</div>';
    endif;	

}

add_filter('woocommerce_thankyou_order_received_text', 'op_change_order_received_text', 10, 2 );
function op_change_order_received_text( $str, $order ) {
  
    $tak_for_din_ordre = get_field('tak_for_din_ordre', 'option');
    if($tak_for_din_ordre):
        $str = $tak_for_din_ordre;
    endif;

    return $str;
}


