<?php

function custom_plus_enqueue_admin_assets($hook_suffix) {
    if ($hook_suffix === 'toplevel_page_cp-plugin-options') {
        wp_enqueue_media();
        wp_enqueue_script(
            'cp-admin-js',
            CUSTOM_PLUS_PLUGIN_URL . 'build/admin.js',
            [],
            CUSTOM_PLUS_VERSION,
            true
        );
    }
    
}