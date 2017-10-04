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
	<a class="button button-primary" href="https://bootstrapped.ventures/downloads/wp-recipe-maker-premium/" target="_blank">More Information</a>
	<?php endif; // Premium active. ?>

	<h2>WP Recipe Maker Premium - Advanced Nutrition</h2>
	<?php if ( WPRM_Addons::is_active( 'nutrition' ) ) : ?>
	<p>This add-on is active.</p>
	<?php else : ?>
	<ul>
		<li>Integration with a <strong>Nutrition API</strong> for automatic nutrition facts</li>
	</ul>
	<a class="button button-primary" href="https://bootstrapped.ventures/downloads/wp-recipe-maker-premium-advanced-nutrition/" target="_blank">More Information</a>
	<?php endif; // Advanced Nutrition active. ?>

	<h2>WP Recipe Maker Premium - Unit Conversion</h2>
	<?php if ( WPRM_Addons::is_active( 'unit-conversion' ) ) : ?>
	<p>This add-on is active.</p>
	<?php else : ?>
	<ul>
		<li>Define a second unit system for your ingredients</li>
		<li>Allow visitors to easily switch back and forth</li>
		<li>Automatically calculate quantities and units for the second system</li>
		<li>Manually adjust anything for full control</li>
	</ul>
	<a class="button button-primary" href="https://bootstrapped.ventures/downloads/wp-recipe-maker-premium-unit-conversion/" target="_blank">More Information</a>
	<?php endif; // Unit Conversion active. ?>
</div>
