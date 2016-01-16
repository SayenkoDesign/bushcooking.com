<?php

if (!defined('ABSPATH')) exit;

class gdrts_addon_admin_posts {
    public $prefix = 'posts';

    public function __construct() {
        add_filter('gdrts_admin_settings_panels', array(&$this, 'panels'), 20);
        add_filter('gdrts_admin_internal_settings', array(&$this, 'settings'));
        add_filter('gdrts_admin_icon_posts', array(&$this, 'icon'));

        add_filter('gdrts_admin_metabox_tabs', array(&$this, 'metabox_tabs'));
        add_action('gdrts_admin_metabox_content_posts-integration', array(&$this, 'metabox_content'));
        add_action('gdrts_admin_metabox_save_post', array(&$this, 'metabox_save'));
    }

    public function icon($icon) {
        return 'thumb-tack';
    }

    public function metabox_tabs($tabs) {
        $tabs['posts-integration'] = '<span class="dashicons dashicons-admin-post"></span> '.__("Rating Embed", "gd-rating-system");

        return $tabs;
    }

    public function metabox_content() {
        global $post;

        $item = gdrts_rating_item::get_instance(null, 'posts', $post->post_type, $post->ID);

        $_gdrts_id = $post->ID;
        $_gdrts_display = $item->get('posts-integration_location', 'default');
        $_gdrts_method = $item->get('posts-integration_method', 'default');

        include(GDRTS_PATH.'forms/meta/posts-integration.php');
    }

    public function metabox_save($post) {
        if (isset($_POST['gdrts']['posts-integration'])) {
            $data = $_POST['gdrts']['posts-integration'];

            if (wp_verify_nonce($data['nonce'], 'gdrts-posts-integration-'.$post->ID) !== false) {
                $item = gdrts_rating_item::get_instance(null, 'posts', $post->post_type, $post->ID);

                $display = sanitize_text_field($data['location']);
                $method = sanitize_text_field($data['method']);

                $item->prepare_save();

                if ($display == 'default') {
                    $item->un_set('posts-integration_location');
                } else {
                    $item->set('posts-integration_location', $display);
                }

                if ($method == 'default') {
                    $item->un_set('posts-integration_method');
                } else {
                    $item->set('posts-integration_method', $method);
                }

                $item->save(false);
            }
        }
    }

    public function panels($panels) {
        $panels['addon_posts'] = array(
            'title' => __("Posts", "gd-rating-system"), 'icon' => 'thumb-tack', 'type' => 'addon',
            'info' => __("Settings on this panel are for control over posts integration.", "gd-rating-system"));

        return $panels;
    }

    public function settings($settings) {
        $settings['addon_posts'] = array('ap_embed' => array('name' => __("Auto Embed", "gd-rating-system"), 'settings' => array()));

        foreach (gdrts()->entities['posts']['types'] as $name => $label) {
            $key = $name.'_auto_embed_';

            $settings['addon_posts']['ap_embed']['settings'][] = new d4pSettingElement('', '', $label, '', d4pSettingType::HR);

            $settings['addon_posts']['ap_embed']['settings'][] = new d4pSettingElement('addons', gdrtsa_posts()->key($key.'location'), __("Location", "gd-rating-system"), '', d4pSettingType::SELECT, gdrtsa_posts()->get($key.'location'), 'array', $this->get_list_embed_locations());
            $settings['addon_posts']['ap_embed']['settings'][] = new d4pSettingElement('addons', gdrtsa_posts()->key($key.'method'), __("Method", "gd-rating-system"), '', d4pSettingType::SELECT, gdrtsa_posts()->get($key.'method'), 'array', $this->get_list_embed_methods());
        }

        return $settings;
    }

    public function get_list_embed_locations() {
        return array(
            'top' => __("Top", "gd-rating-system"),
            'bottom' => __("Bottom", "gd-rating-system"),
            'both' => __("Top and Bottom", "gd-rating-system"),
            'hide' => __("Hide", "gd-rating-system")
        );
    }

    public function get_list_embed_methods() {
        $list = array();

        foreach (gdrts()->methods as $key => $data) {
            if ($data['autoembed']) {
                $list[$key] = $data['label'];
            }
        }

        return $list;
    }
}

global $_gdrts_addon_admin_posts;
$_gdrts_addon_admin_posts = new gdrts_addon_admin_posts();

function gdrtsa_admin_posts() {
    global $_gdrts_addon_admin_posts;
    return $_gdrts_addon_admin_posts;
}
