<?php

if (!defined('ABSPATH')) exit;

class gdrts_core_shortcodes extends d4pShortcodes {
    public $prefix = 'gdrts';
    public $shortcake_title = 'GD Rating System Pro';

    public function init() {
        $this->shortcodes = array(
            'stars_rating' => array(
                'name' => __("Stars Rating", "gd-rating-system"),
                'atts' => array('type' => 'posts.post', 'id' => 0, 'item' => 0, 'class' => '', 'template' => '', 'alignment' => '', 'distribution' => '', 'style_type' => '', 'style_font_name' => '', 'style_image_name' => '', 'style_size' => '', 'style_class' => '')
            ),
            'stars_rating_auto' => array(
                'name' => __("Stars Rating - Auto Item", "gd-rating-system"),
                'atts' => array('class' => '', 'template' => '', 'alignment' => '', 'distribution' => '', 'style_type' => '', 'style_font_name' => '', 'style_image_name' => '', 'style_size' => '', 'style_class' => '')
            ),
            'stars_rating_list' => array(
                'name' => __("Stars Ratings List", "gd-rating-system"),
                'atts' => array('type' => 'posts.post', 'class' => '', 'orderby' => 'rating', 'order' => 'DESC', 'limit' => 5, 'rating_min' => 0, 'votes_min' => 0, 'template' => 'shortcode', 'style_type' => 'font', 'style_font_name' => 'star', 'style_image_name' => 'star', 'style_size' => 20, 'style_class' => '')
            )
        );
    }

    public function shortcode_stars_rating($atts) {
        $name = 'stars_rating';

        if ($this->in_shortcake_preview($name)) {
            return $this->shortcake_preview($atts, $name);
        }

        $atts = $this->_atts($name, $atts);

        gdrts()->load_embed();

        return $this->_wrapper(_gdrts_embed_stars_rating($atts), $name, $atts['class']);
    }

    public function shortcode_stars_rating_auto($atts) {
        $name = 'stars_rating_auto';

        if ($this->in_shortcake_preview($name)) {
            return $this->shortcake_preview($atts, $name);
        }

        $atts = $this->_atts($name, $atts);

        gdrts()->load_embed();

        return $this->_wrapper(_gdrts_embed_stars_rating_auto($atts), $name, $atts['class']);
    }

    public function shortcode_stars_rating_list($atts) {
        $name = 'stars_rating_list';

        if ($this->in_shortcake_preview($name)) {
            return $this->shortcake_preview($atts, $name);
        }

        $atts = $this->_atts($name, $atts);
        $atts['source'] = 'shortcode';

        gdrts()->load_embed();

        return $this->_wrapper(_gdrts_embed_stars_rating_list($atts), $name, $atts['class']);
    }
}

global $_gdrts_shortcodes;

$_gdrts_shortcodes = new gdrts_core_shortcodes();
