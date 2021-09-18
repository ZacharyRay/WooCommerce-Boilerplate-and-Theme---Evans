<?php 

add_action( 'init', 'create_custom_posttype' );
function create_cpt_posttype() {
    register_post_type(
        'custom_posttype', 
        array(
            'labels' => array(
                'name'               => __( 'Custom posttype', 'op-theme' ), //EDIT
                'singular_name'      => __( 'Custom posttyper', 'op-theme' ), //EDIT	
                'add_new'            => __( 'Tilføj ny', 'op-theme' ),
                'add_new_item'       => __( 'Tilføj ny', 'op-theme' ),
                'edit_item'          => __( 'Rediger', 'op-theme' ),
                'new_item'           => __( 'Ny', 'op-theme' ),
                'view_item'          => __( 'Vis', 'op-theme' ),
                'search_items'       => __( 'Søg', 'op-theme' ),
                'not_found'          => __( 'Intet fundet', 'op-theme' ),
                'not_found_in_trash' => __( 'Intet fundet i papirkurven', 'op-theme' ),
            ),
           'supports' => array(
                'title',
                //'editor',
                //'thumbnail',
                //'custom-fields',
                //'revisions',
            ),
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'custom_posttype'), //EDIT
            'menu_position'   => 5,
            'menu_icon' => 'dashicons-admin-page', //https://developer.wordpress.org/resource/dashicons
            'public' => true,
            'show_ui' => true, 
            'show_in_nav_menus' => true,
            'exclude_from_search' => false, 
            'has_archive' => true,            
            'show_in_rest' => false,
        )
    );
}

register_taxonomy( 
    'custom_tax', 
    array('cpt'), 
    array(
        'labels' => array(
                'name'                       => __( 'Custom tax', 'op-theme' ), //EDIT
                'singular_name'              => __( 'Custom tax', 'op-theme' ), //EDIT
                'menu_name'                  => __( 'Custom tax', 'op-theme' ), //EDIT
                'edit_item'                  => __( 'Rediger', 'op-theme' ),
                'update_item'                => __( 'Opdater', 'op-theme' ),
                'add_new_item'               => __( 'Tilføj ny', 'op-theme' ),
                'new_item_name'              => __( 'Ny', 'op-theme' ),
                'parent_item'                => __( 'Forældre kategori', 'op-theme' ),
                'parent_item_colon'          => __( 'Forældre kategori:', 'op-theme' ),
                'all_items'                  => __( 'Alle Kategorier', 'op-theme' ),
                'search_items'               => __( 'Søg i kategori', 'op-theme' ),
                'popular_items'              => __( 'Populærer kategorier', 'op-theme' ),
                'separate_items_with_commas' => __( 'Adskil kategorier med kommaer', 'op-theme' ),
                'add_or_remove_items'        => __( 'Tilføj eller fjern kategorier', 'op-theme' ),
                'choose_from_most_used'      => __( 'Vælg blandt de mest brugte kategorier', 'op-theme' ),
                'not_found'                  => __( 'Ingen kategorier fundet.', 'op-theme' ), 
        ),
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_tagcloud'     => false,
        'hierarchical'      => true,
        'rewrite'           => array( 'slug' => 'custom_tax' ), //EDIT
        'show_admin_column' => true,
        'query_var'         => true,
    )
    );  

add_filter( 'enter_title_here', 'op_cpt_title_text' );
function op_cpt_title_text( $title ){
    $screen = get_current_screen();
 
    if  ( 'cpt' == $screen->post_type ) {
         $title = 'Navn'; //EDIT
    }
 
    return $title; 
}
 
?>