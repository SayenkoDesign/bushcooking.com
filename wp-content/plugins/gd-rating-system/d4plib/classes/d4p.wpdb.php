<?php

/*
Name:    d4pLib_Class_WPDB
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

if (!class_exists('d4p_wpdb')) {
    abstract class d4p_wpdb {
        public $_prefix = '';
        public $_tables = array();
        public $_metas = array();

        protected $_meta_translate = array();

        public function __construct() {
            global $wpdb;

            $plugin = new stdClass();
            $this->db = new stdClass();

            foreach ($this->_tables as $name) {
                $wpdb_name = $this->_prefix.'_'.$name;
                $real_name = $wpdb->prefix.$wpdb_name;

                $plugin->$name = $real_name;
                $this->db->$name = $real_name;

                $wpdb->$wpdb_name = $real_name;
            }

            $wpdb->{$this->_prefix} = $plugin;

            if (!empty($this->_prefix) && !empty($this->_metas)) {
                foreach ($this->_metas as $key => $id) {
                    $this->_meta_translate[$this->_prefix.'_'.$key.'_id'] = $id;
                }

                add_filter('sanitize_key', array(&$this, 'sanitize_meta'));
            }
        }

        public function __get($name) {
            if (isset($this->db->$name)) {
                return $this->db->$name;
            } else if (isset($this->wpdb()->$name)) {
                return $this->wpdb()->$name;
            }
        }

        public function sanitize_meta($key) {
            if (isset($this->_meta_translate[$key])) {
                return $this->_meta_translate[$key];
            }

            return $key;
        }

        public function timestamp($gmt = true) {
            return current_time('timestamp', $gmt);
        }

        public function datetime($gmt = true) {
            return current_time('mysql', $gmt);
        }

        public function get_insert_id() {
            return $this->wpdb()->insert_id;
        }

        public function query($query) {
            return $this->wpdb()->query($query);
        }

        public function found_rows() {
            return $this->get_var('SELECT FOUND_ROWS()');
        }

        public function run($query = null, $output = OBJECT) {
            return $this->wpdb()->get_results($query, $output);
        }

        public function run_and_index($query, $field, $output = OBJECT) {
            $raw = $this->wpdb()->get_results($query, $output);

            return $this->index($raw, $field);
        }

        public function get_var($query, $x = 0, $y = 0) {
            return $this->wpdb()->get_var($query, $x, $y);
        }

        public function get_row($query = null, $output = OBJECT, $y = 0) {
            return $this->wpdb()->get_row($query, $output, $y);
        }

        public function get_col($query = null , $x = 0) {
            return $this->wpdb()->get_col($query, $x);
        }

        public function get_results($query = null, $output = OBJECT) {
            return $this->wpdb()->get_results($query, $output);
        }

        public function insert($table, $data, $format = null) {
            return $this->wpdb()->insert($table, $data, $format);
        }

        public function update($table, $data, $where, $format = null, $where_format = null) {
            return $this->wpdb()->update($table, $data, $where, $format, $where_format);
        }

        public function delete($table, $where, $where_format = null) {
            return $this->wpdb()->delete($table, $where, $where_format);
        }

        public function prepare($query, $args) {
            return $this->wpdb()->prepare($query, $args);
        }

        public function insert_meta_data($table, $column, $id, $meta) {
            foreach ($meta as $key => $value) {
                $this->insert($table, array(
                    $column => $id,
                    'meta_key' => $key,
                    'meta_value' => $value
                ));
            }
        }

        public function update_meta($meta_type, $object_id, $meta_key, $meta_value, $prev_value = '') {
            return update_metadata($this->_prefix.'_'.$meta_type, $object_id, $meta_key, $meta_value, $prev_value);
        }

        public function add_meta($meta_type, $object_id, $meta_key, $meta_value, $unique = false) {
            return add_metadata($this->_prefix.'_'.$meta_type, $object_id, $meta_key, $meta_value, $unique);
        }

        public function get_meta($meta_type, $object_id, $meta_key, $single = false) {
            return get_metadata($this->_prefix.'_'.$meta_type, $object_id, $meta_key, $single);
        }

        public function delete_meta($meta_type, $object_id, $meta_key, $delete_all = false) {
            return delete_metadata($this->_prefix.'_'.$meta_type, $object_id, $meta_key, $delete_all);
        }

        public function pluck($list, $field, $index_key = null) {
            return wp_list_pluck($list, $field, $index_key);
        }

        public function index($list, $field) {
            $new = array();

            foreach ($list as $item) {
                $id = is_array($item) ? $item[$field] : $item->$field;

                $new[$id] = $item;
            }

            return $new;
        }

        public function wpdb() {
            global $wpdb;

            return $wpdb;
        }
    }
}
