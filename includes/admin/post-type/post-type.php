<?php

namespace EasyDirectory\Admin\PostType;

class PostType {

    public static function init(){
        $self = new self();

        add_action('init', [$self, 'register_post_types']);
    }

    public function register_post_types(){
        $post_type = 'easydirectory_types';

        // register_post_type(
		// 	$post_type,
		// 	array(
		// 		'labels'                => array(
		// 			'name'               => _x( 'Certificate Templates', 'post type general name', 'academy' ),
		// 			'singular_name'      => _x( 'Certificate Template', 'post type singular name', 'academy' ),
		// 			'add_new'            => _x( 'Add New Template', 'post type add_new', 'academy' ),
		// 			'add_new_item'       => __( 'Add New Template', 'academy' ),
		// 			'edit_item'          => __( 'Edit Certificate Template', 'academy' ),
		// 			'new_item'           => __( 'New Certificate Template', 'academy' ),
		// 			'all_items'          => __( 'Certificate Templates', 'academy' ),
		// 			'view_item'          => __( 'View Certificate Template', 'academy' ),
		// 			'search_items'       => __( 'Search Certificate Templates', 'academy' ),
		// 			'not_found'          => __( 'No certificate templates found', 'academy' ),
		// 			'not_found_in_trash' => __( 'No certificate templates found in Trash', 'academy' ),
		// 			'parent_item_colon'  => '',
		// 			'menu_name'          => __( 'Certificates', 'academy' ),
		// 		),
		// 		'public'                => true,
		// 		'publicly_queryable'    => true,
		// 		'show_ui'               => true,
		// 		'show_in_menu'          => false,
		// 		'show_in_admin_bar'     => false,
		// 		'show_in_nav_menus'     => false,
		// 		'hierarchical'          => false,
		// 		'has_archive'           => false,
		// 		'rewrite'               => array( 'slug' => 'certificate' ),
		// 		'query_var'             => true,
		// 		'delete_with_user'      => false,
		// 		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'post-formats' ),
		// 		'show_in_rest'          => true,
		// 		'rest_base'             => $post_type,
		// 		'rest_namespace'        => ACADEMY_PLUGIN_SLUG . '/v1',
		// 		'rest_controller_class' => Authorization\CertificateController::CLASS,
		// 		'capability_type'           => 'post',
		// 		'template'              => [ [ 'ablocks/academy-certificate' ] ],
		// 		'template_lock' => 'all',
		// 		'capabilities'              => array(
		// 			'edit_post'             => 'edit_academy_certificate',
		// 			'read_post'             => 'read_academy_certificate',
		// 			'delete_post'           => 'delete_academy_certificate',
		// 			'delete_posts'          => 'delete_academy_certificates',
		// 			'edit_posts'            => 'edit_academy_certificates',
		// 			'edit_others_posts'     => 'edit_others_academy_certificates',
		// 			'publish_posts'         => 'publish_academy_certificates',
		// 			'read_private_posts'    => 'read_private_academy_certificates',
		// 			'create_posts'          => 'edit_academy_certificates',
		// 		),
		// 	)
		// );


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