<?php
/**
 * The loop that displays Slides Slider
 *
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 2.1
 */

global $meta, $post, $post_meta;

$meta = max_get_cutom_meta_array(get_the_ID());

$no_hover = get_option_max('image_show_fade') == 'false' ? ' no-hover' : "";

?>


<!--BEGIN slider -->
<div id="slider-<?php echo get_the_id() ?>" class="slides-slider page-slider" data-loader="<?php echo get_template_directory_uri(); ?>/css/<?php echo get_option_max('color_main') ?>/loading.gif">

	<?php
	$_temp_meta['imgID'] = get_post_thumbnail_id($post->ID);

	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
	?>
	<div class="slide<?php echo $no_hover?>">
	<?php
    max_get_slider_image( $_temp_meta, 'slides-slider', 0, false, false, false );	?>
	</div>
	<?php
	}

	// Catch and create the image for the slider
	$i = 1;

	foreach( $meta[MAX_SHORTNAME.'_featured_image'] as $sort => $value ){
	?>
	<div class="slide<?php echo $no_hover?>">
	<?php
		max_get_slider_image( $value, 'slides-slider', $i, false, false, false );
		$i++;
	?>
	</div>
	<?php }	?>

</div>
<!--END .slider -->

<script type="text/javascript">
	jQuery(document).ready(function(){

		var slidesContainer = jQuery("#slider-<?php echo get_the_id() ?>"),
			slidesTimeout;

		jQuery(window).load(function(){

			var slides = jQuery("#slider-<?php echo get_the_id() ?>").slidesjs({
			  <?php if($meta[MAX_SHORTNAME.'_photo_slider_slides_autoplay'] == 'true'){ ?>
        play: {
          active: true,
          auto: true,
          interval: <?php echo $meta[MAX_SHORTNAME.'_photo_slider_slides_pause'] ?>,
          swap: true
        }
        <?php } ?>
      });

		});

	})

</script>