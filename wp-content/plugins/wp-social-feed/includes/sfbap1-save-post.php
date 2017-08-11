<?php
add_action( 'save_post', 'sfbap1_save_form' );

function sfbap1_save_form( $post_id ) {

	$post_type = get_post_type($post_id);
// If this isn't a 'sfba_subscribe_form' post, don't update it.
	if ( "sfbap1_social_feed" != $post_type ) {
		return;
	}

// Stop WP from clearing custom fields on autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}

// Prevent quick edit from clearing custom fields
	if (defined('DOING_AJAX') && DOING_AJAX){
		return;
	}
// - Update the post's metadata.


	if ( isset( $_REQUEST['sfbap1_enable_facebook_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_facebook_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_facebook_feed', FALSE);
	}


		if ( isset( $_REQUEST['sfbap1_social_icon'] ) ) {
		update_post_meta($post_id, '_sfbap1_social_icon', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_social_icon', FALSE);
	}


	if ( isset( $_REQUEST['sfbap1_enable_twitter_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_twitter_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_twitter_feed', FALSE);
	}


	if ( isset( $_REQUEST['sfbap1_enable_instagram_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_instagram_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_instagram_feed', FALSE);
	}


if ( isset( $_REQUEST['sfbap1_enable_pinterest_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_pinterest_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_pinterest_feed', FALSE);
	}

if ( isset( $_REQUEST['sfbap1_enable_google_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_google_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_google_feed', FALSE);
	}



if ( isset( $_REQUEST['sfbap1_enable_vk_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_vk_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_vk_feed', FALSE);
	}

if ( isset( $_REQUEST['sfbap1_enable_rss_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_enable_rss_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_enable_rss_feed', FALSE);
	}

	if ( isset( $_POST['sfbap1_facebook_page_id'] ) ) {
		update_post_meta( $post_id, '_sfbap1_facebook_page_id', sanitize_text_field( $_POST['sfbap1_facebook_page_id'] ) );
	}

if ( isset( $_POST['sfbap1_show_photos_from_twitter'] ) ) {
		update_post_meta( $post_id, '_sfbap1_show_photos_from_twitter', sanitize_text_field( $_POST['sfbap1_show_photos_from_twitter'] ) );
	}

	if ( isset( $_POST['sfbap1_user_id_twitter'] ) ) {
		update_post_meta( $post_id, '_sfbap1_user_id_twitter', sanitize_text_field( $_POST['sfbap1_user_id_twitter'] ) );
	}


	if ( isset( $_POST['sfbap1_hashtag_twitter'] ) ) {
		update_post_meta( $post_id, '_sfbap1_hashtag_twitter', sanitize_text_field( $_POST['sfbap1_hashtag_twitter'] ) );
	}





if ( isset( $_POST['sfbap1_show_photos_from_instagram'] ) ) {
		update_post_meta( $post_id, '_sfbap1_show_photos_from_instagram', sanitize_text_field( $_POST['sfbap1_show_photos_from_instagram'] ) );
	}

	if ( isset( $_POST['sfbap1_user_id_instagram'] ) ) {
		update_post_meta( $post_id, '_sfbap1_user_id_instagram', sanitize_text_field( $_POST['sfbap1_user_id_instagram'] ) );
	}


	if ( isset( $_POST['sfbap1_hashtag_instagram'] ) ) {
		update_post_meta( $post_id, '_sfbap1_hashtag_instagram', sanitize_text_field( $_POST['sfbap1_hashtag_instagram'] ) );
	}


if ( isset( $_POST['sfbap1_pinterest_board'] ) ) {
		update_post_meta( $post_id, '_sfbap1_pinterest_board', sanitize_text_field( $_POST['sfbap1_pinterest_board'] ) );
	}

if ( isset( $_POST['sfbap1_vk_hashtag'] ) ) {
		update_post_meta( $post_id, '_sfbap1_vk_hashtag', sanitize_text_field( $_POST['sfbap1_vk_hashtag'] ) );
	}


	if ( isset( $_POST['sfbap1_number_facebook'] ) ) {
		update_post_meta( $post_id, '_sfbap1_number_facebook', sanitize_text_field( $_POST['sfbap1_number_facebook'] ) );
	}

if ( isset( $_POST['sfbap1_number_twitter'] ) ) {
		update_post_meta( $post_id, '_sfbap1_number_twitter', sanitize_text_field( $_POST['sfbap1_number_twitter'] ) );
	}

if ( isset( $_POST['sfbap1_number_instagram'] ) ) {
		update_post_meta( $post_id, '_sfbap1_number_instagram', sanitize_text_field( $_POST['sfbap1_number_instagram'] ) );
	}
if ( isset( $_POST['sfbap1_number_pinterest'] ) ) {
		update_post_meta( $post_id, '_sfbap1_number_pinterest', sanitize_text_field( $_POST['sfbap1_number_pinterest'] ) );
	}
if ( isset( $_POST['sfbap1_number_vk'] ) ) {
		update_post_meta( $post_id, '_sfbap1_number_vk', sanitize_text_field( $_POST['sfbap1_number_vk'] ) );
	}

if ( isset( $_POST['sfbap1_date_posted_lang'] ) ) {
		update_post_meta( $post_id, '_sfbap1_date_posted_lang', sanitize_text_field( $_POST['sfbap1_date_posted_lang'] ) );
	}





	if ( isset( $_POST['sfbap1_private_access_token'] ) ) {
		update_post_meta( $post_id, '_sfbap1_private_access_token', sanitize_text_field( $_POST['sfbap1_private_access_token'] ) );
	}
	if ( isset( $_POST['sfbap1_shortcode_value'] ) ) {
		update_post_meta( $post_id, '_sfbap1_shortcode_value', sanitize_text_field( $_POST['sfbap1_shortcode_value'] ) );
	}
	if ( isset( $_POST['sfbap1_theme_selection'] ) ) {
		update_post_meta( $post_id, '_sfbap1_theme_selection', sanitize_text_field( $_POST['sfbap1_theme_selection'] ) );
	}
	if ( isset( $_POST['sfbap1_feed_post_size'] ) ) {
		update_post_meta( $post_id, '_sfbap1_feed_post_size', sanitize_text_field( $_POST['sfbap1_feed_post_size'] ) );
	}
	if ( isset( $_POST['sfbap1_limit_post_characters'] ) ) {
		update_post_meta( $post_id, '_sfbap1_limit_post_characters', sanitize_text_field( $_POST['sfbap1_limit_post_characters'] ) );
	}
	if ( isset( $_POST['sfbap1_column_count'] ) ) {
		update_post_meta( $post_id, '_sfbap1_column_count', sanitize_text_field( $_POST['sfbap1_column_count'] ) );
	}
	if ( isset( $_POST['sfbap1_thumbnail_size'] ) ) {
		update_post_meta( $post_id, '_sfbap1_thumbnail_size', sanitize_text_field( $_POST['sfbap1_thumbnail_size'] ) );
	}
	if ( isset( $_POST['sfbap1_feed_style'] ) ) {
		update_post_meta( $post_id, '_sfbap1_feed_style', sanitize_text_field( $_POST['sfbap1_feed_style'] ) );
	}
	

	if ( isset( $_POST['sfbap1_location'] ) ) {
		update_post_meta( $post_id, '_sfbap1_location', sanitize_text_field( $_POST['sfbap1_location'] ) );
	}
	if ( isset( $_POST['sfbap1_container_width'] ) ) {
		update_post_meta( $post_id, '_sfbap1_container_width', sanitize_text_field( $_POST['sfbap1_container_width'] ) );
	}

	if ( isset( $_REQUEST['sfbap1_show_photos_only'] ) ) {
		update_post_meta($post_id, '_sfbap1_show_photos_only', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_show_photos_only', FALSE);
	}
	if ( isset( $_REQUEST['sfbap1_date_posted'] ) ) {
		update_post_meta($post_id, '_sfbap1_date_posted', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_date_posted', FALSE);
	}
	if ( isset( $_REQUEST['sfbap1_profile_picture'] ) ) {
		update_post_meta($post_id, '_sfbap1_profile_picture', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_profile_picture', FALSE);
	}
	if ( isset( $_REQUEST['sfbap1_caption_text'] ) ) {
		update_post_meta($post_id, '_sfbap1_caption_text', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_caption_text', FALSE);
	}
	if ( isset( $_REQUEST['sfbap1_link_photos_to_social_feed'] ) ) {
		update_post_meta($post_id, '_sfbap1_link_photos_to_social_feed', TRUE);
	} else {
		update_post_meta($post_id, '_sfbap1_link_photos_to_social_feed', FALSE);
	}
}