<?php
add_action('woocommerce_before_account_navigation', 'account_nav_wrapper_start', 0);
function account_nav_wrapper_start(){
    echo '<div class="account_nav_wrapper">';
}

add_action('woocommerce_after_account_navigation', 'account_nav_wrapper_end', 1000);
function account_nav_wrapper_end(){
    echo '</div>'; //end account_nav_wrapper
}


add_action('woocommerce_account_content', 'add_account_title', 1);
function add_account_title(){

    $endpoint = WC()->query->get_current_endpoint();
    global $wp;

    $endpoint_title = '';
    switch ($endpoint) {
        case "downloads":
            $endpoint_title = __("Downloads", 'op-theme');
            break;
        case "orders":
            $endpoint_title =  __("Ordrer", 'op-theme'); 
            break;
        case "edit-address":
            if($wp->query_vars['edit-address']):
                //dont show title
            else:
                $endpoint_title =  __("Adresser", 'op-theme');
            endif;
            break;
        case "edit-account":
            $endpoint_title =  __("Kontoinformation", 'op-theme'); 
            break;
        case "giftcards":
            $endpoint_title =  __("Gavekort", 'op-theme'); 
            break;
        default:
            $endpoint_title =  __("Kundecenter", 'op-theme');
            break;         
    }

    if(!empty($endpoint_title)):
        echo '<div class="h3 op_account_title">'.$endpoint_title.'</div>';
    endif;

}

//Not login user
add_action('woocommerce_before_customer_login_form', 'bliv_medlem_tekst', 10);
function bliv_medlem_tekst(){
    $member_text = get_field('bliv_medlem_tekst', 'option');
    echo '<div class="member_text">';
    echo $member_text;
    echo '</div>';
}

add_action('woocommerce_before_customer_login_form', 'wrap_login_start', 20);
function wrap_login_start(){
    echo '<div class="member_login">';
}
add_action('woocommerce_after_customer_login_form', 'wrap_login_end', 20);
function wrap_login_end(){
    echo '</div>';
}