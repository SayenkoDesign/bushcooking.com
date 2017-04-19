<?php
get_header();
global $app;

$content = [];
$author_id = get_the_author_meta('ID');
$acf_user = 'user_'.$author;
$author = [
    'id' => $author_id,
    'website' => get_the_author_meta('url'),
    'google' => get_the_author_meta('googleplus'),
    'twitter' => get_the_author_meta('twitter'),
    'facebook' => get_the_author_meta('facebook'),
    'linkedin' => get_the_author_meta('linkedin'),
    'pinterest' => get_the_author_meta('pinterest'),
    'instagram' => get_the_author_meta('instagram'),
    'overview' => get_field('overview', $acf_user),
    'bio' => get_field('bio', $acf_user),
    'bio_teaser' => get_field('bio_teaser', $acf_user),
    'name' => get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name'),
    'first_name' => get_the_author_meta('first_name'),
    'last_name' => get_the_author_meta('last_name'),
];
$args = [
    'post_type' => 'recipes' ,
    'author' => get_queried_object_id(),
    'posts_per_page' => 12,
    'paged' => $paged
];
$custom_posts = new WP_Query( $args );
while ($custom_posts->have_posts()) {
    $custom_posts->the_post();
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

            $content[] = $app->render('partials/recipe-teaser.html.twig', [
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
$post = get_post(131);
setup_postdata($post);
echo $app->render('pages/author.html.twig', [
    'content' => $content,
    'author' => $author,
]);
get_footer();