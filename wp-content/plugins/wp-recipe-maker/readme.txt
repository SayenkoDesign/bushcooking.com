=== WP Recipe Maker ===
Contributors: BrechtVds
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QG7KZMGFU325Y
Tags: recipe, recipes, ingredients, food, cooking, seo, schema.org, json-ld
Requires at least: 4.4
Tested up to: 4.7.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The easy and user-friendly recipe plugin for everyone. Automatic JSON-LD metadata for better SEO will get you more visitors!

== Description ==

[WP Recipe Maker](http://bootstrapped.ventures/wp-recipe-maker/) is the easy recipe plugin that everyone can use. An easy workflow allows you to add recipes to any post or page with automatic JSON-LD metadata for your recipes. This recipe metadata will improve your SEO and get you more visitors!

> <strong>Get the most out of WP Recipe Maker!</strong><br>
> Join our [self-paced email course](https://www.getdrip.com/forms/86388969/submissions/new) and we'll help you get started and learn all the tips and trick for using this plugin.

= Features =
An overview of WP Recipe Maker features:

*   **Easy workflow** to add recipes to any post or page
*   Uses schema.org/Recipe JSON-LD metadata optimised for **Google Recipe search**
*   A combination of JSON-LD and inline metadata to ensure compatibility with **Pinterest Rich Pins**
*   **Recipe ratings** in the user comments
*   Clean **print recipe** version for your visitors with optional credit to your website
*   **Fallback recipe** shows up when the plugin is disabled
*   Add **photos** to any step of the recipe
*   Print recipe and **jump to recipe** shortcodes
*   This plugin is **fully responsive**, your recipes will look good on any device
*   Easily **change labels and colors** to fit your website
*   Structure your ingredients and instructions in **groups** (e.g. icing and cake batter)
*   **Full text search** for your recipes
*   Access your recipes through the WordPress **REST API**
*   Built-in **SEO check** for your recipe metadata

= Import Options =

Currently using another recipe plugin? No problem! You can easily migrate all your existing recipes to WP Recipe Maker if you're using any of the following plugins:

*   EasyRecipe
*   WP Ultimate Recipe
*   Meal Planner Pro
*   BigOven
*   ZipList and Zip Recipes
*   Yummly
*   Yumprint Recipe Card
*   (More coming soon!)

= WP Recipe Maker Premium =

Looking for some more advanced functionality? We also have the [WP Recipe Maker Premium](http://bootstrapped.ventures/wp-recipe-maker/) add-on available with the following features:

*   Use **ingredient links** for linking to products or other recipes
*   **Adjustable servings** make it easy for your visitors
*   Display all nutrition data in a **nutrition label**
*   Add a mobile-friendly **kitchen timer** to your recipes
*   More **Premium templates** for a unique recipe template
*   Create custom **recipe taxonomies** like price level, difficulty, ...

Even more add-ons can add the following functionality:

*   Integration with a **Nutrition API** for automatic nutrition facts

This plugin is in active development. Feel free to contact us with any feature requests or ideas.

== Installation ==

1. Upload the `wp-recipe-maker` directory (directory included) to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add recipes using the "WP Recipe Maker" button when editing posts or pages

== Frequently asked questions ==

= Where can I find a demo and some more documentation? =
Go to the [WP Recipe Maker demo website](http://bootstrapped.ventures/wp-recipe-maker/) for more information on all of our features!

= What's the difference with WP Ultimate Recipe? =

[WP Ultimate Recipe](http://www.wpultimaterecipe.com/) is the popular recipe plugin that we released in 2013 and have been working on ever since. This gave us a great idea of what most food bloggers are looking for.

Why the new plugin? A few structural choices we made early on have caused WP Ultimate Recipe to be quite complex and not 100% compatible with all themes. With WP Recipe Maker we're building the perfect recipe plugin from scratch, without all the baggage of years of development.

WP Ultimate Recipe is still in active development and will be maintained alongside this new alternative.

= Do you offer any support? =

Yes! We pride ourselves on offering awesome support and almost always answer support questions within 24 hours. Send us an email at [support@bootstrapped.ventures](mailto:support@bootstrapped.ventures) whenever you have a question or suggestion!

== Screenshots ==

1. Example Pasta Pesto recipe with the Simple template.
2. Use the "WP Recipe Maker" button to add recipes or click on the recipe preview to edit one.
3. The recipe form.
4. Example Pasta Pesto recipe with the Tastefully Simple (EasyRecipe like) template.

== Changelog ==

= 1.18.0 =
* Feature: Add custom styling to the recipe print page
* Feature: Bulk delete ingredients
* Improvement: Easy edit and view links for imported recipes
* Fix: Prevent jumping to the top on the manage page
* Fix: Print URL without trailing slash

= 1.17.1 =
* Fix: Ingredient import problem

= 1.17.0 =
* Feature: Setting to disable the output of inline CSS
* Improvement: Better import of ingredient notes
* Improvement: Prevent themes from messing up the recipe template
* Fix: Duplicate slug problem

= 1.16.0 =
* Feature: Change image sizes in settings
* Feature: Recipe placeholders for print credit
* Feature: Change position of the comment rating stars
* Improvement: Easier access to next recipes on import page
* Improvement: change comment rating label
* Improvement: Support unicode units when parsing ingredients
* Improvement: Ability to save empty ingredient and  instruction groups
* Improvement: Print shortcode works without JS as well (AMP pages)
* Improvement: Click on SEO indicator to edit recipe
* Fix: Search filter in WP Ultimate Post Grid
* Fix: Saving links for new ingredients in Premium plugin

= 1.15.0 =
* Feature: SEO check on manage page
* Feature: Change recipe template fonts from settings
* Feature: Show latest or random recipe with the shortcode
* Improvement: Show preview of links in recipe summary and instructions
* Improvement: Import Recipe Card adapted field to recipe notes
* Improvement: More information in shortcode preview
* Fix: Disappearing characters in text import
* Fix: Don't replace encoded characters in ingredient links
* Fix: Query issues on import recipes page

= 1.14.1 =
* Feature: Setting to change access to import recipes page
* Improvement: Better parsing of ingredients during import
* Improvement: Stay on correct page after reloading datatable
* Fix: Ability to remove ingredient links again

= 1.14.0 =
* Feature: Edit Recipe button for easy access
* Feature: Setting to set capability required for the manage page
* Improvement: Shortcode preview shows entire recipe
* Improvement: Taxonomies in REST API
* Improvement: AggregateRating details in inline metadata even when not shown
* Improvement: Better parsing of ingredient notes
* Fix: Clearfix for recipe container
* Fix: Manage page filters appearing over modal
* Fix: Pagination on taxonomy manage pages

= 1.13.0 =
* Feature: Filter recipes on manage page by ingredients and tags
* Feature: Change comment rating stars color in the settings
* Improvement: Mobile template of Tastefully Simple
* Fix: Problem with unwanted redirections by the Redirection plugin
* Fix: Problem with unwanted redirections by the Yoast SEO Premium plugin
* Fix: Prevent warnings on settings page

= 1.12.1 =
* Fix: Recipe Card import of instructions

= 1.12.0 =
* Feature: Print Credit message
* Feature: Add existing recipe through modal
* Feature: Import Yummly recipes
* Feature: Import Yumprint Recipe Card recipes
* Fix: Issue with shortcode preview displaying on the front-end
* Fix: Prevent importing empty lines
* Fix: Prevent datatable from outputting errors as alerts
* Fix: Empty ingredient groups in text import
* Fix: Text import unit issue in some languages

= 1.11.0 =
* Improvement: Set default value for Author Display field
* Improvement: Noindex the print page
* Improvement: Better margins for recipe image in Tastefully Simple
* Fix: Make sure correct nutrition label is shown with multiple recipes on a page
* Fix: Tastefully Simple template image on mobile

= 1.10.1 =
* Fix: Activation issue for hosts using an old version of PHP

= 1.10.0 =
* Feature: Change recipe template colors in the settings
* Feature: Change recipe template labels in the settings
* Feature: Manage courses and cuisines
* Improvement: Show days in recipe times
* Improvement: Recipe import performance
* Improvement: Prevent accidental closing of the modal
* Improvement: Setting to use featured image of parent post
* Improvement: Prevent recipe getting overwritten by our other shortcodes
* Fix: Prevent issue with post content replacing recipe notes
* Fix: Only import numbers for nutrition facts
* Fix: WordFence Compatibility

= 1.9.1 =
* Feature: WP Recipe Maker icon in TinyMCE editor
* Fix: Ingredients settings page

= 1.9.0 =
* Feature: Manage recipes and ingredients in a central place
* Feature: Edit recipes through the WP Recipe Maker button
* Fix: Prevent Divi Builder bug

= 1.8.0 =
* Feature: Import from ZipList and Zip Recipes
* Improvement: Increased performance of recipe dropdowns
* Improvement: Don't output JSON-LD metadata in RSS feed
* Improvement: Use fallback recipe in RSS feed
* Improvement: Easier to select multiple recipes for import
* Improvement: Indicate recipes without parent post in import
* Fix: Use correct default feature settings

= 1.7.1 =
* Fix: Associate all ingredient terms with recipes

= 1.7.0 =
* Feature: Import recipe from text
* Feature: Add nofollow links in summary and instructions
* Feature: Import recipes from Meal Planner Pro
* Feature: Import recipes from BigOven
* Improvement: Setting to disable comment ratings
* Improvement: Recognize unicode fractions when importing ingredients
* Improvement: Import nutrition facts from WP Ultimate Recipe
* Fix: Only show nutritional metadata if present
* Fix: Consistent behaviour for automatic time calculations

= 1.6.1 =
* Improvement: Show warning if EasyRecipe is breaking things

= 1.6.0 =
* Feature: Show hours for longer recipe times
* Improvement: Prevent font size inconsistencies in template
* Fix: Don't associate recipes with revisions
* Fix: Capital letters in template names

= 1.5.0 =
* Feature: Set recipe author
* Improvement: Sanitize metadata before outputting
* Fix: Warning when adding comments as a subscriber
* Fix: Compatibility issue with Jetpack
* Fix: Prevent infinite shortcode loop

= 1.4.0 =
* Feature: Access recipes though REST API
* Feature: Choose specific recipe template in shortcode
* Improvement: Check for leftover ER comment ratings when importing from WP Ultimate Recipe
* Improvement: Execute shortcodes in the recipe template
* Fix: Include correct stylesheet when using recipe templates from theme
* Fix: Show all recipes to be checked instead of just 8 recipes
* Fix: Use correct print URL if WordPress is in a subdirectory
* Fix: Linebreak accumulation when updating recipes
* Fix: Prevent Post Type Switcher plugin bug from breaking recipes

= 1.3.0 =
* Feature: Import from WP Ultimate Recipe
* Feature: wpDiscuz support for comment ratings
* Improvement: Use photo from Photo tab when importing from EasyRecipe
* Improvement: Check for custom templates in both parent and child theme
* Improvement: Different print system for better browser compatibility
* Fix: Round average comment rating to 2 decimals

= 1.2.0 =
* Feature: New "Tastefully Simple" template, similar to EasyRecipe
* Feature: New "Clean Print with Image" recipe template
* Feature: Print recipe shortcode
* Feature: Jump to recipe shortcode
* Improvement: Shortcode preview includes image and summary
* Fix: use ratingCount instead of reviewCount for JSON-LD metadata
* Fix: Trailing slash issue in asset URLs

= 1.1.0 =
* Feature: Comment ratings with metadata
* Feature: Inline metadata for Pinterest rich pins
* Feature: Calories field for nutrition metadata
* Improvement: FAQ pages
* Improvement: Strip HTML from JSON-LD metadata

= 1.0.0 =
* Very first version of this recipe plugin
* Feature: JSON-LD Metadata
* Feature: Intuitive workflow using regular posts or pages
* Feature: Import from EasyRecipe
* Feature: Clean printing of recipes
* Feature: Fallback recipe when the plugin is disabled

== Upgrade notice ==

= 1.18.0 =
Update to easily customize the recipe print page

= 1.17.1 =
Update if you're importing recipes

= 1.17.0 =
Update if you're experiencing problemns with the post slug

= 1.16.0 =
Update for even more easy recipe template customization options

= 1.15.0 =
Some fun new features and improvements

= 1.14.1 =
Upgrade required to use the latest Premium add-ons

= 1.14.0 =
Update for various improvements and bug fixes

= 1.13.0 =
Update to prevent warning notices on the settings page

= 1.12.1 =
Update if you want to use the Recipe Card import

= 1.12.0 =
New import and other features + some bug fixes

= 1.11.0 =
Some improvements to the recipe template

= 1.10.1 =
Update only needed if you're on a very old version of PHP

= 1.10.0 =
Make your recipe template unique in this new update

= 1.9.1 =
Fix for settings issue introduced in previous update

= 1.9.0 =
Easier recipe management in this new update

= 1.8.0 =
A bunch of general improvements and the possibility to import from ZipList and Zip Recipes

= 1.7.1 =
Update to fix the recipe-ingredient term relations

= 1.7.0 =
Lots of great improvements for WP Recipe Maker

= 1.6.1 =
Warning message for EasyRecipe users

= 1.6.0 =
Some minor updates and the release of WP Recipe Maker Premium

= 1.5.0 =
Fixed a few issues and added the recipe author field.

= 1.4.0 =
A few important bug fixes and improvements

= 1.3.0 =
Another week, another update!

= 1.2.0 =
Update for some new SEO improvements and recipe templates.

= 1.1.0 =
Update highly recommended for SEO purposes.

= 1.0.0 =
First version of this recipe plugin, no upgrades needed.
