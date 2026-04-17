<?php

function custom_plus_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, [
        'teamMember' => __('Team Member', 'custom-plus')
    ]);
}