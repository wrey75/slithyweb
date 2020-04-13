<?php

// If this file is called directly, abort.
if (!defined('WPINC')) die;
require_once( plugin_dir_path( __FILE__ ) . 'class-wp-remote-post.php' );

/**
 * This class is ONLY used for the monitoring of the website by "MaisonWP". If you are
 * not a custormer of our hosting solutions, this part of the controller should never
 * be loaded.
 * 
 * The call to our 
 */
class SlithyWebMonitoring {

    public $rootUrl;
    public $apiHeaders;

    function __construct() {
        $this->rootUrl = "http://localhost:8080/slithy";
        $apikey = SLITHYWEB_ID + ':' + base64_encode(AUTH_KEY);
        $this->apiHeaders = array("website" => $apikey);
        if(defined('WP_DEBUG') && WP_DEBUG){
            $this->registerLogTransmission();
        }
    }


    /**
     * Transmit the logs to the server
     */
    function transmitLogs(){
        $req_time = $_SERVER['REQUEST_TIME'];
        wp_remote_post(
            "{$this->rootUrl}/logs",
            array(
                'headers' => $this->apiHeaders,
                'body' => array(
                    'from' => $req_time
                )   
            )
        );
    }

    function registerLogTransmission(){
        register_shutdown_function($this->transmitLogs);
    }

}

