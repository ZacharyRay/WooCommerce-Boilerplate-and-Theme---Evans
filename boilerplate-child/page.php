<?php get_header(); ?>

<?php 
    $content = get_the_content();
    if($content):
        do_action( 'woocommerce_before_main_content' );
           echo '<h1>'.get_the_title().'</h1>';
           the_content();
        do_action( 'woocommerce_after_main_content' );
    else:
    endif; 
 ?>

<?php get_template_part('elements/acf', 'sectioner'); ?>

<?php get_footer(); ?>
