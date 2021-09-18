<?php
add_shortcode('firma_navn', 'firma_navn');
function firma_navn(){
    return '<span class="firma_navn h5">'.get_field('firma_navn', 'options').'</span>';
}

add_shortcode('firma_gadenavn', 'firma_gadenavn');
function firma_gadenavn(){
    return '<span class="firma_gadenavn">'. get_field('firma_gadenavn', 'options').'</span>';
}

add_shortcode('firma_postnr', 'firma_postnr');
function firma_postnr(){
    return '<span class="firma_postnr">'. get_field('firma_postnr', 'options').'</span>';
}

add_shortcode('firma_by', 'firma_by');
function firma_by(){
    return '<span class="firma_by">'.get_field('firma_by', 'options').'</span>';
}

add_shortcode('firma_adresse', 'firma_adresse');
function firma_adresse(){

    $gadenavn = get_field('firma_gadenavn', 'options');
    $postnr = get_field('firma_postnr', 'options');
    $by = get_field('firma_by', 'options');

    if($gadenavn || $postnr || $by):
        $adresse = '<address>';
            $adresse .= ($gadenavn ? $gadenavn.'<br>' :'');
            $adresse .= ($postnr ? $postnr.' ' :'');
            $adresse .= ($by ? $by.'<br>' :'');
        $adresse .= '</address>';
    endif;

    return $adresse;
}

add_shortcode('firma_cvr', 'firma_cvr');
function firma_cvr(){
    return '<span class="firma_cvr">CVR: '. get_field('firma_cvr', 'options').'</span>';
}

add_shortcode('firma_email', 'firma_email');
function firma_email(){
    return '<span class="firma_email">'.apply_filters('op_email', get_field('firma_mail', 'options')).'</span>';
}

add_shortcode('firma_telefon', 'firma_telefon');
function firma_telefon(){
    return '<span class="firma_telefon">'.apply_filters('op_telefon', get_field('firma_telefon', 'options')).'</span>';
}

add_shortcode('privatlivspolitik', 'privatlivspolitik');
function privatlivspolitik(){
    return '<a class="privatlivspolitik" href="'.get_privacy_policy_url().'" target="_blank">'.__('privatlivspolitik', 'op-theme').'</a>';
}

add_shortcode( 'firma_some', 'firma_some' );
function firma_some(){
 
    echo '<div class="firma_some">';
    $facebook = get_field('some_facebook', 'options');
    if($facebook):
        echo '<a href="'.$facebook.'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
    endif;

    $instagram = get_field('some_instagram', 'options');
    if($instagram):
        echo '<a href="'.$instagram.'" target="_blank"><i class="fab fa-instagram"></i></a>';
    endif;
 
    $linkedin = get_field('some_linkedin', 'options');
    if($linkedin):
        echo '<a href="'.$linkedin.'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
    endif;
 
    $youtube = get_field('some_youtube', 'options');
    if($youtube):
        echo '<a href="'.$youtube.'" target="_blank"><i class="fab fa-youtube"></i></a>';
    endif;
 
  
    echo '</div>';
}

add_shortcode( 'firma_abningstider', 'firma_abningstider' );
function firma_abningstider(){
    return '<span class="firma_abningstider">'.get_field('firma_abningstider', 'options').'</span>';
}


//FONTAWESOME
add_shortcode( 'fa_map_marker', 'fa_map_marker' );
function fa_map_marker(){
    return '<i class="fal fa-map-marker-alt"></i> ';
}

add_shortcode( 'fa_phone', 'fa_phone' );
function fa_phone(){
    return '<i class="fal fa-phone-alt"></i> ';
}

add_shortcode( 'fa_envelope', 'fa_envelope' );
function fa_envelope(){
    return '<i class="fal fa-envelope"></i> ';
}