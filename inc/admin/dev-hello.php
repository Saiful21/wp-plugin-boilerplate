<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
//dev admin class
final class DEV_Hello{
    
    //instance
    public static $_instance;
    //file
    public $file = __FILE__;

    // Constructor
    public function __construct() {
        add_action('admin_notices', array($this, 'dev_rabi_admin_notice'));
    }
    //admin notice
    public function dev_rabi_admin_notice(){
        echo '<div class="notice notice-success is-dismissible">
            <p>Hello! I am your plugin from dashboard.</p>
        </div>';
    }

    public static function dev_get_instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DEV_Hello();
        }
        return self::$_instance;
    }
}