<?php

if (!defined('ABSPATH')) exit;

class gdrts_core_plugin extends d4pCORE {
    public $cap = 'gdrts_standard';

    public $widgets = array(
        'stars-rating-list' => 'gdrtsWidget_stars_rating_list'
    );

    public function core() {
        parent::core();

        define('GDRTS_WPV', intval($this->wp_version));

        add_action('init', array($this, 'rating_load'), 15);
        add_action('init', array($this, 'rating_start'), 20);
    }

    private function file($type, $name, $d4p = false, $min = true) {
        $get = GDRTS_URL;

        if ($d4p) {
            $get.= 'd4plib/resources/';
        }

        if ($name == 'font') {
            $get.= 'font/styles.css';
        } else {
            $get.= $type.'/'.$name;

            if (!$this->is_debug && $type != 'font' && $min) {
                $get.= '.min';
            }

            $get.= '.'.$type;
        }

        return $get;
    }

    public function rating_load() {
        do_action('gdrts_load');

        $this->init_capabilities();
        $this->init_language();

        do_action('gdrts_init');
    }

    public function rating_start() {
        do_action('gdrts_core');
    }

    public function enqueue_scripts() {
        $this->enqueue_core_files();
    }

    public function widgets_init() {
        foreach ($this->widgets as $folder => $widget) {
            require_once(GDRTS_PATH.'widgets/'.$folder.'.php');

            register_widget($widget);
        }
    }

    public function init_capabilities() {
        $role = get_role('administrator');

        if (!is_null($role)) {
            $role->add_cap('gdrts_standard');
        } else {
            $this->cap = 'activate_plugins';
        }

        define('GDRTS_CAP', $this->cap);
    }

    public function init_language() {
        load_plugin_textdomain('gd-rating-system', false, 'gd-rating-system/languages');
    }

    public function enqueue_core_files() {
        wp_enqueue_style('gdrts-font', $this->file('css', 'font'), array(), gdrts_settings()->info_version);
        wp_enqueue_style('gdrts-gridism', $this->file('css', 'gridism', false, false), array(), gdrts_settings()->info_version);
        wp_enqueue_style('gdrts-rating', $this->file('css', 'rating'), array('gdrts-font', 'gdrts-gridism'), gdrts_settings()->info_version);
        wp_enqueue_script('gdrts-rating', $this->file('js', 'rating'), array('jquery'), gdrts_settings()->info_version, true);

        wp_localize_script('gdrts-rating', 'gdrts_rating_data', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('gd-rating-system'),
            'user' => get_current_user_id(),
            'handler' => 'gdrts_live_handler',
            'wp_version' => GDRTS_WPV
        ));
    }
}
