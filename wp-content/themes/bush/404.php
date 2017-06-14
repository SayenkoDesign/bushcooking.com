<?php
get_header();
global $app;
echo $app->render('pages/404.html.twig');
get_footer();