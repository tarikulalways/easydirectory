<?php

namespace EasyDirectory\Controller;

class PostTypeController{

    public static function index(){
        $all_listings = get_posts(['post_type'=>'listing']);

        if($all_listings){
            return rest_ensure_response([
                'message' => $all_listings,
                'status' => true
            ]);
        }else{
            return rest_ensure_response([
                'message' => 'have not a data',
                'status' => false
            ]);
        }
    }

    public static function store($request){
        $cpt_data = array(
            'post_title'    => $request->get_param('post_title'),
            'post_name'     => sanitize_title($request->get_param('post_title')),
            'post_content'  => $request->get_param('post_content'),
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'listing'
        );

        if(is_array($cpt_data)){
            $post_id = wp_insert_post($cpt_data);
            if($post_id){
                return rest_ensure_response([
                   'message' => $post_id,
                   'status' => true 
                ]);
            }else{
                return rest_ensure_response([
                    'message' => 'Someting want wrong',
                    'status' => false
                ]);
            }
        }
    }
}