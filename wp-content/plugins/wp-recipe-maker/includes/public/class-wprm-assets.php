<?php
/**
 * Responsible for loading the WPRM assets.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.22.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Responsible for loading the WPRM assets.
 *
 * @since      1.22.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Assets {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.22.0
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ), 1 );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.22.0
	 */
	public static function enqueue() {
		wp_enqueue_style( 'wprm-public', WPRM_URL . 'assets/css/public/public.min.css', array(), WPRM_VERSION, 'all' );
		wp_enqueue_script( 'wprm-public', WPRM_URL . 'assets/js/public.js', array( 'jquery' ), WPRM_VERSION, true );

		wp_localize_script( 'wprm-public', 'wprm_public', array(
			'settings' => array(
				'features_comment_ratings' => WPRM_Settings::get( 'features_comment_ratings' ),
			),
			'home_url' => home_url( '/' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'wprm' ),
		));
	}
}

WPRM_Assets::init();
