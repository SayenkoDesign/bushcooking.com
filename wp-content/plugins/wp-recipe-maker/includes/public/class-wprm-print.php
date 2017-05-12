<?php
/**
 * Handle the recipe printing.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe printing.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Print {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'print_page' ) );
		add_action( 'wp_ajax_wprm_print_recipe', array( __CLASS__, 'ajax_print_recipe' ) );
		add_action( 'wp_ajax_nopriv_wprm_print_recipe', array( __CLASS__, 'ajax_print_recipe' ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );

		add_filter( 'wprm_get_template', array( __CLASS__, 'print_credit' ), 10, 3 );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.0.0
	 */
	public static function enqueue() {
		wp_enqueue_script( 'wprm-print', WPRM_URL . 'assets/js/public/print.js', array( 'jquery' ), WPRM_VERSION, true );

		wp_localize_script( 'wprm-print', 'wprm_public', array(
			'home_url' => home_url( '/' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'wprm' ),
		));
	}

	/**
	 * Check if someone is trying to reach the print page.
	 *
	 * @since    1.3.0
	 */
	public static function print_page() {
		preg_match( '/\/wprm_print\/(\d+)\/?$/', $_SERVER['REQUEST_URI'], $print_url ); // Input var okay.
		$recipe_id = isset( $print_url[1] ) ? intval( $print_url[1] ) : false;
		if ( $recipe_id && WPRM_POST_TYPE === get_post_type( $recipe_id ) ) {
			$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

			$styles = WPRM_Template_Manager::get_template_styles( $recipe, 'print' );
			$styles .= '<style>body { position: relative; padding-bottom: 30px; } #wprm-print-footer { position: absolute; bottom: 0; left: 0; right: 0; text-align: center; font-size: 0.8em; }</style>';

			if ( WPRM_Settings::get( 'print_css' ) ) {
				$styles .= '<style>' . WPRM_Settings::get( 'print_css' ) . '</style>';
			}

			if ( WPRM_Addons::is_active( 'premium' ) ) {
				$styles .= '<link rel="stylesheet" type="text/css" href="' . WPRMP_URL . 'assets/css/public/public.min.css"/>';
			}

			$scripts = '';
			if ( WPRM_Addons::is_active( 'premium' ) ) {
				$scripts .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>';
				$scripts .= '<script src="' . WPRMP_URL . 'assets/js/public/servings-changer.js"></script>';
			} else {
				$scripts .= '<script>wprm = {}; wprm.set_print_servings = function(servings) {};</script>';
			}

			// Fix for IE.
			header( 'HTTP/1.1 200 OK' );

			$charset = get_bloginfo( 'charset' );
			$print_html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=' . $charset . '" /><meta name="robots" content="noindex">' . $styles . $scripts . '</head><body class="wprm-print">';
			$print_html .= WPRM_Template_Manager::get_template( $recipe, 'print' );
			$print_html .= '</body></html>';
			echo $print_html;
			flush();
			exit;
		}
	}

	/**
	 * Get print HTML for a specific recipe.
	 *
	 * @since    1.0.0
	 */
	public static function ajax_print_recipe() {
		if ( check_ajax_referer( 'wprm', 'security', false ) ) {
			$recipe_id = isset( $_POST['recipe_id'] ) ? intval( $_POST['recipe_id'] ) : 0; // Input var okay.

			$print_html = '';
			if ( 0 !== $recipe_id && WPRM_POST_TYPE === get_post_type( $recipe_id ) ) {
				$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

				$styles = WPRM_Template_Manager::get_template_styles( $recipe, 'print' );
				$styles .= '<style>body { position: relative; padding-bottom: 30px; } #wprm-print-footer { position: absolute; bottom: 0; left: 0; right: 0; text-align: center; font-size: 0.8em; }</style>';

				$print_html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . $styles . '</head><body class="wprm-print">';
				$print_html .= WPRM_Template_Manager::get_template( $recipe, 'print' );
			}
			$print_html .= '</body></html>';

			wp_send_json_success( array(
				'html' => $print_html,
			) );
		}

		wp_die();
	}

	/**
	 * Add credit to the print page.
	 *
	 * @since    1.12.0
	 * @param    mixed $template Template we're filtering.
	 * @param    mixed $recipe   Recipe being printed.
	 * @param    mixed $type     Type of the template.
	 */
	public static function print_credit( $template, $recipe, $type ) {
		if ( 'print' === $type ) {
			$credit = WPRM_Settings::get( 'print_credit' );

			if ( $credit ) {
				$template .= '<div id="wprm-print-footer">' . WPRM_Template_Helper::recipe_placeholders( $recipe, $credit ) . '</div>';
			}
		}

		return $template;
	}
}

WPRM_Print::init();
