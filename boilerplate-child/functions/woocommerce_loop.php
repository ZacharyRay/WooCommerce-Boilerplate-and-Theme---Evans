<?php

//add_filter('woocommerce_loop_add_to_cart_link', '__return_null');

add_filter('woocommerce_show_page_title', false); //remove woocmmerce_page_ttle

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action( 'woocommerce_archive_description', 'op_product_filter_div', 25);
function op_product_filter_div(){
    if ( is_product_category() || is_tax('product_brand')): 
        get_sidebar( 'produkt_filter' );
        //echo '<div class="op_archive_wrapper">';
    endif;
}
//add_action('woocommerce_after_main_content', 'op_end_op_archive_wrapper', 11);
function op_end_op_archive_wrapper(){
    if ( is_product_category() || is_tax('product_brand')): 
        //echo '</div>';
    endif;
}



//Filter
function get_woo_egenskaber(){
    $results = array();

    $attribute_taxonomies = wc_get_attribute_taxonomies();
    //pre($attribute_taxonomies);
    if ( $attribute_taxonomies ) :
        foreach ( $attribute_taxonomies as $tax ) :
            $results[$tax->attribute_name] = esc_html( $tax->attribute_label ); //$tax->attribute_id
        endforeach;
    endif;

    return $results;
}

add_filter('acf/load_field/name=produkt_filter_parameter', 'load_woo_egenskaber');
function load_woo_egenskaber( $field ){
  
  
        $result = get_woo_egenskaber();
        if( is_array($result) ){
            $field['choices'] = array();
            
            foreach( $result as $key => $match ){
                $field['choices'][ $key ] = $match;
            }
        }
        return $field; 
}

add_filter('get_produkt_filter_parameter', 'get_produkt_filter_parameter');
function get_produkt_filter_parameter($id){

    //Find de egenskaber der skal filtreres
    $ancestors = get_ancestors($id, 'product_cat');
    array_unshift($ancestors, $id ); //Prepend id
    //pre($ancestors);

    if($ancestors):
        foreach ($ancestors as $value):
    
            $filter = get_field('produkt_filter_parameter', 'term_'.$value);
            
            if($filter):
                return $filter;
            endif;
    
        endforeach;
    
    endif;

    if(!$filter):
        $default_filter_array = array (
            array(
                     'value' => 'farve',
                     'label' => 'Farve'
            ),
            array(
                     'value' => 'stoerrelse',
                     'label' => 'Størrelse'
             )
         );
 
         return $default_filter_array;
    endif;
} 

//OBS: delete?
function price_filter_array(){

    $price_array = array(
        'range_1' => array(
             'start' => '0',
             'end' => '199'
         ),
         'range_2' => array(
             'start' => '200',
             'end' => '399'
         ),
         'range_3' => array(
             'start' => '400',
             'end' => '699'
         ),
         'range_4' => array(
             'start' => '700',
             'end' => '999'
         ),
         'range_5' => array(
             'start' => '1000',
             'end' => '1499'
         ),
         'range_6' => array(
             'start' => '1500',
             'end' => '2999'
         ),
         'range_7' =>array(
             'start' => '3000',
             'end' => '',
             'seperator' => __('og over')
         )
     );

     return $price_array;

}

add_action('woocommerce_after_main_content', 'op_add_acf_sections', 10);
function op_add_acf_sections(){
    if ( is_product_category() || is_tax('product_brand')): 
        set_query_var( 'page_id', get_queried_object());   
        get_template_part('elements/acf', 'sectioner');
    endif;
}


?>