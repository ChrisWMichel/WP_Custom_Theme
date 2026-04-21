<?php

function custom_plus_register_blocks() {
    $blocks = [
        'fancy-header' => [
            get_stylesheet_directory() . '/build/blocks/fancy-header/block.json',
            CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/fancy-header/block.json',
        ],
        'search-form' => [
            'options' => [
                'render_callback' => 'custom_plus_render_search_form_cb',
            ],
            get_stylesheet_directory() . '/build/blocks/search-form/block.json',
            CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/search-form/block.json',
        ],
            'page-header' => [
                'options' => [
                    'render_callback' => 'custom_plus_render_page_header_cb',
                ],
                get_stylesheet_directory() . '/build/blocks/page-header/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/page-header/block.json',
            ],
            'header-tools' => [
                'options' => [
                     'render_callback' => 'custom_plus_render_header_tools_cb',
                ],
                get_stylesheet_directory() . '/build/blocks/header-tools/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/header-tools/block.json',
            ],
            'auth-modal' => [
                'options' => [
                    'render_callback' => 'custom_plus_render_auth_modal_cb',
                ],
                get_stylesheet_directory() . '/build/blocks/auth-modal/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/auth-modal/block.json',
            ],
            'recipe-summary' => [
                    'options' => [
                        'render_callback' => 'custom_plus_render_recipe_summary_cb',
                    ],
                get_stylesheet_directory() . '/build/blocks/recipe-summary/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/recipe-summary/block.json',
            ],
            'team-members-group' => [
                get_stylesheet_directory() . '/build/blocks/team-members-group/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/team-members-group/block.json',
            ],
             'single-team-member' => [
                get_stylesheet_directory() . '/build/blocks/single-team-member/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/single-team-member/block.json',
            ],
            'popular-recipes' => [
                'options' => [
                    'render_callback' => 'custom_plus_render_popular_recipes_cb',
                ],
                get_stylesheet_directory() . '/build/blocks/popular-recipes/block.json',
                CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/popular-recipes/block.json',
            ],
                'daily-recipe' => [
                    'options' => [
                        'render_callback' => 'custom_plus_render_daily_recipe_cb',
                    ],
                    get_stylesheet_directory() . '/build/blocks/daily-recipe/block.json',
                    CUSTOM_PLUS_PLUGIN_DIR . 'build/blocks/daily-recipe/block.json',
                ],
    ];

    foreach ( $blocks as $block_paths ) {
        $options = [];

        if ( isset( $block_paths['options'] ) && is_array( $block_paths['options'] ) ) {
            $options = $block_paths['options'];
            unset( $block_paths['options'] );
        }

        foreach ( $block_paths as $block_path ) {
            if ( ! is_string( $block_path ) ) {
                continue;
            }

            if ( file_exists( $block_path ) ) {
                register_block_type( $block_path, $options );
                break;
            }
        }
    }
}