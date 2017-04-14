<?php
/**
 * Template for the addons page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.5.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/menu
 */

?>

<div class="wrap wprm-addons">
	<h1><?php echo esc_html_e( 'Add-Ons', 'wp-recipe-maker' ); ?></h1>
	<h2>WP Recipe Maker Premium</h2>
	<?php if ( WPRM_Addons::is_active( 'premium' ) ) : ?>
	<p>This add-on is active.</p>
	<?php else : ?>
	<ul>
		<li>Use <strong>ingredient links</strong> for linking to products or other recipes</li>
		<li><strong>Adjustable servings</strong> make it easy for your visitors</li>
		<li>Display all nutrition data in a <strong>nutrition label</strong></li>
		<li>Add a mobile-friendly <strong>kitchen timer</strong> to your recipes</li>
		<li>More <strong>Premium templates</strong> for a unique recipe template</li>
	</ul>
	<a class="button button-primary" href="http://bootstrapped.ventures/downloads/wp-recipe-maker-premium/" target="_blank">More Information</a>
	<?php endif; // Premium active. ?>

	<h2>WP Recipe Maker Premium - Advanced Nutrition</h2>
	<?php if ( WPRM_Addons::is_active( 'nutrition' ) ) : ?>
	<p>This add-on is active.</p>
	<?php else : ?>
	<ul>
		<li>Integration with a <strong>Nutrition API</strong> for automatic nutrition facts</li>
	</ul>
	<a class="button button-primary" href="http://bootstrapped.ventures/downloads/wp-recipe-maker-premium-advanced-nutrition/" target="_blank">More Information</a>
	<?php endif; // Premium active. ?>
</div>
