<?php

 //add admin editor style
 add_action( 'admin_init', 'op_add_editor_styles' );
 function op_add_editor_styles() {
 
     $themecsspath = get_stylesheet_directory().'/assets/css/admin-style.css';
     $style_ver = filemtime($themecsspath);
     add_editor_style( get_stylesheet_directory_uri().'/assets/css/admin-style.css?'. $style_ver );
 }

// Callback function to filter the MCE settings
add_filter( 'mce_buttons_2', 'op_mce_buttons_2' );
function op_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
   
// Callback function to insert 'styleselect' into the $buttons array
add_filter( 'tiny_mce_before_init', 'op_mce_before_init_insert_formats' );    
function op_mce_before_init_insert_formats( $init_array ) {  
    // Define the style_formats array
    $style_formats = array(  
        // Each array child is a format with it's own settings
        // array(  
        // 'title' => 'underoverskrift',  
        // 'inline' => 'span',  
        // 'classes' => 'underoverskrift',
        // 'wrapper' => true,      
        // ),
        // array(  
        //     'title' => 'manchet',  
        //     'inline' => 'span',  
        //     'classes' => 'manchet',
        //     'wrapper' => true,      
        // ),
        // array(  
        //     'title' => 'overskrift',  
        //     'selector' => 'h1,h2,h3,h4,h5,h6',  
        //     'classes' => 'op_overskrift',
        //     'wrapper' => true,      
        // ),
        // array(  
        //     'title' => 'Link knap',  
        //     'selector' => 'a',  
        //     'classes' => 'button',
        //     'wrapper' => false,      
        // ),



    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 

?>