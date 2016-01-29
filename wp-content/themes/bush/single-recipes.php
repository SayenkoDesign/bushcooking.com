<?php
get_header();
global $app;

$slides = [];
if(get_field('slider')) {
	foreach( get_field('slider') as $slide ) {
		$slides[] = $slide;
	}
}

$ingredients = [];
if( have_rows('ingredients') ) {
	while (have_rows('ingredients')) {
		the_row();
		$ingredients[] = get_sub_field('ingredient');
	}
}

$directions = [];
if( have_rows('directions') ) {
	while (have_rows('directions')) {
		the_row();
		$directions[] = get_sub_field('direction');
	}
}

$difficulties = [];
$difficulties_terms = wp_get_post_terms(get_the_ID(), 'difficulty', array("fields" => "all"));
if($difficulties_terms) {
	foreach($difficulties_terms as $term) {
		$difficulties[] = [
			'term' => $term->name,
			'link' => get_term_link($term->name, 'difficulty')
		];
	}
}

$categories = [];
$categories_terms = wp_get_post_terms(get_the_ID(), 'food_category', array("fields" => "all"));
if($categories_terms) {
	foreach($categories_terms as $term) {
		$categories[] = [
				'term' => $term->name,
				'link' => get_term_link($term->name, 'food_category')
		];
	}
}

$related = [];
$related_posts = get_field('related');
if($related_posts) {
	foreach($related_posts as $post) {
		setup_postdata($post);
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

		$related[] = $app->render('partials/recipe-teaser.html.twig', [
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
}

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

while (have_posts()) {
	the_post();

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

	echo $app->render('pages/single-recipes.html.twig', [
		'slides' => $slides,
		'ingredients' => $ingredients,
		'directions' => $directions,
		'difficulties' => $difficulties,
		'categories' => $categories,
		'related' => $related,
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
get_footer();
