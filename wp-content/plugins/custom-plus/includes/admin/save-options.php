<?php

function custom_plus_save_plugin_options(){
    if(!current_user_can('edit_theme_options')){
        wp_die(__('Unauthorized user', 'custom-plus'));
    }

    if(!isset($_POST['cp_plugin_options_nonce']) || !wp_verify_nonce($_POST['cp_plugin_options_nonce'], 'cp_options_verify')){
        wp_die(__('Nonce verification failed', 'custom-plus'));
    }

    $options = [
        'og_title' => sanitize_text_field($_POST['cp_og_title'] ?? ''),
        'og_image' => esc_url_raw($_POST['cp_og_image'] ?? ''),
        'og_description' => sanitize_textarea_field($_POST['cp_og_description'] ?? ''),
        'enable_og' => isset($_POST['cp_enable_og']) ? 1 : 0,
    ];

    update_option('cp_plugin_options', $options);

    wp_redirect(admin_url('admin.php?page=cp-plugin-options&status=1'));

    exit;
}