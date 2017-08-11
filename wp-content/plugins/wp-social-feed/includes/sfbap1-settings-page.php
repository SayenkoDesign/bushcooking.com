<?php
wp_nonce_field( 'sfbap1_ui_meta_box_nonce', 'sfbap1_meta_box_nonce' );

global $post;
$sfbap1_show_photos_from = get_post_meta($post->ID, '_sfbap1_show_photos_from', true);
$sfbap1_user_id = get_post_meta($post->ID, '_sfbap1_user_id', true);
$sfbap1_hashtag = get_post_meta($post->ID, '_sfbap1_hashtag', true);
$sfbap1_location = get_post_meta($post->ID, '_sfbap1_location', true);
$sfbap1_container_width = get_post_meta($post->ID, '_sfbap1_container_width', true);
$sfbap1_date_posted = get_post_meta($post->ID, '_sfbap1_date_posted', true);
$sfbap1_profile_picture = get_post_meta($post->ID, '_sfbap1_profile_picture', true);
$sfbap1_caption_text = get_post_meta($post->ID, '_sfbap1_caption_text', true);
$sfbap1_link_photos_to_instagram = get_post_meta($post->ID, '_sfbap1_link_photos_to_social_feed', true);
$sfbap1_show_photos_only = get_post_meta($post->ID, '_sfbap1_show_photos_only', true);
$sfbap1_number_of_photos = get_post_meta($post->ID, '_sfbap1_number_of_photos', true);
$sfbap1_feed_style = get_post_meta($post->ID, '_sfbap1_feed_style', true);
$sfbap1_limit_post_characters = get_post_meta($post->ID, '_sfbap1_limit_post_characters', true);
$sfbap1_thumbnail_size = get_post_meta($post->ID, '_sfbap1_thumbnail_size', true);
$sfbap1_column_count = get_post_meta($post->ID, '_sfbap1_column_count', true);
$sfbap1_feed_post_size = get_post_meta($post->ID, '_sfbap1_feed_post_size', true);
$sfbap1_theme_selection = get_post_meta($post->ID, '_sfbap1_theme_selection', true);
$sfbap1_private_access_token = get_post_meta($post->ID, '_sfbap1_private_access_token', true);

$sfbap1_enable_facebook_feed = get_post_meta($post->ID, '_sfbap1_enable_facebook_feed', true);
$sfbap1_enable_twitter_feed = get_post_meta($post->ID, '_sfbap1_enable_twitter_feed', true);
$sfbap1_enable_instagram_feed = get_post_meta($post->ID, '_sfbap1_enable_instagram_feed', true);
$sfbap1_enable_pinterest_feed = get_post_meta($post->ID, '_sfbap1_enable_pinterest_feed', true);
$sfbap1_enable_google_feed = get_post_meta($post->ID, '_sfbap1_enable_google_feed', true);
$sfbap1_enable_vk_feed = get_post_meta($post->ID, '_sfbap1_enable_vk_feed', true);
$sfbap1_enable_rss_feed = get_post_meta($post->ID, '_sfbap1_enable_rss_feed', true);


$sfbap1_facebook_page_id = get_post_meta($post->ID, '_sfbap1_facebook_page_id', true);

$sfbap1_show_photos_from_twitter = get_post_meta($post->ID, '_sfbap1_show_photos_from_twitter', true);
$sfbap1_user_id_twitter = get_post_meta($post->ID, '_sfbap1_user_id_twitter', true);
$sfbap1_hashtag_twitter = get_post_meta($post->ID, '_sfbap1_hashtag_twitter', true);


$sfbap1_show_photos_from_instagram = get_post_meta($post->ID, '_sfbap1_show_photos_from_instagram', true);
$sfbap1_user_id_instagram = get_post_meta($post->ID, '_sfbap1_user_id_instagram', true);
$sfbap1_hashtag_instagram = get_post_meta($post->ID, '_sfbap1_hashtag_instagram', true);

$sfbap1_pinterest_board = get_post_meta($post->ID, '_sfbap1_pinterest_board', true);
$sfbap1_vk_hashtag = get_post_meta($post->ID, '_sfbap1_vk_hashtag', true);

$sfbap1_number_twitter = get_post_meta($post->ID, '_sfbap1_number_twitter', true);

$sfbap1_number_facebook = get_post_meta($post->ID, '_sfbap1_number_facebook', true);
$sfbap1_number_twitter = get_post_meta($post->ID, '_sfbap1_number_twitter', true);
$sfbap1_number_instagram = get_post_meta($post->ID, '_sfbap1_number_instagram', true);
$sfbap1_number_pinterest = get_post_meta($post->ID, '_sfbap1_number_pinterest', true);
$sfbap1_number_vk = get_post_meta($post->ID, '_sfbap1_number_vk', true);
$sfbap1_date_posted_lang = get_post_meta($post->ID, '_sfbap1_date_posted_lang', true);
$sfbap1_social_icon = get_post_meta($post->ID, '_sfbap1_social_icon', true);


