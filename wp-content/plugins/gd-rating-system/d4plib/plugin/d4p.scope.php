<?php

/*
Name:    d4pLib_Class_Plugin
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

if (!class_exists('d4p_scope_core')) {
    abstract class d4p_scope_core {
        private $multisite = false;

        private $admin = false;
        private $network_admin = false;
        private $user_admin = false;
        private $blog_admin = false;

        private $frontend = false;

        private $blog_id = 0;

        function __construct() {
            $this->multisite = is_multisite();
            $this->blog_id = get_current_blog_id();

            if (is_admin()) {
                $this->admin = true;

                if (is_blog_admin()) {
                    $this->blog_admin = true;
                } else if (is_network_admin()) {
                    $this->network_admin = true;
                } else if (is_user_admin()) {
                    $this->user_admin = true;
                }
            } else {
                $this->frontend = true;
            }
        }

        public function is_multisite() {
            return $this->multisite;
        }

        public function is_admin() {
            return $this->admin;
        }

        public function is_network_admin() {
            return $this->network_admin;
        }

        public function is_user_admin() {
            return $this->multisite;
        }

        public function is_blog_admin($blog_id = 0) {
            $blog_id = absint($blog_id);

            if ($blog_id == 0) {
                return $this->blog_admin;
            } else {
                return $this->blog_admin && $this->blog_id = $blog_id;
            }
        }

        public function is_frontend($blog_id = 0) {
            $blog_id = absint($blog_id);

            if ($blog_id == 0) {
                return $this->frontend;
            } else {
                return $this->frontend && $this->blog_id = $blog_id;
            }
        }

        public function get_blog_id() {
            return $this->blog_id;
        }
    }
}
