<?php

if (!defined('ABSPATH')) exit;

class gdrts_method_stars_rating extends gdrts_method {
    public $prefix = 'stars-rating';

    public function __construct() {
        require_once(GDRTS_PATH.'methods/stars-rating/user.php');
        require_once(GDRTS_PATH.'methods/stars-rating/render.php');
        require_once(GDRTS_PATH.'methods/stars-rating/functions.php');

        parent::__construct();
    }

    public function _load_admin() {
        require_once(GDRTS_PATH.'methods/stars-rating/admin.php');
    }

    public function implements_votes($votes = false) {
        return true;
    }

    public function templates_list($entity, $name) {
        $base = 'gdrts--stars-rating--list--'.$this->_args['template'];

        $templates = array(
            $base.'.php'
        );

        return $templates;
    }

    public function templates_single($item) {
        $template = isset($this->_args['template']) ? $this->_args['template'] : 'default';

        $base = 'gdrts--stars-rating--single--'.$template;

        $templates = array(
            $base.'.php'
        );

        return $templates;
    }

    public function labels() {
        $labels = array();

        for ($id = 1; $id <= $this->_calc['stars']; $id++) {
            $key = $id - 1;

            $labels[] = isset($this->_args['labels'][$key]) ? $this->_args['labels'][$key] : sprintf(_n("%s Star", "%s Stars", $id, "gd-rating-system"), $id);
        }

        return $labels;
    }

    public function prepare_loop_list($method, $args = array()) {
        $this->_engine = 'list';

        $this->_render = new gdrts_render_list_stars_rating();

        $this->_load_settings_rule($args['entity'], $args['name']);

        $defaults = array(
            'template' => $this->get_rule('template'),
            'responsive' => $this->get_rule('responsive'),
            'style_type' => $this->get_rule('style_type'),
            'style_name' => $this->get_rule('style_type') == 'font' ? $this->get_rule('style_font_name') : $this->get_rule('style_image_name'),
            'style_size' => $this->get_rule('style_size'),
            'style_class' => '',
            'labels' => $this->get_rule('labels')
        );

        $this->_args = wp_parse_args($method, $defaults);

        $this->_args = apply_filters('gdrts_stars_rating_loop_list_args', $this->_args, $this->prefix);

        $this->_calc['stars'] = intval($this->get_rule('stars'));

        $this->_calc = apply_filters('gdrts_stars_rating_loop_list_calc', $this->_calc, $this->prefix);
    }

    public function update_list_item() {
        $this->_calc['votes'] = intval(gdrts_list()->item()->get('stars-rating_votes', 0));
        $this->_calc['sum'] = gdrts_list()->item()->get('stars-rating_sum', 0);
        $this->_calc['max'] = gdrts_list()->item()->get('stars-rating_max', 0);
        $this->_calc['rating'] = number_format(gdrts_list()->item()->get('stars-rating_rating', 0), gdrts_settings()->get('decimal_round'));

        if ($this->_calc['votes'] > 0 && $this->_calc['max'] != $this->_calc['stars']) {
            $factor = $this->_calc['stars'] / $this->_calc['max'];

            $this->_calc['sum'] = $this->_calc['sum'] * $factor;
            $this->_calc['rating'] = $this->_calc['rating'] * $factor;
            $this->_calc['max'] = $this->_calc['stars'];
        }

        $this->_calc['current'] = intval(100 * ($this->_calc['rating'] / $this->_calc['stars']));
    }

