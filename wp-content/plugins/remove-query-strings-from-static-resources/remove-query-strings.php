<?php
/*
Plugin Name: Remove Query Strings From Static Resources
Plugin URI: https://www.speedupmywebsite.com/
Description: Remove query strings from static resources like CSS & JS files to improve your scores in Pingdom, GTmetrix, PageSpeed and YSlow. Support and speed optimization available at <a href="https://www.speedupmywebsite.com/">Speed Up My Website</a>.
Author: Speed Up My Website, Your WP Expert
Version: 1.4
Author URI: https://www.speedupmywebsite.com/
*/
function _remove_query_strings_1( $src ){	
	$rqs = explode( '?ver', $src );
        return $rqs[0];
}
		if ( is_admin() ) {
// Remove query strings from static resources disabled in admin
}

		else {
add_filter( 'script_loader_src', '_remove_query_strings_1', 15, 1 );
add_filter( 'style_loader_src', '_remove_query_strings_1', 15, 1 );
}

function _remove_query_strings_2( $src ){
	$rqs = explode( '&ver', $src );
        return $rqs[0];
}
		if ( is_admin() ) {
// Remove query strings from static resources disabled in admin
}

		else {
add_filter( 'script_loader_src', '_remove_query_strings_2', 15, 1 );
add_filter( 'style_loader_src', '_remove_query_strings_2', 15, 1 );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'remove_query_strings_link' );

function remove_query_strings_link( $links ) {
   $links[] = '<a href="https://www.speedupmywebsite.com/" target="_blank">Speed Up My Website</a>';
   return $links;
}
?>