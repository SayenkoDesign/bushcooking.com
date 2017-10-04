<?php
/**
 * Template for the import settings sub page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.20.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/settings
 */

?>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="wprm_settings_import">
	<?php wp_nonce_field( 'wprm_settings', 'wprm_settings', false ); ?>
	<h2 class="title"><?php esc_html_e( 'Ingredient Import', 'wp-recipe-maker' ); ?></h2>
	<p>
		<?php esc_html_e( 'Settings for the ingredient parser when importing.', 'wp-recipe-maker' ); ?>
	</p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="import_range_keyword"><?php esc_html_e( 'Range Keyword', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<input name="import_range_keyword" type="text" id="import_range_keyword" value="<?php echo esc_attr( WPRM_Settings::get( 'import_range_keyword' ) ); ?>" class="regular-text">
					<p class="description">
						<?php esc_html_e( 'Keyword used when defining quantity ranges. For example: to when using 1 to 2.', 'wp-recipe-maker-premium' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="import_units"><?php esc_html_e( 'Import Units', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<?php $import_units = implode( PHP_EOL, WPRM_Settings::get( 'import_units' ) ); ?>
					<textarea name="import_units" rows="12" cols="50" id="import_units" class="large-text code"><?php echo esc_html( $import_units ); ?></textarea>
					<p class="description">
						<?php esc_html_e( 'Units that will be recognized. One per line.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="import_notes_identifier"><?php esc_html_e( 'Ingredient Notes Identifier', 'wp-recipe-maker' ); ?></label>
				</th>
				<td>
					<select id="import_notes_identifier" name="import_notes_identifier">
						<?php
						$options = array(
							'comma' => __( 'Everything after the first comma', 'wp-recipe-maker' ),
							'parentheses' => __( 'Everything inside parentheses', 'wp-recipe-maker' ),
							'both' => __( 'Comma or parentheses, whichever comes first', 'wp-recipe-maker' ),
							'none' => __( 'Do not import to ingredient notes', 'wp-recipe-maker' ),
						);

						$setting = WPRM_Settings::get( 'import_notes_identifier' );
						foreach ( $options as $option => $label ) {
							$selected = $setting === $option ? ' selected="selected"' : '';
							echo '<option value="' . esc_attr( $option ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
						}
						?>
					</select>
					<p class="description">
						<?php esc_html_e( 'How to recognize if it should be part of the ingredient notes.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Remove Identifier', 'wp-recipe-maker' ); ?>
				</th>
				<td>
					<label for="import_notes_remove_identifier">
						<?php $checked = WPRM_Settings::get( 'import_notes_remove_identifier' ) ? ' checked="checked"' : ''; ?>
						<input name="import_notes_remove_identifier" type="checkbox" id="import_notes_remove_identifier"<?php echo esc_html( $checked ); ?> />
						<?php esc_html_e( 'Remove the ingredient notes identifier from the notes', 'wp-recipe-maker' ); ?>
					</label>
				</td>
			</tr>
		</tbody>
	</table>
	<?php submit_button( __( 'Save Changes', 'wp-recipe-maker' ) ); ?>
</form>
