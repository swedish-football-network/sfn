<?php
add_shortcode( 'codepen', 'add_codepen_script' );
function add_codepen_script( $atts ) {

  wp_register_script( 'codepen', 'http://codepen.io/assets/embed/ei.js', '', false, true );
  wp_enqueue_script( 'codepen' );

  return null;
}

/* End of cpt_portfolio.php */