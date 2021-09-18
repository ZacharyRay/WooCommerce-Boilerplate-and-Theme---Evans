<?php do_action('op_inner_after_content'); ?>
</div><!-- end .content-wrapper-->

<section class="newsletter">
    <div class="container">
        <div class="newsletter__text"><?= get_field('nyhedsbrev_tekst', 'option'); ?></div>
        <div class="newsletter__form">
            <?php
                $formular = get_field('nyhedsbrev_formular', 'option');
                if ($formular) :
                    echo FrmFormsController::get_form_shortcode(array(
                        'id' => $formular
                    ));
                endif;
                ?>
        </div>
    </div>
</section>

<footer class="footer">

    <div class="container">
   
        <div class="footer__1">
            <?php do_action('op_footer__1')?>
        </div>

        <div class="footer__2">
            <?php do_action('op_footer__2')?>
        </div>

        <div class="footer__3">
            <?php do_action('op_footer__3') ?>                 
        </div>

        <div class="footer__4">
            <?php do_action('op_footer__4')?>                 
        </div>
 
    </div>

</footer>

<?php wp_footer(); ?>

</body>

</html>