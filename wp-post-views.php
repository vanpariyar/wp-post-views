<?php
/**
 * Plugin Name
 *
 * @package           WP Post Views
 * @author            Ronak J Vanpariya
 * @copyright         Ronak J Vanpariya
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       WP Post Views - Wordpress Post views counter
 * Plugin URI:        https://github.com/vanpariyar/wp-post-views
 * Description:       WP Post Views - Wordpress Post views counter
 * Version:           1.22
 * Requires at least: 5.4
 * Requires PHP:      7.4
 * Author URI:        https://vanpariyar.github.io
 * Text Domain:       wp-post-views
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Make sure we don't expose any info if called directly.
if ( ! function_exists( 'add_action' ) ) {
	echo esc_html__( 'Hi there!  I\'m just a plugin, not much I can do when called directly.', 'wp-post-views' );
	exit;
}

/* Plugin Constants */
if ( ! defined( 'WP_POST_VIEW_URL' ) ) {
	define( 'WP_POST_VIEW_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WP_POST_VIEW_PLUGIN_PATH' ) ) {
	define( 'WP_POST_VIEW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

require_once WP_POST_VIEW_PLUGIN_PATH . '/includes/settings.php';

require_once WP_POST_VIEW_PLUGIN_PATH . '/includes/shortcodes.php';

require_once WP_POST_VIEW_PLUGIN_PATH . '/includes/counter.php';

register_activation_hook( __FILE__, array( 'Wp_post_view_settings', 'wppv_activation_hook' ) );

/**
 * MAIN CLASS
 */
class WP_Post_Views {

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function __construct() {
		$WP_Post_Views_Counter_Functions = new WP_Post_Views_Counter_Functions();
		Wp_post_view_settings::settings_init();
	}
}

global $wppv_plugin;

$wppv_plugin = new WP_Post_Views();