?>
<script type="text/javascript">
  jQuery(document).ready( function($) {
    var selected_feed_style = $('input[name=sfbap1_feed_style]:checked', '#sfbap1_style_selection_option').val();
    if(selected_feed_style == 'thumbnails'){
      $('#sfbap1_thumbnail_style_options').show();
      $('#sfbap1_column_count_settings').hide();
      $('#sfbap1_thumbnails_image').css('border','2px inset #858585');
      $('#sfbap1_masonry_image').css('border','none');
      $('#sfbap1_blog_image').css('border','none');
    }
    if(selected_feed_style == 'blog_style' ){
      $('#sfbap1_blog_masonry_style_options').show();
      $('#sfbap1_column_count_settings').hide();
      $('#sfbap1_blog_image').css('border','2px inset #858585');
      $('#sfbap1_thumbnails_image').css('border','none');
      $('#sfbap1_masonry_image').css('border','none');

    }
    if(selected_feed_style == 'masonry'){
      $('#sfbap1_blog_masonry_style_options').show();
      $('#sfbap1_column_count_settings').show();
      $('#sfbap1_masonry_image').css('border','2px inset #858585');
      $('#sfbap1_blog_image').css('border','none');
      $('#sfbap1_thumbnails_image').css('border','none');


    }
    if(selected_feed_style == 'vertical' ){
      $('#sfbap1_blog_masonry_style_options').show();
      $('#sfbap1_column_count_settings').hide();
      $('#sfbap1_vertical_image').css('border','2px inset #858585');
      $('#sfbap1_blog_image').css('border','none');
      $('#sfbap1_thumbnails_image').css('border','none');
      $('#sfbap1_masonry_image').css('border','none');

    }
    $('#sfbap1_style_selection_option input').on('change', function() {
      var feed_style_selection = $('input[name=sfbap1_feed_style]:checked', '#sfbap1_style_selection_option').val(); 
      if(feed_style_selection == 'thumbnails'){
        $('#sfbap1_thumbnail_style_options').show();
        $('#sfbap1_blog_masonry_style_options').hide();
      $('#sfbap1_column_count_settings').hide();
        $('#sfbap1_thumbnails_image').css('border','2px inset #858585');
        $('#sfbap1_vertical_image').css('border','none');
        $('#sfbap1_masonry_image').css('border','none');
        $('#sfbap1_blog_image').css('border','none');
      }
      if(feed_style_selection == 'blog_style' ){
        $('#sfbap1_thumbnail_style_options').hide();
        $('#sfbap1_blog_masonry_style_options').show();
      $('#sfbap1_column_count_settings').hide();
        $('#sfbap1_blog_image').css('border','2px inset #858585');
         $('#sfbap1_vertical_image').css('border','none');
        $('#sfbap1_thumbnails_image').css('border','none');
        $('#sfbap1_masonry_image').css('border','none');
      }
      if(feed_style_selection == 'vertical' ){
        $('#sfbap1_thumbnail_style_options').hide();
        $('#sfbap1_blog_masonry_style_options').show();
      $('#sfbap1_column_count_settings').hide();
        $('#sfbap1_vertical_image').css('border','2px inset #858585');
        $('#sfbap1_blog_image').css('border','none');
        $('#sfbap1_thumbnails_image').css('border','none');
        $('#sfbap1_masonry_image').css('border','none');
      }
      if(feed_style_selection == 'masonry'){
        $('#sfbap1_thumbnail_style_options').hide();
        $('#sfbap1_blog_masonry_style_options').show();
      $('#sfbap1_column_count_settings').show();
       $('#sfbap1_vertical_image').css('border','none');
        $('#sfbap1_masonry_image').css('border','2px inset #858585');
        $('#sfbap1_blog_image').css('border','none');
        $('#sfbap1_thumbnails_image').css('border','none');
      }
    });
  });
</script>
<style type="text/css">

  main {
    background: #FFF;
    width: 98%;
    padding: 1%;
    margin-top: 1%;
    box-shadow: 0 3px 5px rgba(0,0,0,0.2);
  }
  main p {
    font-size: 13px;
  }
  main #sfbap1-tab1, main #sfbap1-tab2, main #sfbap1-tab3, main #sfbap1-tab4, main section {
    clear: both;
    padding-top: 30px;
    display: none;
  }
  #sfbap1-tab1-label, #sfbap1-tab2-label,  #sfbap1-tab3-label,  #sfbap1-tab4-label {
    font-weight: bold;
    font-size: 14px;
    display: block;
    float: left;
    padding: 10px 30px;
    border-top: 2px solid transparent;
    border-right: 1px solid transparent;
    border-left: 1px solid transparent;
    border-bottom: 1px solid #DDD;
  }
  main label:hover {
    cursor: pointer;
    text-decoration: underline;
  }
  #sfbap1-tab1:checked ~ #sfbap1-content1, #sfbap1-tab2:checked ~ #sfbap1-content2, #sfbap1-tab3:checked ~ #sfbap1-content3, #sfbap1-tab4:checked ~ #sfbap1-content4 {
    display: block;
  }
  main input:checked + #sfbap1-tab1-label, main input:checked + #sfbap1-tab2-label, main input:checked +  #sfbap1-tab3-label, main input:checked +  #sfbap1-tab4-label {
    border-top-color: #FFB03D;
    border-right-color: #DDD;
    border-left-color: #DDD;
    border-bottom-color: transparent;
    text-decoration: none;
  }
  #sfbap1_show_photos_from_id , #sfbap1_show_photos_from_location , #sfbap1_show_photos_from_hashtag{
    margin-top: 2px;
  }
  .sfbap1_checkbox{
    width: 25px !important;
    height: 25px !important;
    border: 1px solid lightgrey !important;
    border-radius: 5px !important;
    margin-left: 10px !important;
  }
  .sfbap1_checkbox:checked:before{
    font-size: 30px !important;
  }
  #sfbap1_theme_selection_table tr td{
    vertical-align: top;
    display: inline-block;
  }
  #sfbap1-form { 
    background: -webkit-linear-gradient(bottom,#eaeaea, #fafafa);
    padding: 10px;
    display: inline-block;
    box-shadow: 0 1px 1px rgba(0,0,0,.65);
    border-radius: 3px;
    border: solid 1px #ddd;
    width: 98%; 
}
#sfbap1-fb input { display: none; }
#sfbap1-fb input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}

