<?php 

$news_days = get_field('nyheder_dage', 'option');
$no_news = get_field('ingen_nyheder', 'option');

?>

<?php

$the_query = new WP_Query( array(
    'post_type' => 'product',
    'posts_per_page' => '-1',
    'orderby' => 'date',
    'order'=>'DESC',
    'date_query' => array(
        array(
        'after' => '-'.$news_days.' days',
        'column' => 'post_date',
        ),
    ),
    
));

//pre( $the_query->have_posts() );

?>

<section class="<?= $flex_class ?> op-woocommerce"><!-- nyheder -->
    <div class="container">
        
            <?php 
                if($the_query->have_posts()):
                    echo '<ul class="products columns-5">';
                    while ( $the_query->have_posts() ) : $the_query->the_post(); 
                        wc_get_template_part( 'content', 'product' );                        
                    endwhile;            
                    echo '</ul>';
                else:
                    echo '<div class="no_news">';
                        echo $no_news;
                    echo '</div>';
                endif;
            ?>
       
    </div>
</section>