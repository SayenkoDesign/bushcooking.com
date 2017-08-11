<?php 
add_shortcode( 'arrow_sf', 'sfbap1_arrow_feed_shortcode' );
function sfbap1_arrow_feed_shortcode($atts , $content){

extract( shortcode_atts( array( 'id' => null ) , $atts ) );
$sfbap1_show_photos_from_id_twitter = get_post_meta( $id,'_sfbap1_show_photos_from_id_twitter',true);
if($sfbap1_show_photos_from_id_twitter == 'userid'){
$twitter_query =  get_post_meta( $id,'_sfbap1_twitter_user_id',true);
}
if($sfbap1_show_photos_from_twitter == 'hashtag'){
$twitter_query = get_post_meta( $id,'_sfbap1_twitter_hashtag',true);
}
$sfbap1_number_of_photos = get_post_meta( $id,'_sfbap1_number_of_photos',true);
$sfbap1_date_posted = get_post_meta($id, '_sfbap1_date_posted', true);
$sfbap1_profile_picture = get_post_meta($id, '_sfbap1_profile_picture', true);
$sfbap1_caption_text = get_post_meta($id, '_sfbap1_caption_text', true);
$sfbap1_show_photos_only = get_post_meta($id, '_sfbap1_show_photos_only', true);
$sfbap1_feed_style = get_post_meta($id, '_sfbap1_feed_style', true);
$sfbap1_thumbnail_size = get_post_meta($id, '_sfbap1_thumbnail_size', true);
$sfbap1_limit_post_characters = get_post_meta($id, '_sfbap1_limit_post_characters', true);
$sfbap1_column_count = get_post_meta($id, '_sfbap1_column_count', true);
$sfbap1_theme_selection = get_post_meta($id, '_sfbap1_theme_selection', true);
$sfbap1_private_access_token = get_post_meta($id, '_sfbap1_private_access_token', true);

$sfbap1_enable_facebook_feed = get_post_meta($id, '_sfbap1_enable_facebook_feed', true);
$sfbap1_enable_twitter_feed = get_post_meta($id, '_sfbap1_enable_twitter_feed', true);
$sfbap1_enable_instagram_feed = get_post_meta($id, '_sfbap1_enable_instagram_feed', true);
$sfbap1_enable_pinterest_feed = get_post_meta($id, '_sfbap1_enable_pinterest_feed', true);
$sfbap1_enable_google_feed = get_post_meta($id, '_sfbap1_enable_google_feed', true);
$sfbap1_enable_vk_feed = get_post_meta($id, '_sfbap1_enable_vk_feed', true);
$sfbap1_enable_rss_feed = get_post_meta($id, '_sfbap1_enable_rss_feed', true);



$sfbap1_facebook_page_id = get_post_meta($id, '_sfbap1_facebook_page_id', true);

$sfbap1_show_photos_from_twitter = get_post_meta($id, '_sfbap1_show_photos_from_twitter', true);
$sfbap1_user_id_twitter = get_post_meta($id, '_sfbap1_user_id_twitter', true);
$sfbap1_hashtag_twitter = get_post_meta($id, '_sfbap1_hashtag_twitter', true);


$sfbap1_show_photos_from_instagram = get_post_meta($id, '_sfbap1_show_photos_from_instagram', true);
$sfbap1_user_id_instagram = get_post_meta($id, '_sfbap1_user_id_instagram', true);
$sfbap1_hashtag_instagram = get_post_meta($id, '_sfbap1_hashtag_instagram', true);

$sfbap1_pinterest_board = get_post_meta($id, '_sfbap1_pinterest_board', true);

$sfbap1_vk_hashtag = get_post_meta($id, '_sfbap1_vk_hashtag', true);

$sfbap1_number_facebook = get_post_meta($id, '_sfbap1_number_facebook', true);
$sfbap1_number_twitter = get_post_meta($id, '_sfbap1_number_twitter', true);
$sfbap1_number_instagram = get_post_meta($id, '_sfbap1_number_instagram', true);
$sfbap1_number_pinterest = get_post_meta($id, '_sfbap1_number_pinterest', true);
$sfbap1_number_vk = get_post_meta($id, '_sfbap1_number_vk', true);
$sfbap1_date_posted_lang = get_post_meta($id, '_sfbap1_date_posted_lang', true);
$sfbap1_social_icon = get_post_meta($id, '_sfbap1_social_icon', true);





ob_start();

?>
<style>
.social-feed-container-<?php echo $id; ?> .fa-facebook{
<?php if($sfbap1_social_icon == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .fa-twitter{
<?php if($sfbap1_social_icon == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .fa-instagram{
<?php if($sfbap1_social_icon == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .fa-pinterest{
<?php if($sfbap1_social_icon == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .fa-vk{
<?php if($sfbap1_social_icon == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .social-feed-element a{
color: #0088cc !important;
text-decoration: none !important;
display: block !important;
}
.social-feed-container-<?php echo $id; ?> .pull-left{

<?php if($sfbap1_profile_picture == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .pull-right{

<?php if($sfbap1_date_posted == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{

<?php if($sfbap1_caption_text == '1'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .content{

<?php if($sfbap1_show_photos_only == '1' || $sfbap1_feed_style == 'thumbnails'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{

<?php if($sfbap1_show_photos_only == '1' || $sfbap1_feed_style == 'thumbnails'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .pull-right{

<?php if($sfbap1_show_photos_only == '1' || $sfbap1_feed_style == 'thumbnails'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> p.social-feed-text{
<?php if($sfbap1_show_photos_only == '1' || $sfbap1_feed_style == 'thumbnails'){echo 'display: none !important;';}?>
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body{
<?php if($sfbap1_show_photos_only == '1' || $sfbap1_feed_style == 'thumbnails'){echo 'display: none !important;';}?>
}
<?php if($sfbap1_theme_selection == 'default' || $sfbap1_theme_selection == 'template0'){  ?>

<?php  if($sfbap1_feed_style == 'thumbnails'){ ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element{
width: <?php echo $sfbap1_thumbnail_size; ?>px !important;
display: inline-block !important;
background-color:white !important;
padding: 0 !important;
margin: 5px !important;
vertical-align: middle !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .muted{
color: #6d6d6d;
}
.grid-item {
display: inline-block !important;
position: relative !important;
} 
.social-feed-container-<?php echo $id; ?> {
text-align: center !important;

}<?php } if($sfbap1_feed_style == 'blog_style' || $sfbap1_feed_style == 'vertical' ){ ?>
.social-feed-container-<?php echo $id; ?> .author-title{
font-weight: bold !important;

}
.grid-item{
	position: relative !important;
}
	.fa-facebook{
	    position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #0088cc !important;
    padding: 1px 6px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 3px !important;
}
.fa-twitter{
    position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #4bc3ff !important;
    padding: 1px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 3px !important;
}
.fa-instagram{
	position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #0484c4 !important;
    padding: 2px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.fa-pinterest{
	position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #c40416  !important;
    padding: 2px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.fa-vk{
	position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #507299  !important;
    padding: 3px 2px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
<?php if($sfbap1_feed_style == 'vertical'){?> 
.social-feed-container-<?php echo $id; ?> {
width: 400px !important;
margin: 0 auto !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
margin-bottom: 10px !important;
}
.social-feed-container-<?php echo $id; ?> .pull-right{
float: right !important;
}
<?php } ?>
<?php if($sfbap1_feed_style == 'vertical' && $sfbap1_theme_selection == 'template0'){?> 
	.social-feed-container-<?php echo $id; ?> .author-title{
font-weight: bold !important;

}
.grid-item{
	position: relative !important;
}
	.fa-facebook{
	    position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #0088cc !important;
    padding: 1px 6px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 3px !important;
}
.fa-twitter{
    position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #4bc3ff !important;
    padding: 1px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 3px !important;
}
.fa-instagram{
	position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #0484c4 !important;
    padding: 2px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.fa-pinterest{
	position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #c40416  !important;
    padding: 2px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.fa-vk{
	position: absolute !important;
    top: 0 !important;
    right: 1px !important;
    background: #507299  !important;
    padding: 3px 2px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text{
color: white !important;
}.social-feed-container-<?php echo $id; ?> .pull-right{
float: right !important;
}
.fa-facebook{
	    position: absolute;
    top: 3px;
    right: 3px;
    background: #0088cc;
    padding: 1px 6px;
    border-radius: 0px;
    color: white;
    padding-top: 3px;
}
.social-feed-container-<?php echo $id; ?> .content .media-body p{
margin: 0 !important;
}

<?php } ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element{
box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important;
transition: 0.25s !important;
/*-webkit-backface-visibility: hidden !important;*/
background-color: <?php if($sfbap1_theme_selection == 'template0'){echo '#414141';}else{echo '#fff ';} ?> !important;
color: #333 !important;
text-align: left !important;
font-size: 14px !important;
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
line-height: 16px !important;
color: black  !important;
padding: 0 !important;
width: 100% !important;
margin-bottom: 5px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element:hover {
box-shadow: 0 0 20px 0 rgba(10, 10, 10, 0.4) !important;
}
.social-feed-container-<?php echo $id; ?> .author-title{
color: <?php if($sfbap1_theme_selection == 'template0'){echo 'white';}else{echo 'black';} ?> !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-text{
margin: 0 !important;
}
.social-feed-container-<?php echo $id; ?>  {

text-align: center !important;
}
.social-feed-container-<?php echo $id; ?> .content .media-body p{
margin: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text{
color: <?php if($sfbap1_theme_selection == 'template0'){echo 'white';}else{echo 'black';} ?> !important;
}
.social-feed-container-<?php echo $id; ?> .content .media-body p{
margin: 0 !important;
}
<?php } if($sfbap1_feed_style == 'masonry'){ if($sfbap1_theme_selection == 'template0' || $sfbap1_theme_selection == 'default'){?>

.grid-item{
	position: relative !important;
}
	.fa-facebook{
	    position: absolute !important;
    top: 3px !important;
    right: 3px !important;
    background: #0088cc !important;
    padding: 1px 6px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 3px !important;
}
.fa-twitter{
    position: absolute !important;
    top: 3px !important;
    right: 3px !important;
    background: #4bc3ff !important;
    padding: 1px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 3px !important;
}
.fa-instagram{
	position: absolute !important;
    top: 3px !important;
    right: 3px !important;
    background: #0484c4 !important;
    padding: 2px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.fa-pinterest{
	position: absolute !important;
    top: 3px !important;
    right: 3px !important;
    background: #c40416  !important;
    padding: 2px 3px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
.fa-vk{
	position: absolute !important;
    top: 3px !important;
    right: 3px !important;
    background: #507299  !important;
    padding: 3px 2px !important;
    border-radius: 0px !important;
    color: white !important;
    padding-top: 2px !important;
}
<?php } ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element{
box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important;
transition: 0.25s !important;
/*-webkit-backface-visibility: hidden !important;*/
background-color: <?php if($sfbap1_theme_selection == 'template0'){echo '#414141';}else{echo '#fff ';} ?> !important;
color: #333 !important;
text-align: left !important;
font-size: 14px !important;
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif !important;
line-height: 16px !important;
color: black  !important;
padding: 0 !important;
margin: 0 !important;

}
.grid-item {
padding: 3px;
} 
.social-feed-container-<?php echo $id; ?> .social-feed-element:hover {
box-shadow: 0 0 20px 0 rgba(10, 10, 10, 0.4) !important;
}
.social-feed-container-<?php echo $id; ?> .author-title{
color: <?php if($sfbap1_theme_selection == 'template0'){echo 'white';}else{echo 'black';} ?> !important;
text-decoration: none !important;
font-weight: bold !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-text{
margin: 0 !important;
color: black !important;
}
.social-feed-container-<?php echo $id; ?>  {

text-align: center !important;
}
.social-feed-container-<?php echo $id; ?>{
column-gap: 0 !important;
column-count: <?php echo $sfbap1_column_count; ?> ;
-webkit-column-count: <?php echo $sfbap1_column_count; ?> ;
-moz-column-count: <?php echo $sfbap1_column_count; ?> ;
}
.social-feed-container-<?php echo $id; ?> .content{
padding-top: 15px !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text{
width: 100% !important;
font-size: 14px !important;
color: <?php if($sfbap1_theme_selection == 'template0'){echo 'white';}else{echo 'black';} ?> !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .author-title{
font-size: 15px !important;
font-weight: bold !important;
color: <?php if($sfbap1_theme_selection == 'template0'){echo 'white';}else{echo 'black';} ?> !important;
text-decoration: none !important;
font-weight: bold !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element  {
break-inside: avoid;
padding: 0 !important;
vertical-align: top !important;
margin: 0 !important;

}
.social-feed-container-<?php echo $id; ?> .attachment {
margin: 0 !important;
}
.social-feed-element .media-body > p{
margin: 0 !important;
}
@media (max-width: 600px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 2;
-webkit-column-count: 2 ;
-moz-column-count: 2 ;
}
}
@media (max-width: 360px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 1;
-webkit-column-count: 1 ;
-moz-column-count:1 ;
}
}
<?php } } if($sfbap1_theme_selection == 'template1'){ ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element {
padding: 10px !important;
background: transparent !important;
border: none !important;
box-shadow: none !important;
margin: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .muted{
color: #6d6d6d;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element:hover{
box-shadow: none !important;
background-color: #e6e6e6 !important;
border-radius: 10px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .attachment{
	margin: 0 !important;
border-radius: 10px !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
margin: 5px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-right{
float: left !important;
margin: 0 !important;
margin-top: -5px !important;
}
<?php if($sfbap1_feed_style == 'thumbnails'){ ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element{
width: <?php echo $sfbap1_thumbnail_size; ?>px !important;
display: inline-block !important;
background-color:white !important;
padding: 0 !important;
vertical-align: middle;
margin: 0px !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
display: block !important;
}
.grid-item {
display: inline-block !important;
} 
.social-feed-container-<?php echo $id; ?> .content{
display: block !important;
padding: 0 !important;
}
.social-feed-container-<?php echo $id; ?> p.social-feed-text{
display: none !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body{
display: none !important;
}
<?php } ?>
<?php if($sfbap1_feed_style == 'blog_style' || $sfbap1_feed_style == 'masonry'|| $sfbap1_feed_style == 'vertical' ){ ?>

<?php if($sfbap1_feed_style == 'vertical'){?> 
.social-feed-container-<?php echo $id; ?> {
width: 400px !important;
margin: 0 auto !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
margin-bottom: 10px !important;
}
<?php } ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element .content{
padding: 0 !important;
display: block !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
display: block !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text{
color: black !important;
margin-top: 10px !important;
margin-bottom: 0px;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p{

margin-bottom: 5px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .author-title{
color: black !important;
font-weight: bold !important;
text-decoration: none !important;

}
<?php } if($sfbap1_feed_style == 'masonry'){ ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element .content {
padding: 0 !important;
display: block !important;

}.grid-item {
padding: 3px;
} 
.social-feed-container-<?php echo $id; ?> .social-feed-element  {
break-inside: avoid;
padding: 0 !important;
vertical-align: top !important;
margin: 0 !important;

}
.social-feed-container-<?php echo $id; ?>{
column-gap: 0;
column-count: <?php echo $sfbap1_column_count; ?> ;
-webkit-column-count: <?php echo $sfbap1_column_count; ?> ;
-moz-column-count: <?php echo $sfbap1_column_count; ?> ;
}
@media (max-width: 600px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 2 ;
-webkit-column-count: 2 ;
-moz-column-count: 2 ;
}
}
@media (max-width: 360px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 1 ;
-webkit-column-count: 1 ;
-moz-column-count: 1 ;
}
}

<?php	} } if($sfbap1_theme_selection == 'template2' || $sfbap1_theme_selection == 'template3'){ ?>
	 .social-feed-container-<?php echo $id; ?> img.attachment {
    margin: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
border: none !important;
margin: 0 !important;
box-shadow: none !important;
background-color: <?php if($sfbap1_theme_selection == 'template2'){echo 'white';}else{echo '#414141';} ?> !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element .muted{
color: <?php if($sfbap1_theme_selection == 'template2'){echo '#6d6d6d';}else{echo '#ababab ';} ?> !important;
}
<?php if($sfbap1_theme_selection == 'template2') { ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element:hover{
border-radius: 10px !important;
}
<?php } ?>
.social-feed-container-<?php echo $id; ?> .text-wrapper{
margin: 0px 15px !important;
line-height: 18px;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-right{
float: none;
margin: 15px;
display: block;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .content{
border-top: 2px solid #dfdfdf;
margin: 10px;
display: block;
height: 55px;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element, .social-feed-element .media-body{
margin-top: 5px;
}
<?php if($sfbap1_feed_style == 'thumbnails'){ ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element{
width: <?php echo $sfbap1_thumbnail_size; ?>px !important;
display: inline-block !important;
background-color:white !important;
padding: 0 !important;
vertical-align: middle;
margin: 5px !important;

}
.social-feed-container-<?php echo $id; ?>{
text-align: center;
}
.grid-item {
display: inline-block !important;
} 
.social-feed-container-<?php echo $id; ?> .pull-right{
display: none !important;
}
.social-feed-container-<?php echo $id; ?> .content{
display: none !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
display: none !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element{
width: <?php echo $sfbap1_thumbnail_size; ?>px !important;
display: inline-block !important;
background-color:white !important;
}
<?php } ?>
<?php if($sfbap1_feed_style == 'blog_style' || $sfbap1_feed_style == 'vertical' ){ ?>

<?php if($sfbap1_feed_style == 'vertical'){?> 
.social-feed-container-<?php echo $id; ?> {
width: 400px !important;
margin: 0 auto !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element{
margin: 10px !important;
}
<?php } ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element .content{
margin: 5px 5px 25px 3px !important;
padding: 15px 0 0 15px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-right{
float: none;
margin: 15px;
display: block;
}
.social-feed-container-<?php echo $id; ?>.social-feed-element a{
	display: block !important;
color: #0088cc !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
border: none !important;
box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important;
padding: 0 !important;
margin: 0 !important;
width: 100% !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text {
color: <?php if($sfbap1_theme_selection == 'template2'){echo 'black';}else{echo 'white ';} ?> !important;
margin: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
margin-top: 10px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .author-title{
color: <?php if($sfbap1_theme_selection == 'template2'){echo 'black';}else{echo 'white ';} ?> !important;
font-weight: bold;
text-decoration: none !important;

}
<?php if($sfbap1_feed_style == 'vertical'){?> 
.social-feed-container-<?php echo $id; ?> {
width: 400px !important;
margin: 0 auto !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element{
margin: 10px !important;
}
<?php } ?>
<?php } if($sfbap1_feed_style == 'masonry'){ ?>
.social-feed-container-<?php echo $id; ?>{
column-gap: 0;
column-count: <?php echo $sfbap1_column_count; ?> ;
-webkit-column-count: <?php echo $sfbap1_column_count; ?> ;
-moz-column-count: <?php echo $sfbap1_column_count; ?> ;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
margin-top: 10px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .content{
margin: 5px 5px 0px 3px !important;
padding: 15px 0 0 15px !important;
height: 75px;
}.grid-item {
padding: 3px;
} 
.social-feed-container-<?php echo $id; ?> .social-feed-element {
border: none !important;
box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important;
padding: 0 !important;
margin: 0 !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text {
color: <?php if($sfbap1_theme_selection == 'template2'){echo 'black';}else{echo 'white ';} ?> !important;
margin: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .author-title{
color: <?php if($sfbap1_theme_selection == 'template2'){echo 'black';}else{echo 'white ';} ?> !important;
font-weight: bold;
text-decoration: none !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element  {
break-inside: avoid;
padding: 0 !important;
vertical-align: top !important;
margin: 0 !important;

}
@media (max-width: 600px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 2 ;
-webkit-column-count: 2;
-moz-column-count: 2 ;
}
}
@media (max-width: 360px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 1 ;
-webkit-column-count: 1 ;
-moz-column-count: 1;
}
}

<?php	} } if($sfbap1_theme_selection == 'template4') { ?>

<?php if($sfbap1_feed_style == 'thumbnails'){ ?>
.social-feed-container-<?php echo $id; ?> .social-feed-element{
width: <?php echo $sfbap1_thumbnail_size; ?>px !important;
display: inline-block !important;
background-color:white !important;
padding: 0 !important;
vertical-align: middle;
margin: 5px;
}
.grid-item {
display: inline-block !important;
} 
.social-feed-container-<?php echo $id; ?>{
text-align: center !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element{
width: <?php echo $sfbap1_thumbnail_size; ?>px !important;
display: inline-block !important;
background-color:white !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
display: none !important;
}
.social-feed-container-<?php echo $id; ?> .pull-right{
display: none !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text{
display: none !important;
}

<?php }	if($sfbap1_feed_style == 'blog_style'|| $sfbap1_feed_style == 'vertical' ){ ?>



.social-feed-container-<?php echo $id; ?> .social-feed-element:hover {
box-shadow: 0 0 20px 0 rgba(10, 10, 10, 0.4) !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .content{
padding: 10px 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-left{
display: block !important;
width: 100% !important;
float: none !important;
margin: 0;
text-align: center !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-right{
display: block !important;
width: 100% !important;
float: none !important;
margin: 0;
text-align: center !important;
color: #969696;
height: 17px;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-object{
margin: 0 auto !important;
width: 70px !important;
border-radius: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
border: none !important;
box-shadow: none !important;
padding: 0 !important;
width: 100% !important;
background: white !important;
box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important;
transition: 0.25s !important;
/*-webkit-backface-visibility: hidden !important;*/
}
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text {
color: black !important;
margin: 0 !important;
line-height: 1.3 !important;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
margin-top: 10px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .author-title{
color: black !important;
font-weight: bold;
margin: 5px !important;
font-size: 17px !important;
text-decoration: none !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body{
text-align: center !important;
line-height: 1 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body > p{
margin: 0 !important;
padding: 0 !important;
color: white !important;
margin-top: 5px !important;
text-align: center !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .attachment{
width: 95%;
margin: 0 auto !important;
display: block;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
width: 95%;
text-align: center;
margin: 0 auto !important;
display: block;
margin-top: 15px !important;
font-size: 1.4em;
padding-bottom: 15px !Important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body{
overflow: none !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .social-feed-element .media-body{
overflow: none !important;
}
<?php }	 if($sfbap1_feed_style == 'vertical'){?> 
.social-feed-container-<?php echo $id; ?> {
width: 400px !important;
margin: 0 auto !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
margin-bottom: 10px !important;
}
.social-feed-container-<?php echo $id; ?>  .social-feed-element .social-feed-text{
color: white !important;
}
<?php } if($sfbap1_feed_style == 'masonry'){ ?>

.grid-item{
	position: relative !important;
}
	.fa-facebook{
position: absolute;
    top: 66px;
    right: 36%;
    background: #537ec5;
    padding: 4px 7px;
    color: white;
    border-radius: 4px;
    border: 2px solid white;
}
.fa-twitter{
position: absolute;
    top: 66px;
    right: 36%;
    background: #537ec5;
    padding: 4px 7px;
    color: white;
    border-radius: 4px;
    border: 2px solid white;
}
.fa-instagram{
position: absolute;
    top: 66px;
    right: 36%;
    background: #537ec5;
    padding: 4px 7px;
    color: white;
    border-radius: 4px;
    border: 2px solid white;
}
.fa-pinterest{
position: absolute;
    top: 66px;
    right: 36%;
    background: #537ec5;
    padding: 4px 7px;
    color: white;
    border-radius: 4px;
    border: 2px solid white;
}
.fa-vk{
position: absolute;
    top: 66px;
    right: 36%;
    background: #537ec5;
    padding: 4px 7px;
    color: white;
    border-radius: 4px;
    border: 2px solid white;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element:hover {
box-shadow: 0 0 20px 0 rgba(10, 10, 10, 0.4) !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .content{
padding: 10px 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-left{
display: block !important;
float: none !important;
margin: 0;
text-align: center !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .pull-right{
display: block !important;
width: 100% !important;
float: none !important;
margin: 0;
text-align: center !important;
color: #969696;
height: 17px;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-object{
margin: 0 auto !important;
width: 70px !important;
border-radius: 0 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element {
border: none !important;
box-shadow: none !important;
padding: 0 !important;
background: white !important;
box-shadow: 0 0 10px 0 rgba(10, 10, 10, 0.2) !important;
transition: 0.25s !important;
/*-webkit-backface-visibility: hidden !important;*/
margin: 0 !important;

}.grid-item {
padding: 3px;
} 
.social-feed-container-<?php echo $id; ?> .social-feed-element p.social-feed-text {
color: black !important;
margin: 0 !important;
line-height: 1.3 !important;
}

.social-feed-container-<?php echo $id; ?> .social-feed-element .author-title{
color: black !important;
font-weight: bold;
margin: 5px !important;
font-size: 17px !important;
text-decoration: none !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body{
text-align: center !important;
line-height: 1 !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body > p{
margin: 0 !important;
padding: 0 !important;
color: white !important;
margin-top: 5px !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element .attachment{
width: 90%;
margin: 0 auto !important;
display: block;
}
.social-feed-container-<?php echo $id; ?> .text-wrapper{
width: 90%;
text-align: center;
margin: 0 auto !important;
display: block;
margin-top: 15px !important;
font-size: 16px;
padding-bottom: 15px !important;
line-height: 1.5 !important;

}
.social-feed-container-<?php echo $id; ?> .social-feed-element .media-body{
overflow: none !important;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element, .social-feed-element .media-body{
overflow: none !important;
}
.social-feed-container-<?php echo $id; ?>{
column-gap: 0;
column-count: <?php echo $sfbap1_column_count; ?> ;
-webkit-column-count: <?php echo $sfbap1_column_count; ?> ;
-moz-column-count: <?php echo $sfbap1_column_count; ?> ;
}
.social-feed-container-<?php echo $id; ?> .social-feed-element  {
break-inside: avoid;
padding: 0 !important;
vertical-align: top !important;
margin: 0 !important;

}
@media (max-width: 600px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 2 ;
-webkit-column-count: 2;
-moz-column-count: 2 ;
}
}
@media (max-width: 520px) {
.social-feed-container-<?php echo $id; ?> {
column-count: 1;
-webkit-column-count: 1 ;
-moz-column-count: 1 ;
}
}
<?php	} } ?>


</style>

<div id="social-feed-container-<?php echo $id; ?>" class="social-feed-container-<?php echo $id; ?>"> 

</div>

<script>

var sfbap1_date_posted_lang = '<?php echo $sfbap1_date_posted_lang; ?>';

var sfbap1_access_token = '';
var sfbap1_show_photos_from_twitter = '<?php echo $sfbap1_show_photos_from_twitter; ?>';

var sfbap1_private_access_token = '<?php echo $sfbap1_private_access_token; ?>';
var instagram_query_string = '<?php echo $instagram_query; ?>';
var instagram_limit = '<?php echo $sfbap1_number_of_photos; ?>';
var sfbap1_theme_selection = '<?php echo $sfbap1_theme_selection; ?>';
var sfbap1_limit_post_characters = '<?php echo $sfbap1_limit_post_characters; ?>';


var sfbap1_enable_facebook_feed = '<?php echo $sfbap1_enable_facebook_feed; ?>';
if(sfbap1_enable_facebook_feed == '1'){
	var sfbap1_facebook_page_id = '@'+'<?php echo $sfbap1_facebook_page_id; ?>';
}else{
	var sfbap1_facebook_page_id = '';
}


var sfbap1_enable_twitter_feed = '<?php echo $sfbap1_enable_twitter_feed; ?>';
var sfbap1_show_photos_from_twitter = '<?php echo $sfbap1_show_photos_from_twitter; ?>';
var twitter_query_string = '';


if(sfbap1_enable_twitter_feed == '1'){
	if(sfbap1_show_photos_from_twitter == 'userid'){
		var twitter_query_string = '<?php echo $sfbap1_user_id_twitter; ?>';
	}
	if(sfbap1_show_photos_from_twitter == 'hashtag'){
		var twitter_query_string = '<?php echo $sfbap1_hashtag_twitter; ?>';
	}
}else{

var twitter_query_string = '';
}




var sfbap1_enable_instagram_feed = '<?php echo $sfbap1_enable_instagram_feed; ?>';
var sfbap1_show_photos_from_instagram = '<?php echo $sfbap1_show_photos_from_instagram; ?>';
var instagram_query_string = '';

if(sfbap1_enable_instagram_feed == '1'){
	if(sfbap1_show_photos_from_instagram == 'userid'){
		var instagram_query_string = '<?php echo $sfbap1_user_id_instagram; ?>';
	}
	if(sfbap1_show_photos_from_instagram == 'hashtag'){
		var instagram_query_string = '<?php echo $sfbap1_hashtag_instagram; ?>';
	}
}else{

	var instagram_query_string = '';
}



var pinterest_query_string = '';
var sfbap1_enable_pinterest_feed = '<?php echo $sfbap1_enable_pinterest_feed; ?>';
if(sfbap1_enable_pinterest_feed == '1'){
	var pinterest_query_string = '@'+'<?php echo $sfbap1_pinterest_board; ?>';
}else{
	var pinterest_query_string = '';
}



var vk_query_string = '';
var sfbap1_enable_vk_feed = '<?php echo $sfbap1_enable_vk_feed; ?>';
if(sfbap1_enable_vk_feed == '1'){
	var vk_query_string = '@'+'<?php echo $sfbap1_vk_hashtag; ?>';
}else{
	var vk_query_string = '';
}


var sfbap1_number_facebook = '';
var sfbap1_number_facebook = '<?php echo $sfbap1_number_facebook; ?>';

var sfbap1_number_twitter = '';
var sfbap1_number_twitter = '<?php echo $sfbap1_number_twitter; ?>';

var sfbap1_number_instagram = '';
var sfbap1_number_instagram = '<?php echo $sfbap1_number_instagram; ?>';

var sfbap1_number_pinterest = '';
var sfbap1_number_pinterest = '<?php echo $sfbap1_number_pinterest; ?>';

var sfbap1_number_vk = '';
var sfbap1_number_vk = '<?php echo $sfbap1_number_vk; ?>';


jQuery(document).ready(function(){
if(sfbap1_private_access_token == ''){
sfbap1_access_token = '3115610306.54da896.ae799867a8074bcb91b5cd6995b4974e';
}else{
sfbap1_access_token = sfbap1_private_access_token;
}
if(sfbap1_show_photos_from_twitter == 'hashtag'){
sfbap1_access_token = '3115610306.54da896.ae799867a8074bcb91b5cd6995b4974e';
}
jQuery('.social-feed-container-'+<?php echo $id; ?>).socialfeed({

facebook: {
    accounts: [sfbap1_facebook_page_id],
    limit: sfbap1_number_facebook,
    access_token: '274376249625432|03d7cc70158f4b720a124c11aad5606e'  //String: "APP_ID|APP_SECRET"
},
twitter: {
    accounts: [twitter_query_string],
    limit: sfbap1_number_twitter,
    consumer_key: 'DDWeMCGG2r1ZPV4rEqmmqbhPq', // make sure to have your app read-only
    consumer_secret: 'Ue93hc5ftyPMomjduoMcAZQOMeZWQNTFY8VfrjHNvWeSJ9Un1W', // make sure to have your app read-only
},
instagram: {
    accounts: [instagram_query_string],
    limit: sfbap1_number_instagram,
    access_token: '4926863040.3a81a9f.2c626f11b9e447d1b9d4da1f29ea28fe'
},
pinterest:{
	accounts: [pinterest_query_string],   //Array: Specify a list of accounts from which to pull posts
	limit: sfbap1_number_pinterest,                                   //Integer: max number of posts to load
	access_token: 'AaxGC9-5GKCTKaSg0aBon5jQrOmjFJjQx-nIV-xDs3g_sSA_8wAAAAA' //String: Pinterest client id
},
vk: {
    accounts: [vk_query_string],
    limit: sfbap1_number_vk,
    source: 'all'
},
<?php if($sfbap1_theme_selection == 'default' || $sfbap1_theme_selection == 'template0') { ?>
template_html: '<div class="grid-item"><div class="social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}"><div class="content"><a class="pull-left" href="{{=it.author_link}}" target="_blank"><img class="media-object" src="{{=it.author_picture}}"></a><div class="media-body"><p><span class="muted pull-right"> {{=it.time_ago}}</span><strong><a style="font-weight: bold !important;" href="{{=it.author_link}}" target="_blank" ><i class="fa fa-{{=it.social_network}}"></i> <span class="author-title">{{=it.author_name}}</span></a></strong></p><div class="text-wrapper"><p class="social-feed-text">{{=it.text}} <a href="{{=it.link}}" target="_blank" class="read-button">read more</a></p></div></div></div><a href="{{=it.link}}" target="_blank" class="">{{=it.attachment}}</a></div></div>',
<?php	} ?>
<?php if($sfbap1_theme_selection == 'template1') { ?>
template_html: '<div class="grid-item"><div class="social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}"><div class="content"><div class="text-wrapper"><a href="{{=it.link}}" target="_blank" class="">{{=it.attachment}}</a><p class="social-feed-text">{{=it.text}} <a href="{{=it.link}}" target="_blank" class="read-button">read more</a></p></div><div class="media-body"><a class="pull-left" href="{{=it.author_link}}" target="_blank"><img class="media-object" src="{{=it.author_picture}}"></a><p><strong><a style="font-weight: bold !important;" href="{{=it.author_link}}" target="_blank" ><span class="author-title">{{=it.author_name}}</span></a></strong></p><span class="muted pull-right"> {{=it.time_ago}}</span></div></div></div></div>',
<?php	} ?>
<?php if($sfbap1_theme_selection == 'template2' || $sfbap1_theme_selection == 'template3') { ?>
template_html: '<div class="grid-item"><div class="social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}"><a href="{{=it.link}}" target="_blank" class="">{{=it.attachment}}</a><span class="muted pull-right"> {{=it.time_ago}}</span><div class="text-wrapper"><p class="social-feed-text">{{=it.text}} <a href="{{=it.link}}" target="_blank" class="read-button">read more</a></p></div><div class="content"><a class="pull-left" href="{{=it.author_link}}" target="_blank"><img class="media-object" src="{{=it.author_picture}}"></a><div class="media-body"><p><strong><a style="font-weight: bold !important;" href="{{=it.author_link}}" target="_blank" ><span class="author-title">{{=it.author_name}}</span></a></strong></p></div></div></div></div>',
<?php	} ?>
<?php if($sfbap1_theme_selection == 'template4') { ?>
	template_html: '<div class="grid-item"><div class="social-feed-element {{? !it.moderation_passed}}hidden{{?}}" dt-create="{{=it.dt_create}}" social-feed-id = "{{=it.id}}"><div class="content"><a class="pull-left" href="{{=it.author_link}}" target="_blank"><img class="media-object" src="{{=it.author_picture}}"></a><div class="media-body"><p><strong><a style="font-weight: bold !important;" href="{{=it.author_link}}" target="_blank" ><span class="author-title">{{=it.author_name}}</span></a></strong></p><span class="muted pull-right"> {{=it.time_ago}}</span></div></div><a href="{{=it.link}}" target="_blank" class="">{{=it.attachment}}</a><div class="text-wrapper"><p class="social-feed-text">{{=it.text}} <a href="{{=it.link}}" target="_blank" class="read-button">read more</a></p></div></div></div>',
<?php	} ?>
		length: 200,
		show_media: true,

		// Moderation function - if returns false, template will have class hidden
		
		//update_period: 5000,
		// When all the posts are collected and displayed - this function is evoked
		
});


});

moment.locale(sfbap1_date_posted_lang);
console.log(moment.locale(sfbap1_date_posted_lang));
</script>


<?php
return ob_get_clean();
}