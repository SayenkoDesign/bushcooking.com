<?php
/**
 * Providing helper functions to use in the recipe template.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.5.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Providing helper functions to use in the recipe template.
 *
 * @since      1.5.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Template_Helper {

	/**
	 * Cached version of the labels once they have been requested.
	 *
	 * @since    1.10.0
	 * @access   private
	 * @var      array    $recipes    Array containing recipes that have already been requested for easy access.
	 */
	private static $labels = array();

	/**
	 * Display a label that can be changed in the settings.
	 *
	 * @since    1.10.0
	 * @param	 mixed $uid 	UID of the label.
	 * @param	 mixed $default Default text for the label.
	 */
	public static function label( $uid, $default = '' ) {
		$uid = sanitize_key( $uid );
		$labels = self::get_labels();

		if ( ! isset( $labels[ $uid ] ) ) {
			$labels[ $uid ] = $default;
			self::update_labels( $labels );
		}

		return $labels[ $uid ];
	}

	/**
	 * Get all the labels.
	 *
	 * @since    1.10.0
	 */
	public static function get_labels() {
		// Lazy load labels.
		if ( empty( self::$labels ) ) {
			$default_labels = self::get_default_labels();
			$saved_labels = get_option( 'wprm_labels', array() );

			self::$labels = array_merge( $default_labels, $saved_labels );
		}

		return self::$labels;
	}

	/**
	 * Get the default labels.
	 *
	 * @since    1.10.0
	 */
	public static function get_default_labels() {
		$defaults = array(
			'print_button' => __( 'Print', 'wp-recipe-maker' ),
			'course_tags' => __( 'Course', 'wp-recipe-maker' ),
			'cuisine_tags' => __( 'Cuisine', 'wp-recipe-maker' ),
			'prep_time' => __( 'Prep Time', 'wp-recipe-maker' ),
			'cook_time' => __( 'Cook Time', 'wp-recipe-maker' ),
			'total_time' => __( 'Total Time', 'wp-recipe-maker' ),
			'servings' => __( 'Servings', 'wp-recipe-maker' ),
			'calories' => __( 'Calories', 'wp-recipe-maker' ),
			'author' => __( 'Author', 'wp-recipe-maker' ),
			'ingredients' => __( 'Ingredients', 'wp-recipe-maker' ),
			'instructions' => __( 'Instructions', 'wp-recipe-maker' ),
			'notes' => __( 'Recipe Notes', 'wp-recipe-maker' ),
			'comment_rating' => __( 'Recipe Rating', 'wp-recipe-maker' ),
		);

		return apply_filters( 'wprm_label_defaults', $defaults );
	}

	/**
	 * Update the labels.
	 *
	 * @since    1.10.0
	 * @param	 array $labels_to_update Labels to update.
	 */
	public static function update_labels( $labels_to_update ) {
		$labels = self::get_labels();

		if ( is_array( $labels_to_update ) ) {
			$labels = array_merge( $labels, $labels_to_update );
		}

		update_option( 'wprm_labels', $labels );
		self::$labels = $labels;
	}

	/**
	 * Display the ingredient name with or without link.
	 *
	 * @since    1.5.0
	 * @param		 array   $ingredient Ingredient to display.
	 * @param		 boolean $show_link  Wether to display the ingredient link if present.
	 */
	public static function ingredient_name( $ingredient, $show_link = false ) {
		$name = $ingredient['name'];
		$show_link = WPRM_Addons::is_active( 'premium' ) ? $show_link : false;

		$link = array();
		if ( $show_link ) {
			$link = isset( $ingredient['link'] ) ? $ingredient['link'] : WPRMP_Ingredient_Links::get_ingredient_link( $ingredient['id'] );
		}

		if ( isset( $link['url'] ) && $link['url'] ) {
			$target = WPRM_Settings::get( 'ingredient_links_open_in_new_tab' ) ? ' target="_blank"' : '';

			// Nofollow.
			switch ( $link['nofollow'] ) {
				case 'follow':
					$nofollow = '';
					break;
				case 'nofollow':
					$nofollow = ' rel="nofollow"';
					break;
				default:
					$nofollow = WPRM_Settings::get( 'ingredient_links_use_nofollow' ) ? ' rel="nofollow"' : '';
			}

			return '<a href="' . $link['url'] . '"' . $target . $nofollow . '>' . $name . '</a>';
		} else {
			return $name;
		}
	}

	/**
	 * Display formatted time.
	 *
	 * @since    1.6.0
	 * @param	 mixed   $type Type of time we're displaying.
	 * @param	 int     $time Total minutes of time to display.
	 * @param    boolean $shorthand Wether to use shorthand for the unit text.
	 */
	public static function time( $type, $time, $shorthand ) {
		$days = floor( $time / (24 * 60) );
		$hours = floor( ( $time - $days * 24 * 60 ) / 60 );
		$minutes = ( $time - $days * 24 * 60 ) % 60;

		$output = '';

		if ( $days > 0 ) {
			$output .= '<span class="wprm-recipe-details wprm-recipe-details-days wprm-recipe-' . $type . ' wprm-recipe-' . $type . '-days">';
			$output .= $days;
			$output .= '</span> <span class="wprm-recipe-details-unit wprm-recipe-details-unit-days wprm-recipe-' . $type . '-unit wprm-recipe-' . $type . 'unit-days">';

			if ( $shorthand ) {
				$output .= $days > 1 ? __( 'd', 'wp-recipe-maker' ) : __( 'd', 'wp-recipe-maker' );
			} else {
				$output .= $days > 1 ? __( 'days', 'wp-recipe-maker' ) : __( 'day', 'wp-recipe-maker' );
			}

			$output .= '</span>';
		}

		if ( $hours > 0 ) {
			if ( $days > 0 ) {
				$output .= ' ';
			}
			$output .= '<span class="wprm-recipe-details wprm-recipe-details-hours wprm-recipe-' . $type . ' wprm-recipe-' . $type . '-hours">';
			$output .= $hours;
			$output .= '</span> <span class="wprm-recipe-details-unit wprm-recipe-details-unit-hours wprm-recipe-' . $type . '-unit wprm-recipe-' . $type . 'unit-hours">';

			if ( $shorthand ) {
				$output .= $hours > 1 ? __( 'hr', 'wp-recipe-maker' ) : __( 'hrs', 'wp-recipe-maker' );
			} else {
				$output .= $hours > 1 ? __( 'hours', 'wp-recipe-maker' ) : __( 'hour', 'wp-recipe-maker' );
			}

			$output .= '</span>';
		}

		if ( $minutes > 0 ) {
			if ( $days > 0 || $hours > 0 ) {
				$output .= ' ';
			}
			$output .= '<span class="wprm-recipe-details wprm-recipe-details-minutes wprm-recipe-' . $type . ' wprm-recipe-' . $type . '-minutes">';
			$output .= $minutes;
			$output .= '</span> <span class="wprm-recipe-details-unit wprm-recipe-details-minutes wprm-recipe-' . $type . '-unit wprm-recipe-' . $type . 'unit-minutes">';

			if ( $shorthand ) {
				$output .= $minutes > 1 ? __( 'mins', 'wp-recipe-maker' ) : __( 'min', 'wp-recipe-maker' );
			} else {
				$output .= $minutes > 1 ? __( 'minutes', 'wp-recipe-maker' ) : __( 'minute', 'wp-recipe-maker' );
			}

			$output .= '</span>';
		}

		return $output;
	}

	/**
	 * Display the recipe rating as stars.
	 *
	 * @since    1.6.0
	 * @param    array 	 $rating       Rating to display.
	 * @param    boolean $show_details Wether to display the rating details.
	 */
	public static function rating_stars( $rating, $show_details = false ) {
		$rating_value = ceil( $rating['average'] );

		$output = '<div class="wprm-recipe-rating">';
		for ( $i = 1; $i <= 5; $i++ ) {
			$output .= '<span class="wprm-rating-star">';
			if ( $i <= $rating_value ) {
				ob_start();
				include( WPRM_DIR . 'assets/icons/star-full.svg' );
				$output .= ob_get_contents();
				ob_end_clean();
			} else {
				ob_start();
				include( WPRM_DIR . 'assets/icons/star-empty.svg' );
				$output .= ob_get_contents();
				ob_end_clean();
			}
			$output .= '</span>';
		}

		if ( $show_details ) {
			$output .= '<div class="wprm-recipe-rating-details" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><span itemprop="ratingValue">' . $rating['average'] . '</span> ' . __( 'from', 'wp-recipe-maker' ) . ' <span itemprop="ratingCount">' . $rating['count'] . '</span> ' . _n( 'vote', 'votes', $rating['count'], 'wp-recipe-maker' ) . '</div>';
		} else {
			$output .= '<div class="wprm-recipe-rating-details-meta" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
			$output .= '<meta itemprop="ratingValue" content="' . $rating['average'] . '">';
			$output .= '<meta itemprop="ratingCount" content="' . $rating['count'] . '">';
			$output .= '</div>';
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Display the nutrition label.
	 *
	 * @since    1.10.0
	 * @param    int   $recipe_id Recipe ID of the label we want to display.
	 * @param    mixed $align     Optional alignment for the nutrition label.
	 */
	public static function nutrition_label( $recipe_id = 0, $align = 'left' ) {
		$label = '';
		if ( WPRM_Settings::get( 'show_nutrition_label' ) ) {
			$label = '[wprm-nutrition-label id="' . $recipe_id . '" align="' . $align . '"]';
		}
		return $label;
	}

	/**
	 * Metadata to add for tags.
	 *
	 * @since    1.10.0
	 * @param    mixed $key Tag we're adding the metadata for.
	 */
	public static function tags_meta( $key ) {
		$meta = '';
		if ( 'course' === $key ) {
			$meta = ' itemprop="recipeCategory"';
		} elseif ( 'cuisine' === $key ) {
			$meta = ' itemprop="recipeCuisine"';
		}

		return $meta;
	}

	/**
	 * Replace placeholders in text with recipe values.
	 *
	 * @since    1.16.0
	 * @param    mixed $recipe Recipe to replace the placeholders for.
	 * @param    mixed $text   Text to replace the placeholders in.
	 */
	public static function recipe_placeholders( $recipe, $text ) {
		$text = str_ireplace( '%recipe_url%', $recipe->parent_url(), $text );
		$text = str_ireplace( '%recipe_name%', $recipe->name(), $text );

		return $text;
	}

	/**
	 * Output the recipe image.
	 *
	 * @since    1.16.0
	 * @param    mixed $recipe Recipe to output the image for.
	 * @param    mixed $size   Default size to output.
	 */
	public static function recipe_image( $recipe, $size ) {
		$settings_size = WPRM_Settings::get( 'template_recipe_image' );

		if ( $settings_size ) {
			preg_match( '/^(\d+)x(\d+)$/i', $settings_size, $match );
			if ( ! empty( $match ) ) {
				$size = array( intval( $match[1] ), intval( $match[2] ) );
			} else {
				$size = $settings_size;
			}
		}

		return $recipe->image( $size );
	}

	/**
	 * Output an instruction image.
	 *
	 * @since    1.16.0
	 * @param    mixed $instruction Instruction to output the image for.
	 * @param    mixed $size        Default size to output.
	 */
	public static function instruction_image( $instruction, $size ) {
		$settings_size = WPRM_Settings::get( 'template_instruction_image' );

		if ( $settings_size ) {
			preg_match( '/^(\d+)x(\d+)$/i', $settings_size, $match );
			if ( ! empty( $match ) ) {
				$size = array( intval( $match[1] ), intval( $match[2] ) );
			} else {
				$size = $settings_size;
			}
		}

		return wp_get_attachment_image( $instruction['image'], $size );
	}
}
