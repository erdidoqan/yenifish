<?php

/*-----------------------------------------------------------------------------------*/
/* = Function to get attachment id
/*-----------------------------------------------------------------------------------*/
// Helper function for vt_resize().

function max_get_attachment_id_from_src($img_src){

	global $wpdb;

	$image_src = esc_url($img_src);

	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";

	$img_id = $wpdb->get_var($query);

	return $img_id;
}

/*-----------------------------------------------------------------------------------*/
/* = New Resize Function
/*-----------------------------------------------------------------------------------*/
/*
 * @since Invictus 3.0
*/

function theme_thumb($url, $width, $height=0, $align='', $retina = false) {
  return mr_image_resize($url, $width, $height, true, $align, $retina);
}

?>