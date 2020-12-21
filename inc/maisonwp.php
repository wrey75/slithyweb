<?php

// If this file is called directly, abort.
if (!defined('WPINC')) die;

/**
 * This class is ONLY used for the monitoring of the website by "SlithyWEB". If you are
 * not a custormer of our hosting solutions, this part of the controller should never
 * be loaded.
 * 
 * The call to our backend is made directly by an API key made of the website identifier
 * (found in wp-config.php) and the authentification key. There is no need for strong
 * security because the backend is in charge. For piracy, the hackers needs to guess the
 * salt which is near impossible except if the website is compromised...
 *
 * In the first version of this plugin, the backend will reload the error and access logs
 * not available to the PHP server if we are WP_DEBUG is set to true.
 *
 */
class SlithyWebMonitoring {

    public $rootUrl;
    public $apiHeaders;

    function __construct() {
        $this->rootUrl = "https://app.slithyweb.com/slithy";
        $apikey = SLITHYWEB_ID . ':' . base64_encode(AUTH_KEY);
        $this->apiHeaders = array("x-api" => $apikey);
        if(defined('WP_DEBUG') && WP_DEBUG){
            $this->registerLogTransmission();
        }
        add_filter('updated_option', array($this, 'option_changed'));
    }

    /**
     *  Send a POST command to the server.
     */
    function post($api, $args){
        $url = "{$this->rootUrl}/$api";
        $ret = wp_remote_post($url, array('headers' => $this->apiHeaders, 'body' => $args));
        if( $ret instanceof WP_Error){
            error_log("Error when calling $url: " . $ret->get_error_message());
        } else if($ret['body']){
            // Results are correct
        } else {
            error_log("RETURNED UNEXPECTED $url => " . print_r($ret, TRUE));
        }
    }

    public function option_changed($option_name) {
        $value = get_option($option_name);
        switch($option_name){
            case 'blogname':
            case 'blogdescription':
            case 'siteurl':
            case 'jetpack_site_icon_url':
                $this->post("update_option", array('name'=> $option_name, 'value'=>$value));
                break;
            case 'cron':
            case 'user_hit_count':
            case 'jetpack_next_sync_time_full-sync-enqueue':
            case 'jetpack_options':
            case 'jetpack_constants_sync_checksum':
            case 'jp_sync_lock_full_sync':
            case 'jetpack_sync_https_history_site_url':
            case 'jetpack_protect_blocked_attempts':
            case 'stats_cache':
            case 'autoptimize_imgopt_provider_stat':
            case 'mwp_public_keys_refresh_time':
                break;
            default:
                if( WP_DEBUG && strpos($option_name, "_transient_") !== 0 && strpos($option_name, "_site_transient_") !== 0){
                    error_log("The update of the option '$option_name' is not transmitted.");
                }
                break;
        }
    }

    /**
     * Transmit the logs to the server. In fact, the backend will load the Apache logs stored
     * in our architecture.
     *
     */
    public function transmitLogs(){
        // error_log("Trying to load the logs...");
        $req_time = $_SERVER['REQUEST_TIME'];
        $this->post("logs", array("from" => $req_time));
    }

    function registerLogTransmission(){
        register_shutdown_function(array($this, 'transmitLogs'));
    }
}

