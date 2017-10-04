<?php
/**
 * Handle the recipe shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe shortcode.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Shortcode {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_shortcode( 'wprm-recipe', array( __CLASS__, 'recipe_shortcode' ) );
		add_shortcode( 'wprm-recipe-jump', array( __CLASS__, 'jump_to_recipe_shortcode' ) );
		add_shortcode( 'wprm-recipe-print', array( __CLASS__, 'print_recipe_shortcode' ) );
		add_shortcode( 'wprm-nutrition-label', array( __CLASS__, 'nutrition_label_shortcode' ) );
		add_shortcode( 'adjustable', array( __CLASS__, 'adjustable_shortcode' ) );
		add_shortcode( 'timer', array( __CLASS__, 'timer_shortcode' ) );

		add_filter( 'content_edit_pre', array( __CLASS__, 'replace_wpultimaterecipe_shortcode' ) );
		add_filter( 'content_edit_pre', array( __CLASS__, 'replace_bigoven_shortcode' ) );
		add_filter( 'content_edit_pre', array( __CLASS__, 'replace_tasty_shortcode' ) );

		add_filter( 'the_content', array( __CLASS__, 'replace_tasty_shortcode' ) );

		add_action( 'init', array( __CLASS__, 'fallback_shortcodes' ), 11 );
	}

	/**
	 * Fallback shortcodes for recipe plugins that we imported from.
	 *
	 * @since    1.3.0
	 */
	public static function fallback_shortcodes() {
		if ( ! shortcode_exists( 'seo_recipe' ) ) {
			add_shortcode( 'seo_recipe', array( __CLASS__, 'recipe_shortcode' ) );
		}

		if ( ! shortcode_exists( 'tasty-recipe' ) ) {
			add_shortcode( 'tasty-recipe', array( __CLASS__, 'recipe_shortcode' ) );
		}

		if ( ! shortcode_exists( 'ultimate-recipe' ) ) {
			add_shortcode( 'ultimate-recipe', array( __CLASS__, 'recipe_shortcode' ) );
		}

		if ( ! shortcode_exists( 'nutrition-label' ) ) {
			add_shortcode( 'nutrition-label', array( __CLASS__, 'remove_shortcode' ) );
			add_shortcode( 'ultimate-nutrition-label', array( __CLASS__, 'remove_shortcode' ) );
		}

		if ( ! shortcode_exists( 'recipe-timer' ) ) {
			add_shortcode( 'recipe-timer', array( __CLASS__, 'timer_shortcode' ) );
		}
	}

	/**
	 * Replace WP Ultimate Recipe shortcode with ours.
	 *
	 * @since    1.3.0
	 * @param		 mixed $content Content we want to filter before it gets passed along.
	 */
	public static function replace_wpultimaterecipe_shortcode( $content ) {
		preg_match_all( "/\[ultimate-recipe\s.*?id='?\"?(\d+).*?]/im", $content, $matches );
		foreach ( $matches[0] as $key => $match ) {
			if ( WPRM_POST_TYPE === get_post_type( $matches[1][ $key ] ) ) {
				$content = str_replace( $match, '[wprm-recipe id="' . $matches[1][ $key ] . '"]', $content );
			}
		}

		return $content;
	}

	/**
	 * Replace BigOven shortcode with ours.
	 *
	 * @since    1.23.0
	 * @param	 mixed $content Content we want to filter before it gets passed along.
	 */
	public static function replace_tasty_shortcode( $content ) {
		preg_match_all( "/\[tasty-recipe\s.*?id='?\"?(\d+).*?]/im", $content, $matches );
		foreach ( $matches[0] as $key => $match ) {
			if ( WPRM_POST_TYPE === get_post_type( $matches[1][ $key ] ) ) {
				$content = str_replace( $match, '[wprm-recipe id="' . $matches[1][ $key ] . '"]', $content );
			}
		}

		return $content;
	}

	/**
	 * Replace BigOven shortcode with ours.
	 *
	 * @since    1.7.0
	 * @param	 mixed $content Content we want to filter before it gets passed along.
	 */
	public static function replace_bigoven_shortcode( $content ) {
		preg_match_all( "/\[seo_recipe\s.*?id='?\"?(\d+).*?]/im", $content, $matches );
		foreach ( $matches[0] as $key => $match ) {
			if ( WPRM_POST_TYPE === get_post_type( $matches[1][ $key ] ) ) {
				$content = str_replace( $match, '[wprm-recipe id="' . $matches[1][ $key ] . '"]', $content );
			}
		}

		return $content;
	}

	/**
	 * To be used for shortcodes we want to (temporarily) remove from the content.
	 *
	 * @since    1.3.0
	 */
	public static function remove_shortcode() {
		return '';
	}

	/**
	 * Output for the recipe shortcode.
	 *
	 * @since    1.0.0
	 * @param		 array $atts Options passed along with the shortcode.
	 */
	public static function recipe_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'id' => 'random',
			'template' => '',
		), $atts, 'wprm_recipe' );

		$recipe_template = trim( $atts['template'] );

		// Get recipe.
		if ( 'random' === $atts['id'] ) {
			$posts = get_posts( array(
				'post_type' => WPRM_POST_TYPE,
				'posts_per_page' => 1,
				'orderby' => 'rand',
			) );

			$recipe_id = isset( $posts[0] ) ? $posts[0]->ID : 0;
		} elseif ( 'latest' === $atts['id'] ) {
			$posts = get_posts(array(
				'post_type' => WPRM_POST_TYPE,
				'posts_per_page' => 1,
			));

			$recipe_id = isset( $posts[0] ) ? $posts[0]->ID : 0;
		} else {
			$recipe_id = intval( $atts['id'] );
		}

		$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

		if ( $recipe ) {
			$output = '<div id="wprm-recipe-container-' . esc_attr( $recipe->id() ) . '" class="wprm-recipe-container" data-recipe-id="' . esc_attr( $recipe->id() ) . '">';

			if ( ! is_feed() ) {
				$output .= WPRM_Metadata::get_metadata_output( $recipe );
			}

			$output .= WPRM_Template_Manager::get_template( $recipe, 'single', $recipe_template );
			$output .= '</div>';
			return $output;
		} else {
			return '';
		}
	}

	/**
	 * Output for the jump to recipe shortcode.
	 *
	 * @since    1.2.0
	 * @param		 array $atts Options passed along with the shortcode.
	 */
	public static function jump_to_recipe_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'id' => '0',
			'text' => __( 'Jump to Recipe', 'wp-recipe-maker' ),
		), $atts, 'wprm_recipe_jump' );

		$recipe_id = intval( $atts['id'] );
		$text = $atts['text'];

		// Get first recipe in post content if no ID is set.
		if ( ! $recipe_id ) {
			$parent_post = get_post();
			$recipes = WPRM_Recipe_Manager::get_recipe_ids_from_content( $parent_post->post_content );

			if ( isset( $recipes[0] ) ) {
				$recipe_id = $recipes[0];
			}
		}

		if ( $recipe_id ) {
			return '<a href="#wprm-recipe-container-' . esc_attr( $recipe_id ) . '" class="wprm-jump-to-recipe-shortcode">' . esc_html( $text ) . '</a>';
		} else {
			return '';
		}
	}

	/**
	 * Output for the print recipe shortcode.
	 *
	 * @since    1.2.0
	 * @param		 array $atts Options passed along with the shortcode.
	 */
	public static function print_recipe_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'id' => '0',
			'text' => __( 'Print Recipe', 'wp-recipe-maker' ),
		), $atts, 'wprm_recipe_print' );

		$recipe_id = intval( $atts['id'] );
		$text = $atts['text'];

		// Get first recipe in post content if no ID is set.
		if ( ! $recipe_id ) {
			$parent_post = get_post();
			$recipes = WPRM_Recipe_Manager::get_recipe_ids_from_content( $parent_post->post_content );

			if ( isset( $recipes[0] ) ) {
				$recipe_id = $recipes[0];
			}
		}

		if ( $recipe_id ) {
			$url = home_url( '/wprm_print/' . $recipe_id );
			return '<a href="' . $url . '" class="wprm-print-recipe-shortcode" data-recipe-id="' . esc_attr( $recipe_id ) . '" rel="nofollow">' . esc_html( $text ) . '</a>';
		} else {
			return '';
		}
	}

	/**
	 * Output for the nutrition label shortcode.
	 *
	 * @since    1.5.0
	 * @param	 array $atts Options passed along with the shortcode.
	 */
	public static function nutrition_label_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'id' => '0',
			'align' => 'left',
		), $atts, 'wprm_nutrition_label' );

		if ( WPRM_Addons::is_active( 'premium' ) ) {
			$recipe_id = intval( $atts['id'] );
			$align = in_array( $atts['align'], array( 'center', 'right' ) ) ? $atts['align'] : 'left';

			// Get first recipe in post content if no ID is set.
			if ( ! $recipe_id ) {
				$parent_post = get_post();
				$recipes = WPRM_Recipe_Manager::get_recipe_ids_from_content( $parent_post->post_content );

				if ( isset( $recipes[0] ) ) {
					$recipe_id = $recipes[0];
				}
			}

			if ( $recipe_id ) {
				$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );
				$label = WPRMP_Nutrition_Label::nutrition_label( $recipe );

				if ( 'left' !== $align ) {
					$label = '<div class="wprm-nutrition-label-container" style="text-align: ' . $align . ';">' . $label . '</div>';
				}

				return $label;
			}
		}

		return '';
	}

	/**
	 * Output for the adjustable shortcode.
	 *
	 * @since    1.5.0
	 * @param		 array $atts 		Shortcode attributes.
	 * @param		 mixed $content Content in between the shortcodes.
	 */
	public static function adjustable_shortcode( $atts, $content ) {
		return '<span class="wprm-dynamic-quantity">' . $content . '</span>';
	}

	/**
	 * Output for the timer shortcode.
	 *
	 * @since    1.5.0
	 * @param    array $atts 	Shortcode attributes.
	 * @param	 mixed $content Content in between the shortcodes.
	 */
	public static function timer_shortcode( $atts, $content ) {
		$atts = shortcode_atts( array(
			'seconds' => '0',
			'minutes' => '0',
			'hours' => '0',
		), $atts, 'wprm_timer' );

		$seconds = intval( $atts['seconds'] );
		$minutes = intval( $atts['minutes'] );
		$hours = intval( $atts['hours'] );

		$seconds = $seconds + (60 * $minutes) + (60 * 60 * $hours);

		if ( $seconds > 0 ) {
			return '<span class="wprm-timer" data-seconds="' . esc_attr( $seconds ) . '">' . $content . '</span>';
		} else {
			return $content;
		}
	}
}

WPRM_Shortcode::init();
