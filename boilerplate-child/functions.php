<?php 
// Enqueue
get_template_part('functions/enqueue');

// add features
get_template_part('functions/features');
//get_template_part('functions/editor')

// Add custom post types
//get_template_part('functions/customposttypes');

// remove admin menus
get_template_part('functions/restrictions');
get_template_part('functions/remove_post'); //remove posts

//options page (ACF is needed)
get_template_part('functions/optionspage'); 
get_template_part('functions/acf'); 

//Custom functions
get_template_part('functions/shortcodes');
get_template_part('functions/customfunctions');
get_template_part('functions/menu'); 

//Ajax
get_template_part('functions/ajax/produkt_filter'); 
get_template_part('functions/ajax/remove_shop_notice'); 

//Formidable functions
get_template_part('functions/formidable');

//woocommerce functions
get_template_part('functions/woocommerce');
get_template_part('functions/woocommerce_single');
get_template_part('functions/woocommerce_loop');
get_template_part('functions/brands');
get_template_part('functions/woocommerce_cart');
get_template_part('functions/woocommerce_checkout');
get_template_part('functions/woocommerce_account');
get_template_part('functions/woocommerce_farvoritter');

//hooks
get_template_part('functions/hooks/header_hooks');
get_template_part('functions/hooks/footer_hooks');
get_template_part('functions/hooks/tracking');

// remove Gutenberg
// add_filter('use_block_editor_for_post', '__return_false', 10);

// Remove the content editor on pages
add_action('admin_init', 'remove_textarea');
function remove_textarea() {
    remove_post_type_support( 'page', 'editor' );
    remove_post_type_support( 'post', 'editor' );
};
