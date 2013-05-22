<?php

add_action('login_head', 'malmoe_load_admin_css');
function malmoe_load_admin_css() {
	wp_register_style( 'login-css', get_template_directory_uri() . '/css/login.css', false );
	wp_enqueue_style( 'login-css' );
}

/* End of support_widget.php */