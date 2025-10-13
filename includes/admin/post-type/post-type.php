<?php

namespace EasyDirectory\Admin\PostType;

class PostType {

    public static function init(){
        $self = new self();

        add_action('init', [$self, 'register_post_types']);
    }

    public function register_post_types(){
        $post_type = 'easydirectory_types';

        register_post_type(
            $post_type,
            array(
                'labels' => array(
                    'name' => __('new All listings', 'easydirectory'),
                    'singular_name' => __('All listing', 'easydirectory')
                ),
                'public' => true,
                'show_in_menu' => false,
                'show_ui' => false
            )
        );

    }
}