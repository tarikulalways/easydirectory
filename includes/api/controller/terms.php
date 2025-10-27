<?php

namespace EasyDirectory\API\Controller;

use EasyDirectory\Helper;

class Terms {

    protected $namespace = EASYDIRECTORY_SLUG . '/v1';
    protected $route = '/terms';
    
    private $taxonomy_name = 'easy_directory';

    public static function init(){
        $self = new self();

        add_action('rest_api_init', [$self, 'register_term_routes']);
    }

    public function register_term_routes(){
        // get_items
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'GET',
            'callback' => [$this, 'get_items'],
            'permission_callback' => '__return_true'
        ]);

        // create_item
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'POST',
            'callback' => [$this, 'create_items'],
            'permission_callback' => '__return_true',
            'args' => array(
                'term_name' => array(
                    'required' => true,
                    'type' => 'string',
                    'validate_callback' => function($term_name){
                        if(is_string($term_name)){
                            return $term_name;
                        }
                    }
                )
            )
        ]);

        // update_term
        register_rest_route($this->namespace, $this->route . '/(?P<id>\d+)', [
            'methods' => 'PUT',
            'callback' => [$this, 'update_item'],
            'permission_callback' => '__return_true',
            'args' => array(
                'id' => array(
                    'required' => true,
                    'type' => 'integer'
                )
            )
        ]);

        // get_item
        register_rest_route($this->namespace, $this->route . '/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'get_item'],
            'permission_callback' => '__return_true',
            'args' => array(
                'id' => array(
                    'type' => 'integer',
                    'required' => true,
                    'validate_callback' => function($id){
                        if(is_numeric($id)){
                            return $id;
                        }
                    }
                )
            )
        ]);

        // delete_term
        register_rest_route($this->namespace, $this->route . '/(?P<id>\d+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'delete_term'],
            'permission_callback' => '__return_true'
        ]);
    }

    // get_items
    public function get_items(){
        $term = array(
            'taxonomy' => $this->taxonomy_name,
            'hide_empty' => false
        );

        $terms = get_terms($term);
        
        if(empty($terms)){
            return rest_ensure_response([
                'message' => 'Terms not found',
                'status' => false
            ]);
        }else{
            return rest_ensure_response([
                'data' => $terms,
                'status' => true,
                'total_terms' => count($terms),
                'code'    => 'taxonomy_query_failed',
            ]);
        }
    }
    
    // post_terms
    public function create_items($request) {
        $term_name = sanitize_text_field( $request->get_param('term_name') );
        $args = $request->get_param('args') ? : []; 

        if ( empty($term_name) ) {
            return new \WP_Error( 'missing_term_name', 'Term name is required.', array( 'status' => 400 ) );
        }
        $args['slug'] = sanitize_title( $term_name );

        $result = wp_insert_term(
            $term_name,
            $this->taxonomy_name,
            $args
        );

        if ( is_wp_error( $result ) ) {

            $error_message = $result->get_error_message();
            return rest_ensure_response([
                'message' => 'Term not inserted. Error: ' . $error_message,
                'status'  => false,
                'code'    => $result->get_error_code()
            ]);
            
        } else {
            return rest_ensure_response([
                'message' => 'Term inserted successfully',
                'status'  => true,
                'term_id' => $result['term_id'],
            ]);

            do_action('easydirectory/after_insert_term', $result);
        }
    }

    // update_item

    public function update_item($request){
        $term_id = absint($request->get_param('id'));

        $update_id = wp_update_term($term_id, $this->taxonomy_name, [
            'name' => 
        ]);
    }
}