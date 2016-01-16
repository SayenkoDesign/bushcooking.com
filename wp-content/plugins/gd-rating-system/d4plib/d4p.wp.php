<?php

/*
Name:    d4pLib_WP_Functions
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

if (!function_exists('wp_redirect_self')) {
    function wp_redirect_self() {
        wp_redirect($_SERVER['REQUEST_URI']);
    }
}

if (!function_exists('wp_redirect_referer')) {
    function wp_redirect_referer() {
        wp_redirect($_REQUEST['_wp_http_referer']);
    }
}

if (!function_exists('wp_flush_rewrite_rules')) {
    function wp_flush_rewrite_rules() {
        global $wp_rewrite;

        $wp_rewrite->flush_rules();
    }
}

if (!function_exists('wp_get_attachment_image_url')) {
    function wp_get_attachment_image_url($attachment_id, $size = 'thumbnail', $icon = false) {
        $image = wp_get_attachment_image_src($attachment_id, $size, $icon);

        return isset($image['0']) ? $image['0'] : false;
    }
}

if (!function_exists('is_any_tax')) {
    function is_any_tax() {
        return is_tag() || 
               is_tax() || 
               is_category();
    }
}

if (!function_exists('is_wplogin_page')) {
    function is_wplogin_page() {
        global $pagenow;

        return $pagenow == 'wp-login.php';
    }
}

if (!function_exists('is_wpsignup_page')) {
    function is_wpsignup_page() {
        global $pagenow;

        return $pagenow == 'wp-signup.php';
    }
}

if (!function_exists('is_wpactivate_page')) {
    function is_wpactivate_page() {
        global $pagenow;

        return $pagenow == 'wp-activate.php';
    }
}

if (!function_exists('is_posts_page')) {
    function is_posts_page() {
        global $wp_query;

        return $wp_query->is_posts_page;
    }
}

if (!function_exists('d4p_cache_flush')) {
    function d4p_cache_flush($cache = true, $queries = true) {
        if ($cache) {
            wp_cache_flush();
        }

        if ($queries) {
            global $wpdb;

            if (is_array($wpdb->queries) && !empty($wpdb->queries)) {
                unset($wpdb->queries);
                $wpdb->queries = array();
            }
        }
    }
}

if (!function_exists('d4p_is_current_user_roles')) {
    function d4p_is_current_user_roles($roles = array()) {
        $current = d4p_current_user_roles();
        $roles = (array)$roles;

        if (is_array($current) && !empty($roles)) {
            $match = array_intersect($roles, $current);

            return !empty($match);
        } else {
            return false;
        }
    }
}

if (!function_exists('d4p_current_user_roles')) {
    function d4p_current_user_roles() {
        if (is_user_logged_in()) {
            global $current_user;

            return (array)$current_user->roles;
        } else {
            return array();
        }
    }
}

if (!function_exists('d4p_is_current_user_admin')) {
    function d4p_is_current_user_admin() {
        return d4p_is_current_user_roles('administrator');
    }
}

if (!function_exists('d4p_switch_to_default_theme')) {
    function d4p_switch_to_default_theme() {
        switch_theme(WP_DEFAULT_THEME, WP_DEFAULT_THEME);
    }
}

if (!function_exists('d4p_delete_user_transient')) {
    function d4p_delete_user_transient($user_id, $transient) {
        $transient_option = '_transient_'.$transient;
        $transient_timeout = '_transient_timeout_'.$transient;

        delete_user_meta($user_id, $transient_option);
        delete_user_meta($user_id, $transient_timeout);
    }
}

if (!function_exists('d4p_get_user_transient')) {
    function d4p_get_user_transient($user_id, $transient) {
        $transient_option = '_transient_'.$transient;
        $transient_timeout = '_transient_timeout_'.$transient;

        if (get_user_meta($user_id, $transient_timeout, true) < time()) {
            delete_user_meta($user_id, $transient_option);
            delete_user_meta($user_id, $transient_timeout);
            return false;
        }

        return get_user_meta($user_id, $transient_option, true);
    }
}

if (!function_exists('d4p_set_user_transient')) {
    function d4p_set_user_transient($user_id, $transient, $value, $expiration = 86400) {
        $transient_option = '_transient_'.$transient;
        $transient_timeout = '_transient_timeout_'.$transient;

        if (get_user_meta($user_id, $transient_option, true) != '') {
            delete_user_meta($user_id, $transient_option);
            delete_user_meta($user_id, $transient_timeout);
        }

        add_user_meta($user_id, $transient_timeout, time() + $expiration, true);
        add_user_meta($user_id, $transient_option, $value, true);
    }
}

if (!function_exists('d4p_get_post_excerpt')) {
    function d4p_get_post_excerpt($post, $word_limit = 50) {
        $content = $post->post_excerpt == '' ? $post->post_content : $post->post_excerpt;

        $content = strip_shortcodes($content);
        $content = str_replace(']]>', ']]&gt;', $content);
        $content = strip_tags($content);

        $words = explode(' ', $content, $word_limit + 1);

        if (count($words) > $word_limit) {
            array_pop($words);
            $content = implode(' ', $words);
            $content.= '...';
        }

        return $content;
    }
}

if (!function_exists('d4p_get_post_content')) {
    function d4p_get_post_content($post) {
        $content = $post->post_content;

        if (post_password_required($post)) {
            $content = get_the_password_form($post);
        }

        $content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);

        return $content;
    }
}

if (!function_exists('d4p_get_thumbnail_url')) {
    function d4p_get_thumbnail_url($post_id, $size = 'full') {
        if (has_post_thumbnail($post_id)) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);

            return $image[0];
        } else {
            return '';
        }
    }
}

if (!function_exists('get_the_slug')) {
    function get_the_slug() {
        $post = get_post();
        return !empty($post) ? $post->post_name : false;
    }
}

if (!function_exists('d4p_list_user_roles')) {
    function d4p_list_user_roles() {
        $roles = array();

        global $wp_roles;
	$all_roles = $wp_roles->roles;

        foreach ($all_roles as $role => $details) {
            $roles[$role] = translate_user_role($details['name']);
        }
        
        return $roles;
    }
}

if (!function_exists('d4p_remove_cron')) {
    function d4p_remove_cron($hook) {
        $crons = _get_cron_array();

        if (!empty($crons)) {
            $save = false;

            foreach ($crons as $timestamp => $cron) {
                if (isset($cron[$hook])) {
                    unset($crons[$timestamp][$hook]);
                    $save = true;

                    if (empty($crons[$timestamp])) {
                        unset($crons[$timestamp]);
                    }
                }
            }

            if ($save) {
                _set_cron_array($crons);
            }
        }
    }
}

if (!function_exists('d4p_sanitize_key_expanded')) {
    function d4p_sanitize_key_expanded($key) {
        $key = strtolower($key);
	$key = preg_replace('/[^a-z0-9._\-]/', '', $key);

        return $key;
    }
}

if (!function_exists('d4p_sanitize_basic')) {
    function d4p_sanitize_basic($text) {
        return trim(strip_tags(strip_shortcodes($text)));
    }
}

if (!function_exists('d4p_html_excerpt')) {
    function d4p_html_excerpt($text, $limit, $more = null) {
        return wp_html_excerpt(strip_shortcodes($text), $limit, $more);
    }
}

if (!function_exists('d4p_check_ajax_referer')) {
    function d4p_check_ajax_referer($action, $nonce, $die = true) {
        $result = wp_verify_nonce($nonce, $action);

        if ($die && false === $result) {
            if (defined('DOING_AJAX') && DOING_AJAX) {
                wp_die(-1);
            } else {
                die('-1');
            }
        }

        do_action('check_ajax_referer', $action, $result);

        return $result;
    }
}

if (!function_exists('d4p_permalinks_enabled')) {
    function d4p_permalinks_enabled() {
        return get_option('permalink_structure');
    }
}

if (!function_exists('d4p_json_encode')) {
    function d4p_json_encode($data, $options = 0, $depth = 512) {
        if (function_exists('wp_json_encode') ) {
            return wp_json_encode($data, $options, $depth);
        } else {
            return json_encode($data, $options, $depth);
        }
    }
}

if (!function_exists('d4p_admin_enqueue_defaults')) {
    function d4p_admin_enqueue_defaults() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('wpdialogs');

        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_media();
    }
}
