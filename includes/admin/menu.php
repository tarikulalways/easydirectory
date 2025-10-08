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
        add_menu_page('EasyDirectory', 'EasyDirectory', 'manage_options', EASYDIRECTORY_SLUG, [$this, 'admin_dashboard'], '', 5);
        add_submenu_page(EASYDIRECTORY_SLUG, 'all listings', 'All Listings', 'manage_options', 'all-listing', [$this, 'all_listings']);
    }

    public function admin_dashboard(){
        ?>
        <div class="wrap easydirectory-wrap" id="easydirectory">comming soon...</div>
        <?php
    }

    public function all_listings(){
        ?>
        <div class="wrap easydirectory-wrap" id="easydirectory">All listings comming soon...</div>
        <?php
    }
}