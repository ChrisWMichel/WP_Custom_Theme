<?php

function custom_plus_save_cuisine_field( $term_id ) {
    if ( isset( $_POST['cuisine_more_info_url'] ) ) {
        update_term_meta( $term_id, 'cuisine_more_info_url', esc_url_raw( wp_unslash( $_POST['cuisine_more_info_url'] ) ) );
    }
}