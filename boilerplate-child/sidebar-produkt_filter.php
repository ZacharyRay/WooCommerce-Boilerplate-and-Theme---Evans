<?php 

    $q_object = get_queried_object();
    $ancestors = get_ancestors($q_object->term_id,'product_cat');
    $list_id = $ancestors[count($ancestors) - 1];
 

    //Get formular values
    $orderby = $_GET['orderby'];
    if(!isset($orderby)):
        $orderby = 'price';
    endif;

    $selected_pa_filter = explode_filter_querystring($_SERVER['QUERY_STRING']);
    //pre($selected_pa_filter);

    $min = $_GET['min'];
    $max = $_GET['max'];


    
?>
<div class="op_product_filter">
    <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="product_filter">
    
    <div class="clear_filter" ><i class="fal fa-times"></i> <?= __('Rydfilter', 'op-theme')?></div>

    <?php if(is_tax('product_brand')): ?>
        <input type="hidden" name="product_brand" id="product_brand" value="<?= $q_object->term_id; ?>" />
    <?php else:?>
        <input type="hidden" name="p_cat" id="p_cat" value="<?= $q_object->term_id; ?>" />       
    <?php endif;?>

    <!-- Page -->
    <input type="hidden" name="p_num" id="p_num" value="<?= (get_query_var('paged')) ? get_query_var('paged') : 1 ?>" />
   
    <!-- Sorting -->

    <div id="p_sort" class="p_sort_filter">
            <fieldset>
                <input class="dropdown_controle" type="checkbox" id="checkbox_sort">
                <legend class="h5">
                    <label for="checkbox_sort" class="dropdown_controle_trigger">
                        <span class="label_wrapper">
                            <?= __('Sortering','op-theme'); ?>
                            <!-- <span class="counter">(1)</span> -->
                        </span>
                        <i class="far fa-angle-down pull-right"></i>
                    </label>
                </legend> 
                
                <div class="dropdown">   
                    <div class="input_wrapper">
                        <input name="orderby" id="pris_mindst" type='radio' value="price" <?= ($orderby == "price" ? 'checked' : '');?> >
                        <label for="pris_mindst" ><?= __('Laveste til højeste pris','op-theme'); ?></label>
                    </div>
                    <div class="input_wrapper">
                        <input name="orderby" id="pris_stoerst" type='radio' value="price-desc"  <?= ($orderby == "price-desc" ? 'checked' : '');?>>
                        <label for="pris_stoerst" ><?= __('Højeste til laveste pris','op-theme'); ?></label>
                    </div>
                    <div class="input_wrapper">
                        <input name="orderby" id="popular" type='radio' value="popularity"  <?=  ($orderby == "popularity" ? 'checked' : '');?>>
                        <label for="popular" ><?= __('Mest populære','op-theme'); ?></label>
                    </div>
                    <div class="input_wrapper">
                        <input name="orderby" id="newset" type='radio' value="date"  <?=  ($orderby == "date" ? 'checked' : '');?>>
                        <label for="newset" ><?= __('Nyheder','op-theme'); ?></label>
                    </div>
                    
                </div>
            </fieldset>
        </div>



    <?php if(is_tax('product_brand')): ?>

        <div id="product_brand" class="category_filter">
            <fieldset>
                <input class="dropdown_controle" type="checkbox" id="checkbox_brands">
                <legend class="h5">
                    <label for="checkbox_brands" class="dropdown_controle_trigger">
                        <?= __('Brands', 'op-theme');?>
                        <i class="far fa-angle-down pull-right"></i>
                    </label>
                </legend> 
                
                <div class="dropdown">   
                    <ul>
                        <?php wp_list_categories( array(
                            'taxonomy'          => 'product_brand',
                            'orderby'           => 'id',
                            'show_count'        => true,
                            'child_of'          => 0,
                            'hide_empty'        => false, //EDIT
                            'show_count'        => 0,
                            'title_li'          => __( '' ),
                        ) ); ?>
                    </ul>
                </div>
            </fieldset>
        </div>

    <?php else: ?>

        <div id="product_cat" class="category_filter">
            <fieldset>
                <input class="dropdown_controle" type="checkbox" id="checkbox_cat">
                <legend class="h5">
                    <label for="checkbox_cat" class="dropdown_controle_trigger">
                        <?= __('Kategorier', 'op-theme');?>
                        <i class="far fa-angle-down pull-right"></i>
                    </label>
                </legend> 
                
                <div class="dropdown">   
                    <ul class="list_categories">
                        <?php 
                            wp_list_categories( array(
                                'taxonomy'          => 'product_cat',
                                'orderby'           => 'id',
                                'show_count'        => true,
                                'child_of'          => $list_id,
                                'hide_empty'        => false, //EDIT
                                'exclude'           => array( 16 ), //ukategoriseret
                                'show_count'        => 0,
                                'title_li'          => __( '' ),
                            ) );
                        
                        ?>
                        <?php ?>
                    </ul>
                </div>
            </fieldset>
        </div>

    <?php endif; ?>
    
    <?php //Product attributes
    $filter_egenskaber = apply_filters('get_produkt_filter_parameter', $q_object->term_id); //hent filter parameter
    //pre($filter_egenskaber);
    if(isset($filter_egenskaber)):
        foreach ($filter_egenskaber as $f): 
        
            $count_selected = count($selected_pa_filter['pa_'.$f['value']])
        
        ?>
            <div id="<?= $f['value'] ?>" class="op_check_product_filter">
                <fieldset>
                    <input class="dropdown_controle" type="checkbox" id="<?= "pa_".$f['value']; ?>">
                    
                    <legend class="h5">
                       
                        <label for="<?= "pa_".$f['value']; ?>" class="dropdown_controle_trigger">
                            <span class="label_wrapper">
                                <?= wc_attribute_label("pa_".$f['value'])?>
                                <span class="counter"><?= ($count_selected ? '('.$count_selected.')': '') ?></span>
                            </span>
                            <i class="far fa-angle-down pull-right"></i>                    
                        </label>
                    </legend>  

                    <div class="dropdown">              
                        <?php
                        $terms = get_terms("pa_".$f['value']);
                        foreach ( $terms as $term ):?>
                            <div class="input_wrapper">
                                <input name="pa_<?= $f['value']; ?>[]"  <?= (in_array($term->term_taxonomy_id, $selected_pa_filter['pa_'.$f['value']]) ? 'checked' : '')?> id="<?= $term->term_taxonomy_id; ?>" type='checkbox' value="<?= $term->term_taxonomy_id; ?>">
                                <label for="<?= $term->term_taxonomy_id; ?>" ><?= $term->name; ?></label>
                            </div>
                        <?php endforeach;?>
                    </div>

                </fieldset>
            </div>
        <?php endforeach;?>
    <?php endif; ?>

    <?php  //Price range ?>

        <div id="price_range" class="op_price_filter">
            <fieldset>
                <input class="dropdown_controle" type="checkbox" id="checkbox_price">
                <legend class="h5">
                    <label for="checkbox_price" class="dropdown_controle_trigger">
                        <span class="label_wrapper">
                            <?= __('Pris', 'op-theme');?>
                            <span class="counter"></span>
                        </span>
                        <i class="far fa-angle-down pull-right"></i>
                    </label>
                </legend> 
                
                <div class="dropdown">   
                    <div class="range-amount"></div>
                    <div class="slider-range" data-start-min="<?= (isset($min)? $min : 0); ?>" data-start-max="<?= (isset($max)? $max : round_max_price()); ?>" data-min="0" data-max="<?= round_max_price(); ?>" data-after="kr."></div>
                    <input class="min" name="min" type="hidden" id="storrelse-min" readonly>
                    <input class="max" name="max" type="hidden" id="storrelse-max" readonly>
                </div>
            </fieldset>
        </div>

        <input type="hidden" name="url" id="url" value="<?= explode('?', get_pagenum_link())[0]; ?>">
        <input type="hidden" name="action" value="product_filter">
        <?php wp_nonce_field( 'product_filter', 'product_filter_nonce' ); ?>
        
    </form>
</div>