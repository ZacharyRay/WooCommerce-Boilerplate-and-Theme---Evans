<?php if(have_rows('globale_usp' , 'option')): ?>

<section class="<?= $flex_class ?>"><!-- usp -->
    <div class="container">
        <?php  while(have_rows('globale_usp', 'option')): the_row(); ?>
            <?php 
                $icon = get_sub_field('ikon'); 
                $title = get_sub_field('overskrift'); 
                $description = get_sub_field('beskrivelse'); 
            ?>

            <div class="usp__item">
                <?= ($icon ? '<div class="usp__icon">'.$icon.'</div>' : ''); ?>
                <?= ($title ? '<div class="usp__title">'.$title.'</div>' : ''); ?>
                <?= ($description ? '<div class="usp__description">'.$description.'</div>' : ''); ?>
            </div>
            
        <?php endwhile; ?>
    </div>

</section>

<?php else: ?>
<?php endif; ?>