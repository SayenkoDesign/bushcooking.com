<?php

if (!defined('ABSPATH')) exit;

class gdrts_admin_shared {
    public static function data_list_entity_name_types() {
        $items = array();

        foreach (gdrts()->entities as $entity => $obj) {
            foreach ($obj['types'] as $name => $label) {
                $items[$entity.'.'.$name] = $obj['label'].': '.$label;
            }
        }

        return $items;
    }

    public static function data_list_style_font_name() {
        return apply_filters('gdrts_list_stars_styles_font_icons', array(
            'star' => __("Star", "gd-rating-system"),
            'bell' => __("Bell", "gd-rating-system"),
            'heart' => __("Heart", "gd-rating-system"),
            'asterisk' => __("Asterisk", "gd-rating-system"),
            'square' => __("Square", "gd-rating-system"),
            'circle' => __("Circle", "gd-rating-system"),
            'gear' => __("Gear", "gd-rating-system"),
            'trophy' => __("Trophy", "gd-rating-system"),
            'like' => __("Thumb", "gd-rating-system"),
            'snowflake' => __("Snowflake", "gd-rating-system")
        ));
    }

    public static function data_list_style_image_name() {
        return apply_filters('gdrts_list_stars_styles_images', array(
            'star' => __("Star (512px)", "gd-rating-system"),
            'oxygen' => __("Oxygen Star (256px)", "gd-rating-system")
        ));
    }

    public static function data_list_style_type() {
        return array(
            'font' => __("Font Icon Based", "gd-rating-system"),
            'image' => __("Image Based", "gd-rating-system")
        );
    }

    public static function data_list_orderby() {
        return array(
            'rating' => __("Rating", "gd-rating-system"),
            'votes' => __("Votes", "gd-rating-system"),
            'item_id' => __("Item ID", "gd-rating-system"),
            'id' => __("Object ID", "gd-rating-system"),
            'latest' => __("Latest Vote", "gd-rating-system")
        );
    }

    public static function data_list_order() {
        return array(
            'DESC' => __("Descending", "gd-rating-system"),
            'ASC' => __("Ascending", "gd-rating-system")
        );
    }

    public static function data_list_stars() {
        $list = array();

        for ($i = 1; $i < 26; $i++) {
            $list[$i] = $i.' '._n("star", "stars", $i, "gd-rating-system");
        }

        return $list;
    }

    public static function data_list_templates($method, $type = 'single') {
        if (gdrts_is_method_valid($method) && gdrts_is_template_type_valid($type)) {
            $templates = gdrts_settings()->get($method, 'templates');

            if (!isset($templates[$type]) || empty($templates[$type])) {
                gdrts_rescan_for_templates();

                $templates = gdrts_settings()->get($method, 'templates');
            }

            return $templates[$type];
        } else {
            return array();
        }
    }

    public static function data_list_distributions() {
        return array(
            'normalized' => __("Normalized", "gd-rating-system"),
            'exact' => __("Exact", "gd-rating-system")
        );
    }

    public static function data_list_resolutions() {
        return array(
            100 => __("100% - Full Star", "gd-rating-system"),
            50 => __("50% - Half Star", "gd-rating-system"),
            25 => __("25% - One Quarter Star", "gd-rating-system"),
            20 => __("20% - One Fifth Star", "gd-rating-system"),
            10 => __("10% - One Tenth Star", "gd-rating-system")
        );
    }

    public static function data_list_vote() {
        return array(
            'single' => __("Single vote only", "gd-rating-system"),
            'revote' => __("Single vote with revote", "gd-rating-system"),
            'multi' => __("Multiple votes", "gd-rating-system")
        );
    }

    public static function data_list_align() {
        return array(
            'none' => __("No alignment", "gd-rating-system"),
            'left' => __("Left", "gd-rating-system"),
            'center' => __("Center", "gd-rating-system"),
            'right' => __("Right", "gd-rating-system")
        );
    }
}
