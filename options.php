<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'malmoe'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'malmoe'),
		'two' => __('Two', 'malmoe'),
		'three' => __('Three', 'malmoe'),
		'four' => __('Four', 'malmoe'),
		'five' => __('Five', 'malmoe')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'malmoe'),
		'two' => __('Pancake', 'malmoe'),
		'three' => __('Omelette', 'malmoe'),
		'four' => __('Crepe', 'malmoe'),
		'five' => __('Waffle', 'malmoe')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	/*
	$options[] = array(
		'name' => __('Basic Settings', 'malmoe'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Input Text Mini', 'malmoe'),
		'desc' => __('A mini text input field.', 'malmoe'),
		'id' => 'example_text_mini',
		'std' => 'Default',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Input Text', 'malmoe'),
		'desc' => __('A text input field.', 'malmoe'),
		'id' => 'example_text',
		'std' => 'Default Value',
		'type' => 'text');

	$options[] = array(
		'name' => __('Textarea', 'malmoe'),
		'desc' => __('Textarea description.', 'malmoe'),
		'id' => 'example_textarea',
		'std' => 'Default Text',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Input Select Small', 'malmoe'),
		'desc' => __('Small Select Box.', 'malmoe'),
		'id' => 'example_select',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $test_array);

	$options[] = array(
		'name' => __('Input Select Wide', 'malmoe'),
		'desc' => __('A wider select box.', 'malmoe'),
		'id' => 'example_select_wide',
		'std' => 'two',
		'type' => 'select',
		'options' => $test_array);

	$options[] = array(
		'name' => __('Select a Category', 'malmoe'),
		'desc' => __('Passed an array of categories with cat_ID and cat_name', 'malmoe'),
		'id' => 'example_select_categories',
		'type' => 'select',
		'options' => $options_categories);

	if ($options_tags) {
	$options[] = array(
		'name' => __('Select a Tag', 'options_check'),
		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
		'id' => 'example_select_tags',
		'type' => 'select',
		'options' => $options_tags);
	}

	$options[] = array(
		'name' => __('Select a Page', 'malmoe'),
		'desc' => __('Passed an pages with ID and post_title', 'malmoe'),
		'id' => 'example_select_pages',
		'type' => 'select',
		'options' => $options_pages);

	$options[] = array(
		'name' => __('Input Radio (one)', 'malmoe'),
		'desc' => __('Radio select with default options "one".', 'malmoe'),
		'id' => 'example_radio',
		'std' => 'one',
		'type' => 'radio',
		'options' => $test_array);

	$options[] = array(
		'name' => __('Example Info', 'malmoe'),
		'desc' => __('This is just some example information you can put in the panel.', 'malmoe'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Input Checkbox', 'malmoe'),
		'desc' => __('Example checkbox, defaults to true.', 'malmoe'),
		'id' => 'example_checkbox',
		'std' => '1',
		'type' => 'checkbox');
		*/

	$options[] = array(
		'name' => __('Startsidan', 'malmoe'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Referenser', 'malmoe'),
		'desc' => __('Visa modulen med referenser på startsidan', 'malmoe'),
		'id' => 'show-references',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Om oss', 'malmoe'),
		'desc' => __('Visa modulen med om oss på startsidan', 'malmoe'),
		'id' => 'show-about_us',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Välj sida att visa i "Om oss"', 'malmoe'),
		'desc' => __('Om du valt att visa "Om oss" på startsidan så välj här vilken sida du vill visa', 'malmoe'),
		'id' => 'page-about_us',
		'type' => 'select',
		'options' => $options_pages);

	$options[] = array(
		'name' => __('Maskinpark', 'malmoe'),
		'desc' => __('Visa modulen med maskinparken på startsidan', 'malmoe'),
		'id' => 'show-machines',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Kontakta oss', 'malmoe'),
		'desc' => __('Visa modulen med "Kontaka oss" på startsidan.', 'malmoe'),
		'id' => 'show-connect',
		'type' => 'checkbox');

	/* $options[] = array(
		'name' => "Example Image Selector",
		'desc' => "Images for layout.",
		'id' => "example_images",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

	$options[] = array(
		'name' =>  __('Example Background', 'malmoe'),
		'desc' => __('Change the background CSS.', 'malmoe'),
		'id' => 'example_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => __('Multicheck', 'malmoe'),
		'desc' => __('Multicheck description.', 'malmoe'),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

	$options[] = array(
		'name' => __('Colorpicker', 'malmoe'),
		'desc' => __('No color selected by default.', 'malmoe'),
		'id' => 'example_colorpicker',
		'std' => '',
		'type' => 'color' );

	$options[] = array( 'name' => __('Typography', 'malmoe'),
		'desc' => __('Example typography.', 'malmoe'),
		'id' => "example_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );

	$options[] = array(
		'name' => __('Custom Typography', 'malmoe'),
		'desc' => __('Custom typography options.', 'malmoe'),
		'id' => "custom_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options );

	$options[] = array(
		'name' => __('Text Editor', 'malmoe'),
		'type' => 'heading' );

		*/

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	/*
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Default Text Editor', 'malmoe'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'malmoe' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
*/
	return $options;
}