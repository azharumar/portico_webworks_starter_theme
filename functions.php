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
