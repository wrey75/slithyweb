<?php
/*
 * Plugin Name: Slithy Web
 * Plugin URI: https://www.slithyweb.com/plugin-slithyweb/
 * Description: a plugin to help users to setup their WordPress
 * Version: 1.17.1
 * Author: William Rey
 * Author URI: http://wrey75.wordpress.com/
 * License: GPL2
 * Text Domain: slithy-web
 *
 */

/*
    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version
    2 of the License, or (at your option) any later version.
       
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
       
    You should have received a copy of the GNU General Public License
    with this program. If not, visit: https://www.gnu.org/licenses/
       
    Copyright 2020 William Rey. All rights reserved.
*/

if (!defined('ABSPATH')) die();

register_activation_hook(__FILE__, function() {
    add_option('slithyweb_etag', 1);
    add_option('slithyweb_maxage', 180);
    add_option('slithyweb_last_modified', 1);	
});

/**
 * Add the "settings" in the plugin list (as some many other plugins)
 */
$slithy_plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$slithy_plugin", function($links) {
    $settings_link = '<a href="options-general.php?page=slithyweb_admin_menu">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
} );

/**
 *  Activate only when plugins are loaded.
 */
add_action('plugins_loaded', function() {
    if (defined('SLITHYWEB_ID')){
        include_once(dirname(__FILE__). "/inc/slithy.php");
        $slithywebMonitor = new SlithyWebMonitoring();
    }

    include_once(dirname(__FILE__). "/inc/basic.php");
    if (is_admin()){
        include_once(dirname(__FILE__). "/inc/admin-page.php");
        $slithyAdminMonitor = new SlithyWebAdministrator();
    } else {
        $slithyPlugin = new SlithyWebPlugin();
    }
});

