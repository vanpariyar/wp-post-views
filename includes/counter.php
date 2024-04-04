<?php
/**
 * Counter Functions.
 */

class WP_Post_Views_Counter_Functions {
    public $options;
	public $meta_key;
	public $total_views_transient_key;
	public $total_views_transient_expiration;

    public function __construct()
    {
        $this->load();
    }
	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function load() {
		
		$this->options = get_option( 'wppv_api_settings' );
		$this->meta_key         = 'entry_views';
		$this->total_views_transient_key = 'wppv_post_total_views'; 
		$this->total_views_transient_expiration = 1 * MINUTE_IN_SECONDS;

        // add_action( 'wp_head', array( $this, 'counter' ), 10, 1 );
		add_filter( 'manage_posts_columns', array( $this, 'wppv_posts_column_views' ) );
		add_filter( 'manage_pages_columns', array( $this, 'wppv_posts_column_views' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'wppv_posts_custom_column_views' ) );
		add_action( 'manage_pages_custom_column', array( $this, 'wppv_posts_custom_column_views' ) );
        add_action( "wp_ajax_wppv_counter", array( $this, 'ajax_functions' ) );
        add_action( "wp_ajax_nopriv_wppv_counter", array( $this, 'ajax_functions' ) );
        add_action( "wp_enqueue_scripts", array( $this, 'register_scripts') );
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
				echo esc_html( $view_post_meta );
			}
		}
		
	}

	public function get_ip_address()
	{
		// Check for shared internet/ISP IP
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$client_ip = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
			if (!empty($client_ip) && $this->validate_ip($client_ip)) {
				return $client_ip;
			}
		}

		// Sanitize HTTP_X_FORWARDED_FOR variable
		$x_forwarded_for = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS);
		if ($x_forwarded_for !== null) {
			$iplist = explode(',', $x_forwarded_for);
			foreach ($iplist as $ip) {
				$ip = trim($ip); // Remove any leading/trailing spaces
				if ($this->validate_ip($ip))
					return $ip;
			}
		}

		// Check for IPs passing through proxies
		$proxy_vars = array(
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED'
		);

		foreach ($proxy_vars as $var) {
			if (!empty($_SERVER[$var])) {
				$ip = filter_var($_SERVER[$var], FILTER_VALIDATE_IP);
				if ($ip !== false && $this->validate_ip($ip))
					return $ip;
			}
		}

		// Sanitize and validate REMOTE_ADDR variable
		if (isset($_SERVER['REMOTE_ADDR'])) {
			$remote_addr = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
			if ($remote_addr !== false && $this->validate_ip($remote_addr)) {
				return $remote_addr;
			}
		}

		// Return unreliable IP since all else failed
		return '';
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

	public function counter( $post_id ){
		$post = get_post($post_id);
		$stored_ip_addresses = 0;
		$selected_type = array();
		isset($this->options['wppv_api_post_checkbox_1']) ? $selected_type = $this->options['wppv_api_post_checkbox_1'] : '';
		
		if( is_object($post) && in_array($post->post_type , $selected_type)){
			if ( !empty($this->options['wppv_api_text_field_1']) ) {
				$stored_ip_addresses = get_post_meta($post->ID,'view_ip',true);

				$current_ip = $this->get_ip_address();							
				if( $stored_ip_addresses )
				{
					if(!in_array($current_ip, $stored_ip_addresses))
					{
						$view_post_meta   = get_post_meta($post->ID, $this->meta_key, true);
						$new_viewed_count = intval($view_post_meta) + 1;
						update_post_meta($post->ID, $this->meta_key, $new_viewed_count);
						$stored_ip_addresses[] = $current_ip;
						update_post_meta($post->ID,'view_ip',$stored_ip_addresses);
					}
				} else {
					$stored_ip_addresses = array();
					$view_post_meta   = get_post_meta($post->ID, $this->meta_key, true);
					$new_viewed_count = intval($view_post_meta) + 1;
					update_post_meta($post->ID, $this->meta_key, $new_viewed_count);
					$stored_ip_addresses[] = $current_ip;
					update_post_meta($post->ID,'view_ip',$stored_ip_addresses);
				}
			} else {
				$view_post_meta   = get_post_meta($post->ID, $this->meta_key, true);
				$new_viewed_count = intval($view_post_meta) + 1;
				update_post_meta($post->ID, $this->meta_key, $new_viewed_count);
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

    public function register_scripts(){
        wp_register_script(
            'wp-posts-view-script',
            WP_POST_VIEW_URL.'/assets/js/ajax.js',
            array(),
            '1.1',
            true
        );
        wp_enqueue_script('wp-posts-view-script');

		$localised_array = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('wp-post-view-nonce'),
		);

		if( get_the_ID() && in_array( get_post_type( get_the_ID() ), get_post_types() )){
			$localised_array['post_id'] = get_the_ID();
		}

        wp_localize_script(
            'wp-posts-view-script',
            'wp_post_views_ajax_object',
            $localised_array,
        );
    }

    public function ajax_functions(){

        $post_id = intval(( $_POST['post_id'] ));
		
		if ( ! wp_verify_nonce( $_POST['nonce'], 'wp-post-view-nonce' ) ) {
        	wp_send_json_success('1');
		}
		$this->counter($post_id);
        wp_send_json_success('1');
        // wp_die(); // ajax call must die to avoid trailing 0 in your response
    }
}