    public function prepare_loop_single($method, $args = array()) {
        $this->_engine = 'single';

        $this->_render = new gdrts_render_single_stars_rating();

        $this->_load_settings_rule();

        $defaults = array(
            'allow_super_admin' => $this->get_rule('allow_super_admin'),
            'allow_user_roles' => $this->get_rule('allow_user_roles'),
            'allow_visitor' => $this->get_rule('allow_visitor'),
            'template' => $this->get_rule('template'),
            'alignment' => $this->get_rule('alignment'),
            'responsive' => $this->get_rule('responsive'),
            'distribution' => $this->get_rule('distribution'),
            'style_type' => $this->get_rule('style_type'),
            'style_name' => $this->get_rule('style_type') == 'font' ? $this->get_rule('style_font_name') : $this->get_rule('style_image_name'),
            'style_size' => $this->get_rule('style_size'),
            'style_class' => '',
            'labels' => $this->get_rule('labels')
        );

        $this->_args = wp_parse_args($method, $defaults);

        if (!gdrts_single()->is_suppress_filters()) {
            $this->_args = apply_filters('gdrts_stars_rating_loop_single_args', $this->_args, $this->prefix);
        }

        $this->_user = new gdrts_user_stars_rating($this->_args['allow_super_admin'], $this->_args['allow_user_roles'], $this->_args['allow_visitor']);

        $this->_calc['stars'] = intval($this->get_rule('stars'));
        $this->_calc['resolution'] = intval($this->get_rule('resolution'));
        $this->_calc['vote'] = $this->get_rule('vote');
        $this->_calc['vote_limit'] = $this->get_rule('vote_limit');

        $this->_calc['votes'] = intval(gdrts_single()->item()->get('stars-rating_votes', 0));
        $this->_calc['sum'] = gdrts_single()->item()->get('stars-rating_sum', 0);
        $this->_calc['max'] = gdrts_single()->item()->get('stars-rating_max', 0);
        $this->_calc['rating'] = number_format(gdrts_single()->item()->get('stars-rating_rating', 0), gdrts_settings()->get('decimal_round'));
        $this->_calc['distribution'] = gdrts_single()->item()->get('stars-rating_distribution', $this->distribution_array($this->_calc['max']));

        if ($this->_calc['votes'] > 0 && $this->_calc['max'] != $this->_calc['stars']) {
            $factor = $this->_calc['stars'] / $this->_calc['max'];

            $this->_calc['sum'] = $this->_calc['sum'] * $factor;
            $this->_calc['rating'] = $this->_calc['rating'] * $factor;
            $this->_calc['max'] = $this->_calc['stars'];

            $new_dist = array();

            foreach ($this->_calc['distribution'] as $key => $value) {
                $new_key = number_format(round(floatval($key) * $factor, 2), 2);
                $new_dist[$new_key] = $value;
            }

            $this->_calc['distribution'] = $new_dist;
        }

        $this->_calc['allowed'] = $this->user()->is_allowed();
        $this->_calc['open'] = false;

        $this->_calc = apply_filters('gdrts_stars_rating_loop_single_calc', $this->_calc, $this->prefix);

        $this->_calc['current'] = intval(100 * ($this->_calc['rating'] / $this->_calc['stars']));
        $this->_calc['current_own'] = 0;

        if ($this->user()->has_voted()) {
            $vote = $this->user()->previous_vote();

            $this->_calc['current_own'] = intval(100 * ($vote->meta->vote / $vote->meta->max));
        }

        if (gdrts()->is_locked()) {
            $this->_calc['open'] = false;
        } else if (!gdrts_single()->is_loop_save()) {
            $this->_calc['open'] = $this->user()->is_open($this->_calc['vote'], $this->_calc['vote_limit']);
        }

        gdrts_single()->set_method_args($this->_args);
    }

    public function json_list($data, $method) {
        if ($method == $this->method()) {
            $data['stars'] = array(
                'max' => $this->_calc['stars'],
                'char' => $this->_args['style_type'] == 'font' ? gdrts()->font[$this->_args['style_name']] : '',
                'name' => $this->_args['style_name'],
                'size' => $this->_args['style_size'],
                'type' => $this->_args['style_type'],
                'responsive' => $this->_args['responsive']
            );

            $data['labels'] = $this->labels();
        }

        return $data;
    }

    public function json_single($data, $method) {
        if ($method == $this->method()) {
            $data['stars'] = array(
                'max' => $this->_calc['stars'],
                'resolution' => $this->_calc['resolution'],
                'current' => $this->_calc['current'],
                'char' => $this->_args['style_type'] == 'font' ? gdrts()->font[$this->_args['style_name']] : '',
                'name' => $this->_args['style_name'],
                'size' => $this->_args['style_size'],
                'type' => $this->_args['style_type'],
                'responsive' => $this->_args['responsive']
            );

            $data['labels'] = $this->labels();

            $data['render']['method'] = $this->_args;
        }

        return $data;
    }

