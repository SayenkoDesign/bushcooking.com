<?php
global $app;
$comments = get_comments([
	'post_id' => get_the_ID(),
]);

$content = [];
foreach($comments as $comment){
	$content[] = $app->render('partials/comment.html.twig', [
	        'user_link' => bp_core_get_user_domain($comment->user_id),
			'comment' => $comment,
			'rating' => get_comment_meta($comment->comment_ID, 'rating', true)
	]);
}

ob_start();
comment_form([
	'title_reply' => 'Leave a Comment',
	'label_submit' => "Leave Comment",
]);
$form = ob_get_clean();

echo $app->render('template/comments.html.twig', [
	'comments' => $content,
	'comment_form' => $form,
]);
