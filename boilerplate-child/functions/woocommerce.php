<?php

/* Add woocommerce support */
add_action( 'after_setup_theme', 'op_add_woocommerce_support' );
function op_add_woocommerce_support() {    
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 250,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'max_rows'        => 4,
            'default_columns' => 5,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );

    if ( ! isset( $content_width ) ) {
        $content_width = 1920;
    }

    add_theme_support('wc-product-gallery-lightbox');
    //add_theme_support('wc-product-gallery-slider');
}



add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 10; //EDIT
  return $cols;
}

/* Remove default woocommerce styling */
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/* Theme support */
remove_theme_support( 'wc-product-gallery-zoom' );

/* Content wrapper  */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'op_content_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'op_content_wrapper_end', 10);

function op_content_wrapper_start() {
    echo '<section class="op-woocommerce">';
    echo '<div class="container">';
}

function op_content_wrapper_end() {
    echo '</div>';
    echo '</section>';
}

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);


/*product gallery */
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash');
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
add_action( 'woocommerce_before_shop_loop_item_title', 'op_badge_shop_page', 3 );
add_action( 'woocommerce_before_single_product_summary', 'op_badge_shop_page', 10 );

function op_badge_shop_page() {
    global $product;

    echo '<div class="badge_w">';

    //sale badge
    if ( $product->is_on_sale() )  {    

        if( $product->is_type('variable')){
            $percentages = array();
    
            // Get all variation prices
            $prices = $product->get_variation_prices();
    
            // Loop through variation prices
            foreach( $prices['price'] as $key => $price ){
                // Only on sale variations
                if( $prices['regular_price'][$key] !== $price ){
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
                }
            }
            //get highest
            $percentage = '<span class="up_to">'.__('Op til','op-theme').'</span>'.''. max($percentages) . '%';

        }else if($product->is_type( 'grouped' )){
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();
            $percentage    = 'Tilbud';
        }else {
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();
    
            $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
        }

        echo '<span class="badge sale_badge">'.
                '<span class="sale_text">' .$percentage. '</span>'.
            '</span>';
    }

    //new badge    
    $news_days = get_field('nyheder_dage', 'option');
    $created = strtotime( $product->get_date_created() );
    if ( ( time() - ( 60 * 60 * 24 * $news_days ) ) < $created ) {
        echo '<span class="badge news_badge"><span class="sale_text">' . esc_html__( 'Nyhed', 'op-theme' ) . '</span></span>';
    }

    echo '</div>';
}

//relatede products
add_filter( 'woocommerce_output_related_products_args', 'op_related_products_args', 20 );
function op_related_products_args( $args ) {
	$args['posts_per_page'] = 5; // 4 related products
	$args['columns'] = 5; // arranged in 2 columns
	return $args;
}

//Pagination
add_filter('woocommerce_pagination_args', 'op_comment_pagination_args');
function op_comment_pagination_args($args){
    $args['prev_text'] = '<i class="far fa-long-arrow-left"></i> <span class="text"> '.__('Forrige', 'op-theme').'</span>';
    $args['next_text'] = '<span class="text">'.__('Næste', 'op-theme').'</span> <i class="far fa-long-arrow-right"></i>';
    $args['end_size'] = '2';
    $args['mid_size'] = '2';
    $args['show_all'] = true;

    return $args;
}

//Search only for products
add_action( 'pre_get_posts', 'search_woocommerce_only' );
function search_woocommerce_only( $query ) {
  if( ! is_admin() && is_search() && $query->is_main_query() ) {
    $query->set( 'post_type', 'product' );
  }
}

add_filter('woocommerce_show_page_title', 'search_title');
function search_title(){
    if( ! is_admin() && is_search() ) {
        echo '<h1 class="woocommerce-products-header__title page-title">'. __('Du søgte efter', 'op-theme').': '.get_search_query().'</h1>';
      
    }
}

add_action('woocommerce_shortcode_sale_products_loop_no_results', 'filter_shortcodes', 10);
function filter_shortcodes(){
   echo '<p class="woocommerce-info">'.__('Der blev ikke fundet nogle varer, der matcher dit valg', 'op-theme').'</p>';
}




?>