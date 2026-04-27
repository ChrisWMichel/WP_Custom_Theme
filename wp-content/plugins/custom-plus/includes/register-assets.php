<?php

function custom_plus_register_assets() {
    wp_register_style(
        'cp-block-styles',
        plugins_url('/build/admin/index.css', CUSTOM_PLUS_PLUGIN_FILE),
        [],
        CUSTOM_PLUS_VERSION
    );
    
    wp_register_script(
        'cp-block-editor-js',
        plugins_url('/build/block-editor.js', CUSTOM_PLUS_PLUGIN_FILE),
        ['wp-blocks', 'wp-element', 'wp-editor'],
        CUSTOM_PLUS_VERSION,
        true
    );
}