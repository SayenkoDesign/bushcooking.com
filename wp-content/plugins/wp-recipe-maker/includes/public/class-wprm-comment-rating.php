<?php
/**
 * Allow visitors to rate the recipe in the comment.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Allow visitors to rate the recipe in the comment.
 *
 * @since      1.1.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Comment_Rating {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.1.0
	 */
	public static function init() {
		add_filter( 'comment_text', array( __CLASS__, 'add_stars_to_comment' ), 10, 2 );

		add_action( 'init', array( __CLASS__, 'wpdiscuz_compatibility' ) );
		add_action( 'wpdiscuz_button', array( __CLASS__, 'add_rating_field_to_comments' ) );
		add_action( 'comment_form_after_fields', array( __CLASS__, 'add_rating_field_to_comments' ) );
		add_action( 'comment_form_logged_in_after', array( __CLASS__, 'add_rating_field_to_comments' ) );
		add_action( 'add_meta_boxes_comment', array( __CLASS__, 'add_rating_field_to_admin_comments' ) );

		add_action( 'comment_post', array( __CLASS__, 'save_comment_rating' ) );
		add_action( 'edit_comment', array( __CLASS__, 'save_admin_comment_rating' ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin' ) );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.1.0
	 */
	public static function enqueue() {
		wp_enqueue_script( 'wprm-comment-rating', WPRM_URL . 'assets/js/public/comment-rating.js', array( 'jquery' ), WPRM_VERSION, true );
	}

	/**
	 * Enqueue stylesheets and scripts for admin.
	 *
	 * @since    1.1.0
	 */
	public static function enqueue_admin() {
		wp_enqueue_script( 'wprm-comment-rating', WPRM_URL . 'assets/js/public/comment-rating.js', array( 'jquery' ), WPRM_VERSION, true );
		wp_enqueue_style( 'wprm-comments', WPRM_URL . 'assets/css/admin/comments.min.css', array(), WPRM_VERSION, 'all' );
	}

	/**
	 * Add field to the comment form.
	 *
	 * @since    1.1.0
	 * @param		 mixed  $text Comment text.
	 * @param		 object $comment Comment object.
	 */
	public static function add_stars_to_comment( $text, $comment = null ) {
		if ( null !== $comment ) {
			$rating = intval( get_comment_meta( $comment->comment_ID, 'wprm-comment-rating', true ) );

			$rating_html = '';
			if ( $rating ) {
				ob_start();
				require( WPRM_DIR . 'templates/public/comment-rating.php' );
				$rating_html = ob_get_contents();
				ob_end_clean();
			}

			$text = 'below' === WPRM_Settings::get( 'comment_rating_position' ) ? $text . $rating_html : $rating_html . $text;
		}

		return $text;
	}

	/**
	 * Compatibility with the wpDiscuz plugin.
	 *
	 * @since    1.3.0
	 */
	public static function wpdiscuz_compatibility() {
		if ( ! defined( 'WPDISCUZ_BOTTOM_TOOLBAR' ) ) {
				define( 'WPDISCUZ_BOTTOM_TOOLBAR', true );
		}
	}

	/**
	 * Add field to the comment form.
	 *
	 * @since    1.1.0
	 */
	public static function add_rating_field_to_comments() {
		$rating = 0;
		require( WPRM_DIR . 'templates/public/comment-rating-form.php' );
	}

	/**
	 * Add field to the admin comment form.
	 *
	 * @since    1.1.0
	 */
	public static function add_rating_field_to_admin_comments() {
		add_meta_box( 'wprm-comment-rating', __( 'Recipe Rating', 'wp-recipe-maker' ), array( __CLASS__, 'add_rating_field_to_admin_comments_form' ), 'comment', 'normal', 'high' );
	}

	/**
	 * Callback for the admin comments meta box.
	 *
	 * @since    1.1.0
	 * @param		 object $comment Comment being edited.
	 */
	public static function add_rating_field_to_admin_comments_form( $comment ) {
		$rating = intval( get_comment_meta( $comment->comment_ID, 'wprm-comment-rating', true ) );
		wp_nonce_field( 'wprm-comment-rating-nonce', 'wprm-comment-rating-nonce', false );
		require( WPRM_DIR . 'templates/public/comment-rating-form.php' );
	}

	/**
	 * Save the comment rating.
	 *
	 * @since    1.1.0
	 * @param		 int $comment_id ID of the comment being saved.
	 */
	public static function save_comment_rating( $comment_id ) {
		$rating = isset( $_POST['wprm-comment-rating'] ) ? intval( $_POST['wprm-comment-rating'] ) : 0; // Input var okay.
		update_comment_meta( $comment_id, 'wprm-comment-rating', $rating );
	}

	/**
	 * Save the admin comment rating.
	 *
	 * @since    1.1.0
	 * @param		 int $comment_id ID of the comment being saved.
	 */
	public static function save_admin_comment_rating( $comment_id ) {
		if ( isset( $_POST['wprm-comment-rating-nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['wprm-comment-rating-nonce'] ), 'wprm-comment-rating-nonce' ) ) { // Input var okay.
			$rating = isset( $_POST['wprm-comment-rating'] ) ? intval( $_POST['wprm-comment-rating'] ) : 0; // Input var okay.
			update_comment_meta( $comment_id, 'wprm-comment-rating', $rating );
		}
	}
}

WPRM_Comment_Rating::init();
