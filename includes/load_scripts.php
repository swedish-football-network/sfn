<?php

add_action( 'init', 'sfn_load_scripts' );
function sfn_load_scripts() {
  global $pagenow;
  if( $pagenow == 'single-games.php' || $pagenow == 'single-teams.php' ) {
    wp_register_script( 'tablesorter', get_template_directory_uri() . '/tablesorter/jquery.tablesorter.min.js', array(), false, true );
    wp_enqueue_script( 'tablesorter' );
  }
  wp_register_script( 'sfn-script', get_template_directory_uri() . '/javascripts/script.js', array(), false, true );
  wp_enqueue_script( 'sfn-script' );

  if ($is_IE) {
    wp_register_script ( 'html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js" , false, true);
    wp_enqueue_script ( 'html5shiv' );
  }
}

/* End of load_scripts.php */