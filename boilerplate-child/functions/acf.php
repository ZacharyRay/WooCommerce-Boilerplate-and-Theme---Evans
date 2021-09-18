<?php

//locaton roule
add_filter('acf/location/rule_types', 'acf_location_rules_types');
function acf_location_rules_types( $choices ) {
	
    $choices['User']['id'] = 'Is user';

    return $choices;
    
}

add_filter('acf/location/rule_values/id', 'acf_location_rule_values_user');
function acf_location_rule_values_user( $choices ) {
	
    $users = get_users();
    if( $users ) {	    
        foreach( $users as $user ) {
            $choices[ $user->data->ID ] = $user->data->display_name;
        }        
    }
    return $choices;
}

add_filter('acf/location/rule_match/id', 'acf_location_rule_match_user', 10, 4);
function acf_location_rule_match_user( $match, $rule, $options, $field_group )
{
    $current_user = wp_get_current_user();
    $selected_user = (int) $rule['value'];

    if($rule['operator'] == "==")
    {
    	$match = ( $current_user->ID == $selected_user );
    }
    elseif($rule['operator'] == "!=")
    {
    	$match = ( $current_user->ID != $selected_user );
    }

    return $match;
}


?>