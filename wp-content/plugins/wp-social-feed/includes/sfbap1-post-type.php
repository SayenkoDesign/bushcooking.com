<?php

add_action( 'init', 'sfbap1_social_feed_function' );
add_action('admin_menu', 'sfbap1_custom_menu_pages');

function sfbap1_social_feed_function() {
    $labels = array(
        'name'               => _x( 'Social Feeds', 'post type general name' ),
        'singular_name'      => _x( 'Social Feed', 'post type singular name' ),
        'menu_name'          => _x( 'Social Feed', 'admin menu' ),
        'name_admin_bar'     => _x( 'Social Feed', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'Form' ),
        'add_new_item'       => __( 'Add New Social Feed' ),
        'new_item'           => __( 'New Social Feed' ),
        'edit_item'          => __( 'Edit Social Feed' ),
        'view_item'          => __( 'View Social Feed' ),
        'all_items'          => __( 'All Social Feeds' ),
        'search_items'       => __( 'Search Social Feeds' ),
        'parent_item_colon'  => __( 'Parent Social Feeds:' ),
        'not_found'          => __( 'No Feed Forms found.' ),
        'not_found_in_trash' => __( 'No Feed Forms found in Trash.' )
        );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Add responsive Social feed into your post, page & widgets' ),
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'rewrite'            => array( 'slug' => 'arrow_Social_feed' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'		 => 'dashicons-schedule',
        'supports'           => array( 'title' , 'custom_fields')
        );

    register_post_type( 'sfbap1_social_feed', $args );
}

function sfbap1_custom_menu_pages() {

add_submenu_page(
    'edit.php?post_type=sfbap1_social_feed',
    'Support',
    'Support',
    'manage_options',
    'sfbap1_form_support',
    'sfbap1_support_page' );

}


function sfbap1_support_page(){
    include_once( 'sfbap1-support-page.php' );
}

function sfbap1_settings_page() {

    $scr = get_current_screen();
    
    if( $scr-> post_type !== 'sfbap1_social_feed' )
        return;

    include_once( 'sfbap1-settings-page.php' );
}

add_action( 'edit_form_after_title', 'sfbap1_settings_page' );
/*function admin_redirects() {
    global $pagenow;

    if($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'sfbap1_social_feed' ){
        if (isset($_GET['access_token'])) {
            
        wp_redirect(admin_url('/edit.php?post_type=sfbap1_social_feed&page=sfbap1_settings&access_token='.$_GET["access_token"], 'http'));
        exit;
    }
}
}

add_action('admin_init', 'admin_redirects');
*/
/*    if (isset($_GET['access_token'])) {
$url = urlencode(admin_url('edit.php?post_type=sfbap1_social_feed&page=sfbap1_settings&access_token').$_GET["access_token"]) ;
wp_redirect( $url ); exit;
}
*/

add_action('load-post-new.php', 'sfbap1_limit_cpt' );

function sfbap1_limit_cpt()
{
global $typenow;

if( 'sfbap1_social_feed' !== $typenow )
return;

$total = get_posts( array( 
'post_type' => 'sfbap1_social_feed', 
'numberposts' => -1, 
'post_status' => 'publish,future,draft' 
));

if( $total && count( $total ) >= 3 )
wp_die(
'<p style="text-align:center;font-weight:bold;">Sorry, Creation of maximum number of Social Feed reached, Please <a href="https://www.arrowplugins.com/social-feed" target="_blank">Buy Premium Version</a> to create more amazing Social Feed With Awesome Features</p>', 
'Maximum reached',  
array( 
'response' => 500, 
'back_link' => true 
)
);  
}