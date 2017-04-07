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
		switch($type = get_sub_field('row_type')) {
			case 'ingredient': $value = get_sub_field('ingredient'); break;
			case 'equipment': $value = get_sub_field('equipment'); break;
			case 'heading': $value = get_sub_field('heading'); break;
			default: $value = ''; break;
		}
		$ingredients[] = [
			'type' => $type,
			'value' => $value,
		];
	}
}

$directions = [];
if( have_rows('directions') ) {
	while (have_rows('directions')) {
		the_row();
		switch($type = get_sub_field('row_type')) {
			case 'direction': $value = get_sub_field('direction'); break;
			case 'heading': $value = get_sub_field('heading'); break;
			default: $value = ''; break;
		}
		$directions[] = [
			'type' => $type,
			'value' => $value,
		];
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

$countries = [];
$countries_terms = wp_get_post_terms(get_the_ID(), 'country', array("fields" => "all"));
if($countries_terms) {
	foreach($countries_terms as $term) {
		$countries[] = [
			'term' => $term->name,
			'link' => get_term_link($term->name, 'country')
		];
	}
}

$methods = [];
$methods_terms = wp_get_post_terms(get_the_ID(), 'cooking_method', array("fields" => "all"));
if($methods_terms) {
	foreach($methods_terms as $term) {
		$methods[] = [
			'term' => $term->name,
			'link' => get_term_link($term->name, 'cooking_method')
		];
	}
}

$ingredient_cats = [];
$ingredient_cats_terms = wp_get_post_terms(get_the_ID(), 'ingredient', array("fields" => "all"));
if($ingredient_cats_terms) {
	foreach($ingredient_cats_terms as $term) {
		$ingredient_cats[] = [
			'term' => $term->name,
			'link' => get_term_link($term->name, 'ingredient')
		];
	}
}

$equipment = [];
$equipment_terms = wp_get_post_terms(get_the_ID(), 'equipment', array("fields" => "all"));
if($equipment_terms) {
	foreach($equipment_terms as $term) {
		$equipment[] = [
			'term' => $term->name,
			'link' => get_term_link($term->name, 'equipment')
		];
	}
}

$recipe_types = [];
$recipe_types__terms = wp_get_post_terms(get_the_ID(), 'recipe_type', array("fields" => "all"));
if($recipe_types__terms) {
	foreach($recipe_types__terms as $term) {
		$recipe_types[] = [
			'term' => $term->name,
			'link' => get_term_link($term->name, 'recipe_type')
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
		'countries' => $countries,
		'cooking_methods' => $methods,
		'equipment' => $equipment,
		'recipe_types' => $recipe_types,
		'ingredient_cats' => $ingredient_cats,
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