    public function distribution_array($max) {
        $dist = array();

        for ($i = 0; $i < $max; $i++) {
            $key = number_format($i + 1, 2);
            $dist[$key] = 0;
        }

        return $dist;
    }

    public function calculate($item, $action, $vote, $max = null, $previous = 0, $update_latest = true) {
        $item->prepare_save();

        $votes = intval($item->get('stars-rating_votes', 0));
        $sum = floatval($item->get('stars-rating_sum', 0));
        $max_db = intval($item->get('stars-rating_max', 0));
        $distribution = $item->get('stars-rating_distribution', $this->distribution_array($max));

        if ($votes > 0 && $max_db != $max) {
            $factor = $max / $max_db;
            $sum = $sum * $factor;

            $new_dist = array();

            foreach ($distribution as $key => $value) {
                $new_key = number_format(round(floatval($key) * $factor, 2), 2);
                $new_dist[$new_key] = $value;
            }

            $distribution = $new_dist;
        }

        $dist_vote = number_format(round($vote, 2), 2);

        if ($action == 'vote') {
            $sum = $sum + floatval($vote);
            $votes++;
        } else if ($action == 'revote') {
            $sum = $sum + floatval($vote) - floatval($previous);

            $dist_previous = number_format(round($previous, 2), 2);

            if (isset($distribution[$dist_previous])) {
                $distribution[$dist_previous] = $distribution[$dist_previous] - 1;
            }
        }

        if (!isset($distribution[$dist_vote])) {
            $distribution[$dist_vote] = 0;
        }

        $distribution[$dist_vote] = $distribution[$dist_vote] + 1;

        krsort($distribution);

        $rating = round($sum / $votes, gdrts_settings()->get('decimal_round'));

        $item->set('stars-rating_sum', $sum);
        $item->set('stars-rating_max', $max);
        $item->set('stars-rating_votes', $votes);
        $item->set('stars-rating_rating', $rating);
        $item->set('stars-rating_distribution', $distribution);

        if ($update_latest) {
            $item->set('stars-rating_latest', gdrts_db()->datetime());
        }

        $item->save($update_latest);
    }

    public function validate_vote($meta, $item, $user) {
        $this->_load_settings_rule($item->entity, $item->name);

        $vote = round(floatval($meta->value), 2);
        $max = intval($meta->max);

        $errors = new WP_Error();
        $action = '';
        $previous = 0;
        $reference = 0;

        $_calc_stars = intval($this->get_rule('stars'));
        $_calc_vote = $this->get_rule('vote');
        $_calc_vote_limit = $this->get_rule('vote_limit');

        if ($max != $_calc_stars) {
            $errors->add('request_max', __("Maximum value don't match the rule.", "gd-rating-system"));
        }

        if ($vote == 0 || $vote < 0 || $vote > $max) {
            $errors->add('request_vote', __("Vote value out of rule bounds.", "gd-rating-system"));
        }

        if (empty($errors->errors)) {
            $log = $user->get_log_item_user_method($item->item_id, $this->method());

            $votes = isset($log['vote']) ? count($log['vote']) : 0;
            $revotes = isset($log['revote']) ? count($log['revote']) : 0;

            switch ($_calc_vote) {
                case 'revote':
                    if ($_calc_vote_limit > 0 && $revotes > $_calc_vote_limit) {
                        $errors->add('request_limit', __("You reach the limit to number of vote attempts.", "gd-rating-system"));
                    } else {
                        $action = $votes == 0 ? 'vote' : 'revote';

                        $item = false;
                        if ($revotes > 0) {
                            $item = reset($log['revote']);
                            $reference = $item->log_id;
                        } else if ($votes > 0) {
                            $item = reset($log['vote']);
                            $reference = $item->log_id;
                        }

                        if ($item !== false) {
                            $previous = $item->meta->vote;

                            if ($item->meta->max != $_calc_stars) {
                                $previous = $previous * ($_calc_stars / $item->meta->max);
                            }
                        }
                    }
                    break;
                case 'multi':
                    if ($_calc_vote_limit > 0 && $votes + $revotes > $_calc_vote_limit) {
                        $errors->add('request_limit', __("You reach the limit to number of vote attempts.", "gd-rating-system"));
                    } else {
                        $action = 'vote';
                    }
                    break;
                default:
                case 'single':
                    if ($votes == 1) {
                        $errors->add('request_limit', __("You already voted.", "gd-rating-system"));
                    } else {
                        $action = 'vote';
                    }
                    break;
            }
        }

        if (empty($errors->errors)) {
            return compact('action', 'previous', 'reference');
        } else {
            return $errors;
        }
    }

