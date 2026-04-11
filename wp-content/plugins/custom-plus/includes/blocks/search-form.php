<?php

function custom_plus_render_search_form_cb( $attributes ) {
    $attributes = wp_parse_args(
        $attributes,
        [
            'bgColor'         => '#f87171',
            'textColor'       => '#ffffff',
            'buttonText'      => __( 'Search', 'custom-plus' ),
            'buttonBgColor'   => '#f87171',
            'buttonTextColor' => '#ffffff',
        ]
    );

    $wrapper_styles = sprintf(
        'background-color:%1$s;color:%2$s;',
        esc_attr( $attributes['bgColor'] ),
        esc_attr( $attributes['textColor'] )
    );

    $button_styles = sprintf(
        'background-color:%1$s;color:%2$s;',
        esc_attr( $attributes['buttonBgColor'] ),
        esc_attr( $attributes['buttonTextColor'] )
    );

    $wrapper_attributes = get_block_wrapper_attributes(
        [
            'class' => 'wp-block-udemy-plus-search-form',
            'style' => $wrapper_styles,
        ]
    );

    $search_query = get_search_query();
    // $heading_text = $search_query
    //     ? sprintf( __( 'Search: %s', 'custom-plus' ), $search_query )
    //     : __( 'Search: Your search term here', 'custom-plus' );

    ob_start();
    ?>
    <div <?php echo $wrapper_attributes; ?>>
        <h1>
            <?php esc_html_e('Search', 'custom-plus') ?>: 
            <?php the_search_query(); ?>
        </h1>
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'custom-plus' ); ?>" value="<?php echo esc_attr( the_search_query() ); ?>" name="s" />
            <div class="btn-wrapper">
                <button type="submit" style="<?php echo esc_attr( $button_styles ); ?>"><?php echo esc_html( $attributes['buttonText'] ); ?></button>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}