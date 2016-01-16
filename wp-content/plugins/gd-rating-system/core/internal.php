<?php

if (!defined('ABSPATH')) exit;

class gdrts_admin_settings {
    private $settings;

    function __construct() {
        $this->init();
    }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    private function init() {
        $extensions = array(
            'extensions_methods' => array('name' => __("Rating Methods", "gd-rating-system"), 'settings' => array()),
            'extensions_addons' => array('name' => __("Addons", "gd-rating-system"), 'settings' => array()),
            'extensions_pro' => array('name' => "More rating methods and addons", 'settings' => array(
                new d4pSettingElement('', '', 'GD Rating System Pro', 'You can upgrade to GD Rating System Pro <a target="_blank" href="https://rating.dev4press.com/">here</a>. <p style="font-weight: normal; margin: 10px 0 0;">To learn more about the features available in Pro version only, check out this <a target="_blank" href="https://rating.dev4press.com/free-vs-pro-plugin/">FREE vs. PRO</a> comparison.</p>', d4pSettingType::INFO)
            )),
        );

        foreach (gdrts()->methods as $method => $obj) {
            $info = apply_filters('gdrts_info_method_'.$method, array('icon' => '', 'description' => ''));
            $label = ($info['icon'] != '' ? '<i class="fa fa-'.$info['icon'].' fa-fw"></i> ' : '').$obj['label'];

            $extensions['extensions_methods']['settings'][] =
                    new d4pSettingElement('load', 'method_'.$method, $label, $info['description'], d4pSettingType::BOOLEAN, gdrts_settings()->get('method_'.$method, 'load'));
        }

        foreach (gdrts()->addons as $addon => $obj) {
            $info = apply_filters('gdrts_info_addon_'.$addon, array('icon' => '', 'description' => ''));
            $label = ($info['icon'] != '' ? '<i class="fa fa-'.$info['icon'].' fa-fw"></i> ' : '').$obj['label'];

            $extensions['extensions_addons']['settings'][] =
                    new d4pSettingElement('load', 'addon_'.$addon, $label, $info['description'], d4pSettingType::BOOLEAN, gdrts_settings()->get('addon_'.$addon, 'load'));
        }

        $this->settings = apply_filters('gdrts_admin_internal_settings', array(
            'extensions' => $extensions,
            'global' => array(
                'global_security' => array('name' => __("Security", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'use_nonce', __("Use Nonce Protection", "gd-rating-system"), __("Each AJAX rating request will be protected by Nonce for additional security. But, if you use cache plugins, Nonce check will fail if the cached pages are too old.", "gd-rating-system"), d4pSettingType::BOOLEAN, gdrts_settings()->get('use_nonce'))
                )),
                'global_log' => array('name' => __("Votes Log", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'log_vote_user_agent', __("Save User Agent", "gd-rating-system"), __("User agent string can take a lot of space in the database, and they represent user browser or application used to vote.", "gd-rating-system"), d4pSettingType::BOOLEAN, gdrts_settings()->get('log_vote_user_agent'))
                )),
                'global_anonymous' => array('name' => __("Anonymous Ratings", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'annonymous_verify', __("Verification", "gd-rating-system"), __("If the user voting is visitor (not logged in), there are different methods to verify if visitor can vote.", "gd-rating-system"), d4pSettingType::SELECT, gdrts_settings()->get('annonymous_verify'), 'array', $this->data_list_annonymous_verify()),
                    new d4pSettingElement('settings', 'annonymous_same_ip', __("IP Validation", "gd-rating-system"), __("If logged user and visitor (not logged in) share IP, this option determines if visitor can vote.", "gd-rating-system"), d4pSettingType::BOOLEAN, gdrts_settings()->get('annonymous_same_ip'), null, array(), array('label' => __("Allow visitor to have same IP as logged user", "gd-rating-system")))
                )),
                'global_ajax' => array('name' => __("AJAX Requests", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'ajax_header_no_cache', __("Set no cache header", "gd-rating-system"), '', d4pSettingType::BOOLEAN, gdrts_settings()->get('ajax_header_no_cache'))
                )),
                'global_calculations' => array('name' => __("Calculations", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'decimal_round', __("Decimal rounding", "gd-rating-system"), '', d4pSettingType::SELECT, gdrts_settings()->get('decimal_round'), 'array', $this->data_list_decimal_points())
                ))
            ),
            'administration' => array(
                'administration_votes' => array('name' => __("Votes Log", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'admin_log_remove', __("Show Remove from Log", "gd-rating-system"), __("Remove from log option is used for raw removal of votes from log, and it doesn't affect the rating object agregated results. If you don't understand how this works, do not use this option.", "gd-rating-system"), d4pSettingType::BOOLEAN, gdrts_settings()->get('admin_log_remove'))
                )),
            ),
            'advanced' => array(
                'advanced_disabled' => array('name' => __("Disable Voting", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'voting_disabled', __("Status", "gd-rating-system"), __("This option will disable all voting.", "gd-rating-system"), d4pSettingType::BOOLEAN, gdrts_settings()->get('voting_disabled'), null, array(), array('label' => __("Disable Voting", "gd-rating-system"))),
                    new d4pSettingElement('settings', 'voting_disabled_message', __("Message", "gd-rating-system"), __("If you want, you can set the message to be displayed with rating blocks if the voting is disabled.", "gd-rating-system"), d4pSettingType::TEXT, gdrts_settings()->get('voting_disabled_message'))
                )),
                'advanced_maintenance' => array('name' => __("Maintenance Mode", "gd-rating-system"), 'settings' => array(
                    new d4pSettingElement('settings', 'maintenance', __("Status", "gd-rating-system"), __("This option will disable all voting.", "gd-rating-system"), d4pSettingType::BOOLEAN, gdrts_settings()->get('maintenance'), null, array(), array('label' => __("Disable Voting", "gd-rating-system"))),
                    new d4pSettingElement('settings', 'maintenance_message', __("Message", "gd-rating-system"), __("If you want, you can set the message to be displayed with rating blocks if the voting is disabled.", "gd-rating-system"), d4pSettingType::TEXT, gdrts_settings()->get('maintenance_message'))
                )),
            )
        ));
    }

    private function data_list_decimal_points() {
        return array(
            1 => __("One decimal", "gd-rating-system"),
            2 => __("Two decimals", "gd-rating-system")
        );
    }

    private function data_list_annonymous_verify() {
        return array(
            'ip_or_cookie' => __("IP or Cookie", "gd-rating-system"),
            'ip_andr_cookie' => __("IP and Cookie", "gd-rating-system"),
            'ip' => __("IP Only", "gd-rating-system"),
            'cookie' => __("Cookie Only", "gd-rating-system")
        );
    }
}
