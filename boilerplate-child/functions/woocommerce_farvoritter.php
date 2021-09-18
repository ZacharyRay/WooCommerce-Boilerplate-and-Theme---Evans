<?php

add_action('woocommerce_after_add_to_cart_button', 'add_favorits', 10);
function add_favorits(){
    $current_user = get_current_user_id();
    $favoritter = get_field('favoritter', 'user_'.$current_user);
    $current_product_ID = get_the_ID();
    
    if(is_user_logged_in()):

        if (in_array($current_product_ID, $favoritter)) :
            echo '<button class="favoritter"  data-type="remove" data-id="'.$current_product_ID.'"><i class="fas fa-heart"></i> '.__('Fjern fra favoritter', 'option').'</button>';
        else:
            echo '<button class="favoritter" data-type="add" data-id="'.$current_product_ID.'" ><i class="fal fa-heart"></i> '.__('Tilføj til favoritter', 'option').'</button>';
        endif;

    else:
        echo '<button class="favoritter" data-type="nothing" data-id="'.$current_product_ID.'" disabled title="'.__('Login for at bruge favoritter', 'op-theme').'" ><i class="fal fa-heart"></i> '.__('Tilføj til favoritter', 'option').'</button>';
    endif;
}

//remove from favorit page
add_action('woocommerce_after_shop_loop_item', 'remove_favorit', 20);
function remove_favorit(){
    if( get_row_layout() == 'favoritter' ):
        $current_product_ID = get_the_ID();
        echo '<button class="favoritter" data-type="remove_me" data-id="'.$current_product_ID.'"><i class="fal fa-times"></i> '.__('Fjern').'</button>';
    endif;
}

//Ajax
add_action( 'wp_ajax_nopriv_update_favoritter', 'ajax_update_favoritter' );
add_action( 'wp_ajax_update_favoritter', 'ajax_update_favoritter' );
function ajax_update_favoritter() {

    if ( isset($_REQUEST) ):

        $product_id = $_REQUEST['product_id'];
        $type = $_REQUEST['type'];

        $current_user = get_current_user_id();
        $favoritter = get_field('favoritter', 'user_'.$current_user);

        switch ($type) {
            case 'remove_me':
                $remove_produkter = array_diff($favoritter, array($product_id)); //remove products
                update_field('favoritter', $remove_produkter, 'user_'.$current_user);
                echo get_field('ingen_farvoritter', 'option');
                break;
            case 'remove':
                $remove_produkter = array_diff($favoritter, array($product_id)); //remove products
                update_field('favoritter', $remove_produkter, 'user_'.$current_user);
                echo '<button class="favoritter" data-type="add" data-id="'.$product_id.'" ><i class="fal fa-heart"></i> '.__('Tilføj til favoritter', 'option').'</button>';
                break;
            case 'add':
                if (!in_array($product_id, $favoritter)){
                    $favoritter[] = $product_id; 
                }
                update_field('favoritter', $favoritter, 'user_'.$current_user);
                echo  '<button class="favoritter"  data-type="remove" data-id="'.$product_id.'" ><i class="fas fa-heart"></i> '.__('Fjern fra favoritter', 'option').'</button>';
                break;
        }

    endif;

    die();
}

add_action( 'wp_ajax_nopriv_update_favoritter_count', 'ajax_update_favoritter_count' );
add_action( 'wp_ajax_update_favoritter_count', 'ajax_update_favoritter_count' );
function ajax_update_favoritter_count(){
    $current_user = get_current_user_id();
    $favoritter = get_field('favoritter', 'user_'.$current_user);
    $count = ($favoritter ? count($favoritter) : '0');

    echo $count;

    die();
}