#sfbap1-twitter input { display: none; }
#sfbap1-twitter input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}

#sfbap1-instagram input { display: none; }
#sfbap1-instagram input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}

#sfbap1-gp input { display: none; }
#sfbap1-gp input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}

#sfbap1-pinterest input { display: none; }
#sfbap1-pinterest input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}

#sfbap1-vk input { display: none; }
#sfbap1-vk input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}

#sfbap1-rss input { display: none; }
#sfbap1-rss input:checked + label { 
    background: -webkit-linear-gradient(top,#4D90FE,#4787ED);
    border: solid 1px rgba(0,0,0,.15);
    color: white; 
    box-shadow: 0 1px 1px rgba(0,0,0,.65), 0 1px 0 rgba(255,255,255,.1) inset;
    text-shadow: 0 -1px 0 rgba(0,0,0,.6);
}
#sfbap1-fb label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-twitter label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-instagram label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-gp label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-pinterest label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-vk label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-rss label { 
    font-family: helvetica;
    cursor: pointer; 
    display: block; 
    border: solid 1px transparent;
    width: 100%; 
    height: 40px; 
    text-align: center; 
    line-height: 40px; 001
    border-radius: 3px; 
    margin-bottom: 10px;
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-fb label:last-child { margin-right: 0; }
#sfbap1-fb label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-twitter label:last-child { margin-right: 0; }
#sfbap1-twitter label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-instagram label:last-child { margin-right: 0; }
#sfbap1-instagram label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-gp label:last-child { margin-right: 0; }
#sfbap1-gp label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-pinterest label:last-child { margin-right: 0; }
#sfbap1-pinterest label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-vk label:last-child { margin-right: 0; }
#sfbap1-vk label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-rss label:last-child { margin-right: 0; }
#sfbap1-rss label:hover {     
    background: rgba(77, 144, 254, .5); 
    border: solid 1px rgba(0,0,0,.15); 
}

#sfbap1-fb article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-twitter article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-instagram article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-gp article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-pinterest article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-vk article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-rss article { 
    height: 0; 
    overflow: hidden; 
    -webkit-transition: height .25s linear, opacity .15s linear; 
    position: relative; 
    top: -5px;
    margin-bottom: 0;
    padding: 0 10px;
    color: #333;
    font-family: helvetica;
    font-size: 12px;
    line-height: 18px;
    opacity: 0;
    border: 1px solid lightgrey;
}

#sfbap1-fb > input:checked ~ article { height: 195px; opacity: 1; }

#sfbap1-twitter > input:checked ~ article { height: 210px; opacity: 1; }

#sfbap1-instagram > input:checked ~ article { height: 210px; opacity: 1; }

#sfbap1-gp > input:checked ~ article { height: 210px; opacity: 1; }

#sfbap1-pinterest > input:checked ~ article { height: 210px; opacity: 1; }

#sfbap1-vk > input:checked ~ article { height: 210px; opacity: 1; }

#sfbap1-rss > input:checked ~ article { height: 210px; opacity: 1; }
​/**
 * iOS 6 style switch checkboxes
 * by Lea Verou http://lea.verou.me
 */

:root input[type="checkbox"] { /* :root here acting as a filter for older browsers */
  position: absolute;
  opacity: 0;
}

:root input[type="checkbox"].ios-switch + div {
  display: inline-block;
  vertical-align: middle;
  width: 3em; height: 1em;
  border: 1px solid rgba(0,0,0,.3);
  border-radius: 999px;
  margin: 0 .5em;
  background: white;
  background-image: linear-gradient(rgba(0,0,0,.1), transparent),
                    linear-gradient(90deg, hsl(210, 90%, 60%) 50%, transparent 50%);
  background-size: 200% 100%;
  background-position: 100% 0;
  background-origin: border-box;
  background-clip: border-box;
  overflow: hidden;
  transition-duration: .4s;
  transition-property: padding, width, background-position, text-indent;
  box-shadow: 0 .1em .1em rgba(0,0,0,.2) inset,
              0 .45em 0 .1em rgba(0,0,0,.05) inset;
  font-size: 150%; /* change this and see how they adjust! */
  margin-top: -5px;
}

:root input[type="checkbox"].ios-switch:checked + div {
  padding-left: 2em;  width: 1em;
  background-position: 0 0;
}

:root input[type="checkbox"].ios-switch + div:before {
  content: 'On';
  float: left;
  width: 1.65em; height: 1.65em;
  margin: -.1em;
  border: 1px solid rgba(0,0,0,.35);
  border-radius: inherit;
  background: white;
  background-image: linear-gradient(rgba(0,0,0,.2), transparent);
  box-shadow: 0 .1em .1em .1em hsla(0,0%,100%,.8) inset,
              0 0 .5em rgba(0,0,0,.3);
  color: white;
  text-shadow: 0 -1px 1px rgba(0,0,0,.3);
  text-indent: -2.0em;
}

