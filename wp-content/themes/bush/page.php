<?php
get_header();
global $app;

while (have_posts()) {
    the_post();
    ob_start();
    the_content();
    $content = ob_get_clean();
    echo $app->render('pages/page.html.twig', [
        'content' => $content,
    ]);
}
get_footer();