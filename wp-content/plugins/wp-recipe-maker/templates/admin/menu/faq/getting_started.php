<?php
/**
 * Template for the WP Recipe Maker FAQ Getting Started page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/menu/faq
 */

?>

<h3>Adding Recipes</h3>
<p>
	When creating or editing a regular post or page you should see a "WP Recipe Maker" button appear next to the "Add Media" button right above the post editor. Click that button to insert recipes.
</p>
<img src="<?php echo esc_attr( $img_dir ); ?>/wp-recipe-maker-button.png" />
<h3>Editing Recipes</h3>
<p>
	You can edit a recipe by clicking on the placeholder that will appear in the visual editor after adding a recipe.
</p>
<img src="<?php echo esc_attr( $img_dir ); ?>/recipe-placeholder.png" />
<h3>I need more help!</h3>
<p>
	Take a look at the <a href="http://bootstrapped.ventures/wp-recipe-maker/" target="_blank">WP Recipe Maker website</a> for more documentation and demos. Or just <a href="<?php echo esc_url( add_query_arg( 'sub', 'support', admin_url( 'admin.php?page=wprm_faq' ) ) ); ?>">contact us</a> if you have any questions at all!
</p>
