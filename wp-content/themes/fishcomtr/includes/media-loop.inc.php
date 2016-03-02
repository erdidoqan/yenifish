<?php
/**
 * The loop that displays images from an
 * attached media library gallery.
 *
 * @package WordPress
 * @subpackage invictus
 * @since invictus 3.0.1
 */

global $imgDimensions;

$images = explode(',', get_post_meta($post->ID, MAX_SHORTNAME.'_post_gallery', true)); // get the attached gallery images
$image_size = 'large';
?>

<ul id="portfolioList" class="clearfix portfolio-list loading">

<?php
// Get the gallery images
if( !empty($images) && is_array($images) ) :

	foreach($images as $index => $attachment_id) :

    // get the attachment caption if set
    $attachment_caption = get_post_field('post_excerpt', $attachment_id);
    $attachment_title   = get_post_field('post_title', $attachment_id);
    $imageUrl           = wp_get_attachment_image_src( $attachment_id, $image_size);

    // put it all together & output the image
		?>
		<li id="post-attachment-<?php echo $attachment_id ?>" <?php post_class('item') ?>>
      <div class="shadow">
        <a href="<?php $src = wp_get_attachment_image_src( $attachment_id, 'full' ); echo $src[0]; ?>" data-rel="prettyPhoto[gal]" title="<?php echo $attachment_title ?>" data-effect="mfp-zoom-in">
          <?php
          // show the featured image
          $thumb = theme_thumb( $imageUrl[0], $imgDimensions['width'], $imgDimensions['height'] );
          ?>
          <img src="<?php echo $thumb ?>" alt="<?php if( !empty( $attachment_caption ) ) : echo $attachment_caption; else : echo $attachment_title; endif; ?>" class="attachment-<?php echo $image_size ?>" />
        </a>
      </div>
    </li>

  <?php
	endforeach; // end foreach

endif; ?>
</ul>
