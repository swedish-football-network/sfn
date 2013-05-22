<?php
Class Dashboard_Widget_Template {
	var $id, $name, $callback;

	public function __construct() {
		add_action( 'wp_dashboard_setup', array($this, 'malmoe_add_dashboard_widget' ) );
	}
	
	public function setup_widget( $widget_id, $widget_name, $widget_callback ) {
		$this->id 			= $widget_id;
		$this->name 		= $widget_name;
		$this->callback = $widget_callback;
	}

	public function malmoe_add_dashboard_widget () {
		wp_add_dashboard_widget( $this->id, $this->name, $this->callback );
	}

}

?>