<?php

/*
Name:    d4pLib_Class_Freegeoip_GeoIP
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

if (!class_exists('d4p_freegeoip_geoip')) {
    class d4p_freegeoip_geoip {
        public $_active = true;
        public $_localhost = false;
        public $_error = '';

        public $_url = 'http://freegeoip.net/json/';
        public $_ip = '';
        public $_expire = 14;

        public $_cache_hit = false;

        public $_data = array();

        public function __construct($ip, $expire = 14) {
            $this->_ip = $ip;
            $this->_expire = intval($expire);

            if (in_array($ip, array('127.0.0.1', '::1'))) {
                $this->_active = false;
                $this->_localhost = true;
                $this->_error = __("Localhost IP's can't be geolocated.", "d4plib");
            } else {
                $this->init();
            }
        }

        public function __get($name) {
            if (isset($this->_data->$name)) {
                return $this->_data->$name;
            } else {
                return '';
            }
        }

        public function active() {
            return $this->_active;
        }

        public function error() {
            if (!$this->_active) {
                return $this->_error;
            } else {
                return false;
            }
        }

        public function location() {
            $location = '';

            if ($this->active()) {
                if (isset($this->_data->country)) {
                    $location.= $this->_data->country;
                }

                if (isset($this->_data->city)) {
                    $location.= ', '.$this->_data->city;
                }
            }

            return $location;
        }

        public static function instance($ip = '', $expire = 14) {
            static $freegeoip_ips = array();

            if ($ip == '') {
                $ip = d4p_visitor_ip();
            }

            if (!isset($freegeoip_ips[$ip])) {
                $freegeoip_ips[$ip] = new d4p_freegeoip_geoip($ip, $expire);
            }

            return $freegeoip_ips[$ip];
        }

        private function init() {
            $get = false;

            $key = 'd4pfg_'.$this->_ip;

            if ($this->_expire > 0) {
                $code = get_site_transient($key);

                if ($code === false || is_null($code) || empty($code)) {
                    $get = true;
                } else {
                    $this->_cache_hit = true;
                }
            } else {
                $get = true;
            }

            if ($get) {
                $url = $this->_url.$this->_ip;
                $code = wp_remote_get($url);

                if (!is_wp_error($code)) {
                    $this->_data = json_decode($code['body']);

                    if ($this->_expire > 0) {
                        set_site_transient($key, $this->_data, $this->_expire * DAY_IN_SECONDS);
                    }
                }
            } else {
                $this->_data = $code;
            }
        }

        public function flag($not_found = 'image') {
            if ($this->_active) {
                if ($this->country_code != '') {
                    $info = ucwords(strtolower($this->country_name));
                    if ($this->city != '') {
                        $info.= ', '.$this->city;
                    }

                    return '<img src="'.D4PLIB_URL.'resources/flags/blank.gif" class="flag flag-'.strtolower($this->country_code).'" title="'.$info.'" alt="" />';
                }
            } else if ($this->_localhost) {
                return '<img src="'.D4PLIB_URL.'resources/flags/blank.gif" class="flag flag-localhost" title="'.__("Localhost", "d4plib").'" alt="" />';
            }

            if ($not_found == 'image') {
                return '<img src="'.D4PLIB_URL.'resources/flags/blank.gif" class="flag" title="'.__("IP can't be geolocated.", "d4plib").'" alt="" />';
            } else if ($not_found == 'space') {
                return '';
            }
        }
    }
}

if (!function_exists('d4p_geoip')) {
    function d4p_geoip($ip = '', $expire = 14) {
        return d4p_freegeoip_geoip::instance($ip, $expire);
    }
}
