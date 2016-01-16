<?php

if (!defined('ABSPATH')) exit;

function gdrts_posts_render_rating($args = array(), $method = array()) {
    $defaults = array(
        'echo' => false,
        'name' => '', 
        'id' => null, 
        'method' => 'stars-rating'
    );

    $args = wp_parse_args($args, $defaults);

    if (is_null($args['id']) || $args['id'] == 0) {
        $args['id'] = get_post()->ID;
        $args['name'] = get_post()->post_type;
    }

    $args['entity'] = 'posts';

    return gdrts_render_rating($args, $method);
}

function gdrts_comments_render_rating($args = array(), $method = array()) {
    $defaults = array(
        'echo' => false,
        'name' => 'comment', 
        'id' => null, 
        'method' => 'stars-rating'
    );

    $args = wp_parse_args($args, $defaults);

    if (is_null($args['id']) || $args['id'] == 0) {
        $comment = get_comment();

        $args['id'] = $comment->comment_ID;
        $args['name'] = $comment->comment_type == '' ? 'comment' : $comment->comment_type;
    }

    $args['entity'] = 'comments';

    return gdrts_render_rating($args, $method);
}
