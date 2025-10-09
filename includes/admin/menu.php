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
        add_menu_page($this->top_level_menu(), $this->top_level_menu(), 'manage_options', EASYDIRECTORY_SLUG, [$this, 'admin_dashboard'], '', 5);
    }

    public function admin_dashboard(){
        ?>
        <div class="wrap easydirectory-wrap" id="easydirectory">Loading...</div>
        <?php
    }

    public function top_level_menu(){
        return 'EasyDirectory';
    }
}