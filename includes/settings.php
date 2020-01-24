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
	
	add_filter( 'manage_posts_columns', array( 'Wp_post_view_settings','wppv_posts_column_views') );

	add_action( 'manage_posts_custom_column', array( 'Wp_post_view_settings','wppv_posts_custom_column_views') );

	}

	public static function wppv_posts_column_views( $columns ) {

		$options = get_option( 'wppv_api_settings' );
		//$options['wppv_api_text_field_0'];
		if ( !empty($options['wppv_api_text_field_0']) ) {	
			$columns['post_views'] = 'Views';
		}
	    return $columns;
	}

	public static function wppv_posts_custom_column_views( $column ) {
		$options = get_option( 'wppv_api_settings' );
		if ( !empty($options['wppv_api_text_field_0']) ) {
			if ( $column === 'post_views') {
			$view_post_meta = get_post_meta(get_the_ID(), 'entry_views', true);
			echo $view_post_meta;
	    	}
		}
	    
	}


	public static function wppv_api_add_admin_menu(  ) {
	    add_options_page( 'Wp Post Views Settings', 'Wp Post Views Settings', 'manage_options', 'settings-api-page', array( 'Wp_post_view_settings','wppv_api_options_page' ) );
	}

	public static function wppv_api_settings_init(  ) {
	    register_setting( 'wppvPlugin', 'wppv_api_settings' );
	    add_settings_section(
	        'wppv_api_wppvPlugin_section',
	        __( 'Settings for WP Post Views', 'wordpress' ),array( 'Wp_post_view_settings','wppv_api_settings_section_callback'),
	        'wppvPlugin'
	    );

	    add_settings_field(
	        'wppv_api_text_field_0',
	        __( 'Show post views coloumn', 'wordpress' ),array( 'Wp_post_view_settings','wppv_show_views_callback'),
	        'wppvPlugin',
	        'wppv_api_wppvPlugin_section'
	    );

	    // add_settings_field(
	    //     'wppv_api_select_field_1',
	    //     __( 'Our Field 1 Title', 'wordpress' ),array( 'Wp_post_view_settings', 'wppv_api_select_field_1_render'),
	    //     'wppvPlugin',
	    //     'wppv_api_wppvPlugin_section'
	    // );
	}

	public static function wppv_show_views_callback(  ) {
	    $options = get_option( 'wppv_api_settings' );
	    $checkbox_val = empty($options['wppv_api_text_field_0']) ? '' : $options['wppv_api_text_field_0'] ;
	    ?>
	    <input type='checkbox' name='wppv_api_settings[wppv_api_text_field_0]' value="1" <?php checked( 1, $checkbox_val, true ); ?>>
	    <?php
	}

	public static function wppv_api_select_field_1_render(  ) {
	    $options = get_option( 'wppv_api_settings' );
	    ?>
	    <select name='wppv_api_settings[wppv_api_select_field_1]'>
	        <option value='1' <?php selected( $options['wppv_api_select_field_1'], 1 ); ?>>Option 1</option>
	        <option value='2' <?php selected( $options['wppv_api_select_field_1'], 2 ); ?>>Option 2</option>
	    </select>

	<?php
	}

	public static function wppv_api_settings_section_callback(  ) {
	    echo __( 'This will show one extra coloumn in Post listing page which is show the counts', 'wordpress' );
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