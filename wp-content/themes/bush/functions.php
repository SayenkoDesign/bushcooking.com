<?php
require_once 'vendor/autoload.php';

use Bush\App;
use Bush\WordPress\Menu;
use Bush\WordPress\StyleSheet;
use Bush\WordPress\Script;

// stylesheets
$stylesheet_app = new StyleSheet('bush_app_css', StyleSheet::getThemeURL() . '/stylesheets/app.css');

// scripts
add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
});
$script_jquery = new Script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
$script_foundation = new Script('foundation', Script::getThemeURL() . '/bower_components/foundation-sites/dist/foundation.min.js');
$script_app = new Script('bush_app_js', Script::getThemeURL() . '/js/app.min.js', [
    'foundation'
], time());

// menus
$menu_primary = new Menu('primary', 'primary menu used in header');