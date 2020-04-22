<?php


// If this file is called directly, abort.
if (!defined('WPINC')) die;

include dirname(__FILE__)."/helpers.php";

use \Slithyweb\Helper as Helper;

/**
 * This class is used when the administrator pages are requested.
 */
class SlithyWebAdministrator extends Helper {

    const OPT_GROUP = 'slithyweb_plugin_options';
    const API_SECTION = 'slithyweb_api_section';
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

    function render_my_settings_page() {
        printf('<h1>%s</h1>', self::T("Slithy Web Plugin Settings"));
        printf('<h2>%s (<a href="https://maisonwp.com/">maisonwp.com</a>)</h2>', __("Slithy Web hosting", 'slithy-web'));
        if(defined("SLITHYWEB_ID")){
            printf("<strong>%s:<strong> <code>%s</code> (%s)\n", self::T("Site identifier"), SLITHYWEB_ID, self::T("can not be changed"));
        } else {
            self::parag("This Website is not hosted by our recommended hosting service. Never mind.");
        }
        if(defined("WP_DEBUG")){
            printf("<p>%s %s</p>", self::T("WP_DEBUG is"), WP_DEBUG ? self::T("active") : self::T("disabled (PRODUCTION)"));
        } else {
            printf("<p>%s</p>", self::T("WP_DEBUG is not set (means PRODUCTION mode)")); 
        }
        echo '<form action="options.php" method="post">';
        settings_fields(self::OPT_GROUP);
        do_settings_sections(self::OPT_GROUP);
        submit_button();
        // printf( '<input name="submit" class="button button-primary" type="submit" value="%s" />', esc_attr__( 'Save' ));
        echo '</form>';
    }

    /**
     * Register the settings of the administration page
     */
    function register_my_settings() {
        register_setting( self::OPT_GROUP, 'slithyweb_plugin_options', array(
                'sanitize_callback' => array($this, 'plugin_options_validate')
            )
        );
        add_settings_section( self::API_SECTION, 
            Helper::T('API Settings'),
            function() {
                printf("<p>%s<p>\n", __('Here you can set all the options for using the API', 'slithy-web'));
            },
            self::OPT_GROUP );
    
        add_settings_field( 'plugin_setting_api_key', 'Google Key', function() {
                    $options = get_option(self::API_SECTION);
                    echo Helper::tag("input", array("id"=>'plugin_setting_api_key', "name"=>'slithyweb_plugin_options[api_key]', "type"=>'text', "value"=>$options['api_key']));
                    }, self::OPT_GROUP, self::API_SECTION );
        // add_settings_field( 'plugin_setting_results_limit', 'Results Limit', array($this, 'dbi_plugin_setting_results_limit'), 'slithyweb_api_plugin', 'api_settings' );
        // add_settings_field( 'plugin_setting_start_date', 'Start Date', array($this, 'dbi_plugin_setting_start_date'), 'slithyweb_api_plugin', 'api_settings' );
    }

    function plugin_options_validate($input) {
        $newinput['api_key'] = trim( $input['api_key'] );
        if ( ! preg_match( '/^[a-z0-9]{32}$/i', $newinput['api_key'] ) ) {
            $newinput['api_key'] = '';
        }
    
        return $newinput;
    }

    function plugin_section_text() {
        echo "<p>";
        echo "</p>";
    }

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
