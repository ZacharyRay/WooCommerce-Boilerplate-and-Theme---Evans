<?php
/* op_footer__1 */
add_action( 'op_footer__1', 'op_add_footer_logo', 10 );
if ( ! function_exists( 'op_add_footer_logo' ) ) {
    function op_add_footer_logo(){
        $img = get_field('firma_logo', 'option');
        if($img):
            echo '<a href="'.get_bloginfo('url').'" id="footer_logo">'.wp_get_attachment_image( $img, array('', '20')).'</a>';
        endif;
    }
}

add_action( 'op_footer__1', 'op_add_some', 10 );
if ( ! function_exists( 'op_add_some' ) ) {
    function op_add_some(){
        echo do_shortcode('[firma_some]');
    }
}

/* op_footer__2 */
add_action( 'op_footer__2', 'op_add_info', 10 );
if ( ! function_exists( 'op_add_info' ) ) {
    function op_add_info(){
        echo do_shortcode('[firma_navn]');
        
        echo do_shortcode('[firma_adresse]');
        echo do_shortcode('[firma_cvr]');
        echo '<br><br>';

        //echo '<div class="h5">'.__('Spørgsmål', 'op-theme').'</div>';
        echo do_shortcode('[firma_telefon]');
        echo '<br>';
        echo do_shortcode('[firma_email]'); 
    }
}


/* op_footer__3 */
add_action( 'op_footer__3', 'op_add_footer_menu_1', 10 );
if ( ! function_exists( 'op_add_footer_menu_1' ) ) {
    function op_add_footer_menu_1(){
        $location_name = 'footer_menu_1';
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term( $theme_locations[$location_name], 'nav_menu' ); 
        if(isset($menu_obj->name)):
            echo '<div class="h5">'.$menu_obj->name.'</div>';
            wp_nav_menu( array( 'theme_location' => $location_name, 'fallback_cb' => false, 'depth' => 1 ) ); 
        endif;
    }
}

/* op_footer__4 */
add_action( 'op_footer__4', 'op_add_footer_menu_2', 10 );
if ( ! function_exists( 'op_add_footer_menu_2' ) ) {
    function op_add_footer_menu_2(){
        $location_name = 'footer_menu_2';
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term( $theme_locations[$location_name], 'nav_menu' ); 
        if(isset($menu_obj->name)):
            echo '<div class="h5">'.$menu_obj->name.'</div>';
            wp_nav_menu( array( 'theme_location' => $location_name, 'fallback_cb' => false, 'depth' => 1 ) ); 
        endif;
    }
}