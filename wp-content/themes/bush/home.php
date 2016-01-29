<?php
get_header();
global $app;

$content = [];
while ( have_posts() ) {
    the_post();
    switch(get_post_type()) {
        case 'recipes':
            $comments = get_comments([
                'post_id' => get_the_ID(),
            ]);
            $ratings_total = 0;
            $ratings_count = 0;
            foreach($comments as $comment) {
                $ratings_total += get_comment_meta($comment->comment_ID, 'rating', true);
                $ratings_count++;
            }
            $rating = (!$ratings_total || !$ratings_count) ? 0 : $ratings_total / $ratings_count;
            $content[] = $app->render('partials/recipe-teaser.html.twig', ['rating' => $rating, 'rating_count' => $ratings_count]);
            break;
        case 'post':
            $content[] = $app->render('partials/article-teaser.html.twig');
            break;
        case 'page':
            $content[] = $app->render('partials/page-teaser.html.twig');
            break;
    }
}

wp_reset_postdata();
$post = get_post(get_option('page_for_posts'));
setup_postdata($post);

echo $app->render('/pages/home-blog.html.twig', [
    'content' => $content,
    'categories' => get_categories([
        "hide_empty" => 0,
        "type"      => "post",
        "orderby"   => "name",
        "order"     => "ASC"
    ]),
    'archives' => wp_get_archives([
        'type'            => 'monthly',
        'limit'           => '',
        'format'          => 'html',
        'before'          => '',
        'after'           => '',
        'show_post_count' => true,
        'echo'            => 0,
        'order'           => 'DESC',
        'post_type'     => 'post'
    ]),
]);
get_footer();