<?php

/**
 * Plugin Name: EasyDirectory
 * Plugin URI: https://example.com/
 * Description: EasyDirectory listing plugin.
 * Version: 0.0.1
 * Author: Tarikul
 * Author URI: https://author.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: easydirectory
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Easydirectory {

    private function __construct(){
        $this->define_constant();
        $this->load_dependency();
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
        add_action('easy_directory_loaded', [$this, 'init_plugin']);
    }

    public static function init(){
        static $instance = false;

        if(! $instance){
            $instance = new self();
        }

        return $instance;
    }

    public function define_constant(){
        define('EASYDIRECTORY_ROOT_PATH', plugin_dir_path(__FILE__));
        define('EASYDIRECTORY_ROOT_URL', plugin_dir_url(__FILE__));
        define('EASYDIRECTORY_PLUGIN_BASENAME', plugin_basename(__FILE__));
        define('EASYDIRECTORY_INCLUDES_PATH', EASYDIRECTORY_ROOT_PATH . 'includes/');
        define('EASYDIRECTORY_ASSETS_PATH', EASYDIRECTORY_ROOT_PATH . 'assets/');
        define('EASYDIRECTORY_ASSETS_URL', EASYDIRECTORY_ROOT_URL . 'assets/');
        define('EASYDIRECTORY_SLUG', 'easydirectory');
        define('EASYDIRECTORY_SETTINGS', 'easydirectory_settings');
        define('EASYDIRECTORY_PLUGIN_VERSION', '1.0.0');
    }

    public function on_plugins_loaded(){
        do_action('easy_directory_loaded');
    }

    public function init_plugin(){
        do_action('easydirectory_before_init');
        $this->dispatch_hook();
        do_action('easydirectory_after_init');
    }

    public function dispatch_hook(){
        EasyDirectory\Api::init();
        
        if(is_admin()){
            EasyDirectory\Admin::init();
        }
    }

    public function load_dependency(){
        require_once EASYDIRECTORY_INCLUDES_PATH . 'autoload.php';
    }

    public function activate(){

    }

    public function deactivate(){

    }




}

function start_easydirectory(){
    return Easydirectory::init();
}
start_easydirectory();