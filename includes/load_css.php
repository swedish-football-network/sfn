<?php

add_action( 'init', 'sfn_load_css' );
function sfn_load_css() {
  if ( !is_admin() && !is_404() ) {

    wp_register_style( 'style', get_template_directory_uri() . '/css/style.css', false );
    wp_enqueue_style( 'style' );
  }
}

add_action( 'wp_head', 'sfn_ie_css' );
function sfn_ie_css () {
    echo '<!--[if lt IE 9]>';
    echo '<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css">';
    echo '<![endif]-->';
}

/* End of load_css.php */