<?php

global $wp_content_path;

$absolute_path = __FILE__;

$path_to_file = explode( $wp_content_path, $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

?>