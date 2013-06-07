<?php
add_action( 'admin_menu', 'my_plugin_menu' );

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
}


if ( ! isset( $content_width ) )
$content_width = 568;

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'games',
		array(
			'labels' => array(
				'name' => __( 'Games' ),
				'singular_name' => __( 'Game' ),
				'supports'		=> array("title", "editor", "thumbnail", "author", "custom-fields", "comments")
			),
		'public' => true,
		'has_archive' => true,
		)
	);
	register_post_type( 'teams',
		array(
			'labels' => array(
				'name' => __( 'Teams' ),
				'singular_name' => __( 'Team' )
			),
		'public' => true,
		)
	);
}
add_action( 'after_setup_theme', 'gray_white_black_setup' );
function custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function new_excerpt_more($more) {
       global $post;
	return ' <a href="'. get_permalink($post->ID) . '"><b>   Läs</b></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
function gray_white_black_setup() {

add_editor_style();
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');

set_post_thumbnail_size( 120, 120, true ); // Default size

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain('gray_white_black', get_template_directory() . '/languages');

register_nav_menus(
	array(
	  'primary' => __('Header Menu', 'gray_white_black'),
	  'secondary' => __('Footer Menu', 'gray_white_black')
	)
);

}

function gray_white_black_widgets() {
register_sidebar(array(
	'name' => __( 'Sidebar Widget Area', 'gray_white_black'),
	'id' => 'sidebar-widget-area',
	'description' => __( 'The sidebar widget area', 'gray_white_black'),
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));
}
register_sidebars( 1,
array(
'name' => 'widgetized-page-top',
'before_widget' => '
<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>
',
'before_title' => '
<h2 class="widgettitle">',
'after_title' => '</h2>
'
)
);

add_action ( 'widgets_init', 'gray_white_black_widgets' );

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

add_action( 'init', 'sfn_load_scripts' );
function sfn_load_scripts() {
	global $pagenow;
	if( $pagenow == 'single-games.php' || $pagenow == 'single-teams.php' ) {
		wp_register_script( 'tablesorter', get_template_directory_uri() . '/tablesorter/jquery.tablesorter.min.js', array(), false, true );
		wp_enqueue_script( 'tablesorter' );
	}
	wp_register_script( 'sfn-script', get_template_directory_uri() . '/javascripts/script.js', array(), false, true );
	wp_enqueue_script( 'sfn-script' );
}
