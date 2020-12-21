<?php


// If this file is called directly, abort.
if (!defined('WPINC')) die;

include_once dirname(__FILE__)."/helpers.php";

use \Slithyweb\Helper as Helper;

/**
 * This class is used when the administrator pages are requested.
 */
class SlithyWebAdministrator extends Helper {

    const GTAG_FIELD = 'slithyweb_gtag';
    const ETAG_FIELD = 'slithyweb_etag';
    const MAX_AGE_FIELD = 'slithyweb_maxage';
    const LAST_MODIFIED_FIELD = 'slithyweb_last_modified';
    const OPT_GROUP = 'slithyweb_plugin_options';
    const SETTINGS_SECTION = 'slithyweb_settings_section';
    const MENU_SLUG = 'slithyweb_admin_menu';


    function __construct() {
        add_action( 'admin_menu', function() {
                add_options_page( 
                    __('Slithy Web setting', 'slithy-web'),
                    __('Slithy web', 'slithy-web'),
                    'manage_options', 
                    self::MENU_SLUG, 
                    array($this, 'render_my_settings_page'));
        });
        add_action( 'admin_init', array($this, 'register_my_settings'));
    }

    /**
     * Render the Admin page of the plugin.
     */
    function render_my_settings_page() {
        printf('<h1>%s</h1>', Helper::T("Slithy Web Plugin Settings"));
        printf('<h2>%s (<a href="https://www.slithyweb.com/">slithyweb.com</a>)</h2>', __("Slithy Web hosting", 'slithy-web'));
        if(defined("SLITHYWEB_ID")){
            printf("<strong>%s:<strong> <code>%s</code> (%s)\n", Helper::T("Site identifier"), SLITHYWEB_ID, Helper::T("can not be changed"));
        } else {
            Helper::parag("This Website is not hosted by our recommended hosting service. Never mind.");
        }
        if(defined("WP_DEBUG")){
            printf("<p>%s %s</p>", self::T("WP_DEBUG is"), WP_DEBUG ? Helper::T("active") : Helper::T("disabled (PRODUCTION)"));
        } else {
            printf("<p>%s</p>", self::T("WP_DEBUG is not set (means PRODUCTION mode)")); 
        }
        echo '<form action="options.php" method="post">';
        settings_fields(self::SETTINGS_SECTION);
        do_settings_sections(self::MENU_SLUG);
        submit_button();
        // printf( '<input name="submit" class="button button-primary" type="submit" value="%s" />', esc_attr__( 'Save' ));
        echo '</form>';
    }

    /**
     * Register the settings of the admin page
     */
    function register_my_settings() {
        add_settings_section( self::SETTINGS_SECTION, 
            Helper::T('API Settings'),
            function() {
                printf("<p>%s<p>\n", __('Here you can set all the options for using the API', 'slithy-web'));
            },
            self::MENU_SLUG );
    
        add_settings_field(self::GTAG_FIELD, Helper::T('Google Tracking ID'), function() {
                    $option = get_option(self::GTAG_FIELD);
                    echo Helper::tag("input", array("id"=>self::GTAG_FIELD, "placeholder"=>"UA-", "name"=>self::GTAG_FIELD, "type"=>'text', "value"=>$option ));
                    }, self::MENU_SLUG, self::SETTINGS_SECTION );
    
        add_settings_field(self::MAX_AGE_FIELD, Helper::T('Cache duration (in minutes)'), function() {
                    $option = get_option(self::MAX_AGE_FIELD);
					if(!$option) $option = 60; // Default value
                    echo Helper::tag("input", array("id"=>self::MAX_AGE_FIELD, "name"=>self::MAX_AGE_FIELD, "type"=>'text', "value"=>$option ));
                    }, self::MENU_SLUG, self::SETTINGS_SECTION );
    
        add_settings_field(self::ETAG_FIELD, Helper::T('Etag header'), function() {
                    $option = get_option(self::ETAG_FIELD);
                    echo '<input type="checkbox" name="' . self::ETAG_FIELD . '" value="1" ' . checked(1, get_option(self::ETAG_FIELD), false) . ">";
                    }, self::MENU_SLUG, self::SETTINGS_SECTION );
    
        add_settings_field(self::LAST_MODIFIED_FIELD, Helper::T('Last-modified headers'), function() {
                    $option = get_option(self::LAST_MODIFIED_FIELD);
                    echo '<input type="checkbox" name="' . self::LAST_MODIFIED_FIELD . '" value="1" ' . checked(1, get_option(self::LAST_MODIFIED_FIELD), false) . ">";
                    }, self::MENU_SLUG, self::SETTINGS_SECTION );
        // add_settings_field( 'plugin_setting_results_limit', 'Results Limit', array($this, 'dbi_plugin_setting_results_limit'), 'slithyweb_api_plugin', 'api_settings' );
        // add_settings_field( 'plugin_setting_start_date', 'Start Date', array($this, 'dbi_plugin_setting_start_date'), 'slithyweb_api_plugin', 'api_settings' );
        register_setting( self::SETTINGS_SECTION, self::GTAG_FIELD, array(
                'sanitize_callback' => function ($input) {
                            $newInput = strtoupper(trim($input));
                            if (!$newInput && !preg_match( '/^ua-[0-9]*-[0-9]$/i', $newInput) ) {
                                $newInput = '';
                                add_settings_error('fields_main_input', self::GTAG_FIELD, Helper::T('Incorrect value for the tracking ID (should be UA-xxxxxx-x (where x are digits)!'), 'error');
                            }
                            // print_r($newInput);
                            return $newInput;
                        }
            ));
        register_setting( self::SETTINGS_SECTION, self::ETAG_FIELD, array(
                'sanitize_callback' => function ($input) { return !!$input ? "1" : "0"; }
            ));
        register_setting( self::SETTINGS_SECTION, self::LAST_MODIFIED_FIELD, array(
                'sanitize_callback' => function ($input) { return !!$input ? "1" : "0"; }
            ));
        register_setting( self::SETTINGS_SECTION, self::MAX_AGE_FIELD, array(
                'sanitize_callback' => function ($input) { return intval($input); }
            ));

    }

    /**
     *  A function to validate the user input.
     */


    function dbi_plugin_setting_api_key() {
        $options = get_option( 'slithyweb_plugin_options' );
    }

    function dbi_plugin_setting_results_limit() {
        $options = get_option( 'slithyweb_plugin_options' );
        echo "<input id='plugin_setting_api_key' name='slithyweb_plugin_options[results_limit]' type='text' value='" . esc_attr( $options['results_limit']) . "' />";
    }
    
    function dbi_plugin_setting_start_date() {
        $options = get_option( 'slithyweb_plugin_options' );
        echo "<input id='plugin_setting_api_key' name='slithyweb_plugin_options[start_date]' type='text' value='" . esc_attr( $options['start_date'] ) . "' />";
    }
}


