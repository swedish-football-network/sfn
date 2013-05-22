<?php

add_action('after_setup_theme', 'sfn_setup');
function sfn_setup() {
	// Add language supports.
	load_theme_textdomain('sfn', get_template_directory() . '/languages');


	add_editor_style();
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');

	set_post_thumbnail_size( 120, 120, true ); // Default size

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain('gray_white_black', get_template_directory() . '/languages');

	register_nav_menus(
		array(
		  'primary' => __('Header Menu', 'sfn'),
		  'secondary' => __('Footer Menu', 'sfn')
		)
	);

}

/**
 * Setup custom excerpt length
 */

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 100;
}

/**
 * Setup custom 'READ MORE' output
 */

add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
       global $post;
	return ' <a href="'. get_permalink($post->ID) . '"><strong>   Läs</strong></a>';
}

/* End of theme_setup.php */