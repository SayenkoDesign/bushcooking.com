<?php 
/*
Plugin Name: Social Feed by Arrow Plugins 
Plugin URI: https://wordpress.org/plugins/wp-social-feed
Description: Add Responsive Social Feed (Facebook, Twitter, Instagram, VK & RSS FEED) into your WordPress site.
Author: Arrow Plugins
Author URI: https://www.arrowplugins.com
Version: 1.1.3
License: GplV2
Copyright: 2017 Arrow Plugins
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'SFBAP1_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
include_once('includes/sfbap1-post-type.php');
include_once('includes/sfbap1-custom-columns.php');
include_once('includes/sfbap1-post-meta-boxes.php');
include_once('includes/sfbap1-save-post.php');
include_once('includes/sfbap1-shortcode.php');
include_once('includes/sfbap1-enqueue-scripts.php');


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'sfbap1_plugin_action_links' );

function sfbap1_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=sfbap1_social_feed') ) .'">Dashboard</a>';
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=sfbap1_social_feed&page=sfbap1_form_support') ) .'">Support</a>';
   return $links;
}