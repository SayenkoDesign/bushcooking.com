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
    $recipes[] = $app->render('partials/recipe-teaser.html.twig');
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