<?php

function ct_rest_api_login_handler($request) {
    $response = ['status' => 1];
    $params = $request->get_json_params();

    if(!isset($params['username'], $params['password']) || empty($params['username']) || empty($params['password'])) {
        $response['message'] = 'Username and password are required.';
        return new WP_REST_Response($response, 400);
    }

    $username = sanitize_text_field($params['username']);
    $password = $params['password'];

    $user = wp_signon([
        'user_login' => $username,
        'user_password' => $password,
        'remember' => true
    ], false);

    if (is_wp_error($user)) {
        $response['message'] = 'Invalid username or password.';
        return new WP_REST_Response($response, 401);
    } else {
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user->user_login, $user);
        return new WP_REST_Response(['message' => 'Login successful.', 'status' => 2], 200);
    }
}