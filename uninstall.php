<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) die;

/**
 * The following code will uninstall the stuff added by the plugin.
 */
delete_option('slithyweb_gtag');

