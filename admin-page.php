<?php

// If this file is called directly, abort.
if (!defined('WPINC')) die;

/**
 * This class is used when the administrator pages are requested.
 */
class SlithyWebAdministrator {
    function __construct() {
        add_action( 'admin_menu', array($this, 'add_settings_page'));
        add_action( 'admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_options_page( 
            __('Slithy Web setting', 'slithy-web'),
            __('Slithy web', 'slithy-web'),
            'manage_options', 
            'slithyweb-plugin', 
            array($this, 'render_plugin_settings_page'));
    }

    /**
     * Register the settings of the administration page
     */
    function register_settings() {
        register_setting( 'slithyweb_plugin_options', 'slithyweb_plugin_options', array(
                'sanitize_callback' => array($this, 'plugin_options_validate')
            )
        );
        add_settings_section( 'api_settings', 
            __('API Settings', 'slithy-web'),
            array($this, 'plugin_section_text'), 
            'slithyweb_api_plugin' );
    
        add_settings_field( 'plugin_setting_api_key', 'API Key', array($this, 'dbi_plugin_setting_api_key'), 'slithyweb_api_plugin', 'api_settings' );
        add_settings_field( 'plugin_setting_results_limit', 'Results Limit', array($this, 'dbi_plugin_setting_results_limit'), 'slithyweb_api_plugin', 'api_settings' );
        add_settings_field( 'plugin_setting_start_date', 'Start Date', array($this, 'dbi_plugin_setting_start_date'), 'slithyweb_api_plugin', 'api_settings' );
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
        _e('Here you can set all the options for using the API', 'slithy-web');
        echo "</p>";
    }

    function dbi_plugin_setting_api_key() {
        $options = get_option( 'slithyweb_plugin_options' );
        echo "<input id='plugin_setting_api_key' name='slithyweb_plugin_options[api_key]' type='text' value='{esc_attr( $options['api_key'] )}' />";
    }

    function dbi_plugin_setting_results_limit() {
        $options = get_option( 'slithyweb_plugin_options' );
        echo "<input id='plugin_setting_api_key' name='slithyweb_plugin_options[results_limit]' type='text' value='{esc_attr( $options['results_limit'] )}' />";
    }
    
    function dbi_plugin_setting_start_date() {
        $options = get_option( 'slithyweb_plugin_options' );
        echo "<input id='plugin_setting_api_key' name='slithyweb_plugin_options[start_date]' type='text' value='{esc_attr( $options['start_date'] )}' />";
    }
}