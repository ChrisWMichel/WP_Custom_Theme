<?php

function custom_plus_render_header_tools_cb( $attributes ) {
    $user = wp_get_current_user();
    $is_logged_in = $user->exists();
    $name = $is_logged_in ? $user->display_name : 'Sign in';
    $openClass = $is_logged_in ? '' : 'open-modal';
    $auth_link = $is_logged_in ? wp_logout_url( home_url( '/' ) ) : '#signin-modal';
    $auth_label = $is_logged_in ? 'Log out' : 'My Account';
    $wrapper_attributes = get_block_wrapper_attributes(
        [
            'class' => 'wp-block-udemy-plus-header-tools',
        ]
    );

    ob_start();

    if($attributes['showAuthLink']) {
    ?>
        <div <?php echo $wrapper_attributes; ?>>
        <a class="signin-link <?php echo esc_attr( $openClass ); ?>" href="<?php echo esc_url( $auth_link ); ?>">
            <div class="signin-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="signin-text">
                <small>Hello, <?php echo esc_html( $name ); ?></small>
                <?php echo esc_html( $auth_label ); ?>
            </div>
        </a>
    </div>
    <?php
    }
    
    
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
