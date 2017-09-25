<?php
get_header();
global $app;

//@TODO replace 104 with a var

the_post();
$slider = do_shortcode('[rev_slider alias="home"]');
ob_start();
the_content();
$content = ob_get_clean();
$id = get_the_ID();
$title = get_queried_object()->post_title;

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
    $prep_total_minutes = $prep_hours && $prep_minutes ? $prep_hours * 60 + $prep_minutes : null;
    $cook_hours = get_field('cook_time_hours');
    $cook_minutes = get_field('cook_time_minutes');
    $cook_total_minutes = $cook_hours && $cook_minutes ? $cook_hours * 60 + $cook_minutes : null;
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

$featured = [];
foreach(get_field('featured_recipes', 104) as $posts) {
    $post = $posts['featured_recipe'];
    setup_postdata($post);

    $comments = get_comments([
        'post_id' => $posts['featured_recipe']->ID,
    ]);
    $ratings_total = 0;
    $ratings_count = 0;
    foreach($comments as $comment) {
        $ratings_total += get_comment_meta($comment->comment_ID, 'rating', true);
        $ratings_count++;
    }
    $rating = (!$ratings_total || !$ratings_count) ? 0 : $ratings_total / $ratings_count;

    $prep_hours = get_field('prep_time_hours', $posts['featured_recipe']->ID);
    $prep_minutes = get_field('prep_time_minutes', $posts['featured_recipe']->ID);
    $prep_total_minutes = $prep_hours && $prep_minutes ? $prep_hours * 60 + $prep_minutes : null;
    $cook_hours = get_field('cook_time_hours', $posts['featured_recipe']->ID);
    $cook_minutes = get_field('cook_time_minutes', $posts['featured_recipe']->ID);
    $cook_total_minutes = $cook_hours && $cook_minutes ? $cook_hours * 60 + $cook_minutes : null;
    $total = $prep_total_minutes + $cook_total_minutes;
    $total_hours = floor($total / 60);
    $total_minutes = ($total % 60);
    $total_total = $total_hours * 60 + $total_minutes;

    $featured[] = $app->render('partials/recipe-teaser.html.twig', [
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
wp_reset_postdata();

$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
];
$query = new WP_Query($args);
$recent = [];
while ($query->have_posts()) {
    $query->the_post();
    $recent[] = get_post();
}
wp_reset_postdata();

$blogs = [];
$recent_counter = 0;
foreach(get_field('blog_posts', 104) as $posts) {
    $post = $posts['blog_post'];
    if(!$post) {
        $post = $recent[$recent_counter++];
    }
    setup_postdata($post);

    $blogs[] = $app->render('partials/article-teaser.html.twig');
}
wp_reset_postdata();

$techniques = [];
foreach(get_field('technique_posts', 104) as $posts) {
    $post = $posts['technique_post'];
    setup_postdata($post);

    $techniques[] = $app->render('partials/article-teaser.html.twig');
}
wp_reset_postdata();

echo $app->render('pages/home.html.twig', [
    'rev_slider' => $slider,
    'recipes' => $recipes,
    'featured_recipes' => $featured,
    'featured_recipes_title' => get_field('featured_recipes_title', 104),
    'featured_recipes_url' => get_field('featured_recipes_url', 104),
    'blogs' => $blogs,
    'blogs_title' => get_field('blog_posts_title', 104),
    'blogs_url' => get_field('blog_posts_url', 104),
    'techniques' => $techniques,
    'techniques_title' => get_field('techniques_title', 104),
    'techniques_url' => get_field('techniques_url', 104),
    'content' => $content,
    'title' => $title,
]);
get_footer();