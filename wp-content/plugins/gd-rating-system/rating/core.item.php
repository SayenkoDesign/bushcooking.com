<?php

if (!defined('ABSPATH')) exit;

class gdrts_rating_item {
    public $item_id;
    public $entity;
    public $name;
    public $id;
    public $latest;

    public $meta;
    public $data;

    public $error = false;

    private $backup_meta;

    public function __construct($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        if ($this->item_id > 0) {
            $this->data = gdrts_load_object_data($this->entity, $this->name, $this->id);
        }
    }

    public function __get($name) {
        if (isset($this->meta[$name])) {
            return $this->meta[$name];
        } else {
            return null;
        }
    }

    public static function get_instance($item_id = null, $entity = null, $name = null, $id = null) {
        if (is_null($item_id) || $item_id == 0) {
            $item_id = gdrts()->cache()->get_item_id($entity, $name, $id);
        }

        $item_id = intval($item_id);

        $data = gdrts()->cache()->get('item', $item_id);

        if ($data === false) {
            $item = gdrts_db()->get_item($item_id);

            if (isset($item->item_id) && $item->item_id > 0) {
                $data = array(
                    'item_id' => $item_id,
                    'entity' => $item->entity,
                    'name' => $item->name,
                    'id' => intval($item->id),
                    'latest' => intval(mysql2date('G', $item->latest)),
                    'meta' => gdrts_db()->get_item_meta($item_id)
                );

                gdrts()->cache()->add('item', $item_id, $data);
            } else {
                $data = array('item_id' => $item_id, 'error' => true);
            }
        }

        return new gdrts_rating_item($data);
    }

    public function prepare_save() {
        $this->backup_meta = $this->meta;
    }

    public function save($update_latest = true) {
        foreach ($this->meta as $key => $value) {
            if (isset($this->backup_meta[$key])) {
                gdrts_db()->update_meta('item', $this->item_id, $key, $value, $this->backup_meta[$key]);
            } else {
                gdrts_db()->add_meta('item', $this->item_id, $key, $value, true);
            }
        }

        foreach ($this->backup_meta as $key => $value) {
            if (!isset($this->meta[$key])) {
                gdrts_db()->delete_meta('item', $this->item_id, $key);
            }
        }

        if ($update_latest) {
            gdrts_db()->update_item_latest($this->item_id);
        }

        gdrts()->cache()->delete('item', $this->item_id);
    }

    public function set($name, $value) {
        $this->meta[$name] = $value;
    }

    public function un_set($name) {
        if (isset($this->meta[$name])) {
            unset($this->meta[$name]);
        }
    }

    public function get($name, $default) {
        $value = $this->$name;

        if (is_null($value)) {
            $value = $default;
        }

        return $value;
    }

    public function get_meta($name, $default = false) {
        if (isset($this->meta[$name])) {
            return $this->meta[$name];
        } else {
            return $default;
        }
    }

    public function item_data() {
        return array(
            'entity' => $this->entity,
            'name' => $this->name,
            'id' => $this->id,
            'item_id' => $this->item_id,
            'nonce' => wp_create_nonce($this->nonce_key())
        );
    }

    public function nonce_key() {
        return 'gdrts_item_'.$this->entity.'_'.$this->name.'_'.$this->id;
    }

    public function rating_classes() {
        return array(
            'gdrts-item-entity-'.$this->entity,
            'gdrts-item-name-'.$this->name,
            'gdrts-item-id-'.$this->id,
            'gdrts-item-itemid-'.$this->item_id
        );
    }

    public function title() {
        return $this->data->get_title();
    }

    public function url() {
        return $this->data->get_url();
    }
}

class gdrts_item_post extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_post($this->id);
    }

    public function get_title() {
        return $this->object->post_title;
    }

    public function get_url() {
        return get_permalink($this->id);
    }
}

class gdrts_item_comment extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_comment($this->id);
    }

    public function get_title() {
        return '';
    }

    public function get_url() {
        return get_comment_link($this->id);
    }
}

class gdrts_item_user extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_user_by('id', $this->id);
    }

    public function get_title() {
        return $this->object->display_name;
    }

    public function get_url() {
        return '';
    }
}

class gdrts_item_term extends gdrts_item_data {
    public function __construct($entity, $name, $id) {
        parent::__construct($entity, $name, $id);

        $this->object = get_term_by('id', $this->id, $this->name);
    }

    public function get_title() {
        return $this->object->term_name;
    }

    public function get_url() {
        return get_term_link($this->object);
    }
}

class gdrts_item_custom extends gdrts_item_data {
    public function get_title() {
        return '';
    }

    public function get_url() {
        return '';
    }
}
