<?php

add_action( 'init', 'create_post_type' );
function create_post_type() {

	register_post_type( 'games',
		array(
			'labels' => array(
				'name' => __( 'Games' ),
				'singular_name' => __( 'Game' )
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

/* End of CPTs.php */