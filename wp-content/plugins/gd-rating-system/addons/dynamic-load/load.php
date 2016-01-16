<?php

if (!defined('ABSPATH')) exit;

class gdrts_addon_dynamic_load extends gdrts_addon {
    public $prefix = 'dynamic-load';

    public $_loop_args;
    public $_loop_method;

    public function __construct() {
        parent::__construct();

        add_filter('gdrts_single_block_render_defaults', array(&$this, 'default_args'), 1);
        add_filter('gdrts_engine_single_rendering_override', array(&$this, 'render_override'), 10, 3);
        add_filter('gdrts_ajax_live_handler', array(&$this, 'live_handler'), 10, 2);
    }

    public function live_handler($process, $request) {
        if ($request->todo == 'dynamic') {
            $request->meta->args->echo = false;
            $request->meta->args->dynamic = false;

            gdrts_single()->do_suppress_filters();

            $render = gdrts_single()->render((array)$request->meta->args, (array)$request->meta->method);

            $result = array(
                'status' => 'ok',
                'render' => $render,
                'did' => $request->did
            );

            gdrts_ajax()->respond(json_encode($result));
        }

        return $process;
    }

    public function default_args($defaults) {
        $defaults['dynamic'] = true;

        return $defaults;
    }

    public function render_override($render = false, $args = array(), $method = array()) {
        if (isset($args['dynamic']) && $args['dynamic'] && isset($args['method']) && $args['method'] != 'stars-review') {
            $this->_loop_args = $args;
            $this->_loop_method = $method;

            $render = gdrts_return_template(array('gdrts--dynamic-load--single--default.php'));
        }

        return $render;
    }

    public function json() {
        $data = array(
            'args' => $this->_loop_args,
            'method' => $this->_loop_method
        );

        echo '<script class="gdrts-rating-data" type="application/json">';
        echo json_encode($data);
        echo '</script>';
    }

    public function _load_admin() {
        require_once(GDRTS_PATH.'addons/dynamic-load/admin.php');
    }
}

global $_gdrts_addon_dynamic_load;
$_gdrts_addon_dynamic_load = new gdrts_addon_dynamic_load();

function gdrtsa_dynamic_load() {
    global $_gdrts_addon_dynamic_load;
    return $_gdrts_addon_dynamic_load;
}