:root input[type="checkbox"].ios-switch:active + div:before {
  background-color: #eee;
}

:root input[type="checkbox"].ios-switch:focus + div {
  box-shadow: 0 .1em .1em rgba(0,0,0,.2) inset,
              0 .45em 0 .1em rgba(0,0,0,.05) inset,
              0 0 .4em 1px rgba(255,0,0,.5);
}

:root input[type="checkbox"].ios-switch + div:before,
:root input[type="checkbox"].ios-switch + div:after {
  font: bold 60%/1.9 sans-serif;
  text-transform: uppercase;
}

:root input[type="checkbox"].ios-switch + div:after {
  content: 'Off';
  float: left;
  text-indent: .5em;
  color: rgba(0,0,0,.45);
  text-shadow: none;

}


/* Switch code ends here, from now on it’s just bling for the demo page */

#sfbap1-label label {
  position: relative;
  display: block;
  padding: .8em;
  border: 1px solid silver;
  border-top-width: 0;
  background: white;
  font: bold 110% sans-serif;
}

#sfbap1-label label:first-of-type {
  border-top-width: 1px;
  border-radius: .6em .6em 0 0;
}

#sfbap1-label label:last-of-type {
  border-radius: 0 0 .6em .6em;
  box-shadow: 0 1px hsla(0,0%,100%,.8);
}


</style>
<p style="text-align: center;
    background: white;
    border: 2px solid #ffce87;
    padding: 5px;
    font-size: 17px;">Copy this shortcode & paste into your Posts or Pages to show social feed<br/> <strong>[arrow_sf id='<?php echo $post->ID; ?>']</strong></p>
<main style="position: relative;">
  <input id="sfbap1-tab1" type="radio" name="sfbap1-tabs" checked>
  <label id="sfbap1-tab1-label" for="sfbap1-tab1">General Settings</label>
  <input id="sfbap1-tab2" type="radio" name="sfbap1-tabs">
  <label id="sfbap1-tab2-label" for="sfbap1-tab2">Social Account Settings</label>
  <section id="sfbap1-content1">
  <div id="sfbap1-user-tip" style="    position: absolute;display: none;
    right: 0;
    top: 0;
    margin: 15px;
    color: red;
    font-size: 15px;
    font-weight: bold;
    width: 50%;
    text-align: center;">You haven't enabled any social network yet! Please go to "Social Account Settings" Tab</div>
    <h2 style="font-size: 17px;">Select Feed Style:</h2>
    <table id="sfbap1_style_selection_option">
      <tr>
       <td>
          <p style="text-align: center;margin: 0;">
            <input id="sfbap1_feed_style_vertical" type="radio" name="sfbap1_feed_style" value="vertical" <?php echo ($sfbap1_feed_style == 'vertical')? 'checked="checked"':''; ?> <?php if($sfbap1_feed_style == ''){ echo 'checked="checked"';} ?> /> 
            <label for="sfbap1_feed_style_vertical"><strong>Vertical</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="sfbap1_feed_style_vertical">
              <img id="sfbap1_vertical_image" src="<?php echo plugins_url('images/vertical.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input id="sfbap1_feed_style_thumbnails" type="radio" name="sfbap1_feed_style" value="thumbnails" <?php echo ($sfbap1_feed_style == 'thumbnails')? 'checked="checked"':''; ?> /> 
            <label for="sfbap1_feed_style_thumbnails"><strong>Thumbnails</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="sfbap1_feed_style_thumbnails">
              <img id="sfbap1_thumbnails_image" src="<?php echo plugins_url('images/thumbnails.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled id="sfbap1_feed_style_blog_style" type="radio" name="" value=""  /> 
            <label for="sfbap1_feed_style_blog_style"><strong>Blog Style <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="sfbap1_feed_style_blog_style">
              <img id="sfbap1_blog_image" class="sfbap1_style_image" src="<?php echo plugins_url('images/blog_style.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled id="sfbap1_feed_style_masonry" type="radio" name="" value=""  /> 
            <label for="sfbap1_feed_style_masonry"><strong>Masonry <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
            <label for="sfbap1_feed_style_masonry">
              <img id="sfbap1_masonry_image" class="sfbap1_style_image" src="<?php echo plugins_url('images/masonry.png',__FILE__); ?>" />
            </label>
          </p>
        </td>
      </tr>
    </table>


    <table id="sfbap1_general_options">
    
     
    </table>

    <table id="sfbap1_thumbnail_style_options" style="display: none;">
    <tr>
        <td colspan="2">
            <strong style="color: red;"><span style="font-size: 18px;">Note:</span> Thumbnail View is best suited for Instagram & Pinterest 
            <br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; It will only show pictures if any feed have no pictures in it it will not show that specific feed.</strong>
        </td>
      </tr>
      <tr>
        <td>
          <h3>Thumbnail Size: </h3> 
        </td>
        <td>
          <input style="width: 70px;margin-left: 106px;" type="number"  id="sfbap1_thumbnail_size" name="sfbap1_thumbnail_size" value="<?php if($sfbap1_thumbnail_size == ''){ echo '250' ;}else{ echo $sfbap1_thumbnail_size; } ?>" /> px 
        </td>
      </tr>
    </table>

