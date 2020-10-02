=== Slithy Web ===

Plugin Name: Slithy Web
Contributors: William Rey
Plugin URI: https://github.com/wrey75/slithyweb
Description: A plug-in used for clients of the MaisonWP hosting service. Also offer Google Analytics code inclusion.
Tags: analytics, ga, maisonwp
Author: William Rey
Author URI: https://wrey75.wordpress.com/
Requires at least: 5.0
Tested up to: 5.5.1
Stable tag: v0.10.0
Version: v0.12.0
Requires PHP: 7.0
Text Domain: slithy-web
Domain Path: /languages
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Mainly provided for clients of the integrated MaisonWP hosting solution, this
plugin also add functions available for everybody.

== Description ==

This plugin has been mainly developed for the clients of the MaisonWP hosting solution but also provides some features for all WordPress users.

**Features**

* Connects Google Analytics to WordPress

**Privacy**

__User Data:__ This plugin does not collect any user data. Even so, the tracking code used by Google collect all sorts of user data. You can learn more about Google Privacy [here](https://policies.google.com/privacy?hl=en-US).

__Services:__ This plugin does not connect to any third-party locations or services, but it does enable Google to collect all sorts of data.

**Installation**

1. Upload the plugin to your blog and activate
2. Visit the settings (Slithy Web) to configure your options

After configuring your settings, you can verify that GA tracking code is included by viewing the source code of your web pages.

[More info on installing WP plugins](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

**Usage**

If your Website is hosted by MaisonWP, the link is automatically done. There is no other configuration to do.

To enable Google Analytics tracking on your site, follow these steps:

1. Visit the "Slithy Settings" panel
2. Enter your GA Tracking ID (only the 'gtag.js' is supported).
3.Save changes and it's done.


**Uninstalling**

All plugin settings will be removed from your database when the plugin is uninstalled via the Plugins screen.

Your collected GA data will remain in your Google account.




== Changelogs ==

*Thank you to everyone who shares feedback for the Slithy Web plugin!*

**v0.12.0 (October 2020)**

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

= Is the plugin is limited to MaisonWP clients? =

Even if the plugin mainly focuses on MaisonWP users, this plugin can be used by everybody for adding the Google Analytics tag.


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif).
2. This is the second screen shot

== Changelog ==


== Upgrade Notice ==

To upgrade the plugin, remove the old version and replace it with the new one. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

