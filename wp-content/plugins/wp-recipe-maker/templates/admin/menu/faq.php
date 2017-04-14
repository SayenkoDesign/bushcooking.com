<?php
/**
 * Template for the WP Recipe Maker FAQ.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/menu
 */

// Subpage.
$sub = isset( $_GET['sub'] ) ? sanitize_key( wp_unslash( $_GET['sub'] ) ) : 'faq'; // Input var okay.

if ( ! in_array( $sub, array( 'welcome', 'getting_started', 'whats_new', 'support' ), true ) ) {
		$sub = 'welcome';
}

// Active version.
$name = 'WP Recipe Maker';
$version = WPRM_VERSION;
$full_name = $name . ' ' . $version;

// Image directory.
$img_dir = WPRM_URL . 'assets/images/faq';
?>

<div class="wrap about-wrap wprm-faq">

		<h1><?php echo esc_html( $name ); ?></h1>

		<div class="about-text">Welcome to version <?php echo esc_html( $version ) ?> of the very best recipe plugin!</div>

		<div class="wprm-badge">Version <?php echo esc_html( $version ); ?></div>

		<h2 class="nav-tab-wrapper">
				<a href="<?php echo esc_url( add_query_arg( 'sub', 'welcome', admin_url( 'admin.php?page=wprm_faq' ) ) ); ?>" class="nav-tab<?php if ( 'welcome' === $sub ) { echo esc_attr( ' nav-tab-active' ); } ?>">
					Welcome
				</a><a href="<?php echo esc_url( add_query_arg( 'sub', 'getting_started', admin_url( 'admin.php?page=wprm_faq' ) ) ); ?>" class="nav-tab<?php if ( 'getting_started' === $sub ) { echo esc_attr( ' nav-tab-active' ); } ?>">
					Getting Started
				</a><a href="<?php echo esc_url( add_query_arg( 'sub', 'whats_new', admin_url( 'admin.php?page=wprm_faq' ) ) ); ?>" class="nav-tab<?php if ( 'whats_new' === $sub ) { echo esc_attr( ' nav-tab-active' ); } ?>">
					What&#8217;s New
				</a><a href="<?php echo esc_url( add_query_arg( 'sub', 'support', admin_url( 'admin.php?page=wprm_faq' ) ) ); ?>" class="nav-tab<?php if ( 'support' === $sub ) { echo esc_attr( ' nav-tab-active' ); } ?>">
					Support
				</a>
		</h2>

		<?php include( WPRM_DIR . 'templates/admin/menu/faq/' . $sub . '.php' ); ?>
</div>
