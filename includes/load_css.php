<?php

add_action( 'init', 'malmoe_load_css' );
function malmoe_load_css() {
  if ( !is_admin() ) {

    wp_register_style( 'style', get_template_directory_uri() . '/css/style.css', false );
    wp_enqueue_style( 'style' );
  }
}

add_action( 'wp_head', 'malmoe_ie_css' );
function malmoe_ie_css () {
    echo '<!--[if lt IE 9]>';
    echo '<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css">';
    echo '<![endif]-->';
}

/* End of load_css.php */