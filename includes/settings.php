<?php 
/**
 * Settings Helper Class
 */	

class Wp_post_view_settings
{
	public static function settings_init(){
		// add_action( 'admin_menu', array( 'Wp_post_view_settings', 'settings_options' ) );
		// add_action( 'admin_init', array( 'Wp_post_view_settings', 'settings_init_call' ) );

	add_action( 'admin_menu', array( 'Wp_post_view_settings','wppv_api_add_admin_menu' ) );

	add_action( 'admin_init', array( 'Wp_post_view_settings','wppv_api_settings_init' ) );

	}
	public static function wppv_activation_hook(){
		if(empty(get_option( 'wppv_api_settings' ))){
			$options = array(
				'wppv_api_text_field_0' => '1' ,
				'wppv_api_text_field_1' => '1', 
				'wppv_api_post_checkbox_1'=> array(
					'post' => 'post',
					'page' => 'page'
				),
			);
			update_option( 'wppv_api_settings' , $options , 'yes');
		}
	}

	public static function wppv_api_add_admin_menu(  ) {
	    add_options_page( 'Wp Post Views Settings', 'Wp Post Views Settings', 'manage_options', 'settings-api-page', array( 'Wp_post_view_settings','wppv_api_options_page' ) );
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
		<input type='checkbox' name='wppv_api_settings[wppv_api_post_checkbox_1][post]' value="post" <?php checked( (  'post' == @$checkbox_val['post']), true ); ?>>
		<label for="">Pages </label><input type='checkbox' name='wppv_api_settings[wppv_api_post_checkbox_1][page]' value="page" <?php checked( (  'page' == @$checkbox_val['page']), true ); ?>>
		<?php
		foreach($post_types as $post_type){ 
			?>
			<label for=""><?php echo $post_type->label;?> </label>
			<input type='checkbox' name='wppv_api_settings[wppv_api_post_checkbox_1][<?php echo $post_type->name ?>]' value="<?php echo $post_type->name ?>" <?php checked( (  $post_type->name == @$checkbox_val[$post_type->name]), true ); ?>>
			<?php
		}
	}

	public static function wppv_api_settings_section_callback(  ) {
	    echo __( 'This will show one extra coloumn in Post listing page which is show the counts', 'wppv' );
	}

	public static function wppv_api_options_page(  ) {
	    ?>
	    <form action='options.php' method='post'>
	        <h2>Wp post View All Settings Admin Page</h2>
	        <?php
	        settings_fields( 'wppvPlugin' );
	        do_settings_sections( 'wppvPlugin' );
	        submit_button();
	        ?>
	    </form>
	    <?php
	}
}
 ?>