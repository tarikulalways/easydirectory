<?php

namespace EasyDirectory;

class Api{

    public static function init(){
        $self = new self();

        $self->dispatch_api_hook();
    }

    public function dispatch_api_hook(){
        API\Terms::init();
    }
}