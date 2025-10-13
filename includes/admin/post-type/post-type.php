<?php

namespace EasyDirectory\Admin\PostType;

class PostType {

    public static function init(){
        $self = new self();

        add_action('init', [$self, 'register_post_types']);
    }

    public function register_post_types(){
        $labels = array(
            'name'               => 'All Listings',
            'singular_name'      => 'Listing',
            'menu_name'          => 'All Listings',
            'all_items'          => 'All Listings',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Listing',
            'edit_item'          => 'Edit Listing',
            'view_item'          => 'View Listing',
        );

        $args = array(
            'labels' => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => false, 
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'listing' ),
            'capability_type'     => 'post',
            'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' )
        );

        register_post_type( 'easydirectory_types', $args );

    }
}