<?php
if(isset($_REQUEST['email'])) {
	
/* add volunteer to campaign signup */
require('inc/mailchimp.php');

$email = trim($_REQUEST['email']);

$list_id = get_field('mailchimp_list_id', 'options');
$mailchimp_api_key = get_field('mailchimp_api_key', 'options');
	
$MailChimp = new MailChimp($mailchimp_api_key);
$result = $MailChimp->post('lists/'. $list_id .'/members', array(
	'email_address' => $email,
	'status' => 'subscribed',
	'merge_fields' => array(
		/* merge fields here */
	)
));
}
?>
<?php get_header(); ?>

<?php include('inc/content.php'); ?>

<?php get_footer(); ?>