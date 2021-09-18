<?php 
$current_user = get_current_user_id();
$favoritter = get_field('favoritter', 'user_'.$current_user);

?>


<section class="<?= $flex_class ?>"  ><!-- favoritter -->
    <div class="container">
        <div class="produkter">

            <?php if(is_user_logged_in()):

                    $the_query = new WP_Query( array(      
                        'post_type' => 'product', 
                        'posts_per_page' => -1,
                        'post__in' => $favoritter,
                    )); 
                    
                    if ( $the_query->have_posts() && $favoritter ) : ?>
                      
                        <ul class="products">
                            <?php
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                        wc_get_template_part( 'content', 'product' );
                            endwhile;
                            ?>
                        </ul>
                    <?php else: ?>
                        <?= get_field('ingen_farvoritter', 'option');?>
                    <?php endif;?>

            <?php else: ?>
           
                    <?= get_field('ikke_logget_ind_farvoritter', 'option') ;?>
             
            <?php endif; ?>

        </div>
    </div>
</section>