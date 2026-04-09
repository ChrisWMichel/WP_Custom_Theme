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

require_once(CUSTOM_PLUS_PLUGIN_DIR . 'includes/register-blocks.php');


add_action('init', 'custom_plus_register_blocks');