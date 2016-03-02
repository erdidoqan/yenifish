<?php
/* #################################################################################### */
/*
/* Class for Post Option Set
 *
 * @author		Dennis Osterkamp aka "doitmax"
 * @copyright	Copyright (c) Dennis Osterkamp
 * @link		  http://www.do-media.de
 * @since		  Version 3.0
 * @package 	Invictus
 *
 * @filedesc 	Option set to create the post meta box options
 *
/* #################################################################################### */

class UIElement_Post extends UIElement {

	public function __construct($type) {
        parent::__construct($type);
	}

	public function getMetaBox() {

		$this->createMetabox(array(
			'id'         => MAX_SHORTNAME.'_post_sidebar_metabox',
			'title'      => __('Sidebar Settings', MAX_SHORTNAME),
			'priority'   => "default",
			'context'    => 'side',
		));

    // get the custom sidebars and make a dropdown array
    $_sidebar_option_array = get_option_max('sidebar_array');
    $_dropdown_array = array('false' => __('Default or no Sidebar', MAX_SHORTNAME) );

    if( is_array($_sidebar_option_array) ) {
      foreach( $_sidebar_option_array as $sidebar_value) {
        $_s = explode(',', $sidebar_value);
        $_dropdown_array[$_s[1]] = $_s[0];
      }
    }

    // Sidebar select
    $this->addDropdown(array(
      'id'        => MAX_SHORTNAME.'_sidebar_select',
      'label'     => __('Choose a Sidebar', MAX_SHORTNAME),
      "options"   => $_dropdown_array,
      "standard"  => "false",
      "desc"      => __('Select a sidebar to show on this page or post, when a sidebar is provided for this post or page template. You can create as many sidebars as you like on your Invictus theme settings.', MAX_SHORTNAME),
    ));

	}

}

?>