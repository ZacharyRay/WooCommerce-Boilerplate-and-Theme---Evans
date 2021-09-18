<?php 

$left = get_sub_field('indhold_venstre');
$right = get_sub_field('indhold_hojre');

?>

<section class="<?= $flex_class ?>"><!-- tekst_tekst -->
    <div class="container">
        <div class="left"><?= $left; ?></div>
        <div class="right"><?= $right; ?></div>
    </div>
</section>