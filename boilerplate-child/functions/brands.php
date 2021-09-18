<?php
//fix stretch brand images
add_action('admin_head', 'op_brand_admin_styling');
function op_brand_admin_styling() {
  echo '<style>
    body.taxonomy-product_brand #the-list .column-thumb img,
    body.taxonomy-product_brand #product_cat_thumbnail img{
        object-fit: contain;
    } 
  </style>';
}

//limit two 6 brands
add_filter('acf/validate_value/name=udvalgte_brands', 'limit_selecte_brands', 10, 4);
function limit_selecte_brands($valid, $value, $field, $input) {

	if(!$valid) {
		return $valid;
	}

	if(sizeof($value) > 12) {
		$valid = __('Du kan max vise 12 brands', 'op-theme');
	} else {
		$valid = true;
	}

	return $valid;

}
