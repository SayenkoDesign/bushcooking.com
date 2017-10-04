<?php
/**
 * Template for the features settings sub page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/settings
 */

?>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="wprm_settings_features">
	<?php wp_nonce_field( 'wprm_settings', 'wprm_settings', false ); ?>
	<h2 class="title"><?php esc_html_e( 'Features', 'wp-recipe-maker' ); ?></h2>
	<p>
		<?php esc_html_e( 'Choose the features you want to use on your website.', 'wp-recipe-maker' ); ?>
	</p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Comment Ratings', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="features_comment_ratings">
						<?php $checked = WPRM_Settings::get( 'features_comment_ratings' ) ? ' checked="checked"' : ''; ?>
						<input name="features_comment_ratings" type="checkbox" id="features_comment_ratings"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Allow visitors to vote on your recipes when commenting', 'wp-recipe-maker' ); ?>
					</label>
					<p class="description">
						<a href="http://bootstrapped.ventures/wp-recipe-maker/comment-ratings/" target="_blank"><?php esc_html_e( 'Learn more', 'wp-recipe-maker' ); ?></a>
					</p>
					<?php if ( class_exists( 'Jetpack' ) && in_array( 'comments', Jetpack::get_active_modules(), true ) ) : ?>
					<p class="description">
						<?php esc_html_e( 'Warning: comment ratings cannot work with the Jetpack Comments feature you have activated.', 'wp-recipe-maker' ); ?>
					</p>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Custom Style', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="features_custom_style">
						<?php $checked = WPRM_Settings::get( 'features_custom_style' ) ? ' checked="checked"' : ''; ?>
						<input name="features_custom_style" type="checkbox" id="features_custom_style"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Change the recipe style from the settings page', 'wp-recipe-maker' ); ?>
					</label>
					<p class="description">
						<?php esc_html_e( "Disable if you don't want to output inline CSS.", 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="features_manage_access"><?php esc_html_e( 'Access to Manage Page', 'wp-recipe-maker-premium' ); ?></label>
				</th>
				<td>
					<input name="features_manage_access" type="text" id="features_manage_access" value="<?php echo esc_attr( WPRM_Settings::get( 'features_manage_access' ) ); ?>" class="regular-text">
					<p class="description" id="tagline-features_manage_access">
						<?php esc_html_e( 'Required capability to access the WP Recipe Maker > Manage page.', 'wp-recipe-maker-premium' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="features_import_access"><?php esc_html_e( 'Access to Import Page', 'wp-recipe-maker-premium' ); ?></label>
				</th>
				<td>
					<input name="features_import_access" type="text" id="features_import_access" value="<?php echo esc_attr( WPRM_Settings::get( 'features_import_access' ) ); ?>" class="regular-text">
					<p class="description" id="tagline-features_import_access">
						<?php esc_html_e( 'Required capability to access the WP Recipe Maker > Import Recipes page.', 'wp-recipe-maker-premium' ); ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<h2 class="title"><?php esc_html_e( 'Premium Features', 'wp-recipe-maker' ); ?></h2>
	<p>
		<?php if ( ! WPRM_Addons::is_active( 'premium' ) ) : ?>
		<?php esc_html_e( 'These features are only available in', 'wp-recipe-maker' ); ?> <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/" target="_blank">WP Recipe Maker Premium</a>.
		<?php else : ?>
		<?php esc_html_e( 'Choose the Premium features you want to use on your website.', 'wp-recipe-maker' ); ?>
		<?php endif; ?>
	</p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Adjustable Servings', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="features_adjustable_servings">
						<?php $checked = WPRM_Settings::get( 'features_adjustable_servings' ) ? ' checked="checked"' : ''; ?>
						<input name="features_adjustable_servings" type="checkbox" id="features_adjustable_servings"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Visitors can adjust the serving size of your recipes', 'wp-recipe-maker' ); ?>
					</label>
					<p class="description">
						<a href="http://bootstrapped.ventures/wp-recipe-maker/adjustable-servings/" target="_blank"><?php esc_html_e( 'Learn more', 'wp-recipe-maker' ); ?></a>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'User Ratings', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="features_user_ratings">
						<?php $checked = WPRM_Settings::get( 'features_user_ratings' ) ? ' checked="checked"' : ''; ?>
						<input name="features_user_ratings" type="checkbox" id="features_user_ratings"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Visitors can rate your recipes without commenting', 'wp-recipe-maker' ); ?>
					</label>
					<p class="description">
						<a href="http://bootstrapped.ventures/wp-recipe-maker/user-ratings/" target="_blank"><?php esc_html_e( 'Learn more', 'wp-recipe-maker' ); ?></a>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<?php submit_button( __( 'Save Changes', 'wp-recipe-maker' ) ); ?>
</form>