<table id="sfbap1_column_count_settings" style="display: none;">
      <tr>
        <td>
          <h3>Number of Columns in a Row: </h3> 
        </td>
        <td>
          <input style="width: 70px;margin-left: ;" type="number"  id="sfbap1_column_count" name="sfbap1_column_count" value="<?php if($sfbap1_column_count == ''){ echo '2' ;}else{ echo $sfbap1_column_count; } ?>" /> 
        </td>
      </tr>
    </table>

    <table id="sfbap1_blog_masonry_style_options" style="display: none;">
      <tr>
        <td>
          <h3>Limit Post Caption Text: </h3> 
        </td>
        <td>
          <input type="number" min="50" max="600" id="sfbap1_limit_post_characters" name="sfbap1_limit_post_characters" value="<?php if($sfbap1_limit_post_characters == ''){ echo '300' ;}else{ echo $sfbap1_limit_post_characters; } ?>" /> Characters <span>Minimum value is 50 & Maximum value is 600</span>
        </td>
      </tr>
      <tr>
        <td>
          <h3>Show Photos Only: </h3> 
        </td>
        <td>
          <input type="checkbox" class="sfbap1_checkbox" name="sfbap1_show_photos_only" id="sfbap1_show_photos_only"  value='1'<?php checked(1, $sfbap1_show_photos_only); ?> /> <span style="font-size: 13px;"><strong>(This will hide Post Caption Text, Profile Picture & Date Posted from your feed card)</strong></span>
        </td>
      </tr>
      <tr>
        <td>
          <h3>Change Date Posted Language: </h3> 
        </td>
        <td>
        <select name="sfbap1_date_posted_lang" id="sfbap1_date_posted_lang" value='1'<?php checked(1, $sfbap1_date_posted_lang); ?> >
            <option value="en" <?php if ( $sfbap1_date_posted_lang == "en" ) echo 'selected="selected"'; ?> >English (Default)</option>
            <option value="ar" <?php if ( $sfbap1_date_posted_lang == "ar" ) echo 'selected="selected"'; ?> >Arabic</option>
            <option value="bn" <?php if ( $sfbap1_date_posted_lang == "bn" ) echo 'selected="selected"'; ?> >Bangali</option>
            <option value="cs" <?php if ( $sfbap1_date_posted_lang == "cs" ) echo 'selected="selected"'; ?> >Czech</option>
            <option value="da" <?php if ( $sfbap1_date_posted_lang == "da" ) echo 'selected="selected"'; ?> >Danish</option>
            <option value="nl" <?php if ( $sfbap1_date_posted_lang == "nl" ) echo 'selected="selected"'; ?> >Dutch</option>
            <option value="fr" <?php if ( $sfbap1_date_posted_lang == "fr" ) echo 'selected="selected"'; ?> >French</option>
            <option value="de" <?php if ( $sfbap1_date_posted_lang == "de" ) echo 'selected="selected"'; ?> >German</option>
            <option value="it" <?php if ( $sfbap1_date_posted_lang == "it" ) echo 'selected="selected"'; ?> >Italian</option>
            <option value="ja" <?php if ( $sfbap1_date_posted_lang == "ja" ) echo 'selected="selected"'; ?> >Japanese</option>
            <option value="ko" <?php if ( $sfbap1_date_posted_lang == "ko" ) echo 'selected="selected"'; ?> >Korean</option>
            <option value="pt" <?php if ( $sfbap1_date_posted_lang == "pt" ) echo 'selected="selected"'; ?> >Portuguese</option>
            <option value="ru" <?php if ( $sfbap1_date_posted_lang == "ru" ) echo 'selected="selected"'; ?> >Russian</option>
            <option value="es" <?php if ( $sfbap1_date_posted_lang == "es" ) echo 'selected="selected"'; ?> >Spanish</option>
            <option value="tr" <?php if ( $sfbap1_date_posted_lang == "tr" ) echo 'selected="selected"'; ?> >Turkish</option>
            <option value="uk" <?php if ( $sfbap1_date_posted_lang == "uk" ) echo 'selected="selected"'; ?> >Ukranian</option>
        </select>
        </td>
      </tr>
      <tr>
        <td>
          <h3>Hide Date Posted: </h3> 
        </td>
        <td>
          <input type="checkbox" class="sfbap1_checkbox" name="sfbap1_date_posted" id="sfbap1_date_posted" value='1'<?php checked(1, $sfbap1_date_posted); ?>   />
        </td>
      </tr>
      <tr>
        <td>
          <h3>Hide Profile Picture: </h3> 
        </td>
        <td>
          <input type="checkbox" class="sfbap1_checkbox" name="sfbap1_profile_picture" id="sfbap1_profile_picture" value='1'<?php checked('1', $sfbap1_profile_picture); ?> />
        </td>
      </tr>
      <tr>
        <td>
          <h3>Hide Post Caption Text: </h3> 
        </td>
        <td>
          <input type="checkbox" class="sfbap1_checkbox" name="sfbap1_caption_text" id="sfbap1_caption_text" value='1'<?php checked('1', $sfbap1_caption_text); ?> />
        </td>
      </tr>
      <tr>
        <td>
          <h3>Hide Social Icon From Feed Card: </h3> 
        </td>
        <td>
          <input type="checkbox" class="sfbap1_checkbox" name="sfbap1_social_icon" id="sfbap1_caption_text" value='1'<?php checked('1', $sfbap1_social_icon); ?> />
        </td>
      </tr>
    </table>
