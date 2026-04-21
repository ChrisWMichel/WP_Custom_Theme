<?php

function custom_plus_modify_rest_recipe_query( $args, $request ) {
    // Check if the request is for the 'recipe' post type
    
        $orderBy = $request->get_param('orderByRating');
        if ( isset($orderBy )) {
        $args['orderBy'] = ['meta_value_num' => 'DESC'];
        $args['meta_key'] = 'recipe_rating';
    }

    return $args;
}