<?php

//keep full screen
add_filter( 'frm_admin_full_screen_class', 'frm_keep_full_screen' );
function frm_keep_full_screen(){
  return '';
}

//Select form in acf
function get_forms(){
  $results = array();
  foreach (FrmForm::get_published_forms() as $published_form) {
      $results[$published_form->id] = $published_form->name;
  }
  return $results;
}

function load_forms_function( $field ){
$result = get_forms();
if( is_array($result) ){
  $field['choices'] = array();
  foreach( $result as $key=>$match ){
    $field['choices'][ $key ] = $match;
  }
}
  return $field;
}
add_filter('acf/load_field/name=nyhedsbrev_formular', 'load_forms_function');
