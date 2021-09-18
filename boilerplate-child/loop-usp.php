<?php
$title = get_sub_field('usp'); 
if($title):
    echo '<div class="usp__item">';
    echo '<span class="usp__icon">'.($icon == 'true' ? get_sub_field('ikon') : '<i class="fas fa-check"></i>' ).'</span>';
    echo ($title ? '<span class="usp__title">'. apply_filters('the_content', $title).'</span>' : '');
    echo '</div>';
endif; 
?>