<?php

/*
Plugin Name: Custom Plus emailer
Description: A custom plugin for handling email subscriptions and recipe ratings.
Version: 1.0
Author: Chris Michel
*/

add_action( 'recipe_rated', function($data){
    // Handle the recipe rated event, e.g., send an email notification
    $post_id = $data['post_id'];
    $user_id = $data['user_id'];
    $rating = $data['rating'];
    $avg_rating = $data['avg_rating'];

    // Example: send an email notification
    $user_info = get_userdata($user_id);
    $to = $user_info->user_email;
    $subject = 'Thank you for rating!';
    $message = "You rated the recipe with ID $post_id a $rating star rating. The new average rating is $avg_rating.";
    wp_mail($to, $subject, $message);
} );