<?php

//bredcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

//product gallery

add_filter( 'woocommerce_gallery_image_size', function( $size ) {
    return 'gallery';
} );

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'filter_woocommerce_single_product_image_thumbnail_html', 10, 2 );
function filter_woocommerce_single_product_image_thumbnail_html( $html, $post_thumbnail_id) {   
    
    if ( $post_thumbnail_id ) {
        $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
    } else {
        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
        $html .= '</div>';
    }

    return $html; 
}; 

add_action( 'woocommerce_before_single_product_summary', 'op_gallery_thumbnails', 22);
function op_gallery_thumbnails(){

    global $product;
 
    $post_thumbnail_id = $product->get_image_id();
    $post_thumbnail_ids = $product->get_gallery_image_ids();
    array_unshift($post_thumbnail_ids, $post_thumbnail_id);
    
    if ( count($post_thumbnail_ids) > 1 ) { //&& $product->get_image_id() 
        echo '<div class="woocommerce-product-gallery-thumbnails">';
        foreach ( $post_thumbnail_ids as $attachment_id ) {
            $image             = wp_get_attachment_image(
                                    $attachment_id, 
                                    'gallery_thumb', 
                                    false,
                                    array(
                                        'title'=> _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                                    ),
                                );

            echo '<div class="op_woocommerce-product-gallery__image">' . $image . '</div>';
          
      
        }
        echo '</div>';

    }else{
    }
}

//produckt data_tabs


//varenummer
add_action('woocommerce_single_product_summary', 'op_sku', 9 );
function op_sku(){
    global $product;
    $sku = $product->get_sku();
    if($sku):
        echo '<div class="product_sku"><span>'.__('Varenr.', 'op-theme').'</span> '.$sku.'</div>';
    endif;
}

//Select
add_action('op_variation_before_label', 'variation_before_label', 10);
function variation_before_label($name){
    echo __('Vælg','op-theme').' ';
}

//storrelsesguide
//add_action('op_variation_after_label', 'storrelsesguide', 10);
function storrelsesguide($name){

    $size_guide = get_field('storrelsesguide');
    if($size_guide && $name == 'pa_stoerrelse'):       
       echo ' <span class="size_guide" data-popup="storrelsesguide">'.__('Størrelsesguide', 'op-themes').'</span>';
    else:
    endif;

}
//storrelsesguide popup
//add_action('wp_footer', 'storrelsesguide_popup');
function storrelsesguide_popup(){
    $size_guide = get_field('storrelsesguide');
    if($size_guide):
        echo '<div id="storrelsesguide" class="popup">';
            echo '<div class="pupup_content">';
                    echo $size_guide;
                    echo '<div class="popup_close"><i class="fal fa-times"></i></div>';
            echo '</div>';
            
        echo '</div>';
    endif;

}

//pakkeafsendelse
add_action('woocommerce_single_product_summary', 'op_pakkeafsendelse', 30 );
function op_pakkeafsendelse(){
    //date_default_timezone_set('Europe/Copenhagen');
    $today = date('w', strtotime('now'));
    $i = 0;

    do {

        if(($today + 1) == 8){
            $today = 0;
        }

        $dayOfWeek = get_day_name($today);
        $delivery_time = (get_field($dayOfWeek, 'option') ? : ''); //Get time
        $delivery_day = date_i18n('U', strtotime('+'.$i.' day '.$delivery_time)); //create day string
        
        //echo $i.' - '.$delivery_time;       
        //echo date_i18n('U') .' - '. $delivery_day .'<br>';

        if ($delivery_time && date_i18n('U') < $delivery_day) { //echo '1 <br><br>';
            $next_delivery = date_i18n('c', strtotime('+'.$i.' day '.$delivery_time)) ;
        }else{
            //echo '2 <br><br>';
        }
        
        $today++;
        $i++;
       
    }while ($next_delivery == '' && $i < 8);

    if($next_delivery != ''):

        //Find time difference
        $now = date_i18n('Y-m-d H:i:s');
        $interval = date_diff(date_create($now), date_create($next_delivery));
        
        $nedtælling_html =  '<span id="days" class="days" data-single="'.__('dag', 'op-theme').'" data-multiple="'.__('dage', 'op-theme').'">'.$interval->format('%d').' '.__('dage', 'op-theme').'</span>
                            <span id="hours" class="hours" data-single="'.__('time', 'op-theme').'" data-multiple="'.__('timer', 'op-theme').'">'.$interval->format('%h').' '.__('timer', 'op-theme').'</span>
                            <span id="minutes" class="minutes" data-single="'.__('minut', 'op-theme').'" data-multiple="'.__('minutter', 'op-theme').'">'. $interval->format('%i').' '.__('minutter', 'op-theme').'</span> '.__('og', 'op-theme').' 
                            <span id="seconds" class="seconds" data-single="'.__('sekund', 'op-theme').'" data-multiple="'.__('sekunder', 'op-theme').'">'.$interval->format('%s').' '.__('sekunder', 'op-theme').'</span>'; 
       
        echo '<div class="pakkeafsendelse">';  
            echo '<i class="fal fa-shipping-fast"></i> '.sprintf(__('Vi sender din pakke om <span class="countdown_time" data-countdown="%s" data-reload="%s" >%s</span>'), $next_delivery, __('genindlæs siden', 'op-theme'), $nedtælling_html );
        echo '</div>';

    endif;

    
}


