<?php
/**
 * Show Addons page in the backend menu.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.5.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Show Addons page in the backend menu.
 *
 * @since      1.5.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Admin_Menu_Addons {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.5.0
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_submenu_page' ), 19 );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.5.0
	 */
	public static function enqueue() {
		wp_enqueue_style( 'wprm-addons', WPRM_URL . 'assets/css/admin/addons.min.css', array(), WPRM_VERSION, 'all' );
	}

	/**
	 * Add the FAQ & Support submenu to the WPRM menu.
	 *
	 * @since    1.5.0
	 */
	public static function add_submenu_page() {
		add_submenu_page( 'wprecipemaker', __( 'Add-Ons', 'wp-recipe-maker' ), __( 'Add-Ons', 'wp-recipe-maker' ), 'manage_options', 'wprm_addons', array( __CLASS__, 'page_template' ) );
	}

	/**
	 * Get the template for this submenu.
	 *
	 * @since    1.5.0
	 */
	public static function page_template() {
		require_once( WPRM_DIR . 'templates/admin/menu/addons.php' );
	}
}

WPRM_Admin_Menu_Addons::init();
