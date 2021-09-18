<?php 
add_action('init', 'setup_session', 1);
function setup_session() {

    if(!session_id()) {
        session_start();
    }
}

add_action('after_setup_theme', 'theme_features');
function theme_features() {

    add_theme_support('title-tag');
   
    register_nav_menus(
        array(
            'header_menu'=> __('Header menu', 'op-theme'),
            'footer_menu_1'=> __('Footer menu 1', 'op-theme'),
            'footer_menu_2'=> __('Footer menu 2', 'op-theme'),
        ) 
    );
   
}

// image sizes
add_action( 'after_setup_theme', 'theme_image_sizes' );
function theme_image_sizes() {
    
    add_image_size( 'banner', 1920 , 360, true ); 
    add_image_size( 'brands', '' , 45 , false );

    $varekategori_ratio = (675 / 1400 ); // brede / højde
    add_image_size( 'varekategori_stor', 1400, round(1400*$varekategori_ratio), true);   
    add_image_size( 'varekategori_stor_xs', 320, round(320*$varekategori_ratio), true);
    add_image_size( 'varekategori_stor_sm', 375, round(375*$varekategori_ratio), true);
    add_image_size( 'varekategori_stor_md', 768, round(768*$varekategori_ratio), true);
    add_image_size( 'varekategori_stor_lg', 1024, round(1024*$varekategori_ratio), true);

    add_image_size( 'varekategori_lille', 450, 450, true);
   
    $billede_ratio = (627 / 768 ); // brede / højde
    add_image_size( 'billede', 768, round(768*$billede_ratio), true);
    add_image_size( 'billede', 345, round(345*$billede_ratio), true);

    add_image_size( 'gallery', 600 , 600 , true );
    add_image_size( 'gallery_thumb', 92 , 92 , true );

    
}
add_filter('strtolower_utf8', 'strtolower_utf8');
function strtolower_utf8($inputString){
    $outputString    = utf8_decode($inputString);
    $outputString    = strtolower($outputString);
    $outputString    = utf8_encode($outputString);

    return $outputString;
}

function get_day_name($today){

    switch ($today){
        case 0:
            return 'pakkeafsendelse_soendag';
        case 1:
            return 'pakkeafsendelse_mandag';
        case 2:
            return 'pakkeafsendelse_tirsdag';
        case 3:
            return 'pakkeafsendelse_onsdag';
        case 4:
            return 'pakkeafsendelse_torsdag';
        case 5:
            return 'pakkeafsendelse_fredag';
        case 6:
            return 'pakkeafsendelse_loerdag';
        default:
            return '';
    }
}

function round_max_price(){

    $query = new WP_Query( array(
        'post_type' => 'product',
        'posts_per_page' => '1',
        'order' => 'DESC',
        'orderby' => 'meta_value_num',
        'meta_key'  => '_price'
    ));
  
    
    if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
            $product = wc_get_product( get_the_ID() );
            //echo $product->get_price() .' - '. ceil( $product->get_price() / 100 ) * 100  ;
            return ceil( $product->get_price() / 100 ) * 100; //closes 100
        endwhile;
    endif;
    


}
?>