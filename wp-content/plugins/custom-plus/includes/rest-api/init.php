<?php

function custom_plus_register_api_routes() {
    register_rest_route( 'custom-plus/v1', '/signup', [
        'methods' => 'POST',
        'callback' => 'ct_rest_api_signup_handler',
        'permission_callback' => '__return_true',
    ] );

    register_rest_route( 'custom-plus/v1', '/login', [
        'methods' => 'POST',
        'callback' => 'ct_rest_api_login_handler',
        'permission_callback' => '__return_true',
    ] );

     register_rest_route( 'custom-plus/v1', '/logout', [
        'methods' => 'POST',
        'callback' => 'ct_rest_api_logout_handler',
        'permission_callback' => '__return_true',
    ] );
}