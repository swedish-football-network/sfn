<?php
require('includes/theme_setup.php');
require('includes/load_css.php');
require('includes/sidebars.php');
require('includes/image_functions.php');
require('includes/filters.php');
require('includes/CPTs.php');
// require('includes/shortcodes.php');
// require('includes/pagination.php');

/* Files that should only be included for the admin interface */
if( is_admin() ) {
	//require('includes/admin/load_css.php');

/* Files that only should be included for the front end */
} else {
	require('includes/load_scripts.php');
	require('includes/menu_walkers.php');
}

/* End of functions.php */

function gray_white_black_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gray_white_black_enqueue_comment_reply' );


function gray_white_black_page_menu() {
	if (is_page()) { $highlight = "page_item"; } else {$highlight = "menu-item current-menu-item"; }
	echo '<ul class="menu">';
	wp_list_pages('sort_column=menu_order&title_li=&link_before=&link_after=&depth=3');
	echo '</ul>';
}

function gray_white_black_page_menu_flat() {
	if (is_page()) { $highlight = "page_item"; } else {$highlight = "menu-item current-menu-item"; }
	echo '<ul class="menu">';
	wp_list_pages('sort_column=menu_order&title_li=&link_before=&link_after=&depth=1');
	echo '</ul>';
}

/*add_action( 'admin_menu', 'my_plugin_menu' );

function my_plugin_menu() {
	add_options_page( 'SFN options', 'SFN', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}

function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}*/