<?php

if ( function_exists( 'add_theme_support' ) ) {
    add_image_size( 'client-logo', 150 ); // Full size screen
}

add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'reference',
		array(
			'labels' => array(
				'name' => __( 'Referenser' ),
				'singular_name' => __( 'Referens' )
			),
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'capability_type' => 'page',
		'hierarchical' => false,
		'post-formats' => array( 'post' ),
		'rewrite' => true,
		'supports' => array('title', 'thumbnail')
		)
	);
}

add_action("admin_init", "portfolio_meta_box");
function portfolio_meta_box(){
    add_meta_box('reference-meta', "Extra info", "reference_meta_options", "reference", "normal", "low");
}

/**
 * Function: reference_meta_options
 * description
 * Returns:
 *   return description
 */
function reference_meta_options(){
	global $post;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
    return $post_id;
  }
	$custom = get_post_custom($post->ID);
	$link = $custom["client-link"][0];
	echo '<label>Länk till referens: </label><input name="client-link" class="client-link" value="' . $link . '" /><br />';
}

add_action('save_post', 'save_project_link');
/**
 * Function: save_project_link
 * description
 * Returns:
 *   return description
 */
function save_project_link(){
   global $post;
   if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	} else {
   	update_post_meta($post->ID, "client-link", $_POST["client-link"]);
  }
}

add_filter("manage_edit-portfolio_columns", "project_edit_columns");
/**
 * Function: project_edit_columns
 * description
 * Parameters:
 *   $columns - [type/description]
 * Returns:
 *   return description
 */
function project_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Projekt",
            "description" => "Beskrivning",
            "link" => "Länk",
            "featured" => "Featured",
            "type" => "Projekttyp",
        );
        return $columns;
}

add_action("manage_posts_custom_column",  "project_custom_columns");
/**
 * Function: project_custom_columns
 * description
 * Parameters:
 *   $column - [type/description]
 * Returns:
 *   return description
 */
function project_custom_columns($column){
        global $post;
        switch ($column) {
          case "description":
              the_excerpt();
              break;
          case "featured":
              $custom = get_post_custom();
              echo "on" == $custom["project-featured"][0] ? "Ja" : "Nej";
              break;
          case "link":
              $custom = get_post_custom();
              echo $custom["project-link"][0];
              break;
          case "type":
              echo get_the_term_list($post->ID, 'project-type', '', ', ','');
              break;
        }
}


/* End of cpt_portfolio.php */