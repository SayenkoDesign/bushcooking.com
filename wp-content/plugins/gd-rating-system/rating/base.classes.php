<?php

if (!defined('ABSPATH')) exit;

abstract class gdrts_extension_init {
    public $group = '';
    public $prefix = '';

    public function __construct() {
        add_action('gdrts_plugin_settings_init', array(&$this, 'settings'));
        add_action('gdrts_register_methods_and_addons', array(&$this, 'register'));
        add_action('gdrts_admin_ajax', array(&$this, 'ajax'));
    }

    public function ajax() {}

    public function key($name, $prekey = '') {
        $prekey = empty($prekey) ? $this->prefix : $prekey;

        return $prekey.'_'.$name;
    }

    public function register_option($name, $value) {
        gdrts_settings()->register($this->group, $this->key($name), $value);
    }

    abstract public function settings();
    abstract public function register();

    abstract public function load();
}

abstract class gdrts_extension {
    public $group = '';

    public $prefix = '';
    public $settings = array();
    public $settings_rule = array();

    public $query = array();

    public function __construct() {
        add_action('gdrts_admin_load_modules', array(&$this, '_load_admin'));

        add_action('gdrts_populate_settings', array(&$this, '_load_settings'));

        add_action('gdrts_init', array(&$this, 'init'));
        add_action('gdrts_core', array(&$this, 'core'));
    }

    public function init() {
        
    }

    public function core() {
        
    }

    public function _load_settings() {
        $this->settings = gdrts_settings()->prefix_get($this->prefix.'_', $this->group);
    }

    public function _load_settings_rule($entity = null, $name = null) {
        $entity = is_null($entity) ? gdrts_single()->loop_arg('entity') : $entity;
        $name = is_null($name) ? gdrts_single()->loop_arg('name') : $name;

        $rule_entity = $entity.'_'.$this->prefix.'_';
        $rule_item = $entity.'.'.$name.'_'.$this->prefix.'_';

        $active = gdrts_settings()->get($rule_item.'rule_active', 'items');

        if ($active === true) {
            $this->settings_rule = gdrts_settings()->items_get($rule_item);
        } else {
            $active = gdrts_settings()->get($rule_entity.'rule_active', 'items');

            if ($active === true) {
                $this->settings_rule = gdrts_settings()->items_get($rule_entity);
            } else {
                $this->settings_rule = $this->settings;
            }
        }
    }

    public function get_rule($name) {
        return $this->settings_rule[$name];
    }

    public function get($name, $prefix = '', $prekey = '') {
        if ($prefix != '' && $prekey != '') {
            $override = gdrts_settings()->get($prekey.'_'.$name, $prefix);

            if (!is_null($override)) {
                return $override;
            }
        }

        return $this->settings[$name];
    }

    public function key($name, $prekey = '') {
        $prekey = empty($prekey) ? $this->prefix : $prekey;

        return $prekey.'_'.$name;
    }

    abstract public function _load_admin();
}

abstract class gdrts_addon extends gdrts_extension {
    public $group = 'addons';

    public function __construct() {
        parent::__construct();
    }
}

abstract class gdrts_method extends gdrts_extension {
    public $group = 'methods';

    protected $_user = null;
    protected $_render = null;
    protected $_args = array();
    protected $_calc = array();
    protected $_engine = '';

    public function __construct() {
        parent::__construct();

        add_filter('gdrts_loop_single_json_data', array(&$this, 'json_single'), 10, 2);
        add_filter('gdrts_loop_list_json_data', array(&$this, 'json_list'), 10, 2);
        add_filter('gdrts_query_has_votes_'.$this->prefix, array(&$this, 'implements_votes'));
    }

    public function reset_loop() {
        $this->_args = array();
        $this->_calc = array();
    }

    public function method() {
        return $this->prefix;
    }

    public function loop() {
        return $this;
    }

    public function user() {
        return $this->_user;
    }

    public function render() {
        return $this->_render;
    }

    public function args($name) {
        return isset($this->_args[$name]) ? $this->_args[$name] : false;
    }

    public function calc($name) {
        return isset($this->_calc[$name]) ? $this->_calc[$name] : false;
    }

    public function value($name, $echo = true) {
        $value = '';

        if (isset($this->_calc[$name])) {
            $value = $this->_calc[$name];
        }

        if ($echo) {
            echo $value;
        } else {
            return $value;
        }
    }

    abstract public function implements_votes($votes = false);

    abstract public function prepare_loop_list($method, $args = array());
    abstract public function prepare_loop_single($method, $args = array());

    abstract public function json_single($data, $method);
    abstract public function json_list($data, $method);
    abstract public function templates_single($item);
    abstract public function templates_list($entity, $name);

    abstract public function validate_vote($meta, $item, $user);
    abstract public function vote($meta, $item, $user);

    public function please_wait($text = null, $icon = null, $echo = true) {
        $text = is_null($text) ? __("Please wait...", "gd-rating-system") : $text;
        $icon = is_null($icon) ? '<i class="fa fa-spinner fa-spin"></i>' : $icon;

        $render = '<div class="gdrts-rating-please-wait">';
        $render.= $icon.$text;
        $render.= '</div>';

        if ($echo) {
            echo $render;
        } else {
            return $render;
        }
    }
}

abstract class gdrts_method_render {
    public function __construct() { }

    abstract public function owner();
}

abstract class gdrts_method_user {
    public $method = '';
    public $user = null;
    public $item = 0;

    public $super_admin = true;
    public $user_roles = true;
    public $visitor = true;

    public function __construct($super_admin, $user_role, $visitor) {
        $this->super_admin = $super_admin;
        $this->user_roles = $user_role;
        $this->visitor = $visitor;

        $this->user = gdrts_single()->user();
        $this->item = gdrts_single()->item()->item_id;
    }

    public function is_allowed() {
        if (is_super_admin()) {
            return $this->super_admin;
        } else if (is_user_logged_in()) {
            $allowed = $this->user_roles;

            if ($allowed === true || is_null($allowed)) {
                return true;
            } else if (is_array($allowed) && empty($allowed)) {
                return false;
            } else if (is_array($allowed) && !empty($allowed)) {
                global $current_user;

                if (is_array($current_user->roles)) {
                    $matched = array_intersect($current_user->roles, $allowed);

                    return !empty($matched);
                }
            }
        } else {
            return $this->visitor;
        }
    }

    public function log() {
        if (isset($this->user->log[$this->item][$this->method])) {
            return $this->user->log[$this->item][$this->method];
        }
    }
}

abstract class gdrts_item_data {
    public $object = null;

    public $entity;
    public $name;
    public $id;

    public function __construct($entity, $name, $id) {
        $this->entity = $entity;
        $this->name = $name;
        $this->id = $id;
    }

    public function __get($name) {
        if (isset($this->object->$name)) {
            return $this->object->$name;
        } else {
            return null;
        }
    }

    public function is_valid() {
        return !is_null($this->object);
    }

    abstract public function get_title();
    abstract public function get_url();
}
