<?php
get_header();
global $app;
$slider = do_shortcode('[rev_slider alias="home"]');

$args = [
    'post_type' => 'recipes',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'caller_get_posts'=> 1
];
$query = new WP_Query($args);
$recipes = [];
while ( $query->have_posts() ) {
    $query->the_post();
    $recipes[] = $app->render('partials/recipe-teaser.html.twig', [

    ]);
}

$articles = [];
while ( $query->have_posts() ) {
    $query->the_post();
    $articles[] = $app->render('partials/article-teaser.html.twig', [

    ]);
}

echo $app->render('pages/home.html.twig', [
    'rev_slider' => $slider,
    'recipes' => $recipes,
    'articles' => $articles,
]);
get_footer();