<?php

if (!defined('ABSPATH')) exit;

class gdrts_transfer_wp_postratings {
    public function __construct() { }

    public function db_tables_exist() {
        $tables = array(
            gdrts_db()->wpdb()->prefix.'ratings'
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

    public function transfer($max = 5, $method = 'log') {
        @ini_set('memory_limit', '256M');
        @set_time_limit(0);

        switch ($method) {
            case 'data':
                $this->_transfer_data($max);
                break;
            case 'log':
                $this->_transfer_log($max);
                break;
        }
    }

    private function _transfer_log($max = 5) {
        $sql = "SELECT r.rating_id, r.rating_postid AS post_id, r.rating_rating AS vote, 
               FROM_UNIXTIME(r.rating_timestamp) AS logged, r.rating_ip AS ip, r.rating_userid AS user_id 
               FROM ".gdrts_db()->wpdb()->prefix."ratings r LEFT JOIN ".gdrts_db()->logmeta." l
               ON l.meta_value = r.rating_id AND l.meta_key = 'wppr-import' 
               WHERE l.meta_value IS NULL ORDER BY r.rating_id ASC";
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
                        'logged' => $rating->logged
                    );

                    $meta = array(
                        'vote' => $rating->vote * $factor,
                        'max' => gdrtsm_stars_rating()->get_rule('stars'),
                        'wppr-import' => $rating->rating_id
                    );

                    gdrtsm_stars_rating()->calculate($item, 'vote', $meta['vote'], $meta['max']);

                    gdrts_db()->add_to_log($item->item_id, $rating->user_id, gdrtsm_stars_rating()->method(), $data, $meta);
                }
            }
        }
    }

    private function _transfer_data($max = 5) {
        $sql = "SELECT post_id as `id`, SUBSTR(meta_key, 9) as `key`, meta_value as `value` 
               FROM ".gdrts_db()->wpdb()->postmeta." WHERE meta_key IN ('ratings_users', 'ratings_score', 'ratings_average') 
               ORDER BY post_id ASC";
        $raw = gdrts_db()->run($sql);

        if (!empty($raw)) {
            $data = array();

            foreach ($raw as $r) {
                $id = intval($r->id);
                $data[$id][$r->key] = $r->value;
            }

            foreach ($data as $post => $rating) {
                $post_type = get_post_type($post);

                if ($post_type) {
                    gdrtsm_stars_rating()->_load_settings_rule('posts', $post_type);

                    $args = array(
                        'entity' => 'posts', 
                        'name' => $post_type, 
                        'id' => $post
                    );

                    $item = gdrts_get_rating_item($args);

                    if ($item->get_meta('wppr-import', false) === false) {
                        $factor = gdrtsm_stars_rating()->get_rule('stars') / $max;

                        $votes = intval($item->get('stars-rating_votes', 0));
                        $sum = floatval($item->get('stars-rating_sum', 0));

                        $votes+= $rating['users'];
                        $sum+= $rating['score'] * $factor;

                        $rating = round($sum / $votes, gdrts_settings()->get('decimal_round'));

                        $item->set('stars-rating_sum', $sum);
                        $item->set('stars-rating_max', gdrtsm_stars_rating()->get_rule('stars'));
                        $item->set('stars-rating_votes', $votes);
                        $item->set('stars-rating_rating', $rating);
                        $item->set('wppr-import', true);

                        $item->save();
                    }
                }
            }
        }
    }
}