<br/>

<h2 style="    font-size: 18px; margin: 0;padding: 3px;">Select Feed Template:</h2>
<br/>
    
    <table id="sfbap1_theme_selection_table">
      <tr>
        <td>
          <p style="text-align: center;margin: 0;">
            <input type="radio" id="sfbap1_theme_selection_default" name="sfbap1_theme_selection" value="default" <?php echo ($sfbap1_theme_selection == 'default')? 'checked="checked"':''; ?> <?php if($sfbap1_theme_selection == ''){ echo 'checked="checked"';} ?>/>
            <label for="sfbap1_theme_selection_default"><strong>Default</strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="sfbap1_theme_selection_default">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/default.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="sfbap1_theme_selection_template0" name="" value=""  />
            <label for="sfbap1_theme_selection_template0"><strong>Dark <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="sfbap1_theme_selection_template0">
            <img style="width: 200px;" src="<?php echo plugins_url('images/template0.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="sfbap1_theme_selection_template1" name="" value=""  />
            <label for="sfbap1_theme_selection_template1"><strong>Pinterest Like Layout <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="sfbap1_theme_selection_template1">
            <img style="width: 200px;" src="<?php echo plugins_url('images/template1.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="sfbap1_theme_selection_template2" name="" value=""  />
            <label for="sfbap1_theme_selection_template2"><strong>Modern Light <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="sfbap1_theme_selection_template2">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/template2.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="sfbap1_theme_selection_template3" name="" value=""  />
            <label for="sfbap1_theme_selection_template3"><strong>Modern Dark <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="sfbap1_theme_selection_template3">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/template3.png',__FILE__); ?>">
            </label>
          </p>
        </td>
        <td>
          <p style="text-align: center;margin: 0;">
            <input disabled type="radio" id="sfbap1_theme_selection_template4" name="" value=""  />
            <label for="sfbap1_theme_selection_template4"><strong>Space White <a href="https://www.arrowplugins.com/social-feed" target="_blank">Locked</a></strong></label>
          </p>
          <p style="text-align: center;margin: 5px;">
          <label for="sfbap1_theme_selection_template4">
            <img style="    box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important; width: 200px;" src="<?php echo plugins_url('images/template4.png',__FILE__); ?>">
            </label>
          </p>
        </td>







      </tr>
    </table>
  </section>
  <section id="sfbap1-content2">
    <form id="sfbap1-form">

        <div id="sfbap1-fb">
            <input type="radio" name="size" id="small" value="small" checked="checked" /> 
            <label style="    background: #4867aa;" for="small"><img style="width: 129px;
    margin-top: 4px;" src="<?php echo plugins_url('images/facebook.png',__FILE__); ?>"></label>
            <article>
  <label style="text-align: left;
    border: none;
    margin-top: 25px;" id="sfbap1-label"><strong style="font-size: 20px;">Enable Facebook Feed:</strong> 
  <input type="checkbox" class="ios-switch" name="sfbap1_enable_facebook_feed" id="sfbap1_enable_facebook_feed"  value='1'<?php checked(1, $sfbap1_enable_facebook_feed); ?>>
  <div class="switch">
      
  </div></label>
              <p style="font-size: 1.3em;"><strong>Enter Facebook Page: </strong> www.facebook.com/<input type="text" placeholder="facebook-page-name" style="display: inline-block;" name="sfbap1_facebook_page_id" value="<?php echo $sfbap1_facebook_page_id; ?>" ></p>
              <table style="display: block;">
                   <tr>
        <td>
          <h3>Number of Facebook Posts to Show: </h3> 
        </td>
        <td>
          <input style="margin-left: 15px;display: inline-block;" type="number" min="1" max="20" id="sfbap1_number_of_photos" name="sfbap1_number_facebook" value="<?php if($sfbap1_number_facebook == ''){ echo '20' ;}else{ echo $sfbap1_number_facebook; } ?>" /> max 20 allowed in Free Version
        </td>
      </tr>
              </table>
            </article>
        </div>

        <div id="sfbap1-twitter">
            <input type="radio" class="sfbap1-inputs" name="size" id="medium" value="medium" />     
            <label style="background: #33ccff;" for="medium"><img src="<?php echo plugins_url('images/twitter.gif',__FILE__); ?>" style="    width: 143px;
    margin-top: 0px;"></label>
            <article style="">
<label style="text-align: left;
    border: none;
    margin-top: 25px;" id="sfbap1-label"><strong style="font-size: 20px;">Enable Twitter Feed:</strong> 
<input  type="checkbox" class="ios-switch" name="sfbap1_enable_twitter_feed" id="sfbap1_enable_twitter_feed"  value='1'<?php checked(1, $sfbap1_enable_twitter_feed); ?>>
<div class="switch"></div></label>
             
