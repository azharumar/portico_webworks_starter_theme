<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

 /* Opens site wrapper div */
add_action('generate_before_header', 'tct_open_wrapper');
function tct_open_wrapper(){
    echo '<div class="site-wrapper">';
}

/* Closes site wrapper div */
add_action('generate_after_footer', 'tct_close_wrapper');
function tct_close_wrapper(){
    echo '</div>';
}

/* Enqueue Child Theme style.css to editor */
add_filter('block_editor_settings_all', function($editor_settings) {
    // Get the URL of the child theme's style.css
    $child_theme_style_url = get_stylesheet_directory_uri() . '/style.css';

    $editor_settings['styles'][] = array('css' => wp_remote_get($child_theme_style_url)['body']);
    return $editor_settings;
});


/* Eunqueue Customizer CSS to editor */ 
add_filter( 'block_editor_settings_all', function( $editor_settings ) {
    $css = wp_get_custom_css_post()->post_content;
    $editor_settings['styles'][] = array( 'css' => $css );
    return $editor_settings;
} );

/* Remove WordPress Core default block patterns */
add_action( 'after_setup_theme', 'my_remove_patterns' );
function my_remove_patterns() {
   remove_theme_support( 'core-block-patterns' );
}

/* Patterns accessible in backend */
function be_reusable_blocks_admin_menu() {
    add_menu_page( 'Patterns', 'Patterns', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
}
add_action( 'admin_menu', 'be_reusable_blocks_admin_menu' );

/* Default typography for GeneratePress (child theme) — edit inc/customizer-typography-defaults.json */
add_filter( 'option_generate_settings', 'portico_default_typography', 10, 3 );
function portico_default_typography( $value, $option, $default ) {
	$json_path = get_stylesheet_directory() . '/inc/customizer-typography-defaults.json';
	if ( ! file_exists( $json_path ) ) {
		return $value;
	}
	$json = file_get_contents( $json_path );
	$typography_defaults = json_decode( $json, true );
	if ( ! is_array( $typography_defaults ) ) {
		return $value;
	}
	if ( ! is_array( $value ) ) {
		$value = array();
	}
	if ( empty( $value['typography'] ) ) {
		$value['typography'] = $typography_defaults;
	}
	return $value;
}

/**
 * Portico Webworks — Enqueue Inter font for WP Admin
 */
add_action( 'admin_enqueue_scripts', 'portico_admin_google_font' );
function portico_admin_google_font() {
	wp_enqueue_style(
		'portico-inter',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		[],
		null
	);
}

/**
 * Portico Webworks — Enqueue admin brand stylesheet
 */
add_action( 'admin_enqueue_scripts', 'portico_admin_styles' );
function portico_admin_styles() {
	wp_enqueue_style(
		'portico-admin-style',
		get_stylesheet_directory_uri() . '/admin-style.css',
		[ 'portico-inter' ],
		'1.0.0'
	);
}

/**
 * Portico Webworks — Enqueue Inter font and admin styles on login page
 */
add_action( 'login_enqueue_scripts', 'portico_login_styles' );
function portico_login_styles() {
	wp_enqueue_style(
		'portico-inter-login',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		[],
		null
	);
	wp_enqueue_style(
		'portico-admin-login',
		get_stylesheet_directory_uri() . '/admin-style.css',
		[ 'portico-inter-login' ],
		'1.0.0'
	);
}
