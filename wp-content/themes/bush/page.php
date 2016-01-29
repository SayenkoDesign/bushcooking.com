<?php
get_header();
global $app;

while (have_posts()) {
    the_post();
    echo $app->render('pages/page.html.twig');
}
get_footer();