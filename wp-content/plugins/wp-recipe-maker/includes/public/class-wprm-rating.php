<?php
/**
 * Calculate and store the recipe rating.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.22.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Calculate and store the recipe rating.
 *
 * @since      1.22.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Rating {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.22.0
	 */
	public static function init() {
		add_action( 'comment_post', array( __CLASS__, 'check_for_comment_rating' ), 11 );
		add_action( 'edit_comment', array( __CLASS__, 'check_for_comment_rating' ), 11 );
		add_action( 'transition_comment_status', array( __CLASS__, 'check_for_comment_rating_on_transition' ), 10, 3 );
	}

	/**
	 * Check if comment is getting approved.
	 *
	 * @since    1.22.0
	 * @param	 mixed $new_status New status of the comment.
	 * @param	 mixed $old_status Old status of the comment.
	 * @param	 mixed $comment    Comment object.
	 */
	public static function check_for_comment_rating_on_transition( $new_status, $old_status, $comment ) {
		self::check_for_comment_rating( $comment->comment_ID );
	}

	/**
	 * Check if there is a comment rating.
	 *
	 * @since    1.22.0
	 * @param	 mixed $comment_id ID of the comment we need to check for rating.
	 */
	public static function check_for_comment_rating( $comment_id ) {
		$comment_rating = intval( get_comment_meta( $comment_id, 'wprm-comment-rating', true ) );

		if ( $comment_rating ) {
			$comment = get_comment( $comment_id );
			$post_id = $comment->comment_post_ID;
			$post_content = get_post_field( 'post_content', $post_id );

			$recipe_ids = WPRM_Recipe_Manager::get_recipe_ids_from_content( $post_content );

			if ( count( $recipe_ids ) > 0 ) {
				foreach ( $recipe_ids as $recipe_id ) {
					self::update_recipe_rating( $recipe_id );
				}
			}
		}
	}

	/**
	 * Update the rating for a specific recipe.
	 *
	 * @since    1.22.0
	 * @param	 int $recipe_id Recipe ID to to update the rating for.
	 */
	public static function update_recipe_rating( $recipe_id ) {
		$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );
		$rating = array(
			'count' => 0,
			'total' => 0,
			'average' => 0,
		);

		// Get comment ratings.
		$comments = get_approved_comments( $recipe->parent_post_id() );

		foreach ( $comments as $comment ) {
			$comment_rating = intval( get_comment_meta( $comment->comment_ID, 'wprm-comment-rating', true ) );

			if ( $comment_rating ) {
				$rating['count']++;
				$rating['total'] += $comment_rating;
			} else {
				// Check for EasyRecipe or WP Tasty rating.
				$comment_rating = intval( get_comment_meta( $comment->comment_ID, 'ERRating', true ) );

				if ( $comment_rating ) {
					$rating['count']++;
					$rating['total'] += $comment_rating;

					// This should be migrated.
					update_comment_meta( $comment->comment_ID, 'wprm-comment-rating', $comment_rating );
				}
			}
		}

		// Get user ratings.
		$user_ratings = get_post_meta( $recipe_id, 'wprm_user_ratings' );

		foreach ( $user_ratings as $user_rating ) {
			$rating['count']++;
			$rating['total'] += $user_rating['rating'];
		}

		if ( $rating['count'] > 0 ) {
			 $rating['average'] = ceil( $rating['total'] / $rating['count'] * 100 ) / 100;
		}

		// Update recipe rating and average (to sort by).
		update_post_meta( $recipe_id, 'wprm_rating', $rating );
		update_post_meta( $recipe_id, 'wprm_rating_average', $rating['average'] );

		// Update parent post with rating data (TODO account for multiple recipes in a post).
		update_post_meta( $recipe->parent_post_id(), 'wprm_rating', $rating );
		update_post_meta( $recipe->parent_post_id(), 'wprm_rating_average', $rating['average'] );

		return $rating;
	}
}

WPRM_Rating::init();
