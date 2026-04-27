<?php
/**
 * Plugin Name:       Alert Box
 * Description:       Adds an alert box to output information or warnings to the user.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            Chris Michel
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       alert-box
 *
 * @package AlertBox
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
 * based on the registered block metadata. Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function create_block_alert_box_block_init() {
	wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
}
add_action( 'init', 'create_block_alert_box_block_init' );

function alert_box_register_assets() {
	wp_register_style(
		'alert-box-admin-styles',
		plugins_url( '/build/admin/index.css', __FILE__ ),
		[],
		'1.0.0'
	);
	wp_register_script(
		'alert-box-admin-scripts',
		plugins_url( '/build/admin/index.js', __FILE__ ),
		[],
		'1.0.0',
		true
	);
}
add_action( 'init', 'alert_box_register_assets' );
