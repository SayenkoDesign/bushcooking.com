<?php
/*
Plugin Name: Remove query strings from static resources
Plugin URI: http://www.yourwpexpert.com/remove-query-strings-from-static-resources-wordpress-plugin/
Description: Remove query strings from static resources like CSS & JS files. This plugin will improve your scores in services like PageSpeed, YSlow, Pingdoom and GTmetrix.
Author: Your WP Expert
Version: 1.3.1
Author URI: http://www.yourwpexpert.com/
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
?>