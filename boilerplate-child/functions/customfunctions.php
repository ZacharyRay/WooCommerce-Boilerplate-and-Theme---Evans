<?php 
if (!function_exists('pre')):
    function pre($obj) {
        echo '<pre>';
        if (is_array($obj) || is_object($obj)):
            print_r($obj);
        else:
            print $obj;
        endif;
        echo '</pre>';
        return;
    }
endif;

add_filter('op_email', 'op_email');
function op_email($email){
    return '<a href="mailto:'.$email .'" >'.$email.'</a>';
     //apply_filters('op_email', $telefon); //call in template
}   

add_filter('op_telefon', 'op_telefon');
function op_telefon($telefon){
    if(strpos($telefon, '+45') === 0){
        $tel_url = $telefon;
    }else{
         $tel_url = '+45'.$telefon;
    }
    $tel_url = str_replace (" ", "", $tel_url);
    return '<a href="tel:'.$tel_url .'" >'.$telefon.'</a>';
     //apply_filters('op_telefon', $telefon); //call in template
}


add_filter('body_class', 'add_browser_classes');
function add_browser_classes($classes){
    
    if(is_singular()) {
    	global $post;
    	$classes[] = $post->post_name;
    }

    //add browser classes
    // A little Browser detection shall we?
    $browser = $_SERVER[ 'HTTP_USER_AGENT' ];
 
    // Mac, PC ...or Linux
    if ( preg_match( "/Mac/", $browser ) ){
        $classes[] = 'mac';
 
    } elseif ( preg_match( "/Windows/", $browser ) ){
        $classes[] = 'windows';
 
    } elseif ( preg_match( "/Linux/", $browser ) ) {
        $classes[] = 'linux';
 
    } else {
        $classes[] = 'unknown-os';
    }
 
    // Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
    if ( preg_match( "/Chrome/", $browser ) ) {
		$classes[] = 'chrome';
 
        preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
        $classesh_version = 'ch' . str_replace( '.', '-', $matches[1] );
        $classes[] = $classesh_version;
 
    } elseif ( preg_match( "/Safari/", $browser ) ) {
		$classes[] = 'safari';
		preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
		$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
		$classes[] = $sf_version;
 
    } elseif ( preg_match( "/Opera/", $browser ) ) {
		$classes[] = 'opera';
		preg_match( "/Opera\/(\d.\d)/si", $browser, $matches);
		$op_version = 'op' . str_replace( '.', '-', $matches[1] );
		$classes[] = $op_version;
 
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
		$classes[] = 'msie';
		if( preg_match( "/MSIE 6.0/", $browser ) ) {
         	$classes[] = 'ie6';
		} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
         	$classes[] = 'ie7';
		} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
         	$classes[] = 'ie8';
		} elseif ( preg_match( "/MSIE 9.0/", $browser ) ){
         	$classes[] = 'ie9';
		}
		} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
         	$classes[] = 'firefox';
         	preg_match( "/Firefox\/(\d)/si", $browser, $matches);
         	$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
         	$classes[] = $ff_version;
	} else {
		$classes[] = 'unknown-browser';
	}

    return $classes;
}
?>