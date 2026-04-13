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

add_action('init', 'custom_plus_register_blocks');
add_action('rest_api_init', 'custom_plus_register_api_routes');
add_action('wp_enqueue_scripts', 'custom_plus_enqueue_frontend_assets');