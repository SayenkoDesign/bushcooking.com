<?php
get_header();
global $app;
$slider = do_shortcode('[rev_slider alias="home"]');

$args = [
    'post_type' => 'recipes',
    'post_status' => 'publish',
    'posts_per_page' => 4,
];
$query = new WP_Query($args);
$recipes = [];
while ( $query->have_posts() ) {
    $query->the_post();
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
    $recipes[] = $app->render('partials/recipe-teaser.html.twig', ['rating' => $rating]);
}

$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 8,
];
$query = new WP_Query($args);
$articles = [];
while ( $query->have_posts() ) {
    $query->the_post();
    $articles[] = $app->render('partials/article-teaser.html.twig');
}

$top_articles = array_slice($articles, 0, 4);
$bottom_articles = array_slice($articles, 3, 4);

echo $app->render('pages/home.html.twig', [
    'rev_slider' => $slider,
    'recipes' => $recipes,
    'top_articles' => $top_articles,
    'bottom_articles' => $bottom_articles,
]);
get_footer();