    public function vote($meta, $item, $user) {
        $validation = $this->validate_vote($meta, $item, $user);

        if (is_wp_error($validation)) {
            return $validation;
        }

        extract($validation, EXTR_OVERWRITE); // $action, $previous, $reference

        $data = array(
            'ip' => $user->ip,
            'action' => $action,
            'ref_id' => $reference
        );

        $meta_data = array(
            'vote' => $meta->value,
            'max' => $meta->max
        );

        if (gdrts_settings()->get('log_vote_user_agent')) {
            $meta_data['ua'] = trim($_SERVER['HTTP_USER_AGENT']);
        }

        $log_id = gdrts_db()->add_to_log($item->item_id, $user->id, $this->method(), $data, $meta_data);

        if (!is_null($log_id)) {
            $user->update_cookie($log_id);
        }

        $this->calculate($item, $action, $meta->value, $meta->max, $previous);

        return true;
    }

    public function has_votes() {
        return $this->value('votes', false) > 0;
    }

    public function remove_vote_by_log($log) {
        $item = gdrts_get_rating_item_by_id($log->item_id);

        $item->prepare_save();

        $votes = intval($item->get('stars-rating_votes', 0));
        $sum = floatval($item->get('stars-rating_sum', 0));
        $max = intval($item->get('stars-rating_max', 0));
        $distribution = $item->get('stars-rating_distribution', $this->distribution_array($max));

        $remove = gdrts_db()->get_log_meta($log->log_id);
        $remove_vote = floatval($remove['vote']);
        $remove_max = intval($remove['max']);

        if ($remove_max != $max) {
            $remove_vote = $remove_vote * ($max / $remove_max);
        }

        $sum = $sum - $remove_vote;
        $votes--;

        $dist = number_format(round($remove_vote, 2), 2);

        if (isset($distribution[$dist])) {
            $distribution[$dist] = $distribution[$dist] - 1;
        }

        if ($log->ref_id > 0) {
            $revert = gdrts_db()->get_log_meta($log->ref_id);

            if (!empty($revert)) {
                $sum = $sum + floatval($revert['vote']);
                $votes++;
                
                $dist = number_format(round($revert['vote'], 2), 2);

                if (!isset($distribution[$dist])) {
                    $distribution[$dist] = 0;
                }

                $distribution[$dist] = $distribution[$dist] + 1;
            }
        }

        krsort($distribution);

        $rating = round($sum / $votes, gdrts_settings()->get('decimal_round'));

        $item->set('stars-rating_sum', $sum);
        $item->set('stars-rating_max', $max);
        $item->set('stars-rating_votes', $votes);
        $item->set('stars-rating_rating', $rating);
        $item->set('stars-rating_distribution', $distribution);

        $item->save();
    }

    public function rating($item) {
        $rating = array();

        if ($item->get('stars-rating_votes', 0) > 0) {
            $rating['count'] = intval($item->get('stars-rating_votes', 0));
            $rating['best'] = intval($item->get('stars-rating_max', 0));
            $rating['value'] = number_format($item->get('stars-rating_rating', 0), gdrts_settings()->get('decimal_round'));
        }

        return $rating;
    }
}

global $_gdrts_method_stars_rating;
$_gdrts_method_stars_rating = new gdrts_method_stars_rating();

function gdrtsm_stars_rating() {
    global $_gdrts_method_stars_rating;
    return $_gdrts_method_stars_rating;
}
