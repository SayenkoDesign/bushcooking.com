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

    $prep_hours = get_field('prep_time_hours');
    $prep_minutes = get_field('prep_time_minutes');
    $prep_total_minutes = $prep_hours * 60 + $prep_minutes;
    $cook_hours = get_field('cook_time_hours');
    $cook_minutes = get_field('cook_time_minutes');
    $cook_total_minutes = $cook_hours * 60 + $cook_minutes;
    $total = $prep_total_minutes + $cook_total_minutes;
    $total_hours = floor($total / 60);
    $total_minutes = ($total % 60);
    $total_total = $total_hours * 60 + $total_minutes;

    $recipes[] = $app->render('partials/recipe-teaser.html.twig', [
        'rating' => $rating,
        'rating_count' => $ratings_count,
        'prep_hours' => $prep_hours,
        'prep_minutes' => $prep_minutes,
        'prep_total_minutes' => $prep_total_minutes,
        'cook_hours' => $cook_hours,
        'cook_minutes' => $cook_minutes,
        'cook_total_minutes' => $cook_total_minutes,
        'total_hours' => $total_hours,
        'total_minutes' => $total_minutes,
        'total_total_minutes' => $total_minutes,
    ]);
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
$bottom_articles = array_slice($articles, 4, 4);

echo $app->render('pages/home.html.twig', [
    'rev_slider' => $slider,
    'recipes' => $recipes,
    'top_articles' => $top_articles,
    'bottom_articles' => $bottom_articles,
]);
get_footer();