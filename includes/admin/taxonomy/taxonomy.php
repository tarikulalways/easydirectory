<?php

namespace EasyDirectory\Admin\Taxonomy;

class Taxonomy {

    public static function init(){
        $self = new self();

        add_action('init', [$self, 'register_taxonomies']);
    }

    public function register_taxonomies(){
        $labels = array(
            'name' => __('Directories', 'easydirectory'),
            'singular_name' => __('Directory', 'easydirectory')
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'rewrite' => array(
                'slug' => 'easydirectory'
            )
        );

        register_taxonomy('easy_directory', '', $args);
    }
}