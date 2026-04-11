<?php

function custom_plus_render_page_header_cb( $attributes ) {
    $wrapper_attributes = get_block_wrapper_attributes(
        [
            'class' => 'wp-block-udemy-plus-page-header',
        ]
    );

    $heading_text = ! empty( $attributes['content'] )
        ? esc_html( $attributes['content'] )
        : esc_html( get_the_archive_title() );

    if ( ! empty( $attributes['showCategory'] ) ) {
        $category_name = '';

        if ( is_category() ) {
            $category_name = single_cat_title( '', false );
        } elseif ( is_single() ) {
            $categories = get_the_category();

            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                $category_name = $categories[0]->name;
            }
        }

        if ( $category_name ) {
            $heading_text = sprintf( __( 'Category: %s', 'custom-plus' ), $category_name );
        }
    }

    ob_start();
    ?>
    <div class="wp-block-udemy-plus-page-header">
            <div class ="inner-page-header">
                <h1><?php echo wp_kses_post( $heading_text ); ?></h1>
                 
            </div>
        </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}