<?php
/**
 * Responsible for handling migrations when updating the plugin.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.7.1
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Responsible for handling migrations when updating the plugin.
 *
 * @since      1.7.1
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Migrations {

	/**
	 *  Notices to show after migrating.
	 *
	 * @since    1.10.0
	 * @access   private
	 * @var      array $notices Notices to show.
	 */
	private static $notices = array();

	/**
	 * Register actions and filters.
	 *
	 * @since    1.7.1
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'check_if_migration_needed' ) );
		add_action( 'admin_notices', array( __CLASS__, 'migration_notices' ) );
	}

	/**
	 * Add the import submenu to the WPRM menu.
	 *
	 * @since    1.7.1
	 */
	public static function check_if_migration_needed() {
		$migrated_to_version = get_option( 'wprm_migrated_to_version', '0.0.0' );

		if ( version_compare( $migrated_to_version, '1.7.1' ) < 0 ) {
			require_once( WPRM_DIR . 'includes/admin/migrations/wprm-1-7-1-ingredient-ids.php' );
		}
		if ( version_compare( $migrated_to_version, '1.10.0' ) < 0 ) {
			require_once( WPRM_DIR . 'includes/admin/migrations/wprm-1-10-0-wpurp.php' );
		}

		if ( '0.0.0' === $migrated_to_version ) {
			self::$notices = array();
		}

		update_option( 'wprm_migrated_to_version', WPRM_VERSION );
	}

	/**
	 * Show any migration notices that might have been set.
	 *
	 * @since    1.10.0
	 */
	public static function migration_notices() {
		foreach ( self::$notices as $notice ) {
			echo '<div class="notice notice-warning is-dismissible">';
			echo '<p><strong>WP Recipe Maker</strong><br/>';
			echo wp_kses_post( $notice );
			echo '</p>';
			echo '</div>';
		}
	}
}

WPRM_Migrations::init();
