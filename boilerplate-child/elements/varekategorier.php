<?php 
//test: Fallback image

?>

<section class="<?= $flex_class ?>"> <!-- varekategorier -->
  
  <div class="container">
    
    <?php
    
        if( have_rows('kategorier') ):

            $i = 1; 

            while ( have_rows('kategorier') ) : the_row();

                if( get_row_layout() == 'kategori_link' ):

                    $category_id = get_sub_field('kategori');
                    $image = get_term_meta( $category_id, 'thumbnail_id', true ); 
                    $term = get_term_by( 'id', $category_id, 'product_cat' );
                    $headline = $term->name; 
                    $link = get_term_link( $category_id, 'product_cat' );
                    $link_start = '<a href="'.$link.'" >';
                    $link_end = '</a>';
                    $button_text = __('Se', 'op-theme').' '.apply_filters('strtolower_utf8', $headline);

                elseif( get_row_layout() == 'eksterne_link' ): 

                    $image = get_sub_field('billede');
                    $headline = get_sub_field('overskrift');
                    $link_array = get_sub_field('link');
                    $link_start = '<a href="'.$link_array['url'].'" target="'.($link_array['target'] ? $link_array['target'] : '_self' ).'" >';
                    $link_end = '</a>';
                    $button_text = $link_array['title'] ? $link_array['title'] : 'Shop nu' ;

                endif;

                ?>
                
                <div id="link_<?= $i?>" class="category_item">
                    <?= $link_start ?>

                        <div class="category_item_img">
                            <?php    
                            if($i == 1):
                                echo wp_get_attachment_image( $image, 'varekategori_stor'); 
                            else:
                                echo wp_get_attachment_image( $image, 'varekategori_lille'); 
                            endif;
                            ?>
                        </div>
                        <div class="category_item_content">
                            <div class="headline"><?= $headline ?></div>
                            <?php 
                                
                                echo '<div><button>'.$button_text.' <i class="far fa-long-arrow-right"></i></button></div>';
                                
                            ?>   
                        </div>             
                    <?= $link_end ?>
                </div>
                
                <?php
        
                $i++; 

            endwhile;
        
        else :
        endif;
    
    ?>
    </div>

</section>