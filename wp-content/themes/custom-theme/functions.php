<?php

// Variables

// Includes
require_once get_theme_file_path('/includes/front/enqueue.php');
require_once get_theme_file_path('/includes/front/ct_head.php');
require_once get_theme_file_path('/includes/setup.php');


// Hooks
add_action('wp_head', 'ct_head', 5);
add_action( 'wp_enqueue_scripts', 'ct_enqueue_styles' );
add_action( 'enqueue_block_assets', 'ct_enqueue_block_assets' );
add_action( 'after_setup_theme', 'ct_setup_theme' );


