<?php 
/*
Plugin Name: Dev Rabiul Islam
Plugin URI: https://rabiulislam.com/
Description: Welcome to the Wp Rabiul Islam plugin. This plugin is developed by Rabiul Islam. This plugin is used for testing purpose.
Version: 1.0.0
Tested up to: 5.8
Requires at least: 5.8
Author: wp-rabiul-islam
Author URI: https://rabiulislam.com/
License: GPLv2 or later
Text Domain: rabiu-islam
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//main class
class DevRabi{
    //version
    const version = '1.0.0';
    // Constructor
    private function __construct() {
        $this->define_constants();
        //text domain
        add_action('init', array($this, 'dev_rabi_load_textdomain'));
        //register activation hook
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        //register deactivation hook
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
        //plugin loaded action
        add_action( 'plugins_loaded', array( $this, 'nss_init' ) );
    }
    //text domain
    public function dev_rabi_load_textdomain(){
        load_plugin_textdomain('rabiu-islam', false, dirname(__FILE__).'/languages');
    }
    //plugin loaded action
    public function nss_init(){
        if(is_admin()){
            //admin class
            require_once __DIR__ . '/inc/admin/dev-hello.php';
            Dev_Hello::dev_get_instance();
            
            //admin enqueue scripts
            add_action('admin_enqueue_scripts', array($this, 'dev_rabi_admin_enqueue_scripts'));
        }else{
            //frontend class
            require_once __DIR__ . '/inc/frontend/dev-frontend-hello.php';
            DEV_Frontend_Hello::dev_get_instance();

            //frontend enqueue scripts
            add_action('wp_enqueue_scripts', array($this, 'dev_rabi_frontend_enqueue_scripts'));
        }
    }
    // Initialize the plugin
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }
   
    //constants define
    public function define_constants() {
        define( 'RABIUL_ISLAM_VERSION', self::version );
        define( 'RABIUL_ISLAM_FILE', __FILE__ );
        define( 'RABIUL_ISLAM_PATH', __DIR__ );
        define( 'RABIUL_ISLAM_URL', plugins_url( '', RABIUL_ISLAM_FILE ) );
    }
    //admin enqueue scripts
    public function dev_rabi_admin_enqueue_scripts(){
        wp_enqueue_style('dev-rabiul-islam-admin', RABIUL_ISLAM_URL . '/assets/css/admin/admin.css', [], time(), 'all');
        wp_enqueue_script('dev-rabiul-islam-admin', RABIUL_ISLAM_URL . '/assets/js/admin/admin.js', ['jquery'], time(), true);
    }
    //frontend enqueue scripts
    public function dev_rabi_frontend_enqueue_scripts(){
        wp_enqueue_style('dev-rabiul-islam-frontend', RABIUL_ISLAM_URL . '/assets/css/frontend/frontend.css', [], time(), 'all');
        wp_enqueue_script('dev-rabiul-islam-frontend', RABIUL_ISLAM_URL . '/assets/js/frontend/frontend.js', ['jquery'], time(), true);
    }
    //activation
    public function activate() {
        $installed = get_option( 'rabiul_islam_installed' );

        if ( ! $installed ) {
            update_option( 'rabiul_islam_installed', time() );
        }

        update_option( 'rabiul_islam_version', RABIUL_ISLAM_VERSION );
    }
    //deactivation
    public function deactivate() {
        delete_option( 'rabiul_islam_installed' );
    }
}

//initialize the plugin
DevRabi::init();