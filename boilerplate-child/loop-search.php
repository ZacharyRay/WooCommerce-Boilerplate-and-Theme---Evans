<?php 
// use this loop in template: get_template_part('loop', 'post');
?>
<li class="loop loop-post-item">
    <a class="loop_wrapper" href="<?php the_permalink(); ?>">
        <div class="loop-content">
            <div class="thumbnail"><?php 
            if ( has_post_thumbnail() ) :
                echo get_the_post_thumbnail( $page->ID, 'woocommerce_thumbnail' ); 
            else:
                echo wc_placeholder_img();
            endif;
            ?>
            </div>
            <h2 class="titel"><?= get_the_title(); ?></h2>
        </div>
    </a>
</li>