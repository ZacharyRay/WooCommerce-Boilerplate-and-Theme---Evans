<?php

add_action( 'wp_ajax_nopriv_product_filter', 'ajax_product_filter' );
add_action( 'wp_ajax_product_filter', 'ajax_product_filter' );
function ajax_product_filter() {

    check_admin_referer( 'product_filter', 'product_filter_nonce' );

    // //product_cat
    if($_POST['product_brand']):
        $term_id = $_POST['product_brand'];
        $taxonomy = 'product_brand';
    else:
        $term_id = $_POST['p_cat'];
        $taxonomy = 'product_cat';
    endif;

    //sorting
    $sorting = $_POST['orderby'];
    $meta_key = '';
    switch ($sorting) {
        case 'popularity': 
            $sorting_value = 'meta_value_num';
            $order_value = 'DESC';
            $meta_key = 'total_sales';
            break;
        case 'date':
            $sorting_value = 'date';
            $order_value = 'DESC';
            $meta_key = '';
            break;
        case 'price':
            $sorting_value = 'meta_value_num';
            $order_value = 'ASC';
            $meta_key = '_price';
            break;
        case 'price-desc':
            $sorting_value = 'meta_value_num';
            $order_value = 'DESC';
            $meta_key = '_price';
            break;
       default:
            $sorting_value = 'meta_value_num';
            $order_value = 'ASC';
            $meta_key = '_price';
            break;
    }

    //attributes
    $pa_array['relation'] = 'AND';
    $filter_egenskaber = apply_filters('get_produkt_filter_parameter', $product_cat); //hent filter parameter
    
    if(isset($filter_egenskaber)):
        foreach ($filter_egenskaber as $f): 
            $pa_name = 'pa_'.$f['value'];

            if(isset($_POST[$pa_name])):
                $pa_array[] = array(
                    'taxonomy' => $pa_name,
                    'field' => 'term_id',
                    'terms' => $_POST[$pa_name],
                    'operator' => 'IN' // 'EXISTS'
                    
                );
            endif;
        endforeach;
    endif;

    //prices
    // $prices = $_POST['price'];
    // $price_array = price_filter_array(); //global pricearray
    $price_min = $_POST['min'];
    $price_max = $_POST['max'];
    $meta_query = array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
        ),
        array(
            'key' => '_price',
            'value' => array($price_min, $price_max),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        )
    );

    //pre($_POST);
    $paged = $_POST['p_num']; // ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $args = array(
		//'lang' => ICL_LANGUAGE_CODE,
        'post_status' => 'publish',
        'post_type' => array('product', 'product_variation'), 
        'posts_per_page' =>  10, //EDIT -1
        'paged' => $paged,
        'order' => $order_value,
        'orderby' => $sorting_value,
        'meta_key'  => $meta_key,
        'meta_query' => $meta_query,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $term_id,          
            ),
            $pa_array       
        ),
	);
   
    $query = new WP_Query( $args );
    //pre($query);
    //pre($query->query);

    // $found_posts = $query->found_posts;
    // $max_num_pages = $query->max_num_pages;
    // $html =  '<div style="grid-column: 1/-1;">
    //     Posts: '.$found_posts.' <br>
    //     Pages: '.$max_num_pages.'
    //     '.$query.'        
    // </div>';

    // $html = '<div style="grid-column: 1/-1;">';
    //     $html .= apply_filters('remove_filter_information', $_POST);  
    //     ob_start(); 
    //     $html .= pre($query->query);     
    //     $html .= ob_get_contents();
    //     ob_end_clean(); 
    // $html .= '</div>';

	if( $query->have_posts() ) :
        ob_start();
		while( $query->have_posts() ): $query->the_post();
            wc_get_template_part( 'content', 'product' );            
		endwhile;
        $html .= ob_get_contents();
		wp_reset_postdata();
        ob_end_clean();
	else :
		$html .=  '<div class="no-products">'.__('Der blev ikke fundet nogle varer, der matcher dit valg', 'op-theme').'</div>';
	endif;

    $total   = $query->max_num_pages;
    //$base = get_site_url().$_POST['_wp_http_referer'].'?page=%#%';
    $base = $_POST['url'].'page/%#%/';    
    $format  =  ''; 

    $pagination = paginate_links(
		apply_filters(
            'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
                'add_fragment' => '?'.apply_filters('remove_filter_information', $_POST),
				'current'   => max( 1, $paged ),
				'total'     => $total,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			) 
		)
	);

    echo json_encode(array(
        'html' => $html, 
        'pagination' => $pagination,
        'post' => $_POST,
        'query_string' => '?'.apply_filters('remove_filter_information', $_POST),
    ));
    
    die();
}


add_filter('remove_filter_information', 'remove_filter_information');
function remove_filter_information($args){

    unset($args["p_num"]);
    unset($args["p_cat"]);
    unset($args["url"]);
    unset($args["_wp_http_referer"]);
    unset($args["product_filter_nonce"]);
    unset($args["action"]);

    //pre($args);

    foreach ($args as $name => $value) {
        if(substr( $name, 0, 3 ) === "pa_"): //str_starts_with($name, 'pa_') php8
            $args[$name] = implode( '.', $args[$name] );
        endif;
    }

    $url = http_build_query($args);
   
    return $url;
}

add_action( 'pre_get_posts', 'woocommerce_pre_get_posts', 9 );
function woocommerce_pre_get_posts( $query ) {

    if ( ! is_admin() && $query->is_main_query() && is_archive('product_cat')  ) {
           
        //Orderby is taken care of woocommerce function woocommerce_catalog_ordering by using querystring Orderby
        
        $price_min = $_GET['min'];
        $price_max = $_GET['max']; 
        if(isset($price_min) && isset($price_max)):
            //Get original meta query
            $meta_query = ( is_array( $query->get('meta_query') ) ) ? $query->get('meta_query') : [];

            //Add our meta query to the original meta queries
            $meta_query[] = array(
                'key' => '_price',
                'value' => array($price_min, $price_max),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            );
            $query->set('meta_query',$meta_query);

        endif;

        //pa_*

        $selected_pa_filter = explode_filter_querystring($_SERVER['QUERY_STRING']);
        if(is_array($selected_pa_filter) && !empty($selected_pa_filter)):
            $tax_query = ( is_array( $query->get('tax_query') ) ) ? $query->get('tax_query') : [];
            $tax_query_pa['relation'] =  'AND';

            foreach($selected_pa_filter as $pa_name => $values):
                $tax_query_pa[] = array(
                    'taxonomy' => $pa_name,
                    'field' => 'term_id',
                    'terms' => $values,      
                    'operator' =>  'IN' //'EXISTS' //'IN'                  
                );
            endforeach;
            $tax_query[] = $tax_query_pa;
            

            $query->set('tax_query', $tax_query);
        endif;

        //$query->set('posts_per_page', 5);

        //pre($query);
    }
}

function explode_filter_querystring($query_string){
   
    $query_parameters = explode('&', $query_string);
  
    $data = [];
   
    foreach($query_parameters as $pa_name):

        if(substr( $pa_name, 0, 3 ) === "pa_"):

            $term = explode('=', $pa_name);
            $values = explode('.', $term[1]);

            $data[$term[0]] = $values;

        endif;
    endforeach;

    return $data; 
}
  

?>