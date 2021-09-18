<?php 

    $queried_object = get_queried_object(); 
    if(is_archive()):  
        $from = $queried_object;
        $title = get_field('banner_overskrift', $from) ?:woocommerce_page_title(false);
    else:
        $from = get_the_ID();
        $title = get_field('banner_overskrift', $from)?: get_the_title();
    endif;
    
    $banner = get_field('vis_banner',  $from);
    
    $subtitle = get_field('banner_underoverskrift',  $from);
    $image = get_field('banner_billede',  $from);    
?>

<?php if($banner):?>
    <section class="banner">

        <?= ($image ? '<div class="bg">'.wp_get_attachment_image( $image, 'banner').'</div>' : ''); ?>

        <div class="container">
            
            <?= ($title ? '<h1 class="banner_title">'.$title.'</h1>' : '') ?>  
            <?= ($subtitle ? '<div class="banner_subtitle">'.$subtitle.'</div>' : '') ?>
        </div>
    </section>
<?php endif; ?>