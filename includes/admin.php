<?php

namespace EasyDirectory;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin{

    public static function init(){
        $self = new self();

        $self->dispatch_admin_hook();
    }

    public function dispatch_admin_hook(){
        Admin\Menu::init();
        Admin\Taxonomy\Taxonomy::init();
        Admin\PostType\PostType::init();
    }
}