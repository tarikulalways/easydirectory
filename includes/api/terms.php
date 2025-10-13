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
        register_rest_route($this->namespace, $this->route, [
            'methods' => 'POST',
            'callback' => [$this, 'get_terms'],
            'permission_callback' => '__return_true'
        ]);
    }
    
    public function get_terms($request) {

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