<?php
/**
 * Template for the labels settings sub page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.10.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/settings
 */

?>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="wprm_settings_labels">
	<?php wp_nonce_field( 'wprm_settings', 'wprm_settings', false ); ?>
	<h2 class="title"><?php esc_html_e( 'Labels', 'wp-recipe-maker' ); ?></h2>
	<p>
		<?php esc_html_e( 'Change the labels in the recipe template.', 'wp-recipe-maker' ); ?>
	</p>
	<table class="form-table">
		<tbody>
			<?php
			$labels = WPRM_Template_Helper::get_labels();
			ksort( $labels );

			foreach ( $labels as $uid => $text ) :
				$name = ucwords( str_replace( '_', ' ', $uid ) );
				$uid = 'wprm_label_' . $uid;
			?>
			<tr>
				<th scope="row">
					<label for="<?php echo esc_attr( $uid ); ?>"><?php echo esc_html( $name ); ?></label>
				</th>
				<td>
					<input name="<?php echo esc_attr( $uid ); ?>" type="text" id="<?php echo esc_attr( $uid ); ?>" value="<?php echo esc_attr( $text ); ?>" class="regular-text">
				</td>
			</tr>
			<?php endforeach; // Labels. ?>
		</tbody>
	</table>
	<?php submit_button( __( 'Save Changes', 'wp-recipe-maker' ) ); ?>
</form>
