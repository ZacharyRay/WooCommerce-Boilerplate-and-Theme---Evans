<?php get_header(); ?>

<section class="search_page">
    <div class="container">
        <h1><?php echo __('Du søgte efter', 'op-theme').': '.get_search_query(); ?></h1> 
    </div>
</section>

<?php if (have_posts()): ?>
    <section class="post_list op-woocommerce">
        <div class="container">
            <ul class="products columns-5">
            <?php 
            while (have_posts()) : the_post();
                if ( get_post_type() === 'product' ):
                    wc_get_template_part( 'content', 'product' );
                else:          
                    get_template_part('loop', 'search');
                endif;

                endwhile;
                ?>
            </ul>
        </div>
    </section>

    <section class="pagination">
        <?= paginate_links(array(
            'next_text'=> '<i class="far fa-angle-right"></i>', 
            'prev_text' => '<i class="far fa-angle-left"></i>' 
        )); ?>
    </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>