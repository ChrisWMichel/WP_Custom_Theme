<?php

function custom_plus_activate_plugin() {
    if(version_compare(get_bloginfo('version'), '5.0', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires WordPress version 5.0 or higher. Please update WordPress and try again.');
    }

    ct_recipe_post_type();
    flush_rewrite_rules();

    global $wpdb;
    $table_name = $wpdb->prefix . 'recipe_ratings';
    $charsetCollate = $wpdb->get_charset_collate();

    $sql = "
        CREATE TABLE {$table_name} (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            post_id bigint(20) unsigned NOT NULL,
            user_id bigint(20) unsigned NOT NULL,
            rating float(3,2) unsigned NOT NULL
            ) ENGINE='InnoDB' {$charsetCollate};
             ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $options = get_option( 'custom_plus_plugin_options' );
    if ( ! $options ) {
        add_option( 'custom_plus_plugin_options', [
            'og_title' => get_bloginfo( 'name' ),
            'og_img' => '',
            'og_desc' => get_bloginfo( 'description' ),
            'enable_og' => 1
        ] );
        $default_options = [
            'enable_favorite_recipes' => true,
            'enable_recipe_ratings' => true,
        ];
        update_option( 'custom_plus_plugin_options', $default_options );
    }
}

function custom_plus_deactivate_plugin() {
    // Code to run on plugin deactivation
    // For example, you could clean up custom database tables here
}