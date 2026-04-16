<?php

function ct_rest_api_add_rating_handler($request) {
    $response = ['status' => 1];
    $params = $request->get_json_params();

    if (!isset($params['post_id'], $params['rating']) || empty($params['post_id']) || empty($params['rating'])) {
        $response['message'] = 'Post ID and rating are required.';
        return new WP_REST_Response($response, 400);
    }

    $post_id = intval($params['post_id']);
    $rating = round(floatval($params['rating']), 1);
    $user_id = get_current_user_id();

    if ($rating < 1 || $rating > 5) {
        $response['message'] = 'Rating must be between 1 and 5.';
        return new WP_REST_Response($response, 400);
    }

    global $wpdb;
    $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}recipe_ratings WHERE post_id = %d AND user_id = %d",
            $post_id, $user_id
        )
    );
    if( $wpdb->num_rows > 0 ) {
        $wpdb->update(
            "{$wpdb->prefix}recipe_ratings",
            ['rating' => $rating],
            ['post_id' => $post_id, 'user_id' => $user_id],
            ['%f'],
            ['%d', '%d']
        );
    } else {
        $wpdb->insert(
            "{$wpdb->prefix}recipe_ratings",
            ['post_id' => $post_id, 'user_id' => $user_id, 'rating' => $rating],
            ['%d', '%d', '%f']
        );
    }

    $avgRating = round($wpdb->get_var(
        $wpdb->prepare(
            "SELECT AVG(`rating`) FROM {$wpdb->prefix}recipe_ratings WHERE post_id = %d",
            $post_id
        )
    ), 1);

    // Save the rating as post meta
    update_post_meta($post_id, 'recipe_rating', $avgRating);

    do_action('recipe_rated', [
        'post_id' => $post_id,
        'user_id' => $user_id,
        'rating' => $rating,
        'avg_rating' => $avgRating,
    ]);

    return new WP_REST_Response(['message' => 'Rating added successfully.', 'status' => 2, 'rating' => $avgRating], 200);
}