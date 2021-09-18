<?php

add_action( 'wp_head', 'head_tracking', 10 );
if ( ! function_exists( 'head_tracking' ) ) {

    function head_tracking(){
        the_field('tracking_header', 'option');
    }
}

add_action( 'op_body_start', 'body_tracking', 10 );
if ( ! function_exists( 'body_tracking' ) ) {
    function body_tracking(){
        the_field('tracking_body_start', 'option');
    }
}

add_action( 'wp_footer', 'footer_tracking', 10 );
if ( ! function_exists( 'footer_tracking' ) ) {
    function footer_tracking(){
        the_field('tracking_body_end', 'option');
    }
}

