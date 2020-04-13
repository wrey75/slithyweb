<?php

// If this file is called directly, abort.
if (!defined('WPINC')) die;

/**
 * This class is ONLY used for the monitoring of the website by "MaisonWP". If you are
 * not a custormer of our hosting solutions, this part of the controller should never
 * be loaded.
 * 
 * The call to our backend is made directly by passing both the website identifier
 * (found in wp-config.php) and the authentification key.
 *
 */
class SlithyWebMonitoring {

    public $rootUrl;
    public $apiHeaders;

    function __construct() {
        $this->rootUrl = "http://localhost:8080/slithy";
        $apikey = SLITHYWEB_ID . ':' . base64_encode(AUTH_KEY);
        $this->apiHeaders = array("x-api" => $apikey);
	if(defined('WP_DEBUG') && WP_DEBUG){
            $this->registerLogTransmission();
	}
	add_filter('update_option', array($this, 'option_changed'));
    }


    function post($api, $args){
	$url = "{$this->rootUrl}/$api";
	$ret = wp_remote_post($url, array('headers' => $this->apiHeaders, 'body' => $args));
	error_log("CALLED $url => $ret");
    }

    public function option_changed($option_name, $old_value, $value) {
	switch($option_name){
	case 'title':
		$this->post("update_option", array('name'=> $option_name, 'value'=>$value));
		break;
	}
    }

    /**
     * Transmit the logs to the server
     */
    public function transmitLogs(){
	error_log("Trying to load the logs...");
        $req_time = $_SERVER['REQUEST_TIME'];
        $this->post("logs", array("from" => $req_time));
    }

    function registerLogTransmission(){
        register_shutdown_function(array($this, 'transmitLogs'));
    }

}

