<?php
get_header();
global $app;


$related = [];
$related_posts = get_field('related');
if($related_posts) {
    foreach($related_posts as $post) {
        setup_postdata($post);
        $related[] = $app->render('partials/article-teaser.html.twig');
    }
    wp_reset_postdata();
}

while (have_posts()) {
    the_post();
    echo $app->render('pages/single-post.html.twig', [
        'related' => $related,
        'categories' => get_the_category()
    ]);
}
get_footer();