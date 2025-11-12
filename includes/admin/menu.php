<?php

namespace EasyDirectory\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Menu{
    
    public static function init(){
        $self = new self();

        add_action('admin_menu', [$self, 'admin_menu_register']);
    }

    public function admin_menu_register(){
        add_menu_page('EasyDirectory', 'EasyDirectory', 'manage_options', EASYDIRECTORY_SLUG, [$this, 'load_main_template'], '', 5);
        add_submenu_page(EASYDIRECTORY_SLUG, 'Dashboard', 'Dashboard', 'manage_options', EASYDIRECTORY_SLUG, [$this, 'load_main_template']);
        add_submenu_page(EASYDIRECTORY_SLUG, 'All Listing', 'All Listing', 'manage_options', EASYDIRECTORY_SLUG . '-all-listing', [$this, 'load_main_template']);
    }

    public function load_main_template(){
        $page = sanitize_text_field($_GET['page']);

        switch($page){
            case EASYDIRECTORY_SLUG:
                echo '<div class="easyinventory">Dashboard Page</div>';
                break;
            case EASYDIRECTORY_SLUG . '-all-listing':
                echo '<div class="easyinventory">All Listing Page</div>';
                break;
        }
        
    }
}