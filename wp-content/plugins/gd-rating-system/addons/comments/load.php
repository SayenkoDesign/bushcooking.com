<?php

if (!defined('ABSPATH')) exit;

class gdrts_addon_comments extends gdrts_addon {
    public $prefix = 'comments';

    public function _load_admin() {
        require_once(GDRTS_PATH.'addons/comments/admin.php');
    }

    public function core() {
        if (is_admin()) return;

        add_filter('comment_text', array(&$this, 'content'));
    }

    public function content($content) {
        if (is_main_query() && is_singular()) {
            $location = $this->get('comments_auto_embed_location');
            $method = $this->get('comments_auto_embed_method');

            if ($location != 'hide') {
                $rating = gdrts_comments_render_rating(array('method' => $method));

                if ($location == 'top' || $location == 'both') {
                    $content = $rating.$content;
                }

                if ($location == 'bottom' || $location == 'both') {
                    $content.= $rating;
                }
            }
        }

        return $content;
    }
}

global $_gdrts_addon_comments;
$_gdrts_addon_comments = new gdrts_addon_comments();

function gdrtsa_comments() {
    global $_gdrts_addon_comments;
    return $_gdrts_addon_comments;
}

