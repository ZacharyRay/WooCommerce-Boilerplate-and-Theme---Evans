<?php
    $overskrift = get_sub_field('overskrift');
    $type = get_sub_field('vis_varer');
    $max = get_sub_field('vis_max_produkter');

    switch ($type) {
        case 'selected':
            $post_ids = get_sub_field('udvalgte_varer');
            $the_query = new WP_Query( array(  
                'post_type' => 'product', 
                'posts_per_page' => -1,
                'post__in' => $post_ids
            ));
            break;
        case 'faves':
            $the_query = new WP_Query( array(  
                'post_type' => 'product', 
                'posts_per_page' => $max,
                'post__in' => wc_get_featured_product_ids()
            ));
            break;
        default: //newest       
            $the_query = new WP_Query( array(  
                'post_type' => 'product', 
                'posts_per_page' => $max,
                'orderby' => 'date',
            ));    
        break;
    }

?>

<?php if ( $the_query->have_posts() ) : ?>
    <section class="<?= $flex_class ?>" data-type="<?= $type?>" ><!-- udvalte_varer -->
        <div class="container">
            <?php if($overskrift): ?>
                <div class="indledning h2"><?= $overskrift;?></div>
            <?php endif;?>

            <div class="produkter">
                <ul class="products">
                    <?php
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                                wc_get_template_part( 'content', 'product' );
                    endwhile;
                    ?>
                </ul>
            </div>

        </div>
    </section>
<?php endif;?>