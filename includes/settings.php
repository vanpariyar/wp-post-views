<?php 
/**
 * Settings Helper Class
 */

class Wp_post_view_settings{
	public static function settings_init(){

		add_action( 'admin_menu', array( 'Wp_post_view_settings','wppv_api_add_admin_menu' ) );

		add_action( 'admin_init', array( 'Wp_post_view_settings','wppv_api_settings_init' ) );

		add_action('admin_enqueue_scripts', array( 'Wp_post_view_settings','admin_enqueue_script_callback'));
		add_action('enqueue_block_editor_assets', array( 'Wp_post_view_settings','enqueue_block_editor_assets_callback') );
		add_action( 'admin_init', array( 'Wp_post_view_settings','register_my_setting') );
		add_action( 'rest_api_init', array( 'Wp_post_view_settings','register_my_setting') );

		// add_action( 'plugin_action_links_' . WP_POST_VIEW_PLUGIN_BASE, array( 'Wp_post_view_settings', 'plugin_settings_link', 10 ) );

	}
	public static function wppv_activation_hook(){
		if(empty(get_option( 'wppv_api_settings' ))){
			$options = array(
				'wppv_api_text_field_0' => '1' ,
				'wppv_api_text_field_1' => '0', 
				'wppv_api_post_checkbox_1'=> array(
					'post' => 'post',
					'page' => 'page'
				),
			);
			update_option( 'wppv_api_settings' , $options , 'yes');
		}
	}

	public static function wppv_api_add_admin_menu(  ) {
		add_options_page( 'Wp Post Views Settings', __('Wp Post Views Settings', 'wppv'), 'manage_options', 'settings-api-page', array( 'Wp_post_view_settings','wppv_api_options_page' ) );
	}

	public static function wppv_api_settings_init(  ) {
		register_setting( 'wppvPlugin', 'wppv_api_settings' );
		add_settings_section(
			'wppv_api_wppvPlugin_section',
			__( 'Settings for WP Post Views', 'wppv' ),array( 'Wp_post_view_settings','wppv_api_settings_section_callback'),
			'wppvPlugin'
		);

		add_settings_field(
			'wppv_api_text_field_0',
			__( 'Show post views coloumn', 'wppv' ),array( 'Wp_post_view_settings','wppv_show_views_callback'),
			'wppvPlugin',
			'wppv_api_wppvPlugin_section'
		);
		add_settings_field(
			'wppv_api_text_field_1',
			__( 'Views filter on IP (If checked multiple views will not count From same IP)', 'wppv' ),array( 'Wp_post_view_settings','filter_on_ip_callback'),
			'wppvPlugin',
			'wppv_api_wppvPlugin_section'
		);
		add_settings_field(
			'wppv_api_post_checkbox_1',
			__( 'Select your custom post type', 'wppv' ),array( 'Wp_post_view_settings','select_post_type_callback'),
			'wppvPlugin',
			'wppv_api_wppvPlugin_section'
		);
	}

	public static function wppv_show_views_callback(  ) {
		$options = get_option( 'wppv_api_settings' );
		$checkbox_val = empty($options['wppv_api_text_field_0']) ? '' : $options['wppv_api_text_field_0'] ;
		?>
		<input type='checkbox' name='wppv_api_settings[wppv_api_text_field_0]' value="1" <?php checked( 1, $checkbox_val, true ); ?>>
		<?php
	}

	public static function filter_on_ip_callback(  ) {
		$options = get_option( 'wppv_api_settings' );
		$checkbox_val = empty($options['wppv_api_text_field_1']) ? '' : $options['wppv_api_text_field_1'] ;
		?>
		<input type='checkbox' name='wppv_api_settings[wppv_api_text_field_1]' value="1" <?php checked( 1, $checkbox_val, true ); ?>>
		<?php
	}

