<?php
/**
 * The loop that displays Stacked images
 *
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 2.1
 */

global $meta, $post, $post_meta;

$meta = max_get_cutom_meta_array(get_the_ID());

?>
<!--BEGIN slider -->
<div id="stackedImages" class="page-slider">
<?php
	$_temp_meta['imgID'] = get_post_thumbnail_id($post->ID);

	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
		max_get_slider_image( $_temp_meta, 'full', 0, false, false, false, false );
	}

	// Catch and create the image for the slider
	$i = 0;
	foreach( $meta[MAX_SHORTNAME.'_featured_image'] as $sort => $value ){
		max_get_slider_image( $value, 'full', $i, false, false, false, false );
		$i++;
	}
?>

</div>