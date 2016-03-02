<?php
/* #################################################################################### */
/*
/* Class for Page Option Set
 *
 * @author		Dennis Osterkamp aka "doitmax"
 * @copyright	Copyright (c) Dennis Osterkamp
 * @link		http://www.do-media.de
 * @since		Version 1.0
 * @package 	Invictus
 *
 * @filedesc 	Option set to create the page meta box options
 *
/* #################################################################################### */

class UIElement_Page extends UIElement {

	public function __construct($type) {
        parent::__construct($type);
	}

	public function getSidebarMetaBox() {

		$this->createMetabox(array(
			'id'         => MAX_SHORTNAME.'_page_sidebar_metabox',
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
      "desc"      => __('Select a sidebar to show on this page template, when a sidebar is provided for this template. You can create as many sidebars as you like on your Invictus theme settings.', MAX_SHORTNAME),
    ));

	}

  public function getPageMetaBox() {

    $this->createMetabox(array(
      'id'         => MAX_SHORTNAME.'_page_settings_metabox',
      'title'      => __('Page Settings', MAX_SHORTNAME),
      'priority'   => "high",
    ));

    // Show page header
    $this->addDropdown(array(
      "id"       => MAX_SHORTNAME.'_page_show_header',
      "label"    => __('Show page header?', MAX_SHORTNAME),
      "options"  => array(
        'true'  => "Yes",
        'false' => "No"
      ),
      "standard" => 'true',
      "desc"     => __('You can hide the page header for each page you have created. Set the option to "No" and the page header and excerpt are hidden for the respective page.', MAX_SHORTNAME)
    ));

  }


}

?>