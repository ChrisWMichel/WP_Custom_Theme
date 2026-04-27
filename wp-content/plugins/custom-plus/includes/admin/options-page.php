<?php

function custom_plus_plugin_options_page() {
    $options = get_option('cp_plugin_options');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Custom Plus Settings', 'custom-plus' ); ?></h1>
            <?php if (isset($_GET['status']) && $_GET['status'] == 1) : ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e('Settings saved successfully.', 'custom-plus'); ?></p>
                </div>
            <?php endif; ?>

        <form novalidate="novalidate" method="post" action="admin-post.php">
            <input type="hidden" name="action" value="save_cp_plugin_options">
            <?php wp_nonce_field('cp_options_verify', 'cp_plugin_options_nonce'); ?>
        <table class="form-table">
            <tbody>
            <!-- Open Graph Title -->
            <tr>
                <th>
                <label for="cp_og_title">
                    <?php esc_html_e('Open Graph Title', 'custom-plus'); ?>
                </label>
                </th>
                <td>
                <input name="cp_og_title" type="text" id="cp_og_title"
                    class="regular-text" value="<?php echo esc_attr($options['og_title'] ?? ''); ?>" />
                </td>
            </tr>
            <!-- Open Graph Image -->
            <tr>
                <th>
                <label for="cp_og_image">
                    <?php esc_html_e('Open Graph Image', 'custom-plus'); ?>
                </label>
                </th>
                <td>
                <input type="hidden" name="cp_og_image" id="cp_og_image" value="<?php echo esc_attr($options['og_image'] ?? ''); ?>" />
                <img id="og-img-preview" src="<?php echo esc_url($options['og_image'] ?? ''); ?>" >
                <a href="#" class="button-primary" id="og-img-btn">
                    Select Image
                </a>
                </td>
            </tr>
            <!-- Open Graph Description -->
            <tr>
                <th>
                <label for="cp_og_description">
                    <?php esc_html_e('Open Graph Description', 'custom-plus'); ?>
                </label>
                </th>
                <td>
                <textarea 
                    id="cp_og_description" 
                    name="cp_og_description"
                    class="large-text"
                ><?php echo esc_textarea($options['og_description'] ?? ''); ?></textarea>
                </td>
            </tr>
            <!-- Enable Open Graph -->
            <tr>
                <th>
                <?php esc_html_e('Open Graph', 'custom-plus'); ?>
                </th>
                <td>
                <label for="cp_enable_og"> 
                <input name="cp_enable_og" type="checkbox" id="cp_enable_og" 
                    value="1" <?php checked($options['enable_og'] ?? 0, 1); ?> /> 
                <span>Enable</span>
                </label>
                </td>
            </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
        </form>
    </div>
    <?php
}