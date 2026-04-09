<?php

function ct_register_styles() {
    $theme_version = wp_get_theme()->get( 'Version' );

    wp_register_style( 'custom-theme-google-fonts', 'https://fonts.googleapis.com/css2?family=Pacifico&family=Rubik:wght@300;400;500;700&display=swap', array(), null );
    wp_register_style( 'font-awesome', get_theme_file_uri( '/assets/bootstrap-icons/bootstrap-icons.css' ), array(), $theme_version );
    wp_register_style( 'custom-theme-style', get_theme_file_uri( '/assets/public/index.css' ), array(), $theme_version );
    wp_register_style( 'custom-theme-editor', get_theme_file_uri( '/assets/editor.css' ), array( 'custom-theme-style' ), $theme_version );
}

function ct_enqueue_styles() {
    ct_register_styles();

    wp_enqueue_style( 'custom-theme-google-fonts' );
    wp_enqueue_style( 'font-awesome' );
    wp_enqueue_style( 'custom-theme-style' );
}

function ct_enqueue_block_assets() {
    if ( ! is_admin() ) {
        return;
    }

    ct_register_styles();

    wp_enqueue_style( 'custom-theme-google-fonts' );
    wp_enqueue_style( 'font-awesome' );
    wp_enqueue_style( 'custom-theme-style' );
    wp_enqueue_style( 'custom-theme-editor' );
}