//pakkeafsendelse
add_action('woocommerce_single_product_summary', 'op_product_usp', 31 );
function op_product_usp(){
    if(have_rows('header_usp' , 'option')):
        echo '<div id="product_usp">';
            while(have_rows('header_usp', 'option')): the_row(); 
                set_query_var('icon', true);
                get_template_part('loop', 'usp');
            endwhile; 
        echo '</div>';
    endif;
}


//product info
add_action('woocommerce_single_product_summary', 'op_description', 35 );
function op_description(){
   
    echo '<div class="product_description">'.get_the_content().'</div>';
}

//produckt data_tabs
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 70 );

add_filter( 'woocommerce_product_additional_information_heading', '__return_null' );

add_filter( 'woocommerce_product_tabs', 'op_product_tabs' );
function op_product_tabs( $tabs ) {
  
    // Adds the new tab
    if(get_field('produkt_detaljer')):
        $tabs['details_tab'] =  array(
            'title'     => __( 'Detaljer', 'op-theme' ),
            'priority'  => 50,
            'callback'  => 'op_details_tab_callback'
        );
    endif;

    if(get_field('produkt_levering')):
        $tabs['deliver_tab'] = array(
            'title'     => __( 'Levering', 'op-theme' ),
            'priority'  => 60,
            'callback'  => 'op_delever_tab_callback'
        );
    endif;

    if(get_field('storrelsesguide')):
        $tabs['size_tab'] = array(
            'title'     => __( 'Størrelsesguide', 'op-theme' ),
            'priority'  => 40,
            'callback'  => 'op_size_tab_callback'
        );
    endif;

    $tabs['additional_information']['title'] = __( 'Specifikationer', 'op-theme' );	// Rename the additional information tab
    $tabs['additional_information']['priority'] = 10;

    global $product;
    if(!$product->has_attributes() && !$product->has_weight() && !$product->has_dimensions()):
        unset( $tabs['additional_information'] );  
    endif;

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab

    return $tabs;
}
function op_details_tab_callback() {
	echo get_field('produkt_detaljer');
}
function op_delever_tab_callback(){
    echo get_field('produkt_levering');
}
function op_size_tab_callback(){
 
    echo get_field('storrelsesguide');
}

add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'op_dropdown_variation_attribute_options_args', 10, 1 ); 
function op_dropdown_variation_attribute_options_args($args){
    //pre($args);
    $attribute_label = mb_strtolower( apply_filters( 'the_title', wc_attribute_label( $args['attribute'] ),'UTF-8') );
    if($attribute_label ):
        $args['show_option_none'] = __('Vælg', 'op-theme').' '.  $attribute_label;
    endif;

    return $args;
}


add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'size_selector', 10, 2 );
function size_selector($html, $arg){
    
    $markup = '';
    $attribute_name = 'pa_stoerrelse';

    if($arg['attribute'] == $attribute_name):
  
        //pre($arg['options']);
        $terms = wc_get_product_terms(
            get_the_id(),
            $attribute_name,
            array(
                'fields' => 'all',
            )
        );
        
        if(is_array($terms)):
            $markup .= '<div id="'.$attribute_name.'_variations" class="variation_buttons">';  //Der er lavet javascript til denne
            foreach ($terms as $term):	
                $markup .= '<div class="variation_button" data-attribute-name="'.$attribute_name.'" data-value="'.$term->slug.'">'.$term->name.'</div>';		
            endforeach;
            $markup .= '</div>';
        else:
            $markup .= 'none';
        endif;
        
        return $html .' '.$markup;
    else:
        return $html;
    endif;
}


add_filter('woocommerce_stock_html', 'test', 10, 3);
function test($html, $availability, $product){
    
    if($product->get_total_stock() == 0):
        return $html;
    endif;

    if($product->get_total_stock() < 5 ):
        return '<p class="stock in-stock">'.sprintf(__('Der er <strong>KUN %d</strong> tilbage'), $product->get_total_stock()).'</p>';
    else:
        return '<p class="stock in-stock">'.sprintf(__('Der er %d stk. på lager'), $product->get_total_stock()).'</p>';
    endif;
}

?>