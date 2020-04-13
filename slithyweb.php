<?php
/*
 * Plugin Name: Slithy Web
 * Plugin URI: http://my-awesomeness-emporium.com
 * Description: a plugin to help users to setup their WordPres
 * Version: 0.01.1
 * Author: William Rey
 * Author URI: http://wrey75.wordpress.com/
 * License: GPL2
 *
 */

echo "****";
if(defined('SLITHYWEB_ID')){
    include_once(dirname(__FILE__). "/monitoring.php");
    $slithywebMonitor = new SlithyWebMonitoring();
}

if(is_admin()){
    $slithyAdminMonitor = new SlithyWebAdministrator();
}
