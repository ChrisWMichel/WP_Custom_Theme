<?php

function custom_plus_render_header_tools_cb( $attributes ) {
    $user = wp_get_current_user();
    $name = $user->exists() ? $user->display_name : 'Sign in';
    $openClass = $user->exists() ? '' : 'open-modal';
    $wrapper_attributes = get_block_wrapper_attributes(
        [
            'class' => 'wp-block-udemy-plus-header-tools',
        ]
    );

    ob_start();

    if($attributes['showAuthLink']) {
    ?>
        <div <?php echo $wrapper_attributes; ?>>
        <a class="signin-link <?php echo esc_attr( $openClass ); ?>" href="#signin-modal">
            <div class="signin-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="signin-text">
                <small>Hello, <?php echo esc_html( $name ); ?></small>
                My Account
            </div>
        </a>
    </div>
    <?php
    }
    
    
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
