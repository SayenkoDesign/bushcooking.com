<?php

/*
Name:    d4pLib_Admin_Settings
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

if (!class_exists('d4pSettingType')) {
    class d4pSettingType {
        const INFO = 'info';
        const HR = 'hr';
        const CUSTOM = 'custom';

        const IMAGE = 'image';
        const IMAGES = 'images';
        const BOOLEAN = 'bool';
        const TEXT = 'text';
        const TEXTAREA = 'textarea';
        const SLUG = 'slug';
        const PASSWORD = 'password';
        const FILE = 'file';
        const TEXT_HTML = 'text_html';
        const COLOR = 'color';
        const RICH = 'rich';
        const BLOCK = 'block';
        const HTML = 'html';
        const LINK = 'link';
        const CHECKBOXES = 'checkboxes';
        const RADIOS = 'radios';
        const SELECT = 'select';
        const SELECT_MULTI = 'select_multi';
        const GROUP = 'group';
        const GROUP_MULTI = 'group_multi';
        const NUMBER = 'number';
        const INTEGER = 'integer';
        const HIDDEN = 'hidden';
        const LISTING = 'listing';
        const X_BY_Y = 'x_by_y';

        const EXPANDABLE_PAIRS = 'expandable_pairs';
        const EXPANDABLE_TEXT = 'expandable_text';

        public static $_values = array(
            'info' => self::INFO,
            'hr' => self::HR,
            'custom' => self::CUSTOM,

            'image' => self::IMAGE,
            'images' => self::IMAGES,
            'text' => self::TEXT,
            'password' => self::PASSWORD,
            'file' => self::FILE,
            'text_html' => self::TEXT_HTML,
            'color' => self::COLOR,
            'rich' => self::RICH,
            'block' => self::BLOCK,
            'html' => self::HTML,
            'link' => self::LINK,
            'checkboxes' => self::CHECKBOXES,
            'radios' => self::RADIOS,
            'select' => self::SELECT,
            'select_multi' => self::MULTI,
            'group' => self::GROUP,
            'group_multi' => self::GROUP_MULTI,
            'number' => self::NUMBER,
            'integer' => self::INTEGER,
            'bool' => self::BOOLEAN,
            'listing' => self::LISTING,
            'hidden' => self::HIDDEN,
            'x_by_y' => self::X_BY_Y,

            'expandable_pairs' => self::EXPANDABLE_PAIRS,
            'expandable_text' => self::EXPANDABLE_TEXT
        );

        public static function to_string($value) {
            if (is_null($value)) {
                return null;
            }

            if (array_key_exists($value, self::$_values)) {
                return self::$_values[$value];
            }

            return 'UNKNOWN';
        }
    }
}

if (!class_exists('d4pSettingElement')) {
    class d4pSettingElement {
        public $type;
        public $name;
        public $title;
        public $notice;
        public $input;
        public $value;
        public $source;
        public $data;
        public $args;

        function __construct($type, $name, $title = '', $notice = '', $input = 'text', $value = '', $source = '', $data = '', $args = array()) {
            $this->type = $type;
            $this->name = $name;
            $this->title = $title;
            $this->notice = $notice;
            $this->input = $input;
            $this->value = $value;
            $this->source = $source;
            $this->data = $data;
            $this->args = $args;
        }
    }
}

if (!class_exists('d4pSettingsRender')) {
    class d4pSettingsRender {
        public $base = 'd4pvalue';
        public $kb = 'https://support.dev4press.com/kb/article/%url%/';

        public $panel;
        public $groups;

        function __construct($panel, $groups) {
            $this->panel = $panel;
            $this->groups = $groups;            
        }

        public function render() {
            foreach ($this->groups as $group => $obj) {
                $args = isset($obj['args']) ? $obj['args'] : array();

                $classes = array('d4p-group', 'd4p-group-'.$group);

                if (isset($args['hidden']) && $args['hidden']) {
                    $classes[] = 'd4p-hidden-group';
                }

                if (isset($args['class']) && $args['class'] != '') {
                    $classes[] = $args['class'];
                }

                echo '<div class="'.join(' ', $classes).'" id="d4p-group-'.$group.'">';
                    $kb = isset($obj['kb']) ? str_replace('%url%', $obj['kb']['url'], $this->kb) : '';

                    if ($kb != '') {
                        $kb = '<a class="d4p-kb-group" href="'.$kb.'" target="_blank">'.$obj['kb']['label'].'</a>';
                    }

                    echo '<h3>'.$obj['name'].$kb.'</h3>';
                    echo '<div class="d4p-group-inner">';
                        echo '<table class="form-table">';
                            echo '<tbody>';

                                foreach ($obj['settings'] as $setting) {
                                    $this->render_option($setting, $group);
                                }

                            echo '</tbody>';
                        echo '</table>';
                    echo '</div>';
                echo '</div>';
            }
        }

        private function get_id($name, $id = '') {
            if (!empty($id)) {
                return $id;
            }

            return str_replace('[', '_', str_replace(']', '', $name));
        }

        private function render_option($setting, $group) {
            $name_base = $this->base.'['.$setting->type.']['.$setting->name.']';
            $id_base = $this->get_id($name_base);
            $call_function = array(&$this, 'draw_'.$setting->input);

            if ($setting->input != 'hidden' && $setting->input != 'hr') {
                echo '<tr valign="top">';
                    $class = 'd4p-setting-'.$setting->input;

                    if (isset($setting->args['readonly']) && $setting->args['readonly']) {
                        $class.= 'd4p-setting-disabled';
                    }

                    if (isset($setting->args['class']) && !empty($setting->args['class'])) {
                        $class.= ' '.$setting->args['class'];
                    }

                    echo '<th scope="row">'.$setting->title.'</th>';
                    echo '<td>';
                        echo '<div class="'.$class.'">';

                        do_action('d4p_settings_group_top', $setting, $group);

                        $this->call($call_function, $setting, $name_base, $id_base);

                        if ($setting->notice != '' && $setting->input != 'info') {
                            echo '<em>'.$setting->notice.'</em>';
                        }

                        do_action('d4p_settings_group_bottom', $setting, $group);

                        echo '</div>';
                    echo '</td>';
                echo '</tr>';
            } else if ($setting->input == 'hr') {
                echo '<tr valign="top">';
                    $class = 'd4p-setting-'.$setting->input;

                    if (isset($setting->args['class']) && !empty($setting->args['class'])) {
                        $class.= ' '.$setting->args['class'];
                    }

                    echo '<td colspan="2">';
                    echo '<div class="'.$class.'">';

                    if ($setting->title != '') {
                        echo '<span>'.$setting->title.'</span>';
                    }

                    echo '<hr />';
                    echo '</div>';
                    echo '</td>';

                echo '</tr>';
            } else {
                do_action('d4p_settings_group_hidden_top', $setting, $group);

                $this->call($call_function, $setting, $name_base, $id_base);

                do_action('d4p_settings_group_hidden_bottom', $setting, $group);
            }
        }

        private function call($call_function, $setting, $name_base, $id_base) {
            call_user_func($call_function, $setting, $setting->value, $name_base, $id_base);
        }

        private function draw_info($element, $value, $name_base, $id_base = '') {
            echo $element->notice;
        }

        private function draw_images($element, $value, $name_base, $id_base = '') {
            $value = (array)$value;

            echo '<a href="#" class="button d4plib-button-inner d4plib-images-add"><i class="fa fa-photo"></i> '.__("Add Image", "d4plib").'</a>';

            echo '<div class="d4plib-selected-image" data-name="'.$name_base.'">';

            echo '<div style="display: '.(empty($value) ? "block" : "none").'" class="d4plib-images-none"><span class="d4plib-image-name">'.__("No images selected.", "d4plib").'</span></div>';

            foreach ($value as $id) {
                $image = get_post($id);
                $title = '('.$image->ID.') '.$image->post_title;
                $media = wp_get_attachment_image_src($id, 'full');
                $url = $media[0];

                echo "<div class='d4plib-images-image'>";
                echo "<input type='hidden' value='".$id."' name='".$name_base."[]' />";
                echo "<a class='button d4plib-button-action d4plib-images-remove'><i class='fa fa-ban'></i></a>";
                echo "<a class='button d4plib-button-action d4plib-images-preview'><i class='fa fa-search'></i></a>";
                echo "<span class='d4plib-image-name'>".$title."</span>";
                echo "<img src='".$url."' />";
                echo "</div>";
            }

            echo '</div>';
        }

        private function draw_image($element, $value, $name_base, $id_base = '') {
            echo sprintf('<input class="d4plib-image" type="hidden" name="%s" id="%s" value="%s" />',
                    $name_base, $id_base, esc_attr($value));

            echo '<a href="#" class="button d4plib-button-inner d4plib-image-add"><i class="fa fa-photo"></i> '.__("Select Image", "d4plib").'</a>';
            echo '<a style="display: '.($value > 0 ? "inline-block" : "none").'" href="#" class="button d4plib-button-inner d4plib-image-preview"><i class="fa fa-search"></i> '.__("Show Image", "d4plib").'</a>';
            echo '<a style="display: '.($value > 0 ? "inline-block" : "none").'" href="#" class="button d4plib-button-inner d4plib-image-remove"><i class="fa fa-ban"></i> '.__("Clear Image", "d4plib").'</a>';

            echo '<div class="d4plib-selected-image">';
            $title = __("Image not selected.", "d4plib"); $url = '';

            if ($value > 0) {
                $image = get_post($value);
                $title = '('.$image->ID.') '.$image->post_title;
                $media = wp_get_attachment_image_src($value, 'full');
                $url = $media[0];
            }
            
            echo '<span class="d4plib-image-name">'.$title.'</span>';
            echo '<img src="'.$url.'" />';
            echo '</div>';
        }

        private function draw_hidden($element, $value, $name_base, $id_base = '') {
            echo sprintf('<input type="hidden" name="%s" id="%s" value="%s" />',
                    $name_base, $id_base, esc_attr($value));
        }

        private function draw_bool($element, $value, $name_base, $id_base = '') {
            $selected = $value == 1 || $value === true ? ' checked="checked"' : '';
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';
            $label = isset($element->args['label']) && $element->args['label'] != '' ? $element->args['label'] : 'Enabled';

            echo sprintf('<label for="%s"><input%s type="checkbox" name="%s" id="%s"%s class="widefat" />%s</label>',
                    $id_base, $readonly, $name_base, $id_base, $selected, $label);
        }

        private function draw_html($element, $value, $name_base, $id_base) {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            echo sprintf('<textarea%s name="%s" id="%s" class="widefat">%s</textarea>',
                    $readonly, $name_base, $id_base, esc_textarea($value));
        }

        private function draw_x_by_y($element, $value, $name_base, $id_base, $cls = '') {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            $pairs = explode('x', $value);

            echo sprintf('<input%s type="text" name="%s[x]" id="%s_x" value="%s" class="widefat" />',
                    $readonly, $name_base, $id_base, $pairs[0]);
            echo ' x ';
            echo sprintf('<input%s type="text" name="%s[y]" id="%s_y" value="%s" class="widefat" />',
                    $readonly, $name_base, $id_base, $pairs[1]);
        }

        private function draw_textarea($element, $value, $name_base, $id_base) {
            $this->draw_html($element, $value, $name_base, $id_base);
        }

        private function draw_slug($element, $value, $name_base, $id_base) {
            $this->draw_text($element, $value, $name_base, $id_base);
        }

        private function draw_text_html($element, $value, $name_base, $id_base) {
            $this->draw_text($element, $value, $name_base, $id_base);
        }

        private function draw_text($element, $value, $name_base, $id_base) {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            echo sprintf('<input%s type="text" name="%s" id="%s" value="%s" class="widefat" />',
                    $readonly, $name_base, $id_base, esc_attr($value));
        }

        private function draw_password($element, $value, $name_base, $id_base) {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            echo sprintf('<input%s type="password" name="%s" id="%s" value="%s" class="widefat" />',
                    $readonly, $name_base, $id_base, esc_attr($value));
        }

        private function draw_file($element, $value, $name_base, $id_base) {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            echo sprintf('<input%s type="file" name="%s" id="%s" value="%s" class="widefat" />',
                    $readonly, $name_base, $id_base, esc_attr($value));
        }

        private function draw_color($element, $value, $name_base, $id_base) {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            echo sprintf('<input%s type="text" name="%s" id="%s" value="%s" class="widefat d4p-color-picker" />',
                    $readonly, $name_base, $id_base, esc_attr($value));
        }

        private function draw_integer($element, $value, $name_base, $id_base) {
            $this->draw_number($element, $value, $name_base, $id_base);
        }

        private function draw_number($element, $value, $name_base, $id_base) {
            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            echo sprintf('<input%s type="text" name="%s" id="%s" value="%s" class="widefat" />',
                    $readonly, $name_base, $id_base, $value);

            if (isset($element->args['label_unit'])) {
                echo '<span class="d4p-field-unit">'.$element->args['label_unit'].'</span>';
            }
        }

        private function draw_radios($element, $value, $name_base, $id_base) {
            $this->draw_checkboxes($element, $value, $name_base, $id_base, false);
        }

        private function draw_select($element, $value, $name_base, $id_base) {
            $this->draw_select_multi($element, $value, $name_base, $id_base, false);
        }

        private function draw_group($element, $value, $name_base, $id_base) {
            $this->draw_group_multi($element, $value, $name_base, $id_base, false);
        }

        private function draw_checkboxes($element, $value, $name_base, $id_base, $multiple = true) {
            $data = array();
            switch ($element->source) {
                case 'function':
                    $data = call_user_func($element->data);
                    break;
                default:
                case '':
                case 'array':
                    $data = $element->data;
                    break;
            }

            $value = is_null($value) || $value === true ? array_keys($data) : (array)$value;
            $associative = d4p_is_array_associative($data);

            if ($multiple) {
                echo '<div class="d4p-check-uncheck">';

                echo '<a href="#checkall">'.__("Check All", "d4plib").'</a>';
                echo ' | <a href="#uncheckall">'.__("Uncheck All", "d4plib").'</a>';

                echo '</div>';
            }

            foreach ($data as $key => $title) {
                $real_value = $associative ? $key : $title;
                $sel = in_array($real_value, $value) ? ' checked="checked"' : '';

                echo sprintf('<label><input type="%s" id="%s" value="%s" name="%s%s"%s class="widefat" />%s</label>', 
                        $multiple ? 'checkbox' : 'radio', $id_base, $real_value, $name_base, $multiple == 1 ? '[]' : '', $sel, $title);
            }
        }

        private function draw_group_multi($element, $value, $name_base, $id_base, $multiple = true) {
            $data = array();
            switch ($element->source) {
                case 'function':
                    $data = call_user_func($element->data);
                    break;
                default:
                    $data = $element->data;
                    break;
            }

            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            d4p_render_grouped_select($data, array('selected' => $value, 'readonly' => $readonly, 'name' => $name_base, 'id' => $id_base, 'class' => 'widefat', 'multi' => $multiple));
        }

        private function draw_select_multi($element, $value, $name_base, $id_base, $multiple = true) {
            $data = array();
            switch ($element->source) {
                case 'function':
                    $data = call_user_func($element->data);
                    break;
                default:
                    $data = $element->data;
                    break;
            }

            $readonly = isset($element->args['readonly']) && $element->args['readonly'] ? ' readonly' : '';

            d4p_render_select($data, array('selected' => $value, 'readonly' => $readonly, 'name' => $name_base, 'id' => $id_base, 'class' => 'widefat', 'multi' => $multiple));
        }

        private function _pair_element($name, $id, $i, $value, $element, $hide = false) {
            echo '<div class="pair-element-'.$i.'" style="display: '.($hide ? 'none' : 'block').'">';
            echo '<label>'.$element->args['label_key'].':</label>';
            echo '<input type="text" name="'.$name.'[key]" id="'.$id.'_key" value="'.esc_attr($value['key']).'" class="widefat" />';

            echo '<label>'.$element->args['label_value'].':</label>';
            echo '<input type="text" name="'.$name.'[value]" id="'.$id.'_value" value="'.esc_attr($value['value']).'" class="widefat" />';

            echo '<a class="button-secondary" href="#">'.$element->args['label_buttom_remove'].'</a>';
            echo '</div>';
        }

        private function draw_expandable_pairs($element, $value, $name_base, $id_base = '') {
            $this->_pair_element($name_base.'[0]', $id_base.'_0', 0, array('key' => '', 'value' => ''), $element, true);

            $i = 1;
            foreach ($value as $key => $val) {
                $this->_pair_element($name_base.'['.$i.']', $id_base.'_'.$i, $i, array('key' => $key, 'value' => $val), $element);
                $i++;
            }

            echo '<a class="button-primary" href="#">'.$element->args['label_button_add'].'</a>';
            echo '<input type="hidden" value="'.$i.'" class="d4p-next-id" />';
        }

        private function _text_element($name, $id, $i, $value, $element, $hide = false) {
            echo '<li class="exp-text-element-'.$i.'" style="display: '.($hide ? 'none' : 'list-item').'">';

            echo '<input type="text" name="'.$name.'[value]" id="'.$id.'_value" value="'.esc_attr($value).'" class="widefat" />';

            if (isset($element->args['label_buttom_remove']) && $element->args['label_buttom_remove'] != '') {
                echo '<a class="button-secondary" href="#">'.$element->args['label_buttom_remove'].'</a>';
            }

            echo '</li>';
        }

        private function draw_expandable_text($element, $value, $name_base, $id_base = '') {
            echo '<ol>';

            $this->_text_element($name_base.'[0]', $id_base.'_0', 0, '', $element, true);

            $i = 1;
            foreach ($value as $val) {
                $this->_text_element($name_base.'['.$i.']', $id_base.'_'.$i, $i, $val, $element);
                $i++;
            }

            echo '</ol>';

            echo '<a class="button-primary" href="#">'.$element->args['label_button_add'].'</a>';
            echo '<input type="hidden" value="'.$i.'" class="d4p-next-id" />';
        }
    }
}

if (!class_exists('d4pSettingsProcess')) {
    class d4pSettingsProcess {
        public $bool_values = array(true, false);

        public $base = 'd4pvalue';
        public $settings;

        function __construct($settings) {
            $this->settings = $settings;
        }

        public function process() {
            $list = array();

            foreach ($this->settings as $setting) {
                if ($setting->type != '_') {
                    $post = isset($_REQUEST[$this->base][$setting->type]) ? $_REQUEST[$this->base][$setting->type] : array();

                    $list[$setting->type][$setting->name] = $this->process_single($setting, $post);
                }
            }

            return $list;
        }

        public function process_single($setting, $post) {
            $input = $setting->input;
            $key = $setting->name;
            $value = null;

            switch ($input) {
                case 'skip':
                case 'info':
                case 'hr':
                    $value = null;
                    break;
                case 'expandable_text':
                    $value = array();

                    foreach ($post[$key] as $id => $data) {
                        if ($id > 0) {
                            $_val = $data['value'];

                            if ($_val != '') {
                                $value[] = $_val;
                            }
                        }
                    }
                    break;
                case 'expandable_pairs':
                    $value = array();

                    foreach ($post[$key] as $id => $data) {
                        if ($id > 0) {
                            $_key = trim($data['key']);
                            $_val = trim($data['value']);

                            if ($_key != '' && $_val != '') {
                                $value[$_key] = $_val;
                            }
                        }
                    }
                    break;
                case 'x_by_y':
                    $value = $post[$key]['x'].'x'.$post[$key]['y'];
                    break;
                case 'html':
                case 'text_html':
                case 'text_rich':
                    $value = stripslashes($post[$key]);
                    break;
                case 'bool':
                    $value = isset($post[$key]) ? $this->bool_values[0] : $this->bool_values[1];
                    break;
                case 'number':
                    $value = floatval($post[$key]);
                    break;
                case 'images':
                    if (!isset($post[$key])) {
                        $value = array();
                    } else {
                        $value = (array)$post[$key];
                        $value = array_map('intval', $value);
                        $value = array_filter($value);
                    }
                    break;
                case 'image':
                case 'integer':
                    $value = intval($post[$key]);
                    break;
                case 'listing':
                    $value = d4p_split_textarea_to_list($post[$key]);
                    break;
                case 'media':
                    $value = 0;
                    if ($post[$key] != '') {
                        $value = intval(substr($post[$key], 3));
                    }
                    break;
                case 'checkboxes':
                case 'select_multi':
                case 'group_multi':
                    if (!isset($post[$key])) {
                        $value = array();
                    } else {
                        $value = (array)$post[$key];
                    }
                    break;
                case 'slug':
                    $value = sanitize_key(stripslashes(strip_tags($post[$key])));
                    break;
                default:
                case 'text':
                case 'textarea':
                case 'password':
                case 'color':
                case 'block':
                case 'hidden':
                case 'select':
                case 'radios':
                case 'group':
                    $value = stripslashes(strip_tags($post[$key]));
                    break;
            }

            return $value;
        }
    }
}
