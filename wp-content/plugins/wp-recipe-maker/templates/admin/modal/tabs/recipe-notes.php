<?php
/**
 * Template for the Ingredient Notes tab in the modal.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/modal/tabs
 */

?>

<div class="wprm-recipe-form wprm-recipe-notes-form">
	<div class="wprm-recipe-form-container">
		<label for="wprm-recipe-notes"><?php esc_html_e( 'Notes', 'wp-recipe-maker' ); ?></label>
		<?php
		$editor_settings = array(
			'editor_height' => 300,
		);
		wp_editor( '', 'wprm_recipe_notes', $editor_settings );
		?>
	</div>
</div>
