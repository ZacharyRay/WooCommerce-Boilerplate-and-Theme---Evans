<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta <?php bloginfo('charset') ?>>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <?php do_action('op_body_start'); ?>

    <header class="header"> 
        <div class="header_usp">
            <div class="container">
                <?php do_action('op_header_usp'); ?>
            </div>
        </div>
        <div id="main" class="container">
        
            <div class="header__logo">
                <?php do_action('op_header__logo');?>
            </div>
            <div class="header__search">
                <?php do_action('op_header__search'); ?>
            </div>
            <div class="header__icons">
                <?php do_action('op_header__icons'); ?>
            </div>        
            <div class="header__menu" >
                <?php do_action('op_header__menu'); ?>
            </div>    
            
        </div>


        <?php do_action('op_header_end'); ?>
    </header>

    <?php do_action('op_after_header');?>

    <?php get_template_part('elements/banner');?>

    <?php if ( function_exists('yoast_breadcrumb') && !is_front_page()  ) { ?>
        <section class="breadcrumbs">
            <div class="container">
                <?php yoast_breadcrumb(); ?>
            </div>
        </section>
    <?php } ?>

    <div class="content-wrapper"> 

    <?php do_action('op_inner_before_content'); //brug denne til at indsætte inhold før content?>

