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
 * Plugin Name:       WP Post Views
 * Plugin URI:        https://github.com/vanpariyar/wp-post-views
 * Description:       WP Post Views.
 * Version:           1.11
 * Requires at least: 5.0
 * Requires PHP:      5.3
 * Author:            Ronak J Vanpariya
 * Author URI:        https://vanpariyar.github.io
 * Text Domain:       wppv
 * Domain Path: 	  /languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo __('Hi there!  I\'m just a plugin, not much I can do when called directly.', 'wppv');
	exit;
}

/* Plugin Constants */
if (!defined('WP_POST_VIEW_URL')) {
	define('WP_POST_VIEW_URL', plugin_dir_url(__FILE__));
}

if (!defined('WP_POST_VIEW_PLUGIN_PATH')) {
	define('WP_POST_VIEW_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

require_once (WP_POST_VIEW_PLUGIN_PATH . '/includes/settings.php');

require_once (WP_POST_VIEW_PLUGIN_PATH . '/includes/shortcodes.php');

register_activation_hook( __FILE__, array('Wp_post_view_settings','wppv_activation_hook') );

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
		
		$this->options = get_option( 'wppv_api_settings' );
		$this->meta_key         = 'entry_views';
		$this->total_views_transient_key = 'wppv_post_total_views'; 
		$this->total_views_transient_expiration = 1 * MINUTE_IN_SECONDS;

		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'wp_head', array( $this, 'counter' ), 10, 1 );
		add_filter( 'manage_posts_columns', array( $this, 'wppv_posts_column_views' ) );
		add_filter( 'manage_pages_columns', array( $this, 'wppv_posts_column_views' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'wppv_posts_custom_column_views' ) );
		add_action( 'manage_pages_custom_column', array( $this, 'wppv_posts_custom_column_views' ) );
		Wp_post_view_settings::settings_init();
	}

	function load_textdomain() {
		load_plugin_textdomain( 'wppv', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public function wppv_posts_column_views( $columns ) {

		if ( ! empty( $this->options['wppv_api_text_field_0'] ) ) {
			$columns['post_views'] = 'Views';
		}
		return $columns;
	}

	public function wppv_posts_custom_column_views( $column ) {
		$this->options = get_option( 'wppv_api_settings' );
		if ( !empty($this->options['wppv_api_text_field_0']) ) {
			if ( $column === 'post_views') {
				$view_post_meta = get_post_meta(get_the_ID(), 'entry_views', true);
				echo $view_post_meta;
			}
		}
		
	}

	public function get_ip_address() 
	{
		// check for shared internet/ISP IP
		if (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		// check for IPs passing through proxies
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// check if multiple ips exist in var
			$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($iplist as $ip) {
				if ($this->validate_ip($ip))
					return $ip;
			}
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_X_FORWARDED']))
			return $_SERVER['HTTP_X_FORWARDED'];
		if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];
		if (!empty($_SERVER['HTTP_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_FORWARDED']))
			return $_SERVER['HTTP_FORWARDED'];
		// return unreliable ip since all else failed
		return $_SERVER['REMOTE_ADDR'];
	}

	public function validate_ip($ip) {
		if (
			filter_var( $ip,
				FILTER_VALIDATE_IP,
				FILTER_FLAG_IPV4 |
				FILTER_FLAG_IPV6 |
				FILTER_FLAG_NO_PRIV_RANGE |
				FILTER_FLAG_NO_RES_RANGE
			) === false
		) {
			return false;
		}
		return true;
	}

	public function counter(){
		global $post;
		$stored_ip_addresses = 0;
		$selected_type = array();
		isset($this->options['wppv_api_post_checkbox_1']) ? $selected_type = $this->options['wppv_api_post_checkbox_1'] : '';
		
		if( is_object($post) && in_array($post->post_type , $selected_type)){
			if ( !empty($this->options['wppv_api_text_field_1']) ) {
				$stored_ip_addresses = get_post_meta(get_the_ID(),'view_ip',true);

				$current_ip = $this->get_ip_address();							
				if( $stored_ip_addresses )
				{							
					if(!in_array($current_ip, $stored_ip_addresses))
					{
						$view_post_meta   = get_post_meta(get_the_ID(), $this->meta_key, true);
						$new_viewed_count = intval($view_post_meta) + 1;
						update_post_meta(get_the_ID(), $this->meta_key, $new_viewed_count);
						$stored_ip_addresses[] = $current_ip;
						update_post_meta(get_the_ID(),'view_ip',$stored_ip_addresses);
					}
				} else {
					$stored_ip_addresses = array();
					$view_post_meta   = get_post_meta(get_the_ID(), $this->meta_key, true);
					$new_viewed_count = intval($view_post_meta) + 1;
					update_post_meta(get_the_ID(), $this->meta_key, $new_viewed_count);
					$stored_ip_addresses[] = $current_ip;
					update_post_meta(get_the_ID(),'view_ip',$stored_ip_addresses);
				}
			} else {
				$view_post_meta   = get_post_meta(get_the_ID(), $this->meta_key, true);
				$new_viewed_count = intval($view_post_meta) + 1;
				update_post_meta(get_the_ID(), $this->meta_key, $new_viewed_count);
			}
		}

	}

	private function count_total_view( $post_type = 'post' ) {
		$total = 0;

		if( $total = get_transient( $this->total_views_transient_key.$post_type ) ) {
			return $total;
		}

		$arguments = array(
			'post_type' => $post_type,
			'posts_per_page' => '-1',
			'status' => 'publish',
		);
		$total_count_query = new WP_Query( $arguments );

		if( $total_count_query->have_posts() ){
			while( $total_count_query->have_posts() ) {
				$total_count_query->the_post();
				$view_post_meta   = get_post_meta(get_the_ID(), $this->meta_key, true);
				$total += $view_post_meta;
			}
		}
		set_transient( $this->total_views_transient_key.$post_type, $total, $this->total_views_transient_expiration );

		return $total;
	}

	public function get_total_views( $post_type = 'post' ) {
		return $this->count_total_view($post_type);
	}

}

global $wp_post_views;

$wp_post_views = new WP_Post_Views();
