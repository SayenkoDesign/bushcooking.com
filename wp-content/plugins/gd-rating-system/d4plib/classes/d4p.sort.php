<?php

/*
Name:    d4pLib_Class_Sort
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

if (!class_exists('d4p_object_sort')) {
    class d4p_object_sort {
        var $properties;
        var $sorted;

        function  __construct($objects_array, $properties = array()) {
            $properties = (array)$properties;

            if (count($properties) > 0) {
                $this->properties = $properties;
                usort($objects_array, array(&$this, 'array_compare'));
            }

            $this->sorted = $objects_array;
        }

        function array_compare($one, $two, $i = 0) {
            $column = $this->properties[$i]['property'];
            $order = strtolower($this->properties[$i]['order']);

            if ($one->$column == $two->$column) {
                if ($i < count($this->properties) - 1) {
                    $i++;
                    return $this->array_compare($one, $two, $i);
                } else {
                    return 0;
                }
            }

            if (strtolower($order) == 'asc') {
                return ($one->$column < $two->$column) ? -1 : 1;
            } else {
                return ($one->$column < $two->$column) ? 1 : -1;
            }
        }
    }
}
