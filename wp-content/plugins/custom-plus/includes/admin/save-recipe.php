<?php

function custom_plus_save_post_recipe_meta( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $rating = get_post_meta( $post_id, 'recipe_rating', true );
    $rating = empty( $rating ) ? 0 : floatval( $rating );

    update_post_meta( $post_id, 'recipe_rating', $rating );

    if ( isset( $_POST['prep_time'] ) ) {
        update_post_meta( $post_id, 'prep_time', sanitize_text_field( wp_unslash( $_POST['prep_time'] ) ) );
    }

    if ( isset( $_POST['cook_time'] ) ) {
        update_post_meta( $post_id, 'cook_time', sanitize_text_field( wp_unslash( $_POST['cook_time'] ) ) );
    }

    if ( isset( $_POST['course'] ) ) {
        update_post_meta( $post_id, 'course', sanitize_text_field( wp_unslash( $_POST['course'] ) ) );
    }
}