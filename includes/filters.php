<?php

function your_theme_embed_filter( $output, $data, $url ) {
	$return = '<div class="fitvideo">'.$output.'</div>';
	return $return;
}
add_filter('oembed_dataparse', 'your_theme_embed_filter', 90, 3 );

/* End of filters.php */