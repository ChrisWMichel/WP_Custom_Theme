<?php

function custom_plus_enqueue_frontend_assets() {
    $config = json_encode([
        'signup'   => esc_url_raw(rest_url('custom-plus/v1/signup')),
        'login'    => esc_url_raw(rest_url('custom-plus/v1/login')),
        'loggedIn' => is_user_logged_in(),
    ]);

    // Register a lightweight frontend handle so REST config is always printed.
    wp_register_script('custom-plus-auth-config', '', [], CUSTOM_PLUS_VERSION, true);
    wp_enqueue_script('custom-plus-auth-config');
    wp_add_inline_script('custom-plus-auth-config', "window.ct_auth_rest = {$config};", 'before');

    
}