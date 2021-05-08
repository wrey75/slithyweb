=== Slithy Web ===

Plugin Name: Slithy Web
Contributors: William Rey
Plugin URI: https://www.slithyweb.com/plugin-slithyweb/
Description: A plug-in used for clients of the SlithyWEB hosting service. Also offer some stuff like tooltips, basic cache and an easy Google Analytics add-on.
Tags: analytics, ga, tooltip
Author: William Rey
Author URI: https://wrey75.wordpress.com/
Requires at least: 5.0
Tested up to: 5.7
Stable tag: 1.19.0
Version: 1.19.0
Requires PHP: 7.0
Text Domain: slithy-web
Domain Path: /languages
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Even provided for clients of the integrated <a href="http://www.slithyweb.com">SlithyWeb</a> hosting solution, this
plugin also add some functions available for all.

== Description ==

This plugin has been mainly developed for the clients of the SlithyWeb (slithyweb.com) hosting solutioni for synchronization
purposes but also provides some features for all WordPress users.

**Features**

* Connects Google Analytics to WordPress.
* Add tooltips though shortcodes.
* Add basic cache for browsers.
* Automatic import of any site to the SlithyWeb hosting solution (beta version).


**Privacy**

__User Data:__ This plugin does not collect any user data. Even so, the tracking code used by Google collect all sorts of user data. You can learn more about Google Privacy [here](https://policies.google.com/privacy?hl=en-US).

__Services:__ This plugin does not connect to any third-party locations or services, but it does enable Google to collect all sorts of data.

**Installation**

1. Upload the plugin to your blog and activate
2. Visit the settings (Slithy Web) to configure your options

After configuring your settings, you can verify that GA tracking code is included by viewing the source code of your web pages.

[More info on installing WP plugins](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

**Usage**

If your Website is hosted by <a href="http://www.slithyweb.com/">SlithyWeb</a>, the link is automatically done. There is no other configuration to do.

To enable Google Analytics tracking on your site, follow these steps:

1. Visit the "Slithy Settings" panel
2. Enter your GA Tracking ID (only the 'gtag.js' is supported).
3.Save changes and it's done.


**Uninstalling**

All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen.

Your collected GA data will remain in your Google account.




== Changelogs ==

*Thank you to everyone who shares feedback for the Slithy Web plugin!*

**1.19.0**

Added a shortcode [slithy_login] to force the login of a user (for memberships). This is a very simple
implementation that could evolve in the future.

**1.18.0**

Added support for the cache provided by the SlithyWeb hosting company. Basically, deletes the cache whenever a post has been inserted or updated to ensure we do not read old stuff.

**1.17.4**

* Fixed a bug linked to missing CSS for tooltips.

**1.17.2**

* Fixed minor bugs for default values (cache duration) and Google Analytics tags.

**1.17.1**

* Clarification about the cache duration (must be set in minutes and have a default value of 1 hour if not specified).

**1.17.0**

* Added an import interface to test the <a href="http://www.slithyweb.com">SlithyWeb</a> hosting solution.
* Added basic cache functionality to serve 304 responses when possible.

**1.16.0**

* Moved some files to reduce the loading in the "inc" directory
* Enhanced some parts for the loading of files for the migration process (Slithy hosting)

**v1.15.0 (October 2020)**

* Added the capability to export the Website and its database for a move on a third-party hosting service.

**v0.12.3 (October 2020)**

* Compatibility with WordPress 5.5.1 

**v0.11.0 (April 2020)**

* New feature: added a tooltip shortcode (with integration with the plugin <a href="https://fr.wordpress.org/plugins/name-directory/">Name Directory</a>).
* FIX: now the plugin removes the option for Google Analytic Tag.

**v0.10.0 (April 2020)**

* Initial release


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->SlithyWeb screen to configure the plugin

== Frequently Asked Questions ==

= Is the plugin is limited to SlithyWeb clients? =

Even if the plugin mainly focuses on SlithyWeb users (<a href="http://slithyweb.com/">slithyweb.com</a>), this plugin can be used by everybody for adding the Google Analytics tag.


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif).
2. This is the second screen shot

== Changelog ==


== Upgrade Notice ==

To upgrade the plugin, remove the old version and replace it with the new one. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

