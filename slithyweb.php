<?php
/*
 * Plugin Name: Slithy Web
 * Plugin URI: http://my-awesomeness-emporium.com
 * Description: a plugin to help users to setup their WordPres
 * Version: 0.10.1
 * Author: William Rey
 * Author URI: http://wrey75.wordpress.com/
 * License: GPL2
 * Text Domain: slithy-web
 *
 */

if(defined('SLITHYWEB_ID')){
    include_once(dirname(__FILE__). "/maisonwp.php");
    $slithywebMonitor = new SlithyWebMonitoring();
}

if(is_admin()){
    include_once(dirname(__FILE__). "/admin-page.php");
    $slithyAdminMonitor = new SlithyWebAdministrator();
}
