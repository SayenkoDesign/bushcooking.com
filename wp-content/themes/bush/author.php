<?php
get_header();
global $app;

$content = [];
$current_author = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$author_id = $current_author->ID;
$acf_user = 'user_'.$author_id;
$author_meta = [
    'id' => $author_id,
    'website' => get_the_author_meta('url', $author_id),
    'google' => get_the_author_meta('googleplus', $author_id),
    'twitter' => get_the_author_meta('twitter', $author_id),
    'facebook' => get_the_author_meta('facebook', $author_id),
    'linkedin' => get_the_author_meta('linkedin', $author_id),
    'pinterest' => get_the_author_meta('pinterest', $author_id),
    'instagram' => get_the_author_meta('instagram', $author_id),
    'overview' => get_field('overview', $acf_user),
    'bio' => get_field('bio', $acf_user),
    'bio_teaser' => get_field('bio_teaser', $acf_user),
    'name' => get_the_author_meta('first_name', $author_id) . ' ' . get_the_author_meta('last_name', $author_id),
    'first_name' => get_the_author_meta('first_name', $author_id),
    'last_name' => get_the_author_meta('last_name', $author_id),
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
    'author' => $author_meta,
]);
get_footer();