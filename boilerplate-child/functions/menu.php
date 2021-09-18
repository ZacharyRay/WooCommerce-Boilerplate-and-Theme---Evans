<?php

add_filter( 'nav_menu_submenu_css_class', 'wpdocs_custom_dropdown_class', 10, 3 );
function wpdocs_custom_dropdown_class( $classes, $args, $depth ) {
  
  $classes[] = 'level_'.$depth;

  return $classes;
}



class Header_Walker extends Walker_Nav_Menu {
  /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
      if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
        $t = '';
        $n = '';
      } else {
        $t = "\t";
        $n = "\n";
      }
      $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
  
      $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;
  
      /**
       * Filters the arguments for a single nav menu item.
       *
       * @since 4.4.0
       *
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param WP_Post  $item  Menu item data object.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
  
      /**
       * Filters the CSS classes applied to a menu item's list item element.
       *
       * @since 3.0.0
       * @since 4.1.0 The `$depth` parameter was added.
       *
       * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
       * @param WP_Post  $item    The current menu item.
       * @param stdClass $args    An object of wp_nav_menu() arguments.
       * @param int      $depth   Depth of menu item. Used for padding.
       */
      $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
  
      /**
       * Filters the ID applied to a menu item's list item element.
       *
       * @since 3.0.1
       * @since 4.1.0 The `$depth` parameter was added.
       *
       * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
       * @param WP_Post  $item    The current menu item.
       * @param stdClass $args    An object of wp_nav_menu() arguments.
       * @param int      $depth   Depth of menu item. Used for padding.
       */
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
  
      $output .= $indent . '<li' . $id . $class_names . '>';
  
      $atts           = array();
      $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
      $atts['target'] = ! empty( $item->target ) ? $item->target : '';
      if ( '_blank' === $item->target && empty( $item->xfn ) ) {
        $atts['rel'] = 'noopener';
      } else {
        $atts['rel'] = $item->xfn;
      }
      $atts['href']         = ! empty( $item->url ) ? $item->url : '';
      $atts['aria-current'] = $item->current ? 'page' : '';
  
      /**
       * Filters the HTML attributes applied to a menu item's anchor element.
       *
       * @since 3.6.0
       * @since 4.1.0 The `$depth` parameter was added.
       *
       * @param array $atts {
       *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
       *
       *     @type string $title        Title attribute.
       *     @type string $target       Target attribute.
       *     @type string $rel          The rel attribute.
       *     @type string $href         The href attribute.
       *     @type string $aria_current The aria-current attribute.
       * }
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
  
      $attributes = '';
      foreach ( $atts as $attr => $value ) {
        if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
          $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
          $attributes .= ' ' . $attr . '="' . $value . '"';
        }
      }
  
      /** This filter is documented in wp-includes/post-template.php */
      $title = apply_filters( 'the_title', $item->title, $item->ID );
  
      /**
       * Filters a menu item's title.
       *
       * @since 4.4.0
       *
       * @param string   $title The menu item's title.
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
  
      if($args->walker->has_children):
        $item_output = '<input type="checkbox" id="input-menu-item-'.$item->ID.'">';       
      endif;

      $item_output  .= $args->before;
      if($args->walker->has_children && $depth == 0):
        $item_output .=  '<label class="fake_a" for="input-menu-item-'.$item->ID.'">';
        $item_output .= '<span>'.$args->link_before . $title . $args->link_after.'</span>';
        $item_output .= '<i class="fas fa-angle-down"></i></label>';
      else:
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>'; 
        if($args->walker->has_children):
          $item_output .=  '<label for="input-menu-item-'.$item->ID.'"><i class="fas fa-angle-down"></i></label>';     
        endif;
      endif;

      
      $item_output .= $args->after;
      
      //pre($args);

      /**
       * Filters a menu item's starting output.
       *
       * The menu item's starting output only includes `$args->before`, the opening `<a>`,
       * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
       * no filter for modifying the opening and closing `<li>` for a menu item.
       *
       * @since 3.0.0
       *
       * @param string   $item_output The menu item's starting HTML output.
       * @param WP_Post  $item        Menu item data object.
       * @param int      $depth       Depth of menu item. Used for padding.
       * @param stdClass $args        An object of wp_nav_menu() arguments.
       */
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
      if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
        $t = '';
        $n = '';
      } else {
        $t = "\t";
        $n = "\n";
      }
      $indent = str_repeat( $t, $depth );
  
      // Default class.
      $classes = array( 'sub-menu' );
  
      /**
       * Filters the CSS class(es) applied to a menu list element.
       *
       * @since 4.8.0
       *
       * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
       * @param stdClass $args    An object of `wp_nav_menu()` arguments.
       * @param int      $depth   Depth of menu item. Used for padding.
       */
      $class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
  
      $output .= "{$n}{$indent}<div class='sub-menu-wrapper-".$depth."'><ul$class_names>{$n}";
    }

    /**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</ul></div>{$n}";
	}
  
}


// add_filter( 'nav_menu_item_title', 'filter_nav_menu_item_title', 10, 4 );  
// function filter_nav_menu_item_title( $title, $item, $args, $depth ) { 
  
//   //OBS: remeber fallback image of image space if the category dosent have an image

//   if($depth == 1 && $item->object == 'product_cat'):
//     return  '<div class="sub_menu_title">'.$title.'</div>'; 
//   else:
//     return $title;
//   endif;
// }; 


//add admin notice about max menus levels       
add_action( 'admin_notices', 'op_admin_notice__menu' );
if (!function_exists('op_admin_notice__menu')):
    function op_admin_notice__menu(){ 
        global $nav_menu_selected_id, $locations_screen;
        $screen = get_current_screen();
        
        if ($screen->id == "nav-menus" &&  $locations_screen == 0 ):
          
          $menu_locations = get_nav_menu_locations();
          $location_name = array_keys($menu_locations, $nav_menu_selected_id, false);

          $message = '';
          foreach ($location_name as $location):

            $menu_name = ucfirst(str_replace('_', ' ', $location));

            switch ($location) {
              case 'header_menu':
                $message .= 'Placeringen "'.$menu_name.'" understøtter kun 3 niveauer. ';
                break;
              case 'footer_menu_1':
              case 'footer_menu_2':
                $message .= 'Placeringen "'.$menu_name.'" understøtter kun 1 niveau. ';
                break;
              default:
                break;
            }
          endforeach;

          if( $message != ''):
            echo '<div class="notice notice-success is-dismissible">
                <p>OBS: '.$message.'</p>
            </div>';
          endif;

      endif;
    }
endif;



?>