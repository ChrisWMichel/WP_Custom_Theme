<?php

function custom_plus_add_cuisine_field() {
    ?>
    <div class="form-field">
        <label for="cuisine_more_info_url"><?php _e( 'More Info URL', 'custom-plus' ); ?></label>
        <input type="text" name="cuisine_more_info_url" id="cuisine_more_info_url" value="" class="cuisine-more-info-field" />
        <p class="description"><?php _e( 'Enter a URL for more information about this cuisine.', 'custom-plus' ); ?></p>

    </div>
    <?php
}

function custom_plus_edit_cuisine_field( $term, $taxonomy = '' ) {
    $more_info_url = get_term_meta( $term->term_id, 'cuisine_more_info_url', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="cuisine_more_info_url"><?php _e( 'More Info URL', 'custom-plus' ); ?></label></th>
        <td>
            <input type="text" name="cuisine_more_info_url" id="cuisine_more_info_url" value="<?php echo esc_attr( $more_info_url ); ?>" class="cuisine-more-info-field" />
            <p class="description"><?php _e( 'Enter a URL for more information about this cuisine.', 'custom-plus' ); ?></p>
        </td>
    </tr>
    <?php
}

