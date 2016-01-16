<?php

if (!defined('ABSPATH')) exit;

class gdrts_admin_ajax {
    public function __construct() {
        add_action('wp_ajax_gdrts_rating', array(&$this, 'rating'));
        add_action('wp_ajax_gdrts_tools_recalc', array(&$this, 'recalc'));

        do_action('gdrts_admin_ajax');
    }

    public function check_nonce() {
        $nonce = wp_verify_nonce($_REQUEST['_ajax_nonce'], 'gdrts-admin-internal');

        if ($nonce === false) {
            wp_die(-1);
        }
    }

    public function rating() {
        $this->check_nonce();
    }

    public function recalc() {
        $this->check_nonce();

        @ini_set('memory_limit', '256M');
        @set_time_limit(0);

        require_once(GDRTS_PATH.'core/admin/maintenance.php');

        $operation = $_POST['operation'];

        switch ($operation) {
            case 'start':
                gdrts_settings()->set('maintenance', true, 'settings', true);

                $total = gdrts_admin_maintenance::count_rating_objects();
                $response = array(
                    'objects' => $total,
                    'message' => '* '.sprintf(__("Total of %s rating objects found.", "gd-rating-system"), $total)
                );

                die(json_encode($response));
                break;
            case 'stop':
                gdrts_settings()->set('maintenance', false, 'settings', true);

                $response = array(
                    'message' => '* '.__("Process has completed.", "gd-rating-system")
                );

                die(json_encode($response));
                break;
            case 'run':
                $result = $this->recalc_run();

                $response = array(
                    'message' => '- '.$result
                );

                die(json_encode($response));
                break;
        }
    }

    public function recalc_run() {
        $total = intval($_POST['total']);
        $current = intval($_POST['current']);
        $step = intval($_POST['step']);
        $offset = $current * $step;

        $settings = array();
        $raw = (array)$_POST['settings'];

        foreach ($raw as $operation) {
            $o = explode('|', $operation);

            if (gdrts_is_method_valid($o[0])) {
                if (!isset($settings[$o[0]])) {
                    $settings[$o[0]] = array();
                }

                $settings[$o[0]][] = $o[1];
            }
        }

        $result = gdrts_admin_maintenance::recalculate_rating_objects($offset, $step, $settings);

        $done = ($current + 1) * $step;

        if ($done > $total) {
            $done = $total;
        }

        $render = sprintf(__("%s of %s rating objects recalculated.", "gd-rating-system"), $done, $total);

        return $render;
    }
}

global $_gdrts_admin_ajax;

$_gdrts_admin_ajax = new gdrts_admin_ajax();

function gdrts_ajax_admin() {
    global $_gdrts_admin_ajax;
    return $_gdrts_admin_ajax;
}
