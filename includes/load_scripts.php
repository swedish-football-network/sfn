<?php

add_action( 'init', 'malmoe_load_scripts' );

function malmoe_load_scripts() {

  global $is_IE;

  // Enqueue to header

  // Enqueue to footer
  wp_register_script( 'script', get_template_directory_uri() . '/javascripts/script-ck.js', array(), false, true );
  wp_enqueue_script( 'script' );

  if ($is_IE) {
    wp_register_script ( 'html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js" , false, true);
    wp_enqueue_script ( 'html5shiv' );
  }

   // Enable threaded comments
  if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
    wp_enqueue_script('comment-reply');
}

/* End of load_scripts.php */