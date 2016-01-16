=== GD Rating System ===
Contributors: GDragoN
Donate link: https://rating.dev4press.com/
Version: 1.0.3
Tags: rating, stars, stars rating, star rating, rate posts, rate, vote
Requires at least: 4.0
Tested up to: 4.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Powerful, highly customizable and versatile ratings plugin to allow your users to vote for anything you want.

== Description ==
GD Rating System is the successor to GD Star Rating plugin, but it has nothing in common with the old plugin. GD Rating System uses modular structure with most features split into addons and rating methods. For front end display plugin uses templates similar to WordPress theme templates and allows you to override existing templates or add new ones.

= Overview of plugin features =
With GD Rating System you can rate anything. Plugin supports several basic rating entities and for each one you can have more than one rating type. This includes posts with all default and custom post types, comments, users, terms for default or custom taxonomies.

Here is the list of most important plugin features:

* Rating Method: Stars Rating
* Addon: Posts Integration
* Addon: Comments Integration
* Addon: Dynamic Load
* Addon: Rich Snippets Support
* Presentation: Default set of templates
* Presentation: Shortcode for rating block
* Presentation: Shortcode for rating list
* Widget: Shortcode for rating list
* Stars Rating: 10 icons in a font
* Stars Rating: 2 image based sets
* Administration: Rating objects log
* Administration: Votes log
* Administration: Custom rating rules
* Data Transfer: Import from GD Star Rating
* Data Transfer: Import from WP PostRatings
* Data Transfer: Import from Yet Another Stars Rating

= Upgrade to GD Rating System Pro =
Pro version contains many more great features:

* Rating Method: Stars Review
* Rating Method: Thumbs Rating
* Addon: WP REST API Plugin Support
* Addon: Shortcake UI Plugin Support
* Addon: Dummy Ratings
* Addon: Edit Rating Votes
* Addon: GEO Location for Votes
* Addon: Admin Enhancer
* Stars Rating: 4 extra sets
* Stars Rating: PSD Source Files for image sets
* Thumbs Rating: 4 font icons sets in a font
* Thumbs Rating: 1 image based set
* Presentation: Additional Templates
* Presentation: Additional Widgets

With more features on the roadmap exclusively for Pro version.

* More information about [GD Rating System Pro](https://rating.dev4press.com/)
* Compare [Free vs. Pro Plugin](https://rating.dev4press.com/free-vs-pro-plugin/)

= Documentation and Support =
You need to register for free account on (https://www.dev4press.com/):

* [Frequently Asked Questions](https://support.dev4press.com/kb/product/gd-rating-system/faqs/)
* [Knowledge Base](https://support.dev4press.com/kb/product/gd-rating-system/articles/)
* [Support Forum](https://support.dev4press.com/forums/forum/plugins-lite/gd-rating-system/)

== Installation ==
= General Requirements =
* PHP: 5.2.4 or newer

= WordPress Requirements =
* WordPress: 4.0 or newer

= Basic Installation =
* Plugin folder in the WordPress plugins folder must be `gd-rating-system`.
* Upload `gd-rating-system` folder to the `/wp-content/plugins/` directory.
* Activate the plugin through the 'Plugins' menu in WordPress.
* Plugin adds top level menu 'Rating System' where you can start using it.

== Frequently Asked Questions ==
= Does plugin works with WordPress MultiSite installations? =
Yes. Each website in network can activate and use plugin on it's on.

= Can I translate plugin to my language? =
Yes. POT file is provided as a base for translation. Translation files should go into Languages directory.

= How can I upgrade to Pro version? =
You need to buy Pro plugin license from plugins [home page](https://rating.dev4press.com/pricing-purchase/), and download Pro plugin and replace free plugin with Pro plugin. All data and settings will be used by Pro version, no data will be lost.

= What about the support for cache plugins? =
Plugin uses WordPress internal object cache to store data about rating items. And, it also includes Dynamic Load addon that will load rating blocks through AJAX. This addon is disabled by default.

= Is the GD Rating System compatible with GD Star Rating? =
No. GD Rating System is completely new and different plugin, that has nothing in common with old GD Star Rating plugin.

= Can I import data from other rating plugins? =
Yes. GD Rating System supports import of rating data from: GD Star Rating, WP PostRatings, Yet Another Stars Rating. PRO version of GD Rating System can import thumbs and review ratings too.

== Translations ==
* English

== Upgrade Notice ==
= 1.0.3 =
Some smaller core imporvements. Several bug fixes.

== Changelog ==
= 1.0.3 - 2016.01.04 = 
* Edit: some addons function moved into plugin core
* Edit: improvements to some rendering functions
* Edit: switched to new admin object base class from D4PLib
* Edit: d4pLib 1.5.6
* Fix: extensions panel allows for all methods to be disabled
* Fix: rich snippet addon: broken if selected method is disabled
* Fix: rating method dropdown lists show disabled methods

= 1.0.2.1 - 2015.12.29. =
* Fix: abstract method class inheritance problem

= 1.0.2 - 2015.12.28. =
* Edit: improvements to loading of the templates list
* Edit: d4pLib 1.5.5
* Fix: deleting custom rules not working
* Fix: showing disabled methods and addons on rules panel
* Fix: loading conflict with GD bbPress Toolbox Pro
* Fix: minor metabox initialization issue

= 1.0.1 - 2015.12.27. =
* New: metabox for posts to override embed settings
* Edit: plugin initialization priority changed

= 1.0 - 2015.12.25. =
* First official release

== Screenshots ==
1. Example rating block
2. Example rating block with votes distribution
3. Votes log
4. Stars rating method settings
5. Rich snippets settings
6. Example rating block with widget and shortcode lists
