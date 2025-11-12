<?php

namespace EasyDirectory\Admin\PostType;

class PostType {

    public static function init(){
        $self = new self();

        add_action('init', [$self, 'register_listing_type']);
    }

    public function register_listing_type(){
        $post_type = 'easy_hotel_listing';
		register_post_type($post_type, array(
            'labels' => array(
                'name' => esc_html__('Hotel Booking', 'halim'),
            ),
            'public' => true,
			'show_ui' => false,
			'show_in_menu' => false,
			'hierarchical' => false
        ));
    }
}