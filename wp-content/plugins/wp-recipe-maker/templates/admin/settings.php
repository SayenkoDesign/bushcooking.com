<?php
/**
 * Template for recipe settings page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin
 */

// Subpage.
$sub = isset( $_GET['sub'] ) ? sanitize_key( wp_unslash( $_GET['sub'] ) ) : ''; // Input var okay.

$tabs = apply_filters( 'wprm_settings_tabs', array(
	'appearance' => __( 'Appearance', 'wp-recipe-maker' ),
	'labels' => __( 'Labels', 'wp-recipe-maker' ),
	'features' => __( 'Features', 'wp-recipe-maker' ),
) );

if ( ! array_key_exists( $sub, $tabs ) ) {
	$sub = 'appearance';
}
?>

<div class="wrap wprm-settings">
		<h1><?php esc_html_e( 'WP Recipe Maker Settings', 'wp-recipe-maker' ); ?></h1>

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ( $tabs as $tab => $label ) {
				$url = add_query_arg( 'sub', $tab, admin_url( 'admin.php?page=wprm_settings' ) );
				$active = $sub === $tab ? ' nav-tab-active' : '';

				echo '<a href="' . esc_url( $url ) . '" class="nav-tab' . esc_attr( $active ) . '">' . esc_html( $label ) . '</a>';
			}
			?>
		</h2>

		<?php do_action( 'wprm_settings_page', $sub ); ?>
</div>
