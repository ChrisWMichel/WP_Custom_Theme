<?php

function custom_plus_register_blocks() {
    $blocks = [
        'fancy-header' => [
            get_stylesheet_directory() . '/build/blocks/fancy-header/block.json',
            CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/fancy-header/block.json',
        ],
    ];

    foreach ( $blocks as $block_paths ) {
        foreach ( $block_paths as $block_path ) {
            if ( file_exists( $block_path ) ) {
                register_block_type( $block_path );
                break;
            }
        }
    }
}