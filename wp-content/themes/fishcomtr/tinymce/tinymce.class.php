<?php

class max_tinymce
{
	function __construct()
	{
		add_action('admin_init', array( &$this, 'max_head' ));
		add_action('init', array( &$this, 'max_tinymce_rich_buttons' ));
		add_action('admin_print_scripts', array( &$this, 'max_quicktags' ));
	}

	// --------------------------------------------------------------------------

	function max_head()
	{
		// css
		wp_enqueue_style( 'max-popup', MAX_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );

		// js
		wp_enqueue_script( 'jquery-ui-sortable') ;
		wp_enqueue_script( 'jquery-livequery', MAX_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		//wp_enqueue_script( 'jquery-appendo', MAX_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', MAX_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'max-popup', MAX_TINYMCE_URI . '/js/popup.js', false, '1.0', false );
	}

	// --------------------------------------------------------------------------

	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function max_tinymce_rich_buttons()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array( &$this, 'max_add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'max_register_rich_buttons' ) );
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function max_add_rich_plugins( $plugin_array )
	{
		$plugin_array['maxshortcodes'] = MAX_TINYMCE_URI . '/plugin.js';
		return $plugin_array;
	}

	// --------------------------------------------------------------------------

	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function max_register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'max_button' );
		return $buttons;
	}

	// --------------------------------------------------------------------------

	/**
	 * Registers TinyMCE HTML editor quicktags buttons
	 *
	 * @return	void
	 */
	function max_quicktags() {
		// wp_enqueue_script( 'max_quicktags', MAX_TINYMCE_URI . '/plugins/wizylabs_quicktags.js', array('quicktags') );
	}
}

?>