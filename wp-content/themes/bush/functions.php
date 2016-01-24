<?php
require_once 'vendor/autoload.php';

use Bush\App;
use Bush\WordPress\Menu;
use Bush\WordPress\StyleSheet;
use Bush\WordPress\Script;
use Bush\WordPress\PostType;
use Bush\WordPress\Taxonomy;
use Bush\WordPress\ImageSize;

// stylesheets
$stylesheet_slick = new StyleSheet('slick', '//cdn.jsdelivr.net/g/jquery.slick@1.5.9(slick-theme.css+slick.css)');
$stylesheet_fontawesome = new StyleSheet('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
$stylesheet_app = new StyleSheet('bush_app_css', StyleSheet::getThemeURL() . '/stylesheets/app.css', ['fontawesome', 'slick']);

// scripts
add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
});
$script_jquery = new Script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
$script_slickjs = new Script('slick', '//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js', ['jquery']);
$script_foundation = new Script('foundation', Script::getThemeURL() . '/bower_components/foundation-sites/dist/foundation.min.js');
$script_app = new Script('bush_app_js', Script::getThemeURL() . '/js/app.min.js', [
    'foundation',
    'slick',
], time());

// menus
$menu_primary = new Menu('primary', 'primary menu used in header');

// post type
$recipes = new PostType(
    'recipes',
    'Recipe',
    'Recipe',
    'Food Recipes',
    true,
    true,
    true,
    false,
    ['title', 'author', 'comments', 'thumbnail'],
    true
);

// add taxonomies
$Difficulty = new Taxonomy('difficulty', 'recipes');
$Food = new Taxonomy('food_category', 'recipes');
$Food->setLabel("Food Category");

// move yoast down
add_filter( 'wpseo_metabox_prio', function() { return 'low';});
// gd is gdrts-metabox but I wont be able to move it without a bit of work so I am leaving it as is.

// add image sizes
$teaser = new ImageSize('teaser', 280, 280, true);
