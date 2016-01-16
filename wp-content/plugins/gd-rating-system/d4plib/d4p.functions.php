<?php

/*
Name:    d4pLib_Functions
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

if (!function_exists('d4p_is_oembed_link')) {
    /**
     * Check if the URL is valid for oembed
     * 
     * @param string $url url to check
     * @return bool
     */
    function d4p_is_oembed_link($url) {
        require_once(ABSPATH.WPINC.'/class-oembed.php');

        $oembed = _wp_oembed_get_object();
        $result = $oembed->get_html($url);

        return $result === false ? false : true;
    }
}

if (!function_exists('d4p_replace_tags_in_content')) {
    /**
     * 
     * @param string $content
     * @param array $tags
     * @return string
     */
    function d4p_replace_tags_in_content($content, $tags) {
        foreach ($tags as $tag => $replace) {
            $_tag = '%'.$tag.'%';

            if (strpos($content, $_tag) !== false) {
                $content = str_replace($_tag, $replace, $content);
            }
        }

        return $content;
    }
}

if (!function_exists('d4p_is_array_associative')) {
    /**
     * Check if the array is associative.
     *
     * @param mixed $array array to check
     * @return boolean true if the array is associative, false if it is not.
     */
    function d4p_is_array_associative($array) {
        return is_array($array) && 
               (0 !== count(array_diff_key($array, array_keys(array_keys($array)))) || count($array) == 0);
    }
}

if (!function_exists('d4p_eval_php')) {
    /**
     * Evaluate PHP in astring.
     *
     * @param string $content text to evaluate
     * @return string result string
     */
    function d4p_eval_php($content) {
        ob_start();

        eval('?>'.$content);
	$text = ob_get_contents();
	ob_end_clean();

	return $text;
    }
}

if (!function_exists('d4p_strleft')) {
    /**
     * Strip first string starting from the position of second string.
     *
     * @param string $s1 first string
     * @param string $s2 locator string
     * @return string result string
     */
    function d4p_strleft($s1, $s2) {
        return substr($s1, 0, strpos($s1, $s2));
    }
}

if (!function_exists('d4p_current_url')) {
    /**
     * Get URL of the current page.
     *
     * @return string URL of the current page
     */
    function d4p_current_url() {
        $s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
        $protocol = d4p_strleft(strtolower($_SERVER['SERVER_PROTOCOL']), '/').$s;
        $port = $_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] == '443' ? '' : ':'.$_SERVER['SERVER_PORT'];

        return $protocol.'://'.$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('d4p_visitor_ip')) {
    function d4p_visitor_ip() {
        $ip = '';

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        if ($ip == '::1') {
            $ip = '127.0.0.1';
        } else if ($ip != '') {
            $ip = d4p_ip_cleanup($ip);
        }

        return $ip;
    }
}

if (!function_exists('d4p_ip_cleanup')) {
    function d4p_ip_cleanup($ip) {
        $ip = preg_replace('/[^0-9a-fA-F:., ]/', '', $ip);

        $ips = explode(',', $ip);

        return trim($ips[count($ips) - 1]);
    }
}

if (!function_exists('d4p_scan_dir')) {
    function d4p_scan_dir($path, $filter = 'files', $extensions = array(), $reg_expr = '', $full_path = false) {
        $extensions = (array)$extensions;
        $filter = !in_array($filter, array('folders', 'files', 'all')) ? 'files' : $filter;
        $path = str_replace('\\', '/', $path);

        $files = array();
        $final = array();

        if (file_exists($path)) {
            $files = scandir($path);

            $path = rtrim($path, '/').'/';
            foreach ($files as $file) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);

                if (empty($extensions) || in_array($ext, $extensions)) {
                    if (substr($file, 0, 1) != '.') {
                        if ((is_dir($path.$file) && (in_array($filter, array('folders', 'all')))) ||
                            (is_file($path.$file) && (in_array($filter, array('files', 'all')))) ||
                            ((is_file($path.$file) || is_dir($path.$file)) && (in_array($filter, array('all'))))) {
                                $add = $full_path ? $path : '';

                                if ($reg_expr == '') {
                                    $final[] = $add.$file;
                                } else if (preg_match($reg_expr, $file)) {
                                    $final[] = $add.$file;
                                }
                        }
                    }
                }
            }
        }

        return $final;
    }
}

if (!function_exists('d4p_file_size_format')) {
    function d4p_file_size_format($size, $decimals = 2) {
        $size = intval($size);
        $unit = '';

        if (strlen($size) <= 9 && strlen($size) >= 7) {
            $size = number_format($size / 1048576, $decimals);
            $unit = 'MB';
        } else if (strlen($size) >= 10) {
            $size = number_format($size / 1073741824, $decimals);
            $unit = 'GB';
        } else if (strlen($size) <= 6 && strlen($size) >= 4) {
            $size = number_format($size / 1024, $decimals);
            $unit = 'KB';
        } else {
            $unit = 'B';
        }

        if (floatval($size) == intval($size)) {
            $size = intval($size);
        }
        
        return $size.' '.$unit;
    }
}

if (!function_exists('d4p_text_length_limit')) {
    function d4p_text_length_limit($text, $length = 200, $append = '&hellip;') {
        if (function_exists('mb_strlen')) {
            $text_length = mb_strlen($text);
        } else {
            $text_length = strlen($text);
        }

        if (!empty($length) && ($text_length > $length)) {
            $text = substr($text, 0, $length - 1);
            $text.= $append;
        }

        return $text;
    }
}

if (!function_exists('d4p_entity_decode')) {
    function d4p_entity_decode($content, $quote_style = null, $charset = null) {
        if (null === $quote_style) $quote_style = ENT_QUOTES;
        if (null === $charset) $charset = GDR2_CHARSET;

        return html_entity_decode($content, $quote_style, $charset);
    }
}

if (!function_exists('d4p_str_replace_first')) {
    function d4p_str_replace_first($search, $replace, $subject) {
        $pos = strpos($subject, $search);
        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }
}

if (!function_exists('d4p_extract_images_urls')) {
    function d4p_extract_images_urls($search, $limit = 0) {
        $images = array();

        if (preg_match_all("/<img(.+?)>/", $search, $images)) {
            foreach ($images[1] as $image) {
                if (preg_match( '/src=(["\'])(.*?)\1/', $image, $match)) {
                    $images[] = $match[2];
                }
            }
        }

        if ($limit > 0 && !empty($images)) {
            $images = array_slice($images, 0, $limit);
        }

        if ($limit == 1) {
            return count($images) == 1 ? $images[0] : '';
        } else {
            return $images;
        }
    }
}

if (!function_exists('is_odd')) {
    /**
     * Check if the number is odd or even.
     *
     * @param int $number number to check
     * @return bool true for odd, false for even number
     */
    function is_odd($number) {
        return $number&1;
    }
}

if (!function_exists('is_divisible')) {
    /**
     * Check if one number is divisible by another
     *
     * @param int $number number to check if is divisible
     * @param int $by_number to check if is divisible by
     * @return bool true is divisible, false is not
     */
    function is_divisible($number, $by_number) {
        return $number%$by_number == 0;
    }
}
