<?php

/**
 * Plugin Name: Custom Plus
 * Description: A plugin for adding blocks to a theme.
 * Version: 1.0.0
 * Author: Chris Michel
    * License: GPL2
 * Text Domain: custom-plus
 */

if(!function_exists('add_action')) {
    echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('CUSTOM_PLUS_VERSION', '1.0.0');
define('CUSTOM_PLUS_PLUGIN_DIR', plugin_dir_path(__FILE__));

$rootFiles = glob(CUSTOM_PLUS_PLUGIN_DIR . 'includes/*.php');
$subdirectory = glob(CUSTOM_PLUS_PLUGIN_DIR . 'includes/**/*.php', GLOB_BRACE);
$allFiles = array_merge($rootFiles, $subdirectory);

foreach ( $allFiles as $filename ) {
    require_once $filename;
}

register_activation_hook( __FILE__, 'custom_plus_activate_plugin' );
register_deactivation_hook( __FILE__, 'custom_plus_deactivate_plugin' );
add_action('init', 'custom_plus_register_blocks');
add_action('rest_api_init', 'custom_plus_register_api_routes');
add_action('wp_enqueue_scripts', 'custom_plus_enqueue_frontend_assets');
add_action('init', 'ct_recipe_post_type');
// Add actions for custom taxonomy fields
add_action('cuisine_add_form_fields', 'custom_plus_add_cuisine_field');
add_action('cuisine_edit_form_fields', 'custom_plus_edit_cuisine_field', 10, 2);
add_action('created_cuisine', 'custom_plus_save_cuisine_field');
add_action('edited_cuisine', 'custom_plus_save_cuisine_field');
add_action('save_post_recipe', 'custom_plus_save_post_recipe_meta');
add_action('after_setup_theme', 'custom_plus_register_block_styles');
add_filter('image_size_names_choose', 'custom_plus_custom_image_sizes');
add_filter('rest_recipe_query', 'custom_plus_modify_rest_recipe_query', 10, 2);