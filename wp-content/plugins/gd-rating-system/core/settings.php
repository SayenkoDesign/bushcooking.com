<?php

if (!defined('ABSPATH')) exit;

class gdrts_core_settings {
    public $_filter_base = 'gdrts';

    public $info;
    public $current = array();
    public $settings = array(
        'core' => array(
            'activated' => 0
        ),
        'load' => array(
            
        ),
        'settings' => array(
            'voting_disabled' => false,
            'voting_disabled_message' => 'Voting is currently disabled.',
            'maintenance' => false,
            'maintenance_message' => 'Voting is currently disabled, data maintenance in progress.',
            'use_nonce' => true,
            'annonymous_same_ip' => false,
            'annonymous_verify' => 'ip_or_cookie',
            'ajax_header_no_cache' => true,
            'decimal_round' => 1,
            'admin_log_remove' => false,
            'log_vote_user_agent' => false
        ),
        'templates' => array(
            
        ),
        'items' => array(
            
        ),
        'methods' => array(
            
        ),
        'addons' => array(
            
        )
    );

    public function __construct() {
        $this->info = new gdrts_core_info();

        add_action('gdrts_load_settings', array(&$this, 'init'));
    }

    public function __get($name) {
        $get = explode('_', $name, 2);

        return $this->get($get[1], $get[0]);
    }

    protected function _db() {
        require_once(GDRTS_PATH.'core/admin/install.php');

        gdrts_install_database();
    }
    
    protected function _name($name) {
        return 'dev4press_'.$this->info->code.'_'.$name;
    }

    protected function _install() {
        $this->current = $this->_merge();
        $this->current['info'] = $this->info->to_array();
        $this->current['info']['install'] = true;
        $this->current['info']['update'] = false;

        foreach ($this->current as $key => $data) {
            update_option($this->_name($key), $data);
        }

        $this->_db();
    }

    protected function _update() {
        $old_build = $this->current['info']['build'];

        $this->current['info'] = $this->info->to_array();
        $this->current['info']['install'] = false;
        $this->current['info']['update'] = true;
        $this->current['info']['previous'] = $old_build;

        update_option($this->_name('info'), $this->current['info']);

        $settings = $this->_merge();

        foreach ($settings as $key => $data) {
            if ($key == 'items') {
                continue;
            }

            $now = get_option($this->_name($key));

            if (!is_array($now)) {
                $now = $data;
            } else {
                $now = $this->_upgrade($now, $data);
            }

            $this->current[$key] = $now;

            update_option($this->_name($key), $now);
        }

        $this->_db();
    }

    protected function _upgrade($old, $new) {
        foreach ($new as $key => $value) {
            if (!isset($old[$key])) {
                $old[$key] = $value;
            }
        }

        $unset = array();
        foreach ($old as $key => $value) {
            if (!isset($new[$key])) {
                $unset[] = $key;
            }
        }

        if (!empty($unset)) {
            foreach ($unset as $key) {
                unset($old[$key]);
            }
        }

        return $old;
    }

    protected function _groups() {
        return array_keys($this->settings);
    }

    protected function _merge() {
        $merged = array();

        foreach ($this->settings as $key => $data) {
            $merged[$key] = array();

            foreach ($data as $name => $value) {
                $merged[$key][$name] = $value;
            }
        }

        return $merged;
    }

    public function init() {
        $this->current['info'] = get_option($this->_name('info'));

        do_action('gdrts_plugin_settings_init');

        $installed = is_array($this->current['info']) && isset($this->current['info']['build']);

        if (!$installed) {
            $this->_install();
        } else {
            $update = $this->current['info']['build'] != $this->info->build;

            if ($update) {
                $this->_update();
            } else {
                $groups = $this->_groups();

                foreach ($groups as $key) {
                    $this->current[$key] = get_option($this->_name($key));

                    if (!is_array($this->current[$key])) {
                        $data = $this->group($key);

                        if (!is_null($data)) {
                            $this->current[$key] = $data;

                            update_option($this->_name($key), $data);
                        }
                    }
                }
            }
        }

        do_action('gdrts_plugin_settings_loaded');
    }

    public function group($group) {
        if (isset($this->settings[$group])) {
            return $this->settings[$group];
        } else {
            return null;
        }
    }

    public function exists($name, $group = 'settings') {
        if (isset($this->current[$group][$name])) {
            return true;
        } else if (isset($this->settings[$group][$name])) {
            return true;
        } else {
            return false;
        }
    }

    public function items_get($prefix) {
        $results = array();

        foreach ($this->current['items'] as $key => $value) {
            if (substr($key, 0, strlen($prefix)) == $prefix) {
                $results[substr($key, strlen($prefix))] = $value;
            }
        }

        return $results;
    }

    public function prefix_get($prefix, $group = 'settings') {
        $settings = array_keys($this->group($group));

        $results = array();

        foreach ($settings as $key) {
            if (substr($key, 0, strlen($prefix)) == $prefix) {
                $results[substr($key, strlen($prefix))] = $this->get($key, $group);
            }
        }

        return $results;
    }

    public function group_get($group) {
        return $this->current[$group];
    }

    public function register($group, $name, $value) {
        $this->settings[$group][$name] = $value;
    }

    public function get($name, $group = 'settings') {
        $exit = null;

        if (isset($this->current[$group][$name])) {
            $exit = $this->current[$group][$name];
        } else if (isset($this->settings[$group][$name])) {
            $exit = $this->settings[$group][$name];
        }

        return apply_filters('gdrts_settings_get', $exit, $name, $group);
    }

    public function set($name, $value, $group = 'settings', $save = false) {
        $this->current[$group][$name] = $value;

        if ($save) {
            $this->save($group);
        }
    }

    public function save($group) {
        update_option($this->_name($group), $this->current[$group]);
    }

    public function is_install() {
        return $this->get('install', 'info');
    }

    public function is_update() {
        return $this->get('update', 'info');
    }

    public function mark_for_update() {
        $this->current['info']['update'] = true;

        update_option($this->_name('info'), $this->current['info']);
    }

    public function remove_by_prefix($prefix, $group, $save = true) {
        $keys = array_keys($this->current[$group]);

        foreach ($keys as $key) {
            if (substr($key, 0, strlen($prefix)) == $prefix) {
                unset($this->current[$group][$key]);
            }
        }

        if ($save) {
            $this->save($group);
        }
    }

    public function remove_plugin_settings() {
        delete_option($this->_name('info'));

        foreach ($this->_groups() as $group) {
            delete_option($this->_name($group));
        }
    }

    public function import_from_object($import, $list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        foreach ($import as $key => $data) {
            if (in_array($key, $list)) {
                $this->current[$key] = (array)$data;

                $this->save($key);
            }
        }
    }

    public function serialized_export($list = array()) {
        if (empty($list)) {
            $list = $this->_groups();
        }

        $data = new stdClass();
        $data->info = $this->current['info'];

        foreach ($list as $name) {
            $data->$name = $this->current[$name];
        }

        return serialize($data);
    }
}
