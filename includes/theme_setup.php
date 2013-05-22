<?php
function malmoe_setup() {
	// Add language supports. Please note that Reverie Framework does not include language files.
	load_theme_textdomain('malmoe', get_template_directory() . '/lang');

	// Add post thumbnail supports. http://codex.wordpress.org/Post_Thumbnails
	// add_theme_support('post-thumbnails');
	// set_post_thumbnail_size(150, 150, false);

	// Add post formarts supports. http://codex.wordpress.org/Post_Formats
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	add_theme_support( 'post-thumbnails' );

	// Add menu supports. http://codex.wordpress.org/Function_Reference/register_nav_menus
	add_theme_support('menus');

	add_theme_support( 'infinite-scroll', array(
    'container'  => 'blog-list',
    'render'		 => 'infinite_scroll_render',
    'wrapper'		 => false,
    'footer'     => false
	) );

	register_nav_menus(array(
		'primary_navigation' => __('Primary Navigation', 'malmoe'),
		'blog_navigation' => __('Blog Navigation', 'malmoe')
	));

	if (class_exists( 'Dashboard_Widget_Template' ) ) {
		$add_widget = new Dashboard_Widget_Template;
		$add_widget -> setup_widget( 'Support-widget', 'Utveckling & Support', 'malmoe_support_widget' );
	}
}

add_action('after_setup_theme', 'malmoe_setup');

/*function infinite_scroll_render() {
	get_template_part( 'content' );
}*/

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 100;
}
/* End of theme_setup.php */