	public static function select_post_type_callback(  ) {
		$options = get_option( 'wppv_api_settings' );
		$checkbox_val = empty($options['wppv_api_post_checkbox_1']) ? '' : $options['wppv_api_post_checkbox_1'] ;
		$args = [
			'public' => true,
			'_builtin' => false,
		];
		$post_types = get_post_types( $args, 'objects' );
		/* BUILT IN POST TYPE PAGE AND POST OPTION */
		?>
		<label for="">Posts </label>
		<input type='checkbox' name='wppv_api_settings[wppv_api_post_checkbox_1][post]' value="post" <?php checked( ( isset($checkbox_val['post']) && 'post' == @$checkbox_val['post']), true ); ?>>
		<label for="">Pages </label><input type='checkbox' name='wppv_api_settings[wppv_api_post_checkbox_1][page]' value="page" <?php checked( (  isset($checkbox_val['page']) && 'page' == @$checkbox_val['page']), true ); ?>>
		<?php
		foreach($post_types as $post_type){ 
			?>
			<label for=""><?php echo esc_html( $post_type->label );?> </label>
			<input type="checkbox" name="wppv_api_settings[wppv_api_post_checkbox_1][<?php echo esc_attr( $post_type->name ); ?>]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( ( isset($checkbox_val[$post_type->name]) && $post_type->name == @$checkbox_val[$post_type->name] ), true ); ?>>
			<?php
		}
	}

	public static function wppv_api_settings_section_callback(  ) {
		echo esc_html__( 'This will show one extra coloumn in Post listing page which is show the counts', 'wppv' );
	}

	public static function wppv_api_options_page(  ) {
		echo '<div id="wppv-admin-page"></div>';
	}

	/**
	 * Enqueue our script on the settings page,
	 */

	public static function admin_enqueue_script_callback( $suffix ) {
		$asset_file_page = WP_POST_VIEW_PLUGIN_PATH . 'build/admin.asset.php';
		if ( file_exists( $asset_file_page ) && 'settings_page_settings-api-page' === $suffix ) {
			$assets = require_once $asset_file_page;
			foreach ( $assets['dependencies'] as $style ) {
				wp_enqueue_script( $style );
			}
			foreach ( $assets['dependencies'] as $style ) {
				wp_enqueue_style( $style );
			}
			wp_enqueue_script(
				'pre-publish-settings-script',
				WP_POST_VIEW_URL . 'build/admin.js',
				array(),
				$assets['version'],
				true
			);
		}
	}

	// Enqueue the plugin.

	public static function enqueue_block_editor_assets_callback() {
		$asset_file_path = WP_POST_VIEW_PLUGIN_PATH . 'build/plugin.asset.php';
		if ( file_exists( $asset_file_path ) ) {
			$assets = require_once $asset_file_path;
			wp_enqueue_script(
				'pre-publish-plugin-script',
				WP_POST_VIEW_URL . 'build/plugin.js',
				array(),
				$assets['version'],
				true
			);
		}
	}

	/**
	 * Register some settings.
	 */
	public static function register_my_setting() {
		register_setting(
			'pre-publish-checklist',
			'pre-publish-checklist_data',
			array(
				'type'         => 'object',
				'default'      => array(
					'wordcount'             => 500,
					'requiredFeaturedImage' => false,
					'requiredCategory'      => true,
				),
				'show_in_rest' => array(
					'schema' => array(
						'type'       => 'object',
						'properties' => array(
							'wordCount'             => array(
								'type' => 'integer',
							),
							'requiredFeaturedImage' => array(
								'type' => 'boolean',
							),
							'requiredCategory'      => array(
								'type' => 'boolean',
							),
						),
					),
				),
			)
		);
	}

	public static function plugin_settings_link( $links ) : array {
		// $label = esc_html__( 'Settings', 'wholesome-plugin' );
		// $slug  = 'wholesome_plugin_settings';
	
		// array_unshift( $links, "$label" );
	
		return $links;
	
	}
	

}
?>
