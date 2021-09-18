<?php 
// Add css and js
add_action('wp_enqueue_scripts', 'theme_files');
function theme_files() {

    // filetime for versions
    $themecsspath = get_stylesheet_directory().'/build/style.min.css';
    $themescriptpath = get_stylesheet_directory().'/build/script.min.js';

    $style_ver = filemtime($themecsspath);
    $script_ver = filemtime($themescriptpath);

    //css
    wp_enqueue_style('main_css', get_stylesheet_directory_uri() . '/build/style.min.css', array(), $style_ver, 'all');
    wp_enqueue_style('op-googlefont', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    wp_enqueue_style('slickslider', get_stylesheet_directory_uri() . '/assets/lib/slickslider/slick.css', array(), $style_ver, 'all');
   
    //js
    wp_enqueue_script('main_js', get_stylesheet_directory_uri() . '/build/script.min.js', array('jquery'), $script_ver, true);
    wp_enqueue_script('header_usp_js', get_stylesheet_directory_uri() . '/assets/js/header_usp.js', array('jquery'), $script_ver, true);
    wp_localize_script(	'main_js',	'ajax_obj',	array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/9ff39bd9bf.js', array('jquery'), $script_ver, true);
    wp_enqueue_script('slickslider', get_stylesheet_directory_uri() . '/assets/lib/slickslider/slick.min.js', array('jquery'), $script_ver, true);
    
    if(is_archive('product_cat') || is_tax('product_brand')):
        wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_script('jquery-ui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), false, false);
        wp_enqueue_script('jquery-ui-touch', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js', array('jquery'), false, false);
    endif;
}

//make it posible to use svg instead of i tag
add_filter('script_loader_tag', 'add_data_attribute', 10, 2);
function add_data_attribute($tag, $handle) {
    if ( 'fontawesome' !== $handle )
     return $tag;
 
    return str_replace( ' src', 'data-search-pseudo-elements crossorigin="anonymous" src', $tag );
 }

 add_action('admin_head', 'op_product_cat_admin_styling'); 
 function op_product_cat_admin_styling() {
    //product_cat admin pagewidth
    echo '<style>
        .wp-admin.taxonomy-product_cat #edittag,
        .wp-admin.taxonomy-product_brand #edittag{
            max-width: unset;
        }
    </style>';
}
 
?>