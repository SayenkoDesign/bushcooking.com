=== Remove Query Strings From Static Resources ===
Contributors: speedupmywebsite, yourwpexpert
Donate link: https://www.speedupmywebsite.com/
Tags: remove, query, strings, static, resources, pingdom, gtmetrix, yslow, pagespeed, speed, optimize, performance, cache
Requires at least: 3.0.1
Tested up to: 4.7.2
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Remove query strings from static resources like CSS & JS files.

== Description ==

= Features =
This plugin will remove query strings from static resources like CSS & JS files inside the HTML `<head>` element to improve your speed scores in services like Pingdom, GTmetrix, PageSpeed and YSlow.

Resources with a "?" or "&" in the URL are not cached by some proxy caching servers, and moving the query string and encode the parameters into the URL will increase your WordPress site performance significant.

= Disclaimer =

This plugin will ONLY remove query strings from resources located inside the HTML `<head>` element, any query strings located inside the HTML "body" element shall and will not be removed by this plugin.

= Looking For Support? =

The plugin author does not provide active support on the wordpress.org forum. Support and requests for custom configurations to the plugin are available at [Speed Up My Website](https://www.speedupmywebsite.com/).

= Looking For WordPress Speed Optimization? = 

Want to speed up your WordPress site, to get better rankings in Google, improve your conversions and bring more visitors to your website? Then check out [Speed Up My Website](https://www.speedupmywebsite.com/).

= Reference tests using the latest WordPress version =

Reference test from: [Pingdom](https://tools.pingdom.com/#!/devpiY/https://www.removequerystringsfromstaticresources.com/)

Reference test from: [GTMetrix](https://gtmetrix.com/reports/www.removequerystringsfromstaticresources.com/JHlVY6uO)

Reference site: [Remove Query Strings From Static Resources](https://www.removequerystringsfromstaticresources.com/)


= Do you like this plugin? =

Please don't hesitate to [leave your feedback here](https://wordpress.org/support/plugin/remove-query-strings-from-static-resources/reviews/#postform).

== Installation ==

There are 3 different ways to install Remove Query Strings From Static Resources for WordPress, as with any other wordpress.org plugin.

= Using the WordPress dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Remove Query Strings From Static Resources'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Download the latest version of this plugin from https://wordpress.org/plugins/remove-query-strings-from-static-resources/
2. Navigate to the 'Add New' in the plugins dashboard
3. Navigate to the 'Upload' area
4. Select the zip file (from step 1.) from your computer
5. Click 'Install Now'
6. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download the latest version of this plugin from https://wordpress.org/plugins/remove-query-strings-from-static-resources/
2. Unzip the zip file, which will extract the "remove-query-strings-from-static-resources" directory to your computer
3. Upload the "remove-query-strings-from-static-resources directory" to the /wp-content/plugins/ directory in your FTP
4. Activate the plugin in the Plugin dashboard

== Changelog ==

= 1.4 =

* Tested for WordPress 4.7.2
* Added disclaimer to the plugin description
* Added reference tests for the plugin
* New contributor and author of the plugin

= 1.3.1 =

* Tested for WordPress 4.6.1

= 1.3 =

* Remove query strings from static resources disabled in admin section

* Reverted back to the old remove query strings function, since the new one was too effective


= 1.2 =

* Fix for Google Fonts in the dashboard

= 1.1 =

* Improved to remove even more query strings

* Tested for WP 4.0

= 1.0 =

* First release