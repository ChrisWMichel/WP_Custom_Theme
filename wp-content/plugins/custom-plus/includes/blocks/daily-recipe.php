<?php

function custom_plus_render_daily_recipe_cb($atts){
        $title = esc_html( $atts['title'] );
        $id = get_transient( 'ct_daily_recipe' );

        if(!$id){
            $id = ct_generate_daily_recipe();
        }

    ob_start();
    ?>

    <div class="wp-block-custom-plus-daily-recipe">
         <?php
        if ( $title ) { ?>
            <h6><?php echo $title; ?></h6>
        <?php
        }
        if($id){
            ?>
            <a href="<?= get_permalink( $id ); ?>">
                <img src="<?= get_the_post_thumbnail_url( $id, 'full' ); ?>" />
                <h3><?= get_the_title( $id ); ?></h3>
            </a>
            <?php
        } else {
            echo __('No recipe found', 'custom-plus');
        }
        ?>
    </div>

    <?php

    return ob_get_clean();
}