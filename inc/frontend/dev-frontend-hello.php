<?php 
// Exit if accessed directly    
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
//dev frontend class
final class DEV_Frontend_Hello{
    
    //instance
    public static $_instance;
    //file
    public $file = __FILE__;

    // Constructor
    public function __construct() {
        add_action('wp_footer', array($this, 'dev_rabi_frontend_notice'));
    }
    //frontend notice
    public function dev_rabi_frontend_notice(){
        echo '<div class="notice notice-success is-dismissible">
            <p>Hello! I am your plugin from frontend.</p>
        </div>';
    }

    public static function dev_get_instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DEV_Frontend_Hello();
        }
        return self::$_instance;
    }
}
