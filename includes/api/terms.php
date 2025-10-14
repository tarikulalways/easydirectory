<?php

namespace EasyDirectory\API;

use EasyDirectory\Helper;

class Terms {

    protected $namespace = EASYDIRECTORY_SLUG . '/v1';
    protected $route = '/terms';

    public static function init(){
        $self = new self();

        add_action('rest_api_init', [$self, 'register_term_routes']);
    }

    public function register_term_routes(){
        // get_terms
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'GET',
            'callback' => [$this, 'get_terms'],
            'permission_callback' => '__return_true'
        ]);

        // post_term
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'POST',
            'callback' => [$this, 'post_terms'],
            'permission_callback' => '__return_true'
        ]);

        // update_term
        register_rest_route($this->namespace, $this->route . '/(?P<id>\d+)', [
            'methods' => 'PUT',
            'callback' => [$this, 'update_term'],
            'permission_callback' => '__return_true'
        ]);

        // delete_term
        register_rest_route($this->namespace, $this->route . '/(?P<id>\d+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'delete_term'],
            'permission_callback' => '__return_true'
        ]);
    }

    // get_terms
    public function get_terms(){
        $taxonomy = 'easy_directory';
        $term = array(
            'taxonomy' => $taxonomy,
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
    public function post_terms($request) {

        $taxonomy = 'easy_directory';
        $term_name = sanitize_text_field( $request->get_param('term_name') );
        $args = $request->get_param('args') ? : []; 

        if ( empty($term_name) ) {
            return new \WP_Error( 'missing_term_name', 'Term name is required.', array( 'status' => 400 ) );
        }
        $args['slug'] = sanitize_title( $term_name );

        $result = wp_insert_term(
            $term_name,
            $taxonomy,
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
        }
    }
}