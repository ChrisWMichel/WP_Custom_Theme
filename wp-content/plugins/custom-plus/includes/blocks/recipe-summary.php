<?php

function custom_plus_render_recipe_summary_cb( $attributes, $content, $block ) {
        $prep_time = isset( $attributes['prepTime'] ) ? esc_html( $attributes['prepTime'] ) : '';
        $cook_time = isset( $attributes['cookTime'] ) ? esc_html( $attributes['cookTime'] ) : '';
        $course    = isset( $attributes['course'] ) ? esc_html( $attributes['course'] ) : '';

        $postID = $block->context['postId'] ?? null;
        $postTerms = get_the_terms( $postID, 'cuisine' );
        $postTerms = is_array( $postTerms ) ? array_values( $postTerms ) : [];
        $cuisines = '';
        $lastKey = array_key_last( $postTerms );

        foreach ( $postTerms as $key => $term ) {
                $url = get_term_meta( $term->term_id, 'cuisine_more_info_url', true );
                if ( $url ) {
                        $cuisines .= '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $term->name ) . '</a>';
                        if ( $key !== $lastKey ) {
                                $cuisines .= ', ';
                        }
                        continue;
                }
                $cuisines .= esc_html( $term->name );
                if ( $key !== $lastKey ) {
                        $cuisines .= ', ';
                }
        }

        $rating = get_post_meta( $postID, 'recipe_rating', true );
        $rating = $rating ? esc_html( $rating ) : '';

        global $wpdb;
        $user_id = get_current_user_id();
        $ratingCount = $wpdb->get_var(
                $wpdb->prepare(
                        "SELECT COUNT(*) FROM {$wpdb->prefix}recipe_ratings WHERE post_id = %d AND user_id = %d",
                        $postID, $user_id
                )
        );

        ob_start();
        ?>
        <div <?php echo get_block_wrapper_attributes(); ?>>
                <i class="bi bi-alarm"></i>
                <div class="recipe-columns-2">
                <div class="recipe-metadata">
                <div class="recipe-title">
                        <?php _e('Prep Time', 'udemy-plus'); ?>
                </div>
                <div class="recipe-data recipe-prep-time">
                        <?php echo $prep_time; ?>
                </div>
                </div>
                <div class="recipe-metadata">
                <div class="recipe-title">
                        <?php _e('Cook Time', 'udemy-plus'); ?>
                </div>
                <div class="recipe-data recipe-cook-time">
                        <?php echo $cook_time; ?>
                </div>
                </div>
                </div>
                <div class="recipe-columns-2-alt">
                <div class="recipe-columns-2">
                <div class="recipe-metadata">
                        <div class="recipe-title">
                        <?php _e('Course', 'udemy-plus'); ?>
                        </div>
                        <div class="recipe-data recipe-course">
                        <?php echo $course; ?>
                        </div>
                </div>
                <div class="recipe-metadata">
                        <div class="recipe-title">
                        <?php _e('Cuisine', 'udemy-plus'); ?>
                        </div>
                        <div class="recipe-data recipe-cuisine">
                        <?php echo $cuisines; ?>
                        </div>
                </div>
                <i class="bi bi-egg-fried"></i>
                </div>
                <div class="recipe-metadata">
                <div class="recipe-title">
                        <?php _e('Rating', 'udemy-plus'); ?>
                </div>
                <div class="recipe-data" id="recipe-rating"
                data-post-id="<?php echo esc_attr( $postID ); ?>"
                data-avg-rating="<?php echo esc_attr( $rating ); ?>"
                data-logged-in="<?php echo is_user_logged_in() ? '1' : '0'; ?>"
                data-rating-count="<?php echo esc_attr( $ratingCount ); ?>"
                >
                        <?php echo $rating; ?>
                </div>
                <i class="bi bi-hand-thumbs-up"></i>
                </div>
                </div>
                </div>
        <?php

        return ob_get_clean();
}