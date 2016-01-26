<?php
global $app;
$comments = get_comments([
	'post_id' => get_the_ID(),
]);
foreach($comments as $comment){
	echo $app->render('template/comment.html.twig', [
			'comment' => $comment,
			'rating' => get_comment_meta($comment->comment_ID, 'rating', true)
	]);
}
comment_form([
	'title_reply' => 'Leave a Comment',
	'label_submit' => "Leave Comment",
]);
