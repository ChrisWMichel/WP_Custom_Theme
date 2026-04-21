<?php

function custom_plus_render_popular_recipes_cb( $attributes ) {
    $title = esc_html( $attributes['title'] );
    $cuisineIDs = array_map(function($term) {
        return $term['id'];
    }, $attributes['cuisines'] ?? []);

     $args = [
        'post_type' => 'recipe',
        'posts_per_page' => $attributes['count'] ?? 5,
        'meta_key' => 'recipe_rating',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    ];

    if ( ! empty( $cuisineIDs ) ) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'cuisine',
                'field'    => 'term_id',
                'terms'    => $cuisineIDs,
            ],
        ];
    }

    $query = new WP_Query( $args );

    ob_start();
    ?>
    <div class="popular-recipes-block">
        <?php if ( $title ) { ?>
            <h6 class="popular-recipes-title"><?php echo $title; ?></h6>
        <?php
        }
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $authorName = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) );
                ?>
                <div class="single-post">
                    <?php if ( has_post_thumbnail() ) { ?>
                        <!-- <div class="single-post-thumbnail"> -->
                            <a class="single-post-image" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                            </a>
                        <!-- </div> -->
                    <?php } ?>
                    <div class="single-post-detail">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <span>
                            by <a href="<?php echo get_author_posts_url( get_post_field( 'post_author', get_the_ID() ) ); ?>"><?php echo esc_html( $authorName ); ?></a>
                        </span>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        }
        ?>
    </div>

    <?php

    return ob_get_clean();
}
