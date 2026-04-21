<?php

function ct_generate_daily_recipe(){
    global $wpdb;
    $id = $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type = 'recipe' ORDER BY RAND() LIMIT 1" );

    set_transient( 'ct_daily_recipe', $id, DAY_IN_SECONDS );
    return $id;
}