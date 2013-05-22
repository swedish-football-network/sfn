<?php
/*
 * :: Remove dashboard widgets
 *
 * Removes unwanted dashboard widgets form the admin dashboard
 *
 */
if ( ! function_exists('malmoe_remove_dashboard_widgets' ) ) {
	function malmoe_remove_dashboard_widgets() {
		global $wp_meta_boxes;

		/* Array with all widgets to remove. $widgets_to_remove needs two args - which sidebar and which widget */
		$widgets_to_remove = array( array( 'normal',	'dashboard_recent_comments' ),
																array( 'normal',	'dashboard_incoming_links' ),
																array( 'normal',	'dashboard_plugins' ),
																array( 'side',		'dashboard_quick_press' ),
																array( 'side',		'dashboard_primary' ),
																array( 'side',		'dashboard_secondary' ));

		foreach( $widgets_to_remove as $key => $value ) {
			unset( $wp_meta_boxes[ 'dashboard' ][$value[0]][ 'core' ][$value[1]] );	
		}
	}
}
add_action('wp_dashboard_setup', 'malmoe_remove_dashboard_widgets' );

?>