<?php

/*-----------------------------------------------------------------------------------*/
/*	Paths Defenitions
/*-----------------------------------------------------------------------------------*/
defined('MAX_TINYMCE_PATH') or define('MAX_TINYMCE_PATH', get_template_directory() . '/tinymce');
defined('MAX_TINYMCE_URI') or define('MAX_TINYMCE_URI', get_template_directory_uri() . '/tinymce');

/*-----------------------------------------------------------------------------------*/
/*	Load TinyMCE dialog
/*-----------------------------------------------------------------------------------*/
require_once( MAX_TINYMCE_PATH . '/tinymce.class.php' );		// TinyMCE wrapper class
new max_tinymce(); // do the magic

?>