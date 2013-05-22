<?php
/**
 * Class: inuit_flyout_walker
 * Walker class for the flyout css that is shipped with Inuit.css
 * Extends: Walker_Nav_Menu
 */
class inuit_flyout_walker extends Walker_Nav_Menu {

  function start_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<a href=\"#\" class=\"flyout-toggle\"><span> </span></a><ul class=\"flyout__content island\">\n";
  }

  function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$prepend = $append = '';
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

		if($depth != 0)
			$description = $append = $prepend = "";

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

// Add Foundation 'active' class for the current menu item and Foundation 'has-flyout' for menu item with child
function add_inuit_classes( $classes, $item ) {
    if( 1 == $item->current )
        $classes[] = 'active';

    // Querys the wpdb for nav_menu_items that has a parent with the ID of current menu item
    $has_children = get_posts(array('post_type' => 'nav_menu_item', 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		empty( $has_children ) ? '' : $classes[] = 'flyout';

    return $classes;
}
add_filter( 'nav_menu_css_class', 'add_inuit_classes', 10, 2 );

/* End of menu_walkers.php */
/* Location /includes/ */