<?php
$text = get_sub_field('indhold');
?>

<?php if($text): ?>

    <section class="<?= $flex_class ?>"><!-- fuld_bredde_tekst -->
        <div class="container">
            <?= $text; ?>
        </div>
    </section>
<?php endif; ?>