<table>
      <tr>
        <td style="vertical-align: top;">
          <h3 style="margin: 6px;">Show Tweets From:</h3>
        </td>
        <td>
          <table id="sfbap1_selection_table">
            <tr>
              <td>
                <input style="display: inline-block;" type="radio" id="sfbap1_show_photos_from_id" name="sfbap1_show_photos_from_twitter" value='userid'<?php checked( "userid", $sfbap1_show_photos_from_twitter); ?> <?php if($sfbap1_show_photos_from_twitter == ''){ echo 'checked="checked"';} ?> />
                <label style="    background: none;
    color: black;
    box-shadow: none;
    text-shadow: none;
    text-decoration: none;
    border: none;
    width: 70px;
    height: 27px;
    text-align: left;
    line-height: 40px;
    margin-bottom: 0px;
    display: inline-block;
    padding: 0;
    margin-top: -9px;" for="sfbap1_show_photos_from_id"><strong>Username:</strong></label> 
              </td>
              <td>
                <input style="display:  inline-block;;" type="text" id="sfbap1_show_photos_from_id_value" name="sfbap1_user_id_twitter" placeholder="@twitter_username" value="<?php echo $sfbap1_user_id_twitter; ?>" /> <strong>Example: @audi</strong>
              </td>
            </tr>
            <tr>
              <td>
                <input disabled style="display: inline-block;" type="radio" id="sfbap1_show_photos_from_hashtag"   name="" value=''  /> 
                <label style="    background: none;
    color: black;
    box-shadow: none;
    text-shadow: none;
    text-decoration: none;
    border: none;
    width: 70px;
    height: 27px;
    text-align: left;
    line-height: 40px;
    margin-bottom: 0px;
    display: inline-block;
    padding: 0;
    margin-top: -9px;" for="sfbap1_show_photos_from_hashtag"><strong>Hashtag:</strong></label> 
              </td>
              <td>
                <input disabled style="display:  inline-block;;" type="text" id="sfbap1_show_photos_from_hashtag_value" placeholder="#sunshine" name="sfbap1_hashtag_twitter" value="<?php echo $sfbap1_hashtag_twitter; ?>" /> <strong><a href="https://www.arrowplugins.com/social-feed" target="_blank">Premium Feature</a></strong>
              </td>
            </tr>
          </table>
        </td>
      </tr>

     
</table>
 <table style="display: block;">
                   <tr>
        <td>
          <h3>Number of Tweets to Show: </h3> 
        </td>
        <td>
          <input style="margin-left: 15px;display: inline-block;" type="number" min="1" max="20" id="sfbap1_number_of_photos" name="sfbap1_number_twitter" value="<?php if($sfbap1_number_twitter == ''){ echo '20' ;}else{ echo $sfbap1_number_twitter; } ?>" /> max 20 allowed in Free Version
        </td>
      </tr>
              </table>

            </article>    
        </div>

        <div id="sfbap1-instagram">
            <input type="radio" class="sfbap1-inputs" name="size" id="large" value="large" />     
            <label style="    background: #125688;" for="large"><img src="<?php echo plugins_url('images/instagram.png',__FILE__); ?>" style="    width: 99px;
    margin-top: 8px;"></label>
            <article>

<label style="text-align: left;
    border: none;
    margin-top: 25px;" id="sfbap1-label"><strong style="font-size: 20px;">Enable Instagram Feed:</strong> 

<input type="checkbox" class="ios-switch" name="sfbap1_enable_instagram_feed" id="sfbap1_enable_instagram_feed"  value='1'<?php checked(1, $sfbap1_enable_instagram_feed); ?>>
<div class="switch"></div></label>
              

              <table>
      <tr>
        <td style="vertical-align: top;">
          <h3 style="margin: 6px;">Show Photos From:</h3>
        </td>
        <td>
          <table id="sfbap1_selection_table">
            <tr>
              <td>
                <input style="display: inline-block;" type="radio" id="sfbap1_show_photos_from_id_instagram" name="sfbap1_show_photos_from_instagram" value='userid'<?php checked( "userid", $sfbap1_show_photos_from_instagram); ?> <?php if($sfbap1_show_photos_from_twitter == ''){ echo 'checked="checked"';} ?> />
                <label style="    background: none;
    color: black;
    box-shadow: none;
    text-shadow: none;
    text-decoration: none;
    border: none;
    width: 70px;
    height: 27px;
    text-align: left;
    line-height: 40px;
    margin-bottom: 0px;
    display: inline-block;
    padding: 0;
    margin-top: -9px;" for="sfbap1_show_photos_from_id_instagram"><strong>Username:</strong></label> 
              </td>
              <td>
                <input style="display:  inline-block;;" type="text" id="sfbap1_show_photos_from_id_value" name="sfbap1_user_id_instagram" placeholder="@instagram_username" value="<?php echo $sfbap1_user_id_instagram; ?>" /> <strong>Example: @audi</strong>
              </td>
            </tr>
            <tr>
              <td>
                <input disabled style="display: inline-block;" type="radio" id="sfbap1_show_photos_from_hashtag_instagram"   name="" value='' /> 
                <label style="    background: none;
    color: black;
    box-shadow: none;
    text-shadow: none;
    text-decoration: none;
    border: none;
    width: 70px;
    height: 27px;
    text-align: left;
    line-height: 40px;
    margin-bottom: 0px;
    display: inline-block;
    padding: 0;
    margin-top: -9px;" for="sfbap1_show_photos_from_hashtag_instagram"><strong>Hashtag:</strong></label> 
              </td>
              <td>
                <input disabled style="display:  inline-block;;" type="text" id="sfbap1_show_photos_from_hashtag_value" placeholder="#sunshine" name="" value="" /> <strong><a href="https://www.arrowplugins.com/social-feed" target="_blank">Premium Feature</a></strong>
              </td>
            </tr>
          </table>
        </td>
      </tr>
