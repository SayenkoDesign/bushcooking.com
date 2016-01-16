<?php

if (!defined('ABSPATH')) exit;

function gdrts_render_rating($args = array(), $method = array()) {
    return gdrts_single()->render((array)$args, (array)$method);
}

function gdrts_render_ratings_list($args = array(), $method = array()) {
    return gdrts_list()->render((array)$args, (array)$method);
}

function gdrts_query_ratings($method = 'stars-rating', $args = array()) {
    return gdrts_query()->run($method, $args);
}

function gdrts_get_rating_item_by_id($item_id) {
    return gdrts_rating_item::get_instance($item_id);
}

function gdrts_get_rating_item_by_post($post = null) {
    if (is_null($post)) {
        global $post;
    }

    return gdrts_rating_item::get_instance(null, 'posts', $post->post_type, $post->ID);
}

function gdrts_get_rating_item($args) {
    $defaults = array(
        'entity' => null, 
        'name' => null, 
        'item_id' => null,
        'id' => null
    );

    $atts = shortcode_atts($defaults, $args);

    return gdrts_rating_item::get_instance($atts['item_id'], $atts['entity'], $atts['name'], $atts['id']);
}

function gdrts_return_template($templates) {
    ob_start();

    gdrts_load_template($templates, true);

    $result = ob_get_contents();

    ob_end_clean();

    return $result;
}

function gdrts_load_template($templates, $load = true) {
    $theme = array();

    foreach ($templates as $template) {
        $theme[] = 'gdrts/'.$template;
        $theme[] = $template;
    }

    $found = locate_template($templates, false);

    if (empty($found)) {
        foreach ($templates as $template) {
            if (file_exists(GDRTS_PATH.'templates/'.$template)) {
                $found = GDRTS_PATH.'templates/'.$template;
                break;
            }
        }
    }

    if ($load) {
        include($found);
    } else {
        return $found;
    }
}

function gdrts_is_addon_loaded($name) {
    return in_array('addon_'.$name, gdrts()->loaded);
}

function gdrts_is_method_loaded($name) {
    return in_array('method_'.$name, gdrts()->loaded);
}

function gdrts_is_method_valid($method) {
    return isset(gdrts()->methods[$method]);
}

function gdrts_is_template_type_valid($type) {
    return in_array($type, array('single', 'list'));
}

function gdrts_register_entity($name, $label, $types = array()) {
    if (!isset(gdrts()->entities[$name])) {
        gdrts()->entities[$name] = array('label' => $label, 'types' => $types);
    }
}

function gdrts_register_type($entity, $name, $label) {
    if (isset(gdrts()->entities[$entity])) {
        gdrts()->entities[$entity]['types'][$name] = $label;
    }
}

function gdrts_register_addon($name, $label, $override = false, $autoload = true) {
    if (!isset(gdrts()->addons[$name])) {
        gdrts()->addons[$name] = array('label' => $label, 'override' => $override, 'autoload' => $autoload);
    }
}

function gdrts_register_method($name, $label, $override = false, $autoembed = true, $autoload = true, $review = false) {
    if (!isset(gdrts()->methods[$name])) {
        gdrts()->methods[$name] = array('label' => $label, 'override' => $override, 'autoembed' => $autoembed, 'autoload' => $autoload, 'review' => $review);
    }
}

function gdrts_load_object_data($entity, $name, $id) {
    $data = apply_filters('gdrts_object_data_'.$entity.'_'.$name, null, $id);

    if (is_null($data)) {
        switch ($entity) {
            case 'posts':
                $data = new gdrts_item_post($entity, $name, $id);
                break;
            case 'terms':
                $data = new gdrts_item_term($entity, $name, $id);
                break;
            case 'comments':
                $data = new gdrts_item_comment($entity, $name, $id);
                break;
            case 'users':
                $data = new gdrts_item_user($entity, $name, $id);
                break;
            default:
            case 'custom':
                $data = new gdrts_item_custom($entity, $name, $id);
                break;
        }
    }

    return $data;
}

function gdrts_font_icon_characters() {
    return apply_filters('gdrts_font_icon_characters', array(
        'star' => 's',
        'asterisk' => 'a',
        'heart' => 'h',
        'bell' => 'b',
        'square' => 'q',
        'circle' => 'c',
        'gear' => 'g',
        'trophy' => 't',
        'snowflake' => 'f',
        'like2' => 'k',
        'dislike2' => 'i',
        'like' => 'l',
        'dislike' => 'd',
        'smile' => 'm',
        'frown' => 'r',
        'plus' => '+',
        'minus' => '-'
    ));
}
