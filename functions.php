<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

 /* Opens site wrapper div */
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

/**
 * One-time import of GenerateBlocks global styles from theme XML.
 */
add_action( 'after_switch_theme', 'portico_import_gb_global_styles_on_activation' );
function portico_import_gb_global_styles_on_activation() {
	$import_flag = 'portico_gb_global_styles_imported_v1';

	if ( get_option( $import_flag ) ) {
		return;
	}

	$xml_file = get_stylesheet_directory() . '/gb-global-styles.xml';
	if ( ! file_exists( $xml_file ) ) {
		return;
	}

	$styles = portico_parse_gb_styles_from_xml( $xml_file );
	if ( empty( $styles ) ) {
		return;
	}

	foreach ( $styles as $style ) {
		portico_upsert_gb_style( $style );
	}

	update_option( $import_flag, gmdate( 'c' ) );
}

/**
 * Parse gblocks_styles items from a WordPress XML export file.
 *
 * @param string $xml_file XML file path.
 * @return array<int, array<string, string>>
 */
function portico_parse_gb_styles_from_xml( $xml_file ) {
	$styles = array();

	libxml_use_internal_errors( true );
	$xml = simplexml_load_file( $xml_file );
	if ( ! $xml ) {
		return $styles;
	}

	$wp = $xml->getNamespaces( true );
	if ( ! isset( $wp['wp'] ) ) {
		return $styles;
	}

	foreach ( $xml->channel->item as $item ) {
		$wp_item = $item->children( $wp['wp'] );
		if ( (string) $wp_item->post_type !== 'gblocks_styles' ) {
			continue;
		}

		$selector = '';
		$css      = '';
		$data     = 'a:0:{}';

		foreach ( $wp_item->postmeta as $postmeta ) {
			$meta = $postmeta->children( $wp['wp'] );
			$key  = (string) $meta->meta_key;
			$val  = (string) $meta->meta_value;

			if ( 'gb_style_selector' === $key ) {
				$selector = $val;
			} elseif ( 'gb_style_css' === $key ) {
				$css = $val;
			} elseif ( 'gb_style_data' === $key ) {
				$data = $val;
			}
		}

		if ( '' === $selector ) {
			continue;
		}

		$styles[] = array(
			'title'    => (string) $item->title,
			'postname' => (string) $wp_item->post_name,
			'selector' => $selector,
			'css'      => $css,
			'data'     => $data,
		);
	}

	return $styles;
}

/**
 * Create or update one GenerateBlocks global style post by selector.
 *
 * @param array<string, string> $style Parsed style data.
 * @return void
 */
function portico_upsert_gb_style( $style ) {
	$existing = get_posts(
		array(
			'post_type'      => 'gblocks_styles',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => 'gb_style_selector',
			'meta_value'     => $style['selector'],
			'fields'         => 'ids',
		)
	);

	$post_id = 0;

	if ( ! empty( $existing ) ) {
		$post_id = (int) $existing[0];
		wp_update_post(
			array(
				'ID'        => $post_id,
				'post_title'=> $style['title'],
				'post_name' => $style['postname'],
				'post_type' => 'gblocks_styles',
				'post_status' => 'publish',
			)
		);
	} else {
		$post_id = wp_insert_post(
			array(
				'post_title'  => $style['title'],
				'post_name'   => $style['postname'],
				'post_type'   => 'gblocks_styles',
				'post_status' => 'publish',
			)
		);
	}

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		return;
	}

	update_post_meta( $post_id, 'gb_style_selector', $style['selector'] );
	update_post_meta( $post_id, 'gb_style_css', $style['css'] );
	update_post_meta( $post_id, 'gb_style_data', $style['data'] );
}

add_action( 'after_switch_theme', 'portico_child_theme_activation_setup', 20 );
function portico_child_theme_activation_setup() {
	$flag = 'portico_child_theme_activation_v1';
	if ( get_option( $flag ) ) {
		return;
	}

	$defaults = function_exists( 'generate_get_defaults' ) ? generate_get_defaults() : array();
	$settings = wp_parse_args( get_option( 'generate_settings', array() ), $defaults );

	$settings['container_width']        = '1024';
	$settings['container_alignment']    = 'text';
	$settings['content_layout_setting'] = 'one-container';
	$settings['layout_setting']         = 'no-sidebar';
	$settings['blog_layout_setting']    = 'no-sidebar';
	$settings['single_layout_setting']  = 'no-sidebar';

	if ( defined( 'GP_PREMIUM_VERSION' ) ) {
		$settings['smooth_scroll'] = true;
	}

	update_option( 'generate_settings', $settings );

	if ( function_exists( 'generate_menu_plus_get_defaults' ) ) {
		$mp_defaults = generate_menu_plus_get_defaults();
		$mp          = wp_parse_args( get_option( 'generate_menu_plus_settings', array() ), $mp_defaults );
		if ( array_key_exists( 'smooth_scroll', $mp_defaults ) ) {
			$mp['smooth_scroll'] = true;
			update_option( 'generate_menu_plus_settings', $mp );
		}
	}

	delete_option( 'generate_dynamic_css_output' );

	$home_id = portico_get_or_create_page( 'Homepage', 'homepage' );
	$blog_id = portico_get_or_create_page( 'Blog', 'blog' );

	if ( $home_id && $blog_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		update_option( 'page_for_posts', $blog_id );
	}

	$menu_name = 'Header Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( is_wp_error( $menu_id ) ) {
			$menu_id = 0;
		}
	} else {
		$menu_id = (int) $menu->term_id;
	}

	if ( $menu_id ) {
		wp_update_nav_menu_locations( array( 'primary' => $menu_id ) );
	}

	update_option( $flag, gmdate( 'c' ) );
}

function portico_get_or_create_page( $title, $slug ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $existing ) {
		return (int) $existing->ID;
	}

	$id = wp_insert_post(
		array(
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_type'   => 'page',
			'post_status' => 'publish',
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		return 0;
	}

	return (int) $id;
}
