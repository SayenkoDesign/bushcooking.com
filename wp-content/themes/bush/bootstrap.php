<?php
require_once 'vendor/autoload.php';

global $app;

$app = new \Bush\App([
    'twig.path' => __DIR__ . '/views',
]);
$app->enableTwig();
