<?php

function custom_plus_render_header_tools_cb( $attributes ) {
    $wrapper_attributes = get_block_wrapper_attributes(
        [
            'class' => 'wp-block-udemy-plus-header-tools',
        ]
    );

    ob_start();

    if($attributes['showAuthLink']) {
    ?>
        <div <?php echo $wrapper_attributes; ?>>
        <a class="signin-link open-modal" href="#" style="display:flex;align-items:center;text-decoration:none;">
            <div class="signin-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="signin-text" style="padding-left:.25rem;white-space:nowrap;">
                <small style="display:block;">Hello, Sign in</small>
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
