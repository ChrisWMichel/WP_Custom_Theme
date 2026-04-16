<?php

function ct_recipe_post_type() {
    $labels = array(
        'name'                  => _x( 'Recipes', 'Post type general name', 'custom-plus' ),
        'singular_name'         => _x( 'Recipe', 'Post type singular name', 'custom-plus' ),
        'menu_name'             => _x( 'Recipes', 'Admin Menu text', 'custom-plus' ),
        'name_admin_bar'        => _x( 'Recipe', 'Add New on Toolbar', 'custom-plus' ),
        'add_new'               => __( 'Add New', 'custom-plus' ),
        'add_new_item'          => __( 'Add New recipe', 'custom-plus' ),
        'new_item'              => __( 'New recipe', 'custom-plus' ),
        'edit_item'             => __( 'Edit recipe', 'custom-plus' ),
        'view_item'             => __( 'View recipe', 'custom-plus' ),
        'all_items'             => __( 'All recipes', 'custom-plus' ),
        'search_items'          => __( 'Search recipes', 'custom-plus' ),
        'parent_item_colon'     => __( 'Parent recipes:', 'custom-plus' ),
        'not_found'             => __( 'No recipes found.', 'custom-plus' ),
        'not_found_in_trash'    => __( 'No recipes found in Trash.', 'custom-plus' ),
        'featured_image'        => _x( 'Recipe Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'custom-plus' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'custom-plus' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'custom-plus' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'custom-plus' ),
        'archives'              => _x( 'Recipe archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'custom-plus' ),
        'insert_into_item'      => _x( 'Insert into recipe', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'custom-plus' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this recipe', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'custom-plus' ),
        'filter_items_list'     => _x( 'Filter recipes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'custom-plus' ),
        'items_list_navigation' => _x( 'Recipes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'custom-plus' ),
        'items_list'            => _x( 'Recipes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'custom-plus' ),
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Recipe custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'recipe' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'         => array( 'category', 'post_tag' ),
        'show_in_rest'       => true,
        'description'        => 'A custom post type for recipes.',
    );
     
    register_post_type( 'recipe', $args );

    register_taxonomy(
        'cuisine',
        'recipe',
        array(
            'labels' => array(
            'name'          => __( 'Cuisines', 'custom-plus' ),
            'singular_name' => __( 'Cuisine', 'custom-plus' ),
            'add_new_item'  => __( 'Add Cuisine', 'custom-plus' ),
            'new_item_name' => __( 'New Cuisine Name', 'custom-plus' ),
        ),
            'rewrite' => array( 'slug' => 'cuisine' ),
            'hierarchical' => true,
            'show_in_rest' => true,
        )
    );

    register_term_meta('cuisine', 'cuisine_more_info_url', array(
        'type' => 'string',
        'description' => 'A URL for more information about the cuisine.',
        'single' => true,
        'show_in_rest' => true,
        'default' => '#',
    ));

    register_post_meta('recipe', 'recipe_rating', array(
        'type' => 'number',
        'description' => 'Rating for the recipe.',
        'single' => true,
        'show_in_rest' => true,
        'default' => 0,
    ));
}