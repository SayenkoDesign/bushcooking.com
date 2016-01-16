<?php

/*
Name:    d4pLib_Widget
Version: v1.5.6
Author:  Milan Petrovic
Email:   milan@gdragon.info
Website: https://www.dev4press.com/libs/d4plib/

== Copyright ==
Copyright 2008 - 2015 Milan Petrovic (email: milan@gdragon.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('d4pLib_Widget')) {
    /**
     * Base widget class expanding default WordPress class.
     */
    class d4pLib_Widget extends WP_Widget {
        public $widget_domain = 'dev4press_widgets';

        public $cache_key = '';
        public $cache_prefix = 'd4p_wdg';
        public $cache_method = 'disabled'; // full, results
        public $cache_active = false;
        public $cache_time = 0;

        public $widget_name = 'Dev4Press: Base Widget Class';
        public $widget_description = 'Information about the widget';
        public $widget_base = 'dev4press_widget';
        public $widget_id;

        public $defaults = array(
            'title' => 'Base Widget Class',
            '_display' => 'all',
            '_cached' => 0,
            '_hook' => '',
            '_class' => ''
        );

        public function __construct($id_base = false, $name = '', $widget_options = array(), $control_options = array()) {
            $widget_options = empty($widget_options) ? array('classname' => 'cls_'.$this->widget_base, 'description' => $this->widget_description) : $widget_options;
            $control_options = empty($control_options) ? array() : $control_options;

            parent::__construct($this->widget_base, $this->widget_name, $widget_options, $control_options);
        }

        private function _visible($instance) {
            $visible = $this->is_visible($instance);

            if ($visible && isset($instance['_display'])) {
                $logged = is_user_logged_in();

                $role = substr($instance['_display'], 0, 5) == 'role:' ? substr($instance['_display'], 5) : false;
                $cap = substr($instance['_display'], 0, 4) == 'cap:' ? substr($instance['_display'], 4) : false;

                if ($role === false && $cap === false) {
                    if ($instance['_display'] == 'all' || ($instance['_display'] == 'user' && $logged) || ($instance['_display'] == 'visitor' && !$logged)) {
                        $visible = true;
                    } else {
                        $visible = false;
                    }
                } else if ($role === false) {
                    $visible = current_user_can($cap);
                } else {
                    $visible = d4p_is_current_user_roles($role);
                }
            }

            if (isset($instance['_hook']) && $instance['_hook'] != '') {
                $visible = apply_filters($this->widget_base.'_visible_'.$instance['_hook'], $visible, $this);
            }

            return $visible;
        }

        private function _widget_id($args) {
            $this->widget_id = str_replace(array('-', '_'), array('', ''), $args['widget_id']);
        }

        private function _cache_key($instance) {
            $this->cache_active = $this->_cache_active($instance);

            if ($this->cache_active) {
                $copy = $instance;
                unset($copy['_cached']);

                $this->cache_key = $this->cache_prefix.'_'.md5($this->widget_base.'_'.serialize($copy));
            }
        }

        private function _cache_active($instance) {
            $this->cache_time = isset($instance['_cached']) ? intval($instance['_cached']) : 0;

            return $this->cache_time > 0;
        }

        private function _cached_data($instance) {
            if ($this->cache_method == 'data' && $this->cache_active && $this->cache_key !== '') {
                $results = get_transient($this->cache_key);

                if ($results === false) {
                    $results = $this->results($instance);
                    set_transient($this->cache_key, $results, $this->cache_time * 3600);
                }

                return $results;
            } else {
                return $this->results($instance);
            }
        }

        function get_defaults() {
            return $this->defaults;
        }

        public function widget($args, $instance) {
            $this->_widget_id($args);
            $this->_cache_key($instance);

            $this->init();

            if ($this->_visible($instance)) {
                $render = '';

                if ($this->cache_method == 'full' && $this->cache_active && $this->cache_key !== '') {
                    $render = get_transient($this->cache_key);

                    if ($render === false) {
                        $render = $this->widget_output($args, $instance);
                        set_transient($this->cache_key, $render, $this->cache_time * 3600);
                    } else {
                        if (D4P_DEBUG) {
                            $render.= '<!-- from cache -->';
                        }
                    }
                } else {
                    $render = $this->widget_output($args, $instance);
                }

                echo $render;
            }
        }

        public function widget_output($args, $instance) {
            extract($args, EXTR_SKIP);

            ob_start();

            $results = $this->_cached_data($instance);
            echo $before_widget;

            if (isset($instance['title']) && $instance['title'] != '') {
                echo $before_title;
                echo $this->title($instance);
                echo $after_title;
            }

            echo $this->render($results, $instance);
            echo $after_widget;

            $render = ob_get_contents();
            ob_end_clean();

            return $render;
        }

        public function title($instance) {
            return $instance['title'];
        }

        public function is_visible($instance) {
            return true;
        }

        public function form($instance) {
            $instance = wp_parse_args((array)$instance, $this->defaults);
        }

        public function update($new_instance, $old_instance) {
            $instance = $old_instance;

            $instance['title'] = strip_tags(stripslashes($new_instance['title']));

            return $instance;
        }

        public function simple_render($instance = array()) {
            $instance = shortcode_atts($this->defaults, $instance);

            $results = $this->results($instance);

            return $this->render($results, $instance);
        }

        public function init() { }
        
        public function prepare($instance, $results) { return $results; }

        public function results($instance) { return null; }

        public function render($results, $instance) { return $results; }
    }
}
