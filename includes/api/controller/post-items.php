<?php

namespace EasyDirectory\API\Controller;

class PostItems {

    protected $namespace = EASYDIRECTORY_SLUG . '/v1';
    protected $route = '/posts';

    public static function init(){
        $self = new self();

        add_action('rest_api_init', [$self, 'register_post_item_route']);
    }

    public function register_post_item_route(){
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'POST',
            'callback' => 'create_post',
            'permission_callback' => '__return_true'
        ]);
    }

    public function create_post($request){
        $post_title = $request->get_param('post_title');
        $post_content = $request->get_param('post_content');
        $post_status = $request->get_param('post_status');
        $post_author = $request->get_param('post_author');
        $post_type = 'easydirectory_types';

        $post_id = wp_insert_post(array(
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_author' => $post_author,
            'post_status' => $post_status
        ));

        if($post_id){
            return rest_ensure_response([
                'message' => 'Post Create success',
                'status' => true
            ]);
        }else{
            return rest_ensure_response([
                'message' => 'Post not Create',
                'status' => false
            ]);
        }
    }
}