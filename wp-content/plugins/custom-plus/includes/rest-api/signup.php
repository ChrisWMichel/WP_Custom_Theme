<?php

function ct_rest_api_signup_handler($request){
    $response = ['status' => 1];
    $params = $request->get_json_params();

    if(!isset($params['username'], $params['email'], $params['password']) || empty($params['username']) || empty($params['email']) || empty($params['password'])) {
        $response['message'] = 'All fields are required.';
        return $response;
    }

    $email = sanitize_email($params['email']);
    if(!is_email($email)) {
        $response['message'] = 'Invalid email address.';
        return $response;
    }
    if(email_exists($email)) {
        $response['message'] = 'Email already in use.';
        return $response;
    }
    $username = sanitize_text_field($params['username']);
    $password = sanitize_text_field($params['password']);

    if(username_exists($username) || !is_email($email) || email_exists($email)) {
        $response['message'] = 'Username already in use, or invalid email.';
        return $response;
    }

    $user_id = wp_insert_user([
        'user_login' => $username,
        'user_email' => $email,
        'user_pass' => $password
    ]);

    if (is_wp_error($user_id)) {
        return new WP_REST_Response(['message' => 'Failed to create user.'], 500);
    } else {
        wp_new_user_notification($user_id, null, 'both');
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
    }

    $user = get_user_by('id', $user_id);
    do_action('wp_login', $user->user_login, $user);

    return new WP_REST_Response(['message' => 'User created successfully.', 'status' => 2], 201);

}