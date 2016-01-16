<?php

if (!defined('ABSPATH')) exit;

class gdrts_transfer_yet_another_stars_rating {
    public function __construct() { }

    public function db_tables_exist() {
        $tables = array(
            gdrts_db()->wpdb()->prefix.'yasr_log',
            gdrts_db()->wpdb()->prefix.'yasr_votes'
        );

        $ok = true;

        foreach ($tables as $table) {
            $rows = gdrts_db()->run("SHOW TABLES LIKE '".$table."'");

            if (count($rows) == 0) {
                $ok = false;
            }
        }

        return $ok;
    }

    public function transfer_stars_rating($max = 5, $method = 'log') {
        @ini_set('memory_limit', '256M');
        @set_time_limit(0);

        switch ($method) {
            case 'data':
                $this->_transfer_stars_rating_data($max);
                break;
            case 'log':
                $this->_transfer_stars_rating_log($max);
                break;
        }
    }

    private function _transfer_stars_rating_log($max = 5) {
        $sql = "SELECT r.* FROM ".gdrts_db()->wpdb()->prefix."yasr_log r LEFT JOIN ".gdrts_db()->logmeta." l
                ON l.meta_value = r.id AND l.meta_key = 'yasr-import' 
                WHERE r.`multi_set_id` = -1 AND l.meta_value IS NULL ORDER BY r.id ASC";
        $raw = gdrts_db()->run($sql);

        if (!empty($raw)) {
            foreach ($raw as $rating) {
                $post_type = get_post_type($rating->post_id);

                if ($post_type) {
                    gdrtsm_stars_rating()->_load_settings_rule('posts', $post_type);

                    $args = array(
                        'entity' => 'posts', 
                        'name' => $post_type, 
                        'id' => $rating->post_id
                    );

                    $item = gdrts_get_rating_item($args);
                    $factor = gdrtsm_stars_rating()->get_rule('stars') / $max;

                    $data = array(
                        'action' => 'vote',
                        'ip' => $rating->ip,
                        'logged' => $rating->date
                    );

                    $meta = array(
                        'vote' => $rating->vote * $factor,
                        'max' => gdrtsm_stars_rating()->get_rule('stars'),
                        'wppr-import' => $rating->id
                    );

                    gdrtsm_stars_rating()->calculate($item, 'vote', $meta['vote'], $meta['max']);

                    gdrts_db()->add_to_log($item->item_id, $rating->user_id, gdrtsm_stars_rating()->method(), $data, $meta);

                }
            }
        }
    }

    private function _transfer_stars_rating_data($max = 5) {
        $sql = "SELECT `post_id`, `number_of_votes` AS `votes`, `sum_votes` AS `sum` FROM ".gdrts_db()->wpdb()->prefix."yasr_votes WHERE `number_of_votes` > 0";
        $raw = gdrts_db()->run($sql);

        if (!empty($raw)) {
            foreach ($raw as $rating) {
                $post_type = get_post_type($rating->post_id);

                if ($post_type) {
                    gdrtsm_stars_rating()->_load_settings_rule('posts', $post_type);

                    $args = array(
                        'entity' => 'posts', 
                        'name' => $post_type, 
                        'id' => $rating->post_id
                    );

                    $item = gdrts_get_rating_item($args);

                    if ($item->get_meta('yasr-import', false) === false) {
                        $factor = gdrtsm_stars_rating()->get_rule('stars') / $max;

                        $votes = intval($item->get('stars-rating_votes', 0));
                        $sum = floatval($item->get('stars-rating_sum', 0));

                        $votes+= $rating->votes;
                        $sum+= $rating->sum * $factor;

                        $rate = round($sum / $votes, gdrts_settings()->get('decimal_round'));

                        $item->set('stars-rating_sum', $sum);
                        $item->set('stars-rating_max', gdrtsm_stars_rating()->get_rule('stars'));
                        $item->set('stars-rating_votes', $votes);
                        $item->set('stars-rating_rating', $rate);
                        $item->set('yasr-import', true);

                        $item->save();
                    }
                }
            }
        }
    }
}
