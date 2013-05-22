<?php

register_sidebar(array('name'=> 'Sidebar',
	'id' => 'sidebar',
	'description' => 'Sidebar',
	'class' => '',
	'before_widget' => '<article id="%1$s" class="widget %2$s">',
	'after_widget' => '</article>',
	'before_title' => '<h4>',
	'after_title' => '</h4>'
));

/* End of sidebars.php */