</table>
 <table style="display: block;">
                   <tr>
        <td>
          <h3>Number of Instagram Photos to Show: </h3> 
        </td>
        <td>
          <input style="margin-left: 15px;display: inline-block;" type="number" min="1" max="20" id="sfbap1_number_of_photos" name="sfbap1_number_instagram" value="<?php if($sfbap1_number_instagram == ''){ echo '20' ;}else{ echo $sfbap1_number_instagram; } ?>" /> max 20 allowed in Free Version
        </td>
      </tr>
              </table>
            </article>
        </div>

        <div id="sfbap1-pinterest">
            <input type="radio" class="sfbap1-inputs" name="size" id="xxxlarge" value="xxxlarge" />     
            <label style="background: #d42127;" for="xxxlarge"><img src="<?php echo plugins_url('images/pinterest.jpg',__FILE__); ?>" style="    width: 119px;
    margin-top: 2px;"></label>
            <article>

<label style="text-align: left;
    border: none;
    margin-top: 25px;" id="sfbap1-label"><strong style="font-size: 20px;">Enable Pinterest Feed:</strong> 
<input type="checkbox" class="ios-switch" name="sfbap1_enable_pinterest_feed" id="sfbap1_enable_pinterest_feed"  value='1'<?php checked(1, $sfbap1_enable_pinterest_feed); ?>>
<div class="switch"></div></label>
              <p  style="font-size: 1.3em;"><strong>Enter Your Pinterest Borad: </strong> www.pinterest.com/<input type="text" placeholder="username/bord-name" style="display: inline-block;width: 50%;" name="sfbap1_pinterest_board" value="<?php echo $sfbap1_pinterest_board; ?>" ></p>

               <table style="display: block;">
                   <tr>
        <td>
          <h3>Number of Board Pins to Show: </h3> 
        </td>
        <td>
          <input style="margin-left: 15px;display: inline-block;" type="number" min="1" max="20" id="sfbap1_number_of_photos" name="sfbap1_number_pinterest" value="<?php if($sfbap1_number_pinterest == ''){ echo '20' ;}else{ echo $sfbap1_number_pinterest; } ?>" /> max 20 allowed in Free Version
        </td>
      </tr>
              </table>

            </article>
        </div>

        <div id="sfbap1-vk">    
            <input type="radio" class="sfbap1-inputs" name="size" id="xxxxlarge" value="xxxxlarge" />     
            <label style="background: #507299;" for="xxxxlarge"><img src="<?php echo plugins_url('images/vk.png',__FILE__); ?>" style="width: 119px;"></label>
            <article>

<label style="text-align: left;
    border: none;
    margin-top: 25px;" id="sfbap1-label"><strong style="font-size: 20px;">Enable VK Feed:</strong> 
<input type="checkbox" class="ios-switch" name="sfbap1_enable_vk_feed" id="sfbap1_enable_vk_feed"  value='1'<?php checked(1, $sfbap1_enable_vk_feed); ?>>
<div class="switch"></div></label>
              <p  style="font-size: 1.3em;"><strong>Enter Your VK Account ID: </strong> <input type="text" name="sfbap1_vk_hashtag" value="<?php echo $sfbap1_vk_hashtag; ?>"  placeholder="5874905" style="display: inline-block;"></p>


                <table style="display: block;">
                   <tr>
        <td>
          <h3>Number of VK Posts to Show: </h3> 
        </td>
        <td>
          <input style="margin-left: 15px;display: inline-block;" type="number" min="1" max="20" id="sfbap1_number_of_photos" name="sfbap1_number_vk" value="<?php if($sfbap1_number_vk == ''){ echo '20' ;}else{ echo $sfbap1_number_vk; } ?>" /> max 20 allowed in Free Version
        </td>
      </tr>
              </table>

            </article>
        </div>

    </form>
  </section>
  <section id="sfbap1-content3">
    <h3>Heading Text</h3>
    <p>Fusce pulvinar porttitor dui, eget ultrices nulla tincidunt vel. Suspendisse faucibus lacinia tellus, et viverra ligula. Suspendisse eget ipsum auctor, congue metus vel, dictum erat. Aenean tristique euismod molestie. Nulla rutrum accumsan nisl, ac semper sapien tincidunt et. Praesent tortor risus, commodo et sagittis nec, aliquam quis augue. Aenean non elit elementum, tempor metus at, aliquam felis.</p>
  </section>
  <section id="sfbap1-content4">
    <h3>Here Are Many Words</h3>
    <p>Vivamus convallis lectus lobortis dapibus ultricies. Sed fringilla vitae velit id rutrum. Maecenas metus felis, congue ut ante vitae, porta cursus risus. Nulla facilisi. Praesent vel ligula et erat euismod luctus. Etiam scelerisque placerat dapibus. Vivamus a mauris gravida urna mattis accumsan. Duis sagittis massa vel elit tincidunt, sed molestie lacus dictum. Mauris elementum, neque eu dapibus gravida, eros arcu euismod metus, vitae porttitor nibh elit at orci. Vestibulum laoreet id nulla sit amet mattis.</p>
  </section>
</main>
<script type="text/javascript">
    var $boxes = jQuery('input[name=sfbap1_enable_facebook_feed]:checked');
    if($boxes.length == 0){
        jQuery('#sfbap1-user-tip').show();
    }else{
        jQuery('#sfbap1-user-tip').hide();

    }
</script>