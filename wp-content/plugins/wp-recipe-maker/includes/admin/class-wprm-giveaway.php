<?php
/**
 * Responsible for promoting the giveaway.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.11.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Responsible for promoting the giveaway.
 *
 * @since      1.11.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Giveaway {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.11.0
	 */
	public static function init() {
		$now = new DateTime();
		$giveaway_start = new DateTime( '2017-01-13 17:00:00', new DateTimeZone( 'Europe/Brussels' ) );
		$giveaway_end = new DateTime( '2017-01-27 23:00:00', new DateTimeZone( 'Europe/Brussels' ) );

		if ( $giveaway_start < $now && $now < $giveaway_end ) {
			add_action( 'admin_menu', array( __CLASS__, 'add_submenu_page' ), 99 );
			add_action( 'wprm_modal_notice', array( __CLASS__, 'modal_notice' ) );
		}
	}

	/**
	 * Add the Giveaway menu page.
	 *
	 * @since    1.11.0
	 */
	public static function add_submenu_page() {
		add_submenu_page( 'wprecipemaker', 'Giveaway', '~ Plugin Giveaway! ~', 'manage_options', 'wprm_giveaway', array( __CLASS__, 'page_template' ) );
	}

	/**
	 * Template for the giveaway page.
	 *
	 * @since    1.11.0
	 */
	public static function page_template() {
		echo '<div class="wrap">';
		echo '<h1>Plugin Giveaway</h1>';
		echo '<a class="e-widget no-button" href="https://gleam.io/sTRSD/birthday-giveaway-2017" rel="nofollow">Birthday Giveaway 2017</a>';
		echo '<script type="text/javascript" src="https://js.gleam.io/e.js" async="true"></script>';
		echo '</div>';
	}

	/**
	 * Show a notice in the modal.
	 *
	 * @since    1.11.0
	 */
	public static function modal_notice() {
		if ( ! WPRM_Addons::is_active( 'premium' ) ) {
			echo '<div class="wprm-giveaway-notice">';
			echo '<strong>Feeling lucky?</strong> Win plugins in our <a href="' . esc_url( admin_url( 'admin.php?page=wprm_giveaway' ) ) . '" target="_blank">Birthday Giveaway</a>!';
			echo '</div>';
		}
	}
}

WPRM_Giveaway::init();
