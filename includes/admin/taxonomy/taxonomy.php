<?php

namespace EasyDirectory\Admin\Taxonomy;

class Taxonomy {

    public static function init(){
        $self = new self();

        add_action('init', [$self, 'register_taxonomies']);
    }

    public function register_taxonomies(){

        $object_type = 'easy_hotel_listing';
        $taxonomy_name = 'easy_directory';

        $taxonomy_register = register_taxonomy(
            $taxonomy_name,
            $object_type,
            array(
                'labels' => array(
                    'name' => __('Directories', 'easydirectory'),
                    'singular_name' => __('Directory', 'easydirectory')
                ),
                'public' => true,
                'show_in_menu' => false,
                'show_ui' => false,
                'hierarchical' => true
            )
        );

        if($taxonomy_register){
            do_action('easydirectory/after_register_taxonomy');
        }
        
    }
}