<?php

function custom_plus_register_api_routes() {
    register_rest_route( 'custom-plus/v1', '/signup', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'ct_rest_api_signup_handler',
        'permission_callback' => '__return_true',
    ] );

    register_rest_route( 'custom-plus/v1', '/login', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'ct_rest_api_login_handler',
        'permission_callback' => '__return_true',
    ] );

     register_rest_route( 'custom-plus/v1', '/logout', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'ct_rest_api_logout_handler',
        'permission_callback' => '__return_true',
    ] );

        register_rest_route( 'custom-plus/v1', '/rate', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => 'ct_rest_api_add_rating_handler',
            'permission_callback' => 'is_user_logged_in',
        ] );
}