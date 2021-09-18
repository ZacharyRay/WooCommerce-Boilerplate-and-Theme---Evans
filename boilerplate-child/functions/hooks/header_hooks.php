<?php
/* op_header__menu */
add_action( 'op_header_usp', 'header_usp', 10 );
if ( ! function_exists( 'header_usp' ) ) {
    function header_usp(){

    if(have_rows('header_usp' , 'option')):
        echo '<div id="header_usp" class="header_usp_slider">';
        while(have_rows('header_usp', 'option')): the_row(); 
            get_template_part('loop', 'usp');
        endwhile; 
    echo '</div>';

    else: 
    endif; 

    }
}


add_action( 'op_header_usp', 'header_kundeservice', 10 );
if ( ! function_exists( 'header_kundeservice' ) ) {
    function header_kundeservice(){
        $header_link = get_field('header_link', 'option');
        if($header_link){
            echo '<div class="header_link">
                <a class="btn" href='.$header_link['url'].' target='.($header_link['target'] ? $header_link['target'] : '_self' ).' >'.
                    ($header_link['title'] ? $header_link['title'] : 'Læs mere' ).
                '</a>
            </div>';
        }
       
    }
}



/* op_header__logo */
add_action( 'op_header__logo', 'op_add_logo', 10 );
if ( ! function_exists( 'op_add_logo' ) ) {
    function op_add_logo(){
        $img = get_field('firma_logo', 'option');
        if($img):
            echo '<a href="'.get_bloginfo('url').'" id="logo">'.wp_get_attachment_image( $img, 'full').'</a>';
        endif;
    }
}

add_action('op_header__search', 'op_add_search_field', 10);
function op_add_search_field(){
    echo 
    '<div class="search_field">
            <form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
                <input id="h_search" type="search" class="search-field" name="s" placeholder="' . __('Søg på shoppen', 'op-theme') . '" />
                <input type="submit" class="search-submit" value="' . __('Search', 'op-theme') . '" />
                <input type="hidden" name="post_type" value="product" />
                <i class="fal fa-search"></i>
            </form>
    </div>';
}


/* op_header__icons */
add_action( 'op_header__menu', 'op_add_mobile_menu', 10 );
if ( ! function_exists( 'op_add_mobile_menu' ) ) {
    function op_add_mobile_menu(){ ?>
        <button id="h_icon_menu"><i class="fal fa-bars"></i></button>
    <?php }
}

//add_action( 'op_header__icons', 'op_add_search', 11 );
if ( ! function_exists( 'op_add_search' ) ) {
    function op_add_search(){ ?> 
        <button id="h_icon_search"><i class="fal fa-search"></i></button>
    <?php }
}


add_action( 'op_header__icons', 'op_add_account', 12 );
if ( ! function_exists( 'op_add_account' ) ) {
    function op_add_account(){ ?>
        <a id="h_icon_user" href="<?= get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><i class="fal fa-user-alt"></i></a>
    <?php }
}

add_action( 'op_header__icons', 'op_add_wishlist', 13 );
if ( ! function_exists( 'op_add_wishlist' ) ) {
    function op_add_wishlist(){ ?>
        <?php 
        $favorit_side = get_field('favoritside', 'option');
        
        if($favorit_side):
            $current_user = get_current_user_id();
            $favoritter = get_field('favoritter', 'user_'.$current_user);
            $count = ($favoritter ? count($favoritter) : '0');
        ?>
            <a id="h_icon_whislist" href="<?= $favorit_side ?>"><i class="fal fa-heart"></i><span id="whishlist_count" class="menu_count" ><?= $count?></span></a>
        <?php endif;?>
    <?php }
}

add_action( 'op_header__icons', 'op_add_cart', 14 );
if ( ! function_exists( 'op_add_cart' ) ) {
    function op_add_cart(){ ?>
        <?php 
        global $woocommerce;
        $count =  $woocommerce->cart->cart_contents_count;
        ?>
        <a id="h_icon_cart" href="<?= get_permalink( get_option( 'woocommerce_cart_page_id' ) ); ?>"><i class="fal fa-shopping-bag"></i><span id="cart_count" class="menu_count" ><?= $count?></span></a>
    <?php }
}

/* op_header__menu */
add_action( 'op_header__menu', 'op_add_menu', 10 );
if ( ! function_exists( 'op_add_menu' ) ) {
    function op_add_menu(){

        wp_nav_menu(array(
            'theme_location' => 'header_menu',
            'menu_class'=> 'menu menu--vertical', 
            'container' => false, 
            'fallback_cb' => false,
            'depth' => 3,
            'walker' => new Header_Walker()            
        )); 
    }
}

add_action('op_after_header', 'shop_notice');
function shop_notice(){
    $vis_shop_notice = get_field('vis_shop_notice', 'option');
    $shop_notice = get_field('shop_notice', 'option');
    $fra = get_field('shop_notice_fra', 'option', false) ? :current_time('Ymd');
    $til = get_field('shop_notice_til', 'option', false)? :current_time('Ymd');

    $session = $_SESSION["shop_notice_close"];
    $to_day = current_time('Ymd');

    // pre($fra);
    // pre($til);
    // pre($to_day);

    if($vis_shop_notice && $session != 'removed'):
        
        if($to_day >= $fra && $to_day <= $til):
            echo '<div class="shop_notice">';
                echo '<div class="container">';
                echo 
                    '<a class="shop_notice_wrapper" href='.$shop_notice['url'].' target='.($shop_notice['target'] ? $shop_notice['target'] : '_self' ).' >'.
                        ($shop_notice['title'] ? $shop_notice['title'] : 'Læs mere' ).
                        '<i class="far fa-long-arrow-right"></i>'.
                    '</a>';
                echo '<div id="shop_notice_close"><i class="far fa-times"></i></div>';
                echo '</div>';
            echo '</div>';
        endif;

    else:
    endif;
}

?>
