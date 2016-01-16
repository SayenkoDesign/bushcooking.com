<?php

/*
Name:    d4pLib_Core
Version: v1.5.6
Author:  Milan Petrovic
Email:   milan@gdragon.info
Website: https://www.dev4press.com/libs/d4plib/

== Copyright ==
Copyright 2008 - 2015 Milan Petrovic (email: milan@gdragon.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('D4P_VERSION')) { 
    define('D4P_VERSION', '1.5.6');
    define('D4P_BUILD', '1874');
}

if (!defined('D4P_EOL')) {
    define('D4P_EOL', "\r\n");
}

if (!defined('D4P_TAB')) {
    define('D4P_TAB', "\t");
}

if (!defined('D4P_CHARSET')) { 
    define('D4P_CHARSET', get_option('blog_charset'));
}

if (!defined('D4P_ADMIN')) { 
    define('D4P_ADMIN', defined('WP_ADMIN') && WP_ADMIN);
}

if (!defined('D4P_AJAX')) { 
    define('D4P_AJAX', defined('DOING_AJAX') && DOING_AJAX);
}

if (!defined('D4P_ASYNC_UPLOAD') && D4P_AJAX) {
    define('D4P_ASYNC_UPLOAD', isset($_REQUEST['action']) && 'upload-attachment' === $_REQUEST['action']);
}

if (!defined('D4P_CRON')) { 
    define('D4P_CRON', defined('DOING_CRON') && DOING_CRON);
}

if (!defined('D4P_DEBUG')) { 
    define('D4P_DEBUG', defined('WP_DEBUG') && WP_DEBUG);
}

if (!defined('D4P_SCRIPT_DEBUG')) { 
    define('D4P_SCRIPT_DEBUG', defined('SCRIPT_DEBUG') && SCRIPT_DEBUG);
}

if (!function_exists('d4p_include')) {
    function d4p_include($name, $directory = '', $base_path = '') {
        $path = $base_path == '' ? dirname(__FILE__).'/' : $base_path;

        if ($directory != '') {
            $path.= $directory.'/';
        }

        $path.= 'd4p.'.$name.'.php';

        require_once($path);
    }
}

if (!function_exists('d4p_includes')) {
    function d4p_includes($load = array(), $base_path = '') {
        foreach ($load as $item) {
            if (is_array($item)) {
                d4p_include($item['name'], $item['directory'], $base_path);
            } else {
                d4p_include($item, '', $base_path);
            }
        }
    }
}

if (!function_exists('d4p_icon_class')) {
    function d4p_icon_class($name, $extra = array()) {
        $class = ''; $d4p = false; $dashicons = false;

        if (substr($name, 0, 3) == 'd4p') {
            $class.= 'd4pi '.$name;
            $d4p = true;
        } else if (substr($name, 0, 9) == 'dashicons') {
            $class.= 'dashicons '.$name;
            $dashicons = true;
        } else {
            $class.= 'fa fa-'.$name;
        }

        if (!empty($extra) && !$dashicons) {
            $extra = (array)$extra;

            foreach ($extra as $key) {
                $class.= ' '.($d4p ? 'd4pi' : 'fa').'-'.$key;
            }
        }

        return $class;
    }
}

if (D4P_DEBUG) {
    d4p_include('debug');
}
