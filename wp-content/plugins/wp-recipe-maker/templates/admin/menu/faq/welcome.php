<?php
/**
 * Template for the WP Recipe Maker FAQ Welcome page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/menu/faq
 */

?>

<h3>Get the most out of WP Recipe Maker!</h3>
<p>
	Join our self-paced email course to <strong>help you get started</strong> and learn about all the <strong>tips and tricks</strong> to get the most out of WP Recipe Maker.
</p>
<p>
	Go through the entire course and we'll even <strong>promote your recipes for free</strong>!
</p>
<?php
$current_user = wp_get_current_user();
$email = $current_user->user_email;
$website = get_site_url();
?>
<form action="https://www.getdrip.com/forms/86388969/submissions" method="post" class="wprm-drip-form" data-drip-embedded-form="86388969" target="_blank">
	<div>
			<label for="fields[email]">Email Address</label><br />
			<input type="email" id="fields[email]" name="fields[email]" value="<?php echo esc_attr( $email ); ?>" />
			<input type="hidden" name="tags[]" value="wprm-getting-started-welcome" />
	</div>
	<div>
		<input type="submit" name="submit" value="Help me get the most out of WP Recipe Maker!" class="button button-primary" data-drip-attribute="sign-up-button" />
	</div>
</form>
