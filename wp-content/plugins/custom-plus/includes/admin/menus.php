<?php



function custom_plus_add_admin_menu() {
    add_menu_page(
        __('Custom Plus', 'custom-plus'),
        __('Custom Plus', 'custom-plus'),
        'edit_theme_options',
        'cp-plugin-options',
        'custom_plus_plugin_options_page',
        CUSTOM_PLUS_PLUGIN_URL . 'letter-u.svg',
        20
        
    );
}

