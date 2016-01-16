<?php

if (!defined('ABSPATH')) exit;

function _gdrts_widget_render_header($instance, $widget_base, $base_class = '') {
    $class = array('gdrts-widget-wrapper');
    $class[] = str_replace('_', '-', $widget_base);

    if ($base_class != '') {
        $class[] = $base_class;
    }

    if ($instance['_class'] != '') {
        $class[] = $instance['_class'];
    }

    $render = '<div class="'.join(' ', $class).'">'.D4P_EOL;

    if ($instance['before'] != '') {
        $render.= '<div class="gdrts-widget-before">'.$instance['before'].'</div>';
    }

    return $render;
}

function _gdrts_widget_render_footer($instance) {
    $render = '';

    if ($instance['after'] != '') {
        $render.= '<div class="gdrts-widget-after">'.$instance['after'].'</div>';
    }

    $render.= '</div>';

    return $render;
}

function _gdrts_helper_clean_call_args($args) {
    if ($args['type'] != '') {
        $_type_name = explode('.', $args['type']);

        if (count($_type_name) == 2) {
            $args['entity'] = $_type_name[0];
            $args['name'] = $_type_name[1];
        }
    }

    $args['echo'] = false;

    unset($args['type']);

    return $args;
}

function _gdrts_helper_clean_call_method($args) {
    $args['style_name'] = $args['style_type'] == 'font' ? $args['style_font_name'] : $args['style_image_name'];

    unset($args['style_font_name']);
    unset($args['style_image_name']);
    
    $call_method = array();

    foreach ($args as $key => $value) {
        if ($value != '') {
            $call_method[$key] = $value;
        }
    }

    return $call_method;
}

function _gdrts_embed_stars_rating($atts) {
    $defaults_atts = array(
        'type' => '',
        'entity' => '',
        'name' => '',
        'id' => 0,
        'item_id' => 0
    );

    $defaults_method = array(
        'class' => '',
        'template' => '',
        'alignment' => '',
        'distribution' => '',
        'style_type' => '',
        'style_font_name' => '',
        'style_image_name' => '',
        'style_size' => '',
        'style_class' => ''
    );

    $call_args = shortcode_atts($defaults_atts, $atts);
    $call_args = _gdrts_helper_clean_call_args($call_args);

    $call_method = shortcode_atts($defaults_method, $atts);
    $call_method = _gdrts_helper_clean_call_method($call_method);

    $call_args['method'] = 'stars-rating';

    return gdrts_render_rating($call_args, $call_method);
}

function _gdrts_embed_stars_rating_auto($atts) {
    $atts['id'] = get_post()->ID;
    $atts['type'] = 'posts.'.get_post()->post_type;

    return _gdrts_embed_stars_rating($atts);
}

function _gdrts_embed_stars_rating_list($atts) {
    $defaults_atts = array(
        'type' => '',
        'entity' => '',
        'name' => '',
        'id__in' => array(),
        'id__not_in' => array(),
        'orderby' => 'rating',
        'order' => 'DESC',
        'offset' => 0,
        'limit' => 5,
        'return' => 'objects',
        'rating_min' => 0,
        'votes_min' => 0,
        'period' => false,
        'source' => ''
    );

    $defaults_method = array(
        'template' => '',
        'style_type' => '',
        'style_font_name' => '',
        'style_image_name' => '',
        'style_size' => '',
        'style_class' => ''
    );

    $call_args = shortcode_atts($defaults_atts, $atts);
    $call_args = _gdrts_helper_clean_call_args($call_args);

    $call_method = shortcode_atts($defaults_method, $atts);
    $call_method = _gdrts_helper_clean_call_method($call_method);

    $call_args['method'] = 'stars-rating';

    return gdrts_render_ratings_list($call_args, $call_method);
}
