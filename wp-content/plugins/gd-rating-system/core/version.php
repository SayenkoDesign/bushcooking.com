<?php

if (!defined('ABSPATH')) exit;

class gdrts_core_info {
    public $code = 'gd-rating-system';

    public $version = '1.0.3';
    public $codename = 'Hyperion';
    public $build = 207;
    public $edition = 'lite';
    public $status = 'stable';
    public $updated = '2016.01.04';
    public $url = 'https://rating.dev4press.com/';
    public $author_name = 'Milan Petrovic';
    public $author_url = 'https://www.dev4press.com/';
    public $released = '2015.12.25';

    public $install = false;
    public $update = false;
    public $previous = 0;

    function __construct() { }

    public function to_array() {
        return (array)$this;
    }
}

