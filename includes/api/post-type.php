<?php

namespace EasyDirectory\API;

use EasyDirectory\Controller\PostTypeController;

class PostType{

    private $namespace;

    public static function init(){
        $self = new self();

        $self->namespace = EASYDIRECTORY_SLUG . '/v1';
        add_action('rest_api_init', [$self, 'register_post_types']);
    }

    public function register_post_types(){
        $endpoint = 'listings';

        register_rest_route($this->namespace, $endpoint, [
            'methods' => 'GET',
            'callback' => [PostTypeController::class, 'index'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route($this->namespace, $endpoint, [
            'methods' => 'POST',
            'callback' => [PostTypeController::class, 'store'],
            'permission_callback' => '__return_true',
            'args' => [
                'post_title' => [
                    'required' => true,
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => function($value){
                        if(! is_string($value)){
                            return;
                        }
                    }
                ],
                'post_content' => [
                    'required' => true,
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => function($value){
                        if(! is_string($value)){
                            return;
                        }
                    }
                ]
            ]
        ]);
    }

    public function store(){
        error_log('local');
    }

}