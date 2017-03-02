=== Remove Query Strings From Static Resources ===
Contributors: yourwpexpert
Tags: remove, query, strings, static, resources, pingdom, gtmetrix, yslow, pagespeed
Requires at least: 3.0.1
Tested up to: 4.6.1
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Remove query strings from static resources like CSS & JS files.

== Description ==
This plugin will remove query strings from static resources like CSS & JS files, and will improve your speed scores in services like PageSpeed, YSlow, Pingdoom and GTmetrix.

Resources with a “?” or “&” in the URL are not cached by some proxy caching servers, and moving the query string and encode the parameters into the URL will increase your WordPress site performance significant.

== Installation ==
1. Upload the `remove-query-strings-from-static-resources` folder to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. That's it!

== Changelog ==

= 1.3.1 =

* Tested for WordPress 4.6.1

= 1.3 =

* Remove query strings from static resources disabled in admin section

* Reverted back to the old remove query strings function, since the new one was to effective


= 1.2 =

* Fix for Google Fonts in the dashboard

= 1.1 =

* Improved to remove even more query strings

* Tested for WP 4.0

= 1.0 =

* First release