<?php
/**
 * Handle the recipe metadata.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe metadata.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Metadata {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
	}

	/**
	 * Get the metadata to output for a recipe.
	 *
	 * @since    1.0.0
	 * @param		 object $recipe Recipe to get the metadata for.
	 */
	public static function get_metadata_output( $recipe ) {
		$metadata = self::sanitize_metadata( self::get_metadata( $recipe ) );
		return '<script type="application/ld+json">' . wp_json_encode( $metadata ) . '</script>';
	}

	/**
	 * Santize metadata before outputting.
	 *
	 * @since    1.5.0
	 * @param		 mixed $metadata Metadata to sanitize.
	 */
	public static function sanitize_metadata( $metadata ) {
		$sanitized = array();
		if ( is_array( $metadata ) ) {
			foreach ( $metadata as $key => $value ) {
				$sanitized[ $key ] = self::sanitize_metadata( $value );
			}
		} else {
			$sanitized = strip_shortcodes( wp_strip_all_tags( do_shortcode( $metadata ) ) );
		}
		return $sanitized;
	}

	/**
	 * Get the metadata for a recipe.
	 *
	 * @since    1.0.0
	 * @param		 object $recipe Recipe to get the metadata for.
	 */
	public static function get_metadata( $recipe ) {
		// Essentials.
		$metadata = array(
			'@context' => 'http://schema.org/',
			'@type' => 'Recipe',
			'name' => $recipe->name(),
			'author' => array(
				'@type' => 'Person',
				'name' => $recipe->author_meta(),
			),
			'datePublished' => $recipe->date(),
			'image' => $recipe->image_url( 'full' ),
			'description' => wp_strip_all_tags( $recipe->summary() ),
		);

		// Yield.
		if ( $recipe->servings() ) {
			$metadata['recipeYield'] = $recipe->servings() . ' ' . $recipe->servings_unit();
		}

		// Times.
		if ( $recipe->prep_time() ) {
			$metadata['prepTime'] = 'PT' . $recipe->prep_time() . 'M';
		}
		if ( $recipe->cook_time() ) {
			$metadata['cookTime'] = 'PT' . $recipe->cook_time() . 'M';
		}
		if ( $recipe->total_time() ) {
			$metadata['totalTime'] = 'PT' . $recipe->total_time() . 'M';
		}

		// Ingredients.
		$ingredients = $recipe->ingredients_without_groups();
		if ( count( $ingredients ) > 0 ) {
			$metadata_ingredients = array();

			foreach ( $ingredients as $ingredient ) {
				$metadata_ingredient = $ingredient['amount'] . ' ' . $ingredient['unit'] . ' ' . $ingredient['name'];
				if ( trim( $ingredient['notes'] ) !== '' ) {
					$metadata_ingredient .= ' (' . $ingredient['notes'] . ')';
				}

				$metadata_ingredients[] = $metadata_ingredient;
			}

			$metadata['recipeIngredient'] = $metadata_ingredients;
		}

		// Instructions.
		$instructions = $recipe->instructions_without_groups();
		if ( count( $instructions ) > 0 ) {
			$metadata_instructions = array();

			foreach ( $instructions as $instruction ) {
				$metadata_instructions[] = wp_strip_all_tags( $instruction['text'] );
			}

			$metadata['recipeInstructions'] = $metadata_instructions;
		}

		// Category & Cuisine.
		$courses = $recipe->tags( 'course' );
		if ( count( $courses ) > 0 ) {
			$metadata['recipeCategory'] = wp_list_pluck( $courses, 'name' );
		}
		$cuisines = $recipe->tags( 'cuisine' );
		if ( count( $cuisines ) > 0 ) {
			$metadata['recipeCuisine'] = wp_list_pluck( $cuisines, 'name' );
		}

		// Nutrition.
		$nutrition_mapping = array(
			'serving_size' => 'servingSize',
			'calories' => 'calories',
			'fat' => 'fatContent',
			'saturated_fat' => 'saturatedFatContent',
			'unsaturated_fat' => 'unsaturatedFatContent',
			'trans_fat' => 'transFatContent',
			'carbohydrates' => 'carbohydrateContent',
			'sugar' => 'sugarContent',
			'fiber' => 'fiberContent',
			'protein' => 'proteinContent',
			'cholesterol' => 'cholesterolContent',
			'sodium' => 'sodiumContent',
		);
		$nutrition_metadata = array();
		$nutrition = $recipe->nutrition();

		// Calculate unsaturated fat.
		if ( isset( $nutrition['polyunsaturated_fat'] ) && isset( $nutrition['monounsaturated_fat'] ) ) {
			$nutrition['unsaturated_fat'] = $nutrition['polyunsaturated_fat'] + $nutrition['monounsaturated_fat'];
		} elseif ( isset( $nutrition['polyunsaturated_fat'] ) ) {
			$nutrition['unsaturated_fat'] = $nutrition['polyunsaturated_fat'];
		} elseif ( isset( $nutrition['monounsaturated_fat'] ) ) {
			$nutrition['unsaturated_fat'] = $nutrition['monounsaturated_fat'];
		}

		foreach ( $nutrition as $field => $value ) {
			if ( $value && array_key_exists( $field, $nutrition_mapping ) ) {
				$unit = esc_html__( 'g', 'wp-recipe-maker' );

				if ( 'serving_size' === $field && $nutrition['serving_unit'] ) {
					$unit = $nutrition['serving_unit'];
				} elseif ( 'calories' === $field ) {
					$unit = esc_html__( 'kcal', 'wp-recipe-maker' );
				} elseif ( 'cholesterol' === $field || 'sodium' === $field ) {
					$unit = esc_html__( 'mg', 'wp-recipe-maker' );
				}

				$nutrition_metadata[ $nutrition_mapping[ $field ] ] = $value . ' ' . $unit;
			}
		}

		if ( count( $nutrition_metadata ) > 0 ) {
			if ( ! isset( $nutrition_metadata['servingSize'] ) ) {
				$nutrition_metadata['servingSize'] = esc_html__( '1 serving', 'wp-recipe-maker' );
			}

			$metadata['nutrition'] = array_merge( array(
				'@type' => 'NutritionInformation',
			), $nutrition_metadata );
		}

		// Rating.
		$rating = $recipe->rating();
		if ( $rating['count'] > 0 ) {
			$metadata['aggregateRating'] = array(
				'@type' => 'AggregateRating',
				'ratingValue' => $rating['average'],
				'ratingCount' => $rating['count'],
			);
		}

		// Allow external filtering of metadata.
		return apply_filters( 'wprm_recipe_metadata', $metadata, $recipe );
	}
}

WPRM_Metadata::init();
