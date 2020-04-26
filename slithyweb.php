<?php
/*
 * Plugin Name: Slithy Web
 * Plugin URI: https://github.com/wrey75/slithyweb
 * Description: a plugin to help users to setup their WordPres
 * Version: 0.10.1
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

if (defined('SLITHYWEB_ID')){
    include_once(dirname(__FILE__). "/maisonwp.php");
    $slithywebMonitor = new SlithyWebMonitoring();
}

if (is_admin()){
    include_once(dirname(__FILE__). "/basic.php");
    include_once(dirname(__FILE__). "/admin-page.php");
    $slithyAdminMonitor = new SlithyWebAdministrator();
} else {
    include_once(dirname(__FILE__). "/basic.php");
    $slithyPlugin = new SlithyWebPlugin();

    /*
    if ( ! function_exists( 'is_plugin_active' ) ){
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    }
    if (is_plugin_active("name-directory")) {
        include_once(dirname(__FILE__). "/name-directory-ext.php");
    }
    */
}

