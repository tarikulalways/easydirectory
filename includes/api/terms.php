<?php

namespace EasyDirectory\API;


class Terms {

    protected $namespace = EASYDIRECTORY_SLUG . '/v1';
    protected $route = '/terms';

    public static function init(){
        $self = new self();

        add_action('rest_api_init', [$self, 'register_routes']);
    }

    public function register_routes(){
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'POST',
            'callback' => [$this, 'get_terms'],
            'permission_callback' => '__return_true'
        ]);
    }
    
    public function get_terms($request) {

    $taxonomy = 'easy_directory';
    
    // 1. Term Name এবং args রিকোয়েস্ট থেকে সুরক্ষিতভাবে রিসিভ করুন।
    // get_param() মেথড URL Query এবং JSON Body উভয় স্থান থেকে ডেটা নিতে পারে।
    $term_name = sanitize_text_field( $request->get_param('term_name') );
    
    // 'args' প্যারামিটারটি রিসিভ করুন। যদি না থাকে, তবে একটি ফাঁকা অ্যারে সেট করুন।
    $args = $request->get_param('args') ? : []; 

    // ডেটা না থাকলে প্রাথমিক চেক
    if ( empty($term_name) ) {
        return new \WP_Error( 'missing_term_name', 'Term name is required.', array( 'status' => 400 ) );
    }

    // 2. Term Name ব্যবহার করে Slug তৈরি করুন এবং args-এ যোগ করুন।
    // wp_insert_term() ফাংশনটি যদি স্ল্যাগ না পায়, তবে এটি নিজেই তৈরি করে নেয়।
    // তবে এখানে স্পষ্টভাবে সেট করে দেওয়া নিরাপদ।
    $args['slug'] = sanitize_title( $term_name );


    // 3. Term ইনসার্ট করুন
    $result = wp_insert_term(
        $term_name,
        $taxonomy,
        $args
    );

    // 4. Term ইনসার্ট সফল হয়েছে কিনা, এবং কোনো ত্রুটি আছে কিনা, তা পরীক্ষা করুন।
    // wp_insert_term() সফল হলে একটি অ্যারে এবং ব্যর্থ হলে WP_Error অবজেক্ট রিটার্ন করে।
    if ( is_wp_error( $result ) ) {
        
        // ত্রুটি ঘটলে (যেমন টার্মটি আগে থেকেই থাকলে)
        $error_message = $result->get_error_message();
        
        // 400 Bad Request বা 409 Conflict স্ট্যাটাস কোড ব্যবহার করা ভালো
        return rest_ensure_response([
            'message' => 'Term not inserted. Error: ' . $error_message,
            'status'  => false,
            'code'    => $result->get_error_code()
        ]);
        
    } else {
        
        // সফলভাবে ইনসার্ট হলে
        // 201 Created স্ট্যাটাস কোড ব্যবহার করুন।
        return rest_ensure_response([
            'message' => 'Term inserted successfully',
            'status'  => true,
            'term_id' => $result['term_id'], // ইনসার্ট হওয়া টার্মের আইডি রিটার্ন করা হলো
        ]);
    }
}
}