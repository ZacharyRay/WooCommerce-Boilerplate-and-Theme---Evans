<?php

$type = get_sub_field('vis_brands');
$visning = get_sub_field('brands_visning')?:'slider';

switch ($type) {
    case 'selected':
        $terms = get_sub_field('udvalgte_brands');        
        break;
    case 'all':
        $terms = get_terms( array(
            'taxonomy' => 'product_brand',
            'hide_empty' => true, //EDIT
            'number' => 0,
        ) );
        break;
    default:
        $terms = get_terms( array(
            'taxonomy' => 'product_brand',
            'hide_empty' => false, //EDIT
            'number' => 0,
        ) );
        shuffle( $terms );
        $terms = array_slice( $terms, 0, 12 );
        break;
}

//pre($terms);

?>

<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ): ?>
    <section class="<?= $flex_class .' '.$visning?>"><!-- brands -->
        <div class="container">
            <?php if($visning == 'slider'):?>
               <div class="brand-slider"> 
            <?php endif; ?>
                <?php foreach ($terms as $term): ?> 
                    
                    <?php 
                        $image_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                        
                        if($image_id):
                            $img =  wp_get_attachment_image( $image_id, 'brands');
                        else:
                            $img =  $term->name;//wc_placeholder_img( 'brands');
                        endif;

                        $link = get_term_link( $term->term_id, 'product_brand' );
                    ?>
                    
                    
                    <a class="brand-item" href="<?= $link; ?>" title="<?= $term->name?>">
                        <?= $img; ?>
                    </a>

                <?php endforeach;?>

            <?php if($visning == 'slider'):?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>