<?php
/**
 * Template for the Recipe Details tab in the modal.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/modal/tabs
 */

?>

<div class="wprm-recipe-form wprm-recipe-details-form">
	<?php do_action( 'wprm_modal_notice' ); ?>
	<div class="wprm-easyrecipe-warning" style="display: none;">
		<strong>Warning!</strong>
		<p>It looks this page already has an EasyRecipe recipe in it. Unfortunately their code is breaking things and preventing our plugin (and others) from working correctly.</p>
		<p>WP Recipe Maker should work correctly if you remove the EasyRecipe recipe first and update the page before using our plugin.</p>
		<p>We also have an <a href="http://bootstrapped.ventures/wp-recipe-maker/import-from-easyrecipe/" target="_blank">EasyRecipe import feature</a> if you'd like to migrate those recipes!</p>
		<p>This problem does not occur for new posts or posts without recipes. If you're getting this warning in those cases, please <a href="http://bootstrapped.ventures/wp-recipe-maker/support/" target="_blank">contact us</a>!</p>
	</div>
	<div class="wprm-recipe-form-container wprm-recipe-image-container">
		<label for="wprm-recipe-image-id"><?php esc_html_e( 'Image', 'wp-recipe-maker' ); ?></label>
		<button type="button" class="button wprm-recipe-image-add"><?php esc_html_e( 'Add Image', 'wp-recipe-maker' ); ?></button>
		<button type="button" class="button wprm-recipe-image-remove hidden"><?php esc_html_e( 'Remove Image', 'wp-recipe-maker' ); ?></button>
		<input type="hidden" id="wprm-recipe-image-id" />
		<div class="wprm-recipe-image-preview"></div>
	</div>
	<div class="wprm-recipe-form-container">
		<label for="wprm-recipe-name"><?php esc_html_e( 'Name', 'wp-recipe-maker' ); ?></label>
		<input type="text" id="wprm-recipe-name" placeholder="<?php esc_attr_e( 'Recipe Name', 'wp-recipe-maker' ); ?>" />
	</div>
	<div class="wprm-recipe-form-container wprm-recipe-summary-container">
		<label for="wprm-recipe-summary"><?php esc_html_e( 'Summary', 'wp-recipe-maker' ); ?></label>
		<textarea id="wprm-recipe-summary" class="wprm-rich-editor" rows="4"></textarea>
	</div>
	<div class='wprm-modal-hint'>
		<span class="wprm-modal-hint-header"><?php esc_html_e( 'Hint', 'wp-recipe-maker' ); ?></span>
		<span class="wprm-modal-hint-text"><?php esc_html_e( 'Select text to add styling or links.', 'wp-recipe-maker' ); ?></span>
	</div>
	<div class="wprm-recipe-form-container wprm-recipe-form-container-halfs">
		<label for="wprm-recipe-author-display"><?php esc_html_e( 'Author', 'wp-recipe-maker' ); ?></label>
		<select id="wprm-recipe-author-display">
			<?php
			$options = array(
				'disabled' => __( "Don't show", 'wp-recipe-maker' ),
				'post_author' => __( 'Name of post author', 'wp-recipe-maker' ),
				'custom' => __( 'Custom author name', 'wp-recipe-maker' ),
			);
			$setting = WPRM_Settings::get( 'recipe_author_display_default' );

			echo '<option value="default" data-default="' . esc_attr( $setting ) . '">' . esc_html__( 'Default', 'wp-recipe-maker' ) . ' (' . esc_html( $options[ $setting ] ) . ')</option>';

			foreach ( $options as $option => $label ) {
				echo '<option value="' . esc_attr( $option ) . '">' . esc_html( $label ) . '</option>';
			}
			?>
		</select>
	</div><div class="wprm-recipe-form-container wprm-recipe-form-container-halfs" id="wprm-recipe-author-name-container">
		<label for="wprm-recipe-author-name"><?php esc_html_e( 'Custom Author Name', 'wp-recipe-maker' ); ?></label>
		<input type="text" id="wprm-recipe-author-name" placeholder="<?php esc_attr_e( 'Author Name', 'wp-recipe-maker' ); ?>" />
	</div>
	<div class="wprm-recipe-form-container">
		<label for="wprm-recipe-servings"><?php esc_html_e( 'Servings', 'wp-recipe-maker' ); ?></label>
		<input type="number" min="0" id="wprm-recipe-servings" placeholder="4" /> <input type="text" id="wprm-recipe-servings-unit" placeholder="<?php esc_attr_e( 'people', 'wp-recipe-maker' ); ?>" />
	</div>
	<?php if ( ! WPRM_Addons::is_active( 'premium' ) ) : ?>
	<div class="wprm-recipe-form-container">
		<label for="wprm-recipe-calories"><?php esc_html_e( 'Calories', 'wp-recipe-maker' ); ?></label>
		<input type="number" min="0" id="wprm-recipe-calories" placeholder="280" /> <?php esc_html_e( 'kcal', 'wp-recipe-maker' ); ?>
	</div>
	<?php endif; // Calories. ?>
	<div class="wprm-recipe-form-container wprm-recipe-form-container-thirds">
		<label for="wprm-recipe-prep-time"><?php esc_html_e( 'Prep Time', 'wp-recipe-maker' ); ?></label>
		<input type="number" id="wprm-recipe-prep-time" class="wprm-recipe-time" placeholder="10" min="0" /> <?php esc_html_e( 'minutes', 'wp-recipe-maker' ); ?>
	</div><div class="wprm-recipe-form-container wprm-recipe-form-container-thirds">
		<label for="wprm-recipe-cook-time"><?php esc_html_e( 'Cook Time', 'wp-recipe-maker' ); ?></label>
		<input type="number" id="wprm-recipe-cook-time" class="wprm-recipe-time" placeholder="20" min="0" /> <?php esc_html_e( 'minutes', 'wp-recipe-maker' ); ?>
	</div><div class="wprm-recipe-form-container wprm-recipe-form-container-thirds">
		<label for="wprm-recipe-total-time"><?php esc_html_e( 'Total Time', 'wp-recipe-maker' ); ?></label>
		<input type="number" id="wprm-recipe-total-time" class="wprm-recipe-time" placeholder="30" min="0" /> <?php esc_html_e( 'minutes', 'wp-recipe-maker' ); ?>
	</div>
	<?php
	$taxonomies = WPRM_Taxonomies::get_taxonomies();

	foreach ( $taxonomies as $taxonomy => $options ) :
		$key = substr( $taxonomy, 5 );
	?><div class="wprm-recipe-form-container wprm-recipe-form-container-halfs">
		<label for="wprm-recipe-tag-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $options['singular_name'] ); ?></label>
		<select id="wprm-recipe-tag-<?php echo esc_attr( $key ); ?>" class="wprm-recipe-tags" data-key="<?php echo esc_attr( $key ); ?>" multiple>
			<?php
			$terms = get_terms( array(
					'taxonomy' => $taxonomy,
					'hide_empty' => false,
			) );

			foreach ( $terms as $term ) {
				echo '<option value="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</option>';
			}
			?>
		</select>
	</div><?php endforeach; // Taxonomies. ?>
	<div class='wprm-modal-hint'>
		<span class="wprm-modal-hint-header"><?php esc_html_e( 'Hint', 'wp-recipe-maker' ); ?></span>
		<span class="wprm-modal-hint-text"><?php esc_html_e( 'You can type in any term you want and press ENTER.', 'wp-recipe-maker' ); ?></span>
	</div>
</div>
