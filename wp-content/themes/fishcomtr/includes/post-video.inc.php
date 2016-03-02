<?php
global $meta, $portfolio, $post, $post_metam, $page_tpl;

$meta = max_get_cutom_meta_array(get_the_ID());

$embededCode = $meta[MAX_SHORTNAME.'_video_embeded_value'];

$_m4v  = !empty($meta[MAX_SHORTNAME.'_video_url_m4v_value']) ? $meta[MAX_SHORTNAME.'_video_url_ogv_value'] : false;
$_ogv  = !empty($meta[MAX_SHORTNAME.'_video_url_ogv_value']) ? $meta[MAX_SHORTNAME.'_video_url_ogv_value'] : false;
$_webm = !empty($meta[MAX_SHORTNAME.'_video_url_webm_value']) ? $meta[MAX_SHORTNAME.'_video_url_webm_value'] : false;

// Video Preview is an Imager from an URL
if($meta[MAX_SHORTNAME.'_video_poster_value'] == 'url'){
	$_poster_url = $meta[MAX_SHORTNAME.'_video_url_poster_value'];
}

// Video Preview is the post featured image or the URL was chosen but not set
if( $meta[MAX_SHORTNAME.'_video_poster_value'] == 'featured' || ( $meta[MAX_SHORTNAME.'_video_poster_value'] == 'url' && $meta[MAX_SHORTNAME.'_video_poster_value'] == "" ) ){

	$_previewUrl = max_get_image_path($post->ID, 'full');

	// get the imgUrl for showing the post image
	$_poster_url = max_get_custom_image_url(get_post_thumbnail_ID(get_the_ID()), get_the_ID(), MAX_CONTENT_WIDTH, $meta[MAX_SHORTNAME.'_video_height_value'] );

}

$width = MAX_CONTENT_WIDTH;

?>

<div class="entry-video-wrapper">
  <div class="entry-video" style="width: 100%">

  <script>// get fitVids if not already included
  if( !jQuery().fitVids ){
    document.write('<script src="<?php echo get_template_directory_uri() ?>/js/jquery.fitvids.min.js"><\/script>');
  }</script>

  <?php
  if( $meta[MAX_SHORTNAME.'_photo_item_type_value'] == "selfhosted" ) {

    max_get_video_js($post->ID);

  } else if ( $meta[MAX_SHORTNAME.'_photo_item_type_value'] == "youtube_embed" || $meta[MAX_SHORTNAME.'_photo_item_type_value'] == "vimeo_embed" ){

    echo stripslashes( htmlspecialchars_decode($embededCode) );

  }
  ?>
  </div>
</div>