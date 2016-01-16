<?php

if (!defined('ABSPATH')) exit;

class gdrts_core_query {
    public $args = array();

    public $_votes = false;

    public $sql = '';

    public function __construct() { }

    public function run($args = array()) {
        $defaults = array(
            'method' => 'stars-rating',
            'entity' => 'posts',
            'name' => 'post',
            'id__in' => array(),
            'id__not_in' => array(),
            'orderby' => 'rating',
            'order' => 'DESC',
            'offset' => 0,
            'limit' => 5,
            'return' => 'objects', // ids, objects, quick,
            'rating_min' => 0,
            'votes_min' => 1,
            'period' => false,
            'source' => ''
        );

        $this->args = wp_parse_args($args, $defaults);

        $this->_votes = apply_filters('gdrts_query_has_votes_'.$this->args['method'], $this->_votes);

        if (!$this->_votes && in_array($this->args['orderby'], array('votes', 'sum'))) {
            $this->args['orderby'] = 'rating';
        }

        $query = $this->build_query();

        $items = gdrts_db()->run_and_index($query, 'item_id');

        switch ($this->args['return']) {
            case 'ids':
                return array_keys($items);
            case 'quick':
                return array_values($items);
            default:
            case 'objects':
                return $this->prepare_objects($items);
        }
    }

    public function parse_order() {
        $q = array(
            'select' => '',
            'query' => '',
            'where' => array(),
            'order' => ''
        );

        if ($this->args['orderby'] != '' && $this->args['orderby'] != 'none') {
            if ($this->args['orderby'] == 'rand') {
                $q['order'] = ' ORDER BY RAND()';
            } else {
                $q['order'] = ' ORDER BY ';

                $order = 'DESC';
                $orderby = $this->args['orderby'];

                if (strtoupper($this->args['order']) == 'ASC') {
                    $order = 'ASC';
                }

                switch ($orderby) {
                    case 'item':
                    case 'item_id':
                        $q['order'].= 'i.`item_id`';
                        break;
                    case 'id':
                        $q['order'].= 'i.`id`';
                        break;
                    case 'latest':
                        $q['order'].= 'i.`latest`';
                        break;
                    case 'rating':
                        $q['order'].= 'rating ';

                        if ($this->_votes) {
                            $q['order'].= $order.', votes';
                        }
                        break;
                    case 'votes':
                        $q['order'].= 'votes';
                        break;
                    case 'sum':
                        $q['select'] = ", ms.`meta_value` as sum";
                        $q['query'] = " INNER JOIN ".gdrts_db()->itemmeta." ms ON ms.`item_id` = i.`item_id` AND ms.`meta_key` = '".$this->args['method']."_sum'";
                        $q['order'].= 'sum';
                        break;
                }

                $q['order'].= ' '.$order;
            }
        }

        return $q;
    }

    public function parse_period() {
        return array('where' => array());
    }

    public function build_query() {
        $where = array(
            "i.`entity` = '".$this->args['entity']."'",
            "i.`name` = '".$this->args['name']."'"
        );

        $select = $this->args['return'] == 'ids' ? 'i.`item_id`' : 'i.*';
        $select.= ", m.`meta_value` as rating";

        $query = " FROM ".gdrts_db()->items." i INNER JOIN ".gdrts_db()->itemmeta." m";
        $query.= " ON m.item_id = i.item_id AND m.meta_key = '".$this->args['method']."_rating'";

        if ($this->_votes) {
            $select.= ", mv.`meta_value` as votes";
            $query.= " INNER JOIN ".gdrts_db()->itemmeta." mv ON mv.`item_id` = i.`item_id` AND mv.`meta_key` = '".$this->args['method']."_votes'";
        }

        if (!empty($this->args['id__in'])) {
            $where[] = "i.`id` IN (".join(', ', $this->args['id__in']).")";
        } else if (!empty($this->args['id__not_in'])) {
            $where[] = "i.`id` NOT IN (".join(', ', $this->args['id__not_in']).")";
        }

        if (is_numeric($this->args['rating_min']) && $this->args['rating_min'] > 0) {
            $where[] = 'm.`meta_value` >= '.$this->args['rating_min'];
        }

        if ($this->_votes && is_numeric($this->args['votes_min']) && $this->args['votes_min'] > 0) {
            $where[] = 'mv.`meta_value` >= '.$this->args['votes_min'];
        }

        $order = $this->parse_order();
        $period = $this->parse_period();

        if ($order['select'] != '') {
            $select.= $order['select'];
        }

        if ($order['query'] != '') {
            $query.= $order['query'];
        }

        if (!empty($order['where'])) {
            $where = array_merge($where, $order['where']);
        }

        if (!empty($period['where'])) {
            $where = array_merge($where, $period['where']);
        }

        $this->sql = "SELECT DISTINCT ".$select.$query." WHERE ".join(' AND ', $where);

        if ($order['order'] != '') {
            $this->sql.= $order['order'];
        }

        if (is_numeric($this->args['offset']) > 0 || is_numeric($this->args['limit']) > 0) {
            $this->sql.= " LIMIT ".absint($this->args['offset']).", ".absint($this->args['limit']);
        }

        return $this->sql;
    }

    public function prepare_objects($items) {
        $list = array();

        $get = array();
        foreach ($items as $item_id => $obj) {
            gdrts()->cache()->set('item_id', $obj->entity.'-'.$obj->name.'-'.$obj->id, $item_id);

            if (!gdrts()->cache()->in('item', $item_id)) {
                $get[] = $item_id;
            }
        }

        if (!empty($get)) {
            $metas = gdrts_db()->get_items_meta($get);
        }

        $i = 1;
        foreach ($items as $item_id => $obj) {
            $data = (array)$obj;
            $data['meta'] = isset($metas[$item_id]) ? $metas[$item_id] : array();

            gdrts()->cache()->add('item', $item_id, $data);

            $item = gdrts_get_rating_item_by_id($item_id);
            $item->ordinal = $i;
            $list[] = $item;

            $i++;
        }

        return $list;
    }
}

global $_gdrts_query;

$_gdrts_query = new gdrts_core_query();

function gdrts_query() {
    global $_gdrts_query;
    return $_gdrts_query;
}
