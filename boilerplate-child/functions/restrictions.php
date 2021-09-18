<?php

// Restrict iframe access 
header('X-Frame-Options: SAMEORIGIN');

function is_op() {
    global $current_user;
    if ($current_user->user_login == 'OnlinePlus') :
        return true;
    else:
        return false;
    endif;    
}

//remove menus
add_action('admin_init', 'op_remove_admin_menu_pages', 100);
function op_remove_admin_menu_pages() {
    remove_menu_page( 'edit-comments.php' );

    if (!is_op()):
        remove_submenu_page('index.php', 'update-core.php');
        remove_submenu_page('themes.php', 'themes.php');
        remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode($_SERVER['SCRIPT_NAME']));
        remove_submenu_page( 'themes.php', 'theme-editor.php' ); 
        remove_menu_page('plugins.php');
        remove_submenu_page( 'tools.php', 'site-health.php' );        
    endif;
}
if (!is_op()):
    add_filter('acf/settings/show_admin', '__return_false');
endif;

//prevent access to pages
add_action( 'current_screen', 'op_restrict_admin_pages' );
function op_restrict_admin_pages(){
    if ( is_admin() ) {
        $screen = get_current_screen();

        if (!is_op()):
            $restricted_pages = array(
                'update-core',
                'themes',
                'theme-editor',
                'plugins',
                'plugin-install',
                'plugin-editor',
                'edit-acf-field-group',
                'acf-field-group',
                'custom-fields_page_acf-tools',
                'custom-fields_page_acf-settings-updates',
                'site-health'
            );
            if( in_array($screen->id, $restricted_pages) ) {
                wp_die( __( 'Du har ikke tilstrækkelige tilladelser til at få adgang til denne side', 'op-theme' ) );
            }
        endif;
    }
}

//Add admin notice
//add_action( 'admin_notices', 'op_admin_notice' );
if (!function_exists('op_admin_notice')):
    function op_admin_notice(){ 
        if (is_op()):
            $screen = get_current_screen();
            echo '<div class="notice notice-success is-dismissible">
                <p>Screen id: '.$screen->id.'</p>
            </div>';
        endif;
    }
endif;

// Restrict users from deleting the user: OnlinePlus
add_filter('user_row_actions', 'secure_admin', 1, 2);
if (!function_exists('secure_admin')):
    function secure_admin($actions, $user_object) {
        if ('OnlinePlus' == $user_object->user_login) :
            unset($actions['delete']);
        endif;
        return $actions;
    }
endif;

// Extra security preventing users from deleting the user: OnlinePlus
add_action('delete_user', 'op_dont_delete_user');
if (!function_exists('op_dont_delete_user')):
    function op_dont_delete_user($id) {
        $dont_delete_ids = array(1);
        if (in_array($id, $dont_delete_ids))
            wp_die('Du har ikke rettigheder til at slette denne bruger.');
    }
endif;

//prevent search
// add_action( 'parse_query', 'op_filter_query' );
// function op_filter_query( $query, $error = true ) {
//     if ( is_search() ) {
//         $query->is_search = false;
//         $query->query_vars[s] = false;
//         $query->query[s] = false;
//     if ( $error == true )
//         $query->is_404 = true;
//     }
// }


?>