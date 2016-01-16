<?php

if (!defined('ABSPATH')) exit;

class gdrts_transfer_gd_star_rating {
    public function __construct() { }

    public function db_tables_exist() {
        $tables = array(
            gdrts_db()->wpdb()->prefix.'gdsr_data_article',
            gdrts_db()->wpdb()->prefix.'gdsr_data_comment',
            gdrts_db()->wpdb()->prefix.'gdsr_votes_log'
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

    public function transfer_stars_rating($max = 10, $method = 'log') {
        @ini_set('memory_limit', '256M');
        @set_time_limit(0);

        switch ($method) {
            case 'data':
                $this->_transfer_stars_rating_data_posts($max);
                $this->_transfer_stars_rating_data_comments($max);
                break;
            case 'log':
                $this->_transfer_stars_rating_log($max);
                break;
        }
    }

    public function _transfer_stars_rating_data_comments($max = 10) {
        $sql = "SELECT r.comment_id, r.last_voted, r.user_voters + r.visitor_voters as `votes`, r.user_votes + r.visitor_votes as `sum`
                FROM ".gdrts_db()->wpdb()->prefix."gdsr_data_comment r ORDER BY r.post_id ASC";
        $raw = gdrts_db()->run($sql);

        if (!empty($raw)) {
            foreach ($raw as $rating) {
                gdrtsm_stars_rating()->_load_settings_rule('comments', 'comment');

                $args = array(
                    'entity' => 'comments', 
                    'name' => 'comment', 
                    'id' => $rating->comment_id
                );

                $item = gdrts_get_rating_item($args);

                if ($item->get_meta('gdsr-review-import', false) === false) {
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
                    $item->set('gdsr-review-import', true);

                    $item->save();
                }
            }
        }
    }

    public function _transfer_stars_rating_data_posts($max = 10) {
        $sql = "SELECT r.post_id, r.last_voted, r.user_voters + r.visitor_voters as votes, r.user_votes + r.visitor_votes as sum
                FROM ".gdrts_db()->wpdb()->prefix."gdsr_data_article r ORDER BY r.post_id ASC";
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

                    if ($item->get_meta('gdsr-review-import', false) === false) {
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
                        $item->set('gdsr-review-import', true);

                        $item->save();
                    }
                }
            }
        }
    }

    public function _transfer_stars_rating_log($max = 10) {
        $sql = "SELECT r.record_id, r.id, r.vote_type, r.user_id, r.vote, r.voted, r.ip, r.user_agent 
               FROM ".gdrts_db()->wpdb()->prefix."gdsr_votes_log r LEFT JOIN ".gdrts_db()->logmeta." l 
               ON l.meta_value = r.record_id AND l.meta_key = 'gdsr-review-import' 
               WHERE l.meta_value IS NULL AND vote_type in ('article', 'comment') ORDER BY r.record_id ASC";
        $raw = gdrts_db()->run($sql);

        if (!empty($raw)) {
            foreach ($raw as $rating) {
                $found = false;
                $args = array();

                if ($rating->vote_type == 'article') {
                    $post_type = get_post_type($rating->id);

                    if ($post_type) {
                        $found = true;

                        gdrtsm_stars_rating()->_load_settings_rule('posts', $post_type);

                        $args = array(
                            'entity' => 'posts', 
                            'name' => $post_type, 
                            'id' => $rating->id
                        );
                    }
                } else {
                    $found = true;

                    gdrtsm_stars_rating()->_load_settings_rule('comments', 'comment');

                    $args = array(
                        'entity' => 'comments', 
                        'name' => 'comment', 
                        'id' => $rating->id
                    );
                }

                if ($found) {
                    $item = gdrts_get_rating_item($args);
                    $factor = gdrtsm_stars_rating()->get_rule('stars') / $max;

                    $data = array(
                        'action' => 'vote',
                        'ip' => $rating->ip,
                        'logged' => $rating->voted
                    );

                    $meta = array(
                        'vote' => $rating->vote * $factor,
                        'max' => gdrtsm_stars_rating()->get_rule('stars'),
                        'gdsr-review-import' => $rating->record_id
                    );

                    gdrtsm_stars_rating()->calculate($item, 'vote', $meta['vote'], $meta['max']);

                    gdrts_db()->add_to_log($item->item_id, $rating->user_id, gdrtsm_stars_rating()->method(), $data, $meta);
                }
            }
        }
    }
}
