<?php
add_action( 'wp_ajax_nopriv_remove_shop_notice', 'ajax_remove_shop_notice' );
add_action( 'wp_ajax_remove_shop_notice', 'ajax_remove_shop_notice' );
function ajax_remove_shop_notice() {
    $_SESSION["shop_notice_close"] = 'removed';
    
    die();
}