<?php

if (!defined('ABSPATH')) exit;

class gdrtsWidget_stars_rating_list extends d4pLib_Widget {
    public $widget_base = 'gdrts_stars_rating_list';
    public $widget_domain = 'd4prts_widgets';
    public $cache_prefix = 'd4prts';

    public $defaults = array(
        'title' => 'Top Ratings',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'before' => '',
        'after' => '',
        'type' => 'posts.post',
        'orderby' => 'rating', 
        'order' => 'DESC', 
        'limit' => 5, 
        'rating_min' => 0, 
        'votes_min' => 0, 
        'template' => 'widget',
        'style_type' => '',
        'style_font_name' => '',
        'style_image_name' => '',
        'style_size' => 20,
        'style_class' => ''
    );

    function __construct($id_base = false, $name = "", $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Show Stars Rating list.", "gd-rating-system");
        $this->widget_name = 'GD Rating System: '.__("Stars Rating List", "gd-rating-system");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-rating-system"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-rating-system"), 'include' => array('stars-rating-list-content')),
            'display' => array('name' => __("Display", "gd-rating-system"), 'include' => array('stars-rating-list-display')),
            'extra' => array('name' => __("Extra", "gd-rating-system"), 'include' => array('shared-wrapper'))
        );

        include(GDRTS_PATH.'forms/widgets/shared-loader.php');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['_display'] = strip_tags(stripslashes($new_instance['_display']));
        $instance['_cached'] = intval(strip_tags(stripslashes($new_instance['_cached'])));
        $instance['_class'] = strip_tags(stripslashes($new_instance['_class']));
        $instance['_tab'] = strip_tags(stripslashes($new_instance['_tab']));
        $instance['_hook'] = sanitize_key($new_instance['_hook']);

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['before'])));
            $instance['after'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['after'])));
        }

        $instance['type'] = strip_tags(stripslashes($new_instance['type']));
        $instance['orderby'] = strip_tags(stripslashes($new_instance['orderby']));
        $instance['order'] = strip_tags(stripslashes($new_instance['order']));

        $instance['limit'] = intval(strip_tags(stripslashes($new_instance['limit'])));
        $instance['rating_min'] = intval(strip_tags(stripslashes($new_instance['rating_min'])));
        $instance['votes_min'] = intval(strip_tags(stripslashes($new_instance['votes_min'])));

        $instance['template'] = strip_tags(stripslashes($new_instance['template']));
        $instance['style_class'] = strip_tags(stripslashes($new_instance['style_class']));
        $instance['style_type'] = strip_tags(stripslashes($new_instance['style_type']));
        $instance['style_font_name'] = strip_tags(stripslashes($new_instance['style_font_name']));
        $instance['style_image_name'] = strip_tags(stripslashes($new_instance['style_image_name']));
        $instance['style_size'] = intval(strip_tags(stripslashes($new_instance['style_size'])));

        return $instance;
    }

    function render($results, $instance) {
        gdrts()->load_embed();

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        echo _gdrts_widget_render_header($instance, $this->widget_base);

        echo _gdrts_embed_stars_rating_list($instance);

        echo _gdrts_widget_render_footer($instance);
    }
}
