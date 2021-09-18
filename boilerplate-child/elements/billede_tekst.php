<?php

$placement = get_sub_field('placering');
$image = get_sub_field('billede');
$text = get_sub_field('tekst');

?>

<?php if($image || $text) : ?>

    <section class="<?= $flex_class ?>"><!-- billede_tekst -->
        <div class="container <?= $placement ?>">
            <div class="image_col"><?= wp_get_attachment_image( $image, 'billede' );?></div>
            <div class="text_col"><?= $text ?></div>
        </div>
    </section>

<?php endif; ?>