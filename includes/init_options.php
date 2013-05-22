<?php

/* Initiate options framework */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/options/' );
	require_once dirname( __FILE__ ) . '/includes/options/options-framework.php';
}

/* End of init_options.php */