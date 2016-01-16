<?php

if (!defined('ABSPATH')) exit;

class gdrts_addon_posts extends gdrts_addon {
    public $prefix = 'posts';

    public function _load_admin() {
        require_once(GDRTS_PATH.'addons/posts/admin.php');
    }

    public function core() {
        if (is_admin()) return;

        add_filter('the_content', array(&$this, 'content'));
    }

    public function content($content) {
        if (is_main_query() && is_singular()) {
            global $post;

            $item = gdrts_get_rating_item_by_post($post);

            $post_type = $post->post_type;
            $location = $item->get('posts-integration_location', 'default');
            $method = $item->get('posts-integration_method', 'default');

            if ($location == 'default') {
                $location = $this->get($post_type.'_auto_embed_location');
            }

            if ($method == 'default') {
                $method = $this->get($post_type.'_auto_embed_method');
            }

            if ($location != 'hide') {
                $rating = gdrts_posts_render_rating(array('name' => $post_type, 'id' => $post->ID, 'method' => $method));

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

global $_gdrts_addon_posts;
$_gdrts_addon_posts = new gdrts_addon_posts();

function gdrtsa_posts() {
    global $_gdrts_addon_posts;
    return $_gdrts_addon_posts;
}
