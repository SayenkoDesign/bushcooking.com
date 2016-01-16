<?php

if (!defined('ABSPATH')) exit;

class gdrts_core {
    private $_embed_loaded = false;

    private $_cache;

    public $font = array();

    public $addons = array();
    public $methods = array();

    public $loaded = array();

    public $entities = array(
        'posts' => array('label' => 'Post Types', 'types' => array(), 'icon' => 'file-text-o'),
        'terms' => array('label' => 'Terms', 'types' => array(), 'icon' => 'tags'),
        'comments' => array('label' => 'Comments', 'types' => array(), 'icon' => 'comments-o'),
        'users' => array('label' => 'Users', 'types' => array(), 'icon' => 'users'),
        'custom' => array('label' => 'Custom', 'types' => array(), 'icon' => 'asterisk')
    );

    public function __construct() {
        require_once(GDRTS_PATH.'rating/base.functions.php');
        require_once(GDRTS_PATH.'rating/base.expanded.php');
        require_once(GDRTS_PATH.'rating/core.item.php');
        require_once(GDRTS_PATH.'rating/core.user.php');
        require_once(GDRTS_PATH.'rating/core.cache.php');

        $this->_cache = new gdrts_core_cache();

        add_action('gdrts_load', array(&$this, 'prepare'));

        add_action('wp', array(&$this, 'ready'));
    }

    public function _types_registration() {
        do_action('gdrts_register_entities');

        global $wp_post_types, $wp_taxonomies;

        foreach ($wp_post_types as $post_type) {
            if ($post_type->public) {
                $this->entities['posts']['types'][$post_type->name] = $post_type->label;
            }
        }

        foreach ($wp_taxonomies as $taxonomy) {
            if ($taxonomy->public) {
                $this->entities['terms']['types'][$taxonomy->name] = $taxonomy->label;
            }
        }

        $this->entities['comments']['types']['comment'] = 'Comments';
        $this->entities['users']['types']['user'] = 'Users';
        $this->entities['custom']['types']['free'] = 'Free';

        do_action('gdrts_register_types');
    }

    public function _extensions_registration() {
        do_action('gdrts_register_methods_and_addons');

        foreach ($this->addons as $addon => $obj) {
            gdrts_settings()->register('load', 'addon_'.$addon, $obj['autoload']);
        }

        foreach ($this->methods as $method => $obj) {
            gdrts_settings()->register('load', 'method_'.$method, $obj['autoload']);
        }
    }

    public function db() {
        return gdrts_db();
    }

    public function cache() {
        return $this->_cache;
    }

    public function settings() {
        return gdrts_settings();
    }

    public function register_item_option($entity, $name, $option, $value) {
        gdrts_settings()->register('items', $entity.'_'.$name.'_'.$option, $value);
    }

    public function prepare() {
        $this->_types_registration();
        $this->_extensions_registration();

        do_action('gdrts_load_settings');

        $load = gdrts_settings()->group_get('load');

        foreach ($load as $key => $do) {
            if ($do) {
                $this->loaded[] = $key;

                do_action('gdrts_load_'.$key);
            }
        }

        do_action('gdrts_populate_settings');

        $this->font = gdrts_font_icon_characters();

        do_action('gdrts_plugin_rating_ready');
    }

    public function ready() {
        do_action('gdrts_ready');

        if ($this->is_locked()) {
            add_action('gdrts-template-rating-block-after', array(&$this, 'show_disabled_message'));
        }
    }

    public function show_disabled_message() {
        echo '<div class="gdrts-voting-disabled">';

        if (gdrts_settings()->get('maintenance')) {
            echo gdrts_settings()->get('maintenance_message');
        } else if (gdrts_settings()->get('voting_disabled')) {
            echo gdrts_settings()->get('voting_disabled_message');
        }

        echo '</div>';
    }

    public function cookie_key() {
        return apply_filters('gdrts_cookie_key', 'wp-gdrts-log');
    }

    public function cookie_expiration($time = null) {
        if (is_null($time)) {
            $time = apply_filters('gdrts_cookie_expiration', YEAR_IN_SECONDS);
        }

        return time() + $time;
    }

    public function is_locked() {
        return gdrts_settings()->get('voting_disabled') || gdrts_settings()->get('maintenance');
    }

    public function load_embed() {
        if (!$this->_embed_loaded) {
            require_once(GDRTS_PATH.'rating/base.embed.php');

            $this->_embed_loaded = true;
        }
    }
}
