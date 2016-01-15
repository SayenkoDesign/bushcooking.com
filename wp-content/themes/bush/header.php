<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div data-sticky-container>
    <div class="sticky" data-sticky id="top-bar-container">
        <div class="top-bar" id="search-bar">
            <div class="column row">
                <div class="top-bar-right">
                    <ul class="menu">
                        <li>
                            <button class="dropdown button" type="button" data-toggle="example-dropdown">
                                Toggle Dropdown
                            </button>
                        </li>
                        <li>
                            <input type="search" placeholder="Search">
                        </li>
                        <li>
                            <button type="button" class="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </li>
                    </ul>
                    <div class="dropdown-pane" id="example-dropdown" data-dropdown>
                        <ul class="menu vertical">
                            <?php
                            wp_list_categories([
                                'orderby'            => 'name',
                                'order'              => 'ASC',
                                'title_li'           => __( '' ),
                                'hide_empty'         => 0,
                                'show_count'         => 0,
                                'use_desc_for_title' => 1,
                                'child_of'           => 0,
                                'hierarchical'       => 0,
                            ]);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-bar" id="primary-navigation">
            <div class="column row">
                <div class="top-bar-center hide-for-small-only">
                    <?php
                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'menu_class' => "dropdown menu",
                            'menu_id' => 'primary-nav'
                        ]);
                    ?>
                </div>
                <div class="top-bar-right">
                    <ul class="menu social-links">
                        <li><a href="http://allrecipes.com/cook/7709795/" target="_blank"><i class="fa all-recipes"></i></a></li>
                        <li><a href="https://www.instagram.com/_bushcooking_/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://www.pinterest.com/Bush_Cooking/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="https://www.facebook.com/BushCooking" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="" target="_blank"><i class="fa fa-stumbleupon"></i></a></li>
                        <li><a href="https://twitter.com/BushCooking" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://plus.google.com/u/0/b/116280046121062819121/116280046121062819121" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                    <div id="primary-menu-toggle">
                        <div data-responsive-toggle="primary-mobile-nav" data-hide-for="medium">
                            <button class="menu-icon" type="button" data-toggle></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(get_header_image()): ?>
            <div class="column row">
                <a href="<?php get_home_url(); ?>" id="large-logo">
                    <img src="<?php echo get_header_image(); ?>" alt="">
                </a>
            </div>
        <?php endif; ?>

        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class' => "vertical menu hide-for-medium",
            'menu_id' => 'primary-mobile-nav'
        ]);
        ?>
        <!--
        <ul class="vertical menu hide-for-medium" id="primary-mobile-nav" data-accordion-menu>
            <li>
                <a href="#">Item 1</a>
                <ul class="menu vertical nested">
                    <li>
                        <a href="#">Item 1A</a>
                        <ul class="menu vertical nested">
                            <li><a href="#">Item 1Ai</a></li>
                            <li><a href="#">Item 1Aii</a></li>
                            <li><a href="#">Item 1Aiii</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Item 1B</a></li>
                    <li><a href="#">Item 1C</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Item 2</a>
                <ul class="menu vertical nested">
                    <li><a href="#">Item 2A</a></li>
                    <li><a href="#">Item 2B</a></li>
                </ul>
            </li>
            <li><a href="#">Item 3</a></li>
        </ul>
        -->
    </div>
</div>