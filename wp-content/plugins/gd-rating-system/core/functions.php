<?php

if (!defined('ABSPATH')) exit;

function gdrts_timestamp_from_gmt_timestamp($timestamp) {
    $tz = intval(get_option('gmt_offset'));

    return $timestamp + $tz * 3600;
}

function gdrts_timestamp_from_gmt_date($date) {
    $timestamp = strtotime($date);

    return gdrts_timestamp_from_gmt_timestamp($timestamp);
}

function gdrts_json_to_data_attribute($data, $echo = true) {
    $render = esc_attr(json_encode($data));

    if ($echo) {
        echo $render;
    } else {
        return $render;
    }
}

function gdrts_list_all_method() {
    $items = array();

    foreach (gdrts()->methods as $method => $obj) {
        $items[$method] = $obj['label'];
    }

    return $items;
}

function gdrts_list_all_entities() {
    $items = array();

    foreach (gdrts()->entities as $entity => $obj) {
        $rule = array(
            'title' => $obj['label'],
            'values' => array(
                $entity => sprintf(__("All %s Types", "gd-rating-system"), $obj['label'])
            )
        );

        foreach ($obj['types'] as $name => $label) {
            $rule['values'][$entity.'.'.$name] = $label;
        }

        $items[] = $rule;
    }

    return $items;
}

function gdrts_rescan_for_templates() {
    require_once(GDRTS_PATH.'core/admin/templates.php');

    $templates = gdrts_admin_templates::scan_for_templates();

    foreach ($templates as $method => $list) {
        gdrts_settings()->set($method, $list, 'templates');
    }

    gdrts_settings()->save('templates');
}
