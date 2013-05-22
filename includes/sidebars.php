<?php

add_action ( 'widgets_init', 'sfn_widgets' );
function sfn_widgets() {

	register_sidebar(array(
		'name' => __( 'Sidebar Widget Area', 'sfn'),
		'id' => 'sidebar-widget-area',
		'description' => __( 'The sidebar widget area', 'sfn'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Page top Widgets', 'sfn'),
		'id' => 'widgetized-page-top',
		'description' => __( 'The top widget area', 'sfn'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>'
	));
}

/* End of sidebars.php */