<?php
add_filter( 'manage_sfbap1_social_feed_posts_columns', 'sfbap1_custom_posts_columns' );

// Hook to custom data in Custom Columns
add_action( 'manage_sfbap1_social_feed_posts_custom_column' , 'sfbap1_custom_form_columns' , 10 , 2 );

function sfbap1_custom_posts_columns( $columns ){
	$newColumns = array();
	$newColumns['title'] = 'Feed Title';
	$newColumns['sfba-info'] = 'Feed Configrations';
	$newColumns['shortcode'] = 'Shortcode';
	$newColumns['date'] = 'Date';
	$newColumns['author'] = 'Created by';
	return $newColumns;
}


function sfbap1_custom_form_columns( $column , $post_id ){
	switch( $column ){
		case 'shortcode' : 
		$sfbap1_cpt_generated_shortcode = get_post_meta($post_id, '_sfbap1_shortcode_value', true);
		echo '<span style="font-weight: bold;font-size:16px;font-weight:;display:inline-block;padding-top:7px;">'.$sfbap1_cpt_generated_shortcode.'</span><br/>';
		break;

		case 'sfba-info' :
		$_sfbap1_feed_style = get_post_meta($post_id, '_sfbap1_feed_style', true);
		$_sfbap1_theme_selection = get_post_meta($post_id, '_sfbap1_theme_selection', true);
		$_sfbap1_show_photos_from = get_post_meta($post_id, '_sfbap1_show_photos_from', true);
		$_sfbap1_hashtag = get_post_meta($post_id, '_sfbap1_hashtag', true);
		$_sfbap1_user_id = get_post_meta($post_id, '_sfbap1_user_id', true);
		$selected_feed_theme ='';
		$selected_feed_style ='';
		$selected_feed_from ='';
		$selected_feed_from_value ='';

		$sfbap1_enable_facebook_feed = get_post_meta($post_id, '_sfbap1_enable_facebook_feed', true);
		$sfbap1_enable_twitter_feed = get_post_meta($post_id, '_sfbap1_enable_twitter_feed', true);
		$sfbap1_enable_instagram_feed = get_post_meta($post_id, '_sfbap1_enable_instagram_feed', true);
		$sfbap1_enable_pinterest_feed = get_post_meta($post_id, '_sfbap1_enable_pinterest_feed', true);
		$sfbap1_enable_vk_feed = get_post_meta($post_id, '_sfbap1_enable_vk_feed', true);

		$if_fb_enabled ='';
		$if_tw_enabled ='';
		$if_insta_enabled ='';
		$if_p_enabled ='';
		$if_vk_enabled ='';

		if($sfbap1_enable_facebook_feed == '1'){
			$if_fb_enabled ='<img style="width: 16px;margin-top: 3px;display: inline-block;position: ;" src="'. plugins_url('images/fb-info.png',__FILE__) .'"/>';
		}
		if($sfbap1_enable_twitter_feed == '1'){
			$if_tw_enabled ='<img style="width: 16px;margin-top: 3px;display: inline-block;position: ;" src="'. plugins_url('images/tw-info.png',__FILE__) .'"/>';
		}
		if($sfbap1_enable_instagram_feed == '1'){
			$if_insta_enabled ='<img style="width: 16px;margin-top: 3px;display: inline-block;position: ;" src="'. plugins_url('images/insta-info.png',__FILE__) .'"/>';
		}
		if($sfbap1_enable_pinterest_feed == '1'){
			$if_p_enabled ='<img style="width: 16px;margin-top: 3px;display: inline-block;position: ;" src="'. plugins_url('images/p-info.png',__FILE__) .'"/>';
		}
		if($sfbap1_enable_vk_feed == '1'){
			$if_vk_enabled ='<img style="width: 16px;margin-top: 3px;display: inline-block;position: ;" src="'. plugins_url('images/vk-info.png',__FILE__) .'"/>';
		}


		if($_sfbap1_theme_selection == 'default'){
			$selected_feed_theme = 'Default Theme';
		}else if($_sfbap1_theme_selection == 'template0'){
			$selected_feed_theme = 'Dark';
		}else if($_sfbap1_theme_selection == 'template1'){
			$selected_feed_theme = 'Pinterest Like';
		}else if($_sfbap1_theme_selection == 'template2'){
			$selected_feed_theme = 'Modern Light';
		}else if($_sfbap1_theme_selection == 'template3'){
			$selected_feed_theme = 'Modern Dark';
		}else if($_sfbap1_theme_selection == 'template4'){
			$selected_feed_theme = 'Space White';
		}

		if($_sfbap1_feed_style == 'vertical'){
			$selected_feed_style = 'Vertical';
		}else if($_sfbap1_feed_style == 'thumbnails'){
			$selected_feed_style = 'Thumbnails';
		}else if($_sfbap1_feed_style == 'blog_style'){
			$selected_feed_style = 'Blog Style';
		}else if($_sfbap1_feed_style == 'masonry'){
			$selected_feed_style = 'Masonry';
		}

		if($_sfbap1_show_photos_from == 'hashtag'){
			$selected_feed_from_value = $_sfbap1_hashtag;
			$selected_feed_from = 'Hashtag';

		}else if($_sfbap1_show_photos_from == 'userid'){
			$selected_feed_from_value = $_sfbap1_user_id;
			$selected_feed_from = 'Username';
		}

		echo '<span style="font-weight:bold;">Enabled Social Feeds: '.$if_fb_enabled.' '.$if_tw_enabled.' '.$if_insta_enabled.' '.$if_p_enabled.' '.$if_vk_enabled.'</span><br/>';
		echo '<span style="font-weight:bold;">Feed Style: '.$selected_feed_style.'</span><br/>';
		echo '<span style="font-weight:bold;">Feed Theme: '.$selected_feed_theme.'</span><br/>';

		

		break;
	}

}
