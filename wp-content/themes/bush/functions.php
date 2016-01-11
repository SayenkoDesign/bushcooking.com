<?php
require_once 'vendor/autoload.php';

use Bush\App;
use Bush\WordPress\Menu;
use Bush\WordPress\StyleSheet;

$app = new App();

$stylesheet = new StyleSheet('bush', StyleSheet::getThemeURL() . '/stylesheets/app.css');
$menu_1 = new Menu('location', 'and a description');