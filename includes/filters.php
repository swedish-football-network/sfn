<?php

/**
 * Add FitVids to all embeds
 */

add_filter('oembed_dataparse', 'your_theme_embed_filter', 90, 3 );
function your_theme_embed_filter( $output, $data, $url ) {
	$return = '<div class="fitvideo">'.$output.'</div>';
	return $return;
}

/* End of filters.php */