<?php
global $fullsize_gallery_posts, $meta, $portfolio, $post, $show_slideshow, $_query_has_videos, $isFullsizeGallery, $main_homepage, $isFullsizeVideo, $max_retina_sizes;

// check for fullsize video autoplay
$fullsize_autoplay = 'false';

if( isset( $isFullsizeGallery ) && !$main_homepage && !$isFullsizeVideo ){


	if(!isset($meta[MAX_SHORTNAME.'_page_fullsize_autoplay'])){
		$autoplay = get_option_max('fullsize_autoplay_slideshow');
	}else{
		$autoplay = $meta[MAX_SHORTNAME.'_page_fullsize_autoplay'];
	}

  // check for fullsize autoplay
	if( !isset($meta[MAX_SHORTNAME.'_page_fullsize_autoplay_videos']) ) {
    $fullsize_autoplay = get_option_max('fullsize_autoplay_video');
  }else{
    $fullsize_autoplay = $meta[MAX_SHORTNAME.'_page_fullsize_autoplay_videos'];
  }

}else{

	$autoplay = get_option_max('fullsize_autoplay_slideshow');
  if( ( get_option_max('fullsize_autoplay_video') == 'true' && !$isFullsizeVideo ) || ( $isFullsizeVideo === true && $meta[MAX_SHORTNAME.'_video_autoplay_value'] == 'true') ){
  	$fullsize_autoplay = 'true';
  }

}

// check for hiding theme elements on video play
$video_show_elements = 'true';
if( (get_option_max('fullsize_video_show_elements') == 'false') ){
	$video_show_elements = 'false';
}

// check for thumbnails
$show_thumbnails = false;
$_show_thumbnails_checker = !empty($meta['max_show_page_fullsize_thumbnails']) ? $meta['max_show_page_fullsize_thumbnails'] : "";
if( ( $main_homepage === true && get_option_max('homepage_show_thumbnails') == 'true') ||
	( $isFullsizeGallery === true && $_show_thumbnails_checker == 'false' )){
	$show_thumbnails = true;
}

// check for slideshow interval from page meta, otherwise get from option set
$slideshow_interval = !empty($meta[MAX_SHORTNAME.'_fullsize_interval']) ? $meta[MAX_SHORTNAME.'_fullsize_interval'] : get_option_max('fullsize_interval');
?>

<script src='<?php echo get_template_directory_uri(); ?>/js/swfobject.js?ver=3.2.1'></script>
<script src='<?php echo get_template_directory_uri(); ?>/js/jwplayer/jwplayer.js?ver=3.2.1'></script>

    <?php
    // show large prev/next arrows
    if( get_option_max( "fullsize_show_arrows", 'false' ) == 'true' && !$isFullsizeVideo && get_option_max( "fullsize_featured_count", 12 ) > 1 ) { ?>
    <div class="fsg-arrows">
      <a href="#" class="fsg-arrows-prev"><i class="fa fa-angle-left"></i><span><?php _e('Previous Image', MAX_SHORTNAME) ?></span></a>
      <a href="#" class="fsg-arrows-next"><i class="fa fa-angle-right"></i><span><?php _e('Next Image', MAX_SHORTNAME) ?></span></a>
    </div>
    <?php } ?>

		<?php // check if the fullsize overlay title text should be shown ?>
		<?php if ( ( $main_homepage && get_option_max('fullsize_show_title') == 'true' ) || $meta['max_show_page_fullsize_title'] == 'true' ){ ?>
		<div id="responsiveTitle">
		  <span class="clearfix imagetitle"><a href="#">Show Details</a></span>
		</div>
		<?php } ?>

		<!-- Video play button -->
		<a id="fsg_playbutton" href="#" class="fsg-playbutton-hide"><i class="fa fa-play"></i><span><?php _e('Play', MAX_SHORTNAME) ?></span></a>

		<div id="thumbnails"
				class="clearfix thumbs-hide-<?php echo get_option_max('fullsize_toggle_thumbnails') ?> <?php echo get_option_max('fullsize_controls_position'); if ( get_option_max('fullsize_mouse_scrub')  == "true" ){ ?> mouse-scrub<?php } ?><?php if ( get_option_max('fullsize_key_nav') == "true" ){ ?> key-nav<?php } ?><?php if ( get_option_max('fullsize_mouse_leave')  == "true" ){ ?> mouse-leave<?php } ?>"
				data-object='{"fullsize_autoplay_slideshow":"<?php echo $autoplay ?>","directory_uri":"<?php echo get_template_directory_uri(); ?>","color_main":"<?php echo get_option_max('color_main'); ?>","fullsize_yt_hd":"<?php echo get_option_max('fullsize_yt_hd') ?>","fullsize_interval":"<?php echo $slideshow_interval ?>"<?php if( $show_thumbnails ){ ?>,"homepage_show_thumbnails":"true"<?php } ?>,"fullsize_autoplay_video":"<?php echo $fullsize_autoplay ?>", "video_show_elements": "<?php echo $video_show_elements ?>"}'
			>

			<div class="rel">

				<?php // check if the fullsize overlay title text should be shown ?>
				<?php if ( ( $main_homepage && get_option_max('fullsize_show_title') == 'true' || $meta['max_show_page_fullsize_title'] == 'true' ) || $main_homepage && get_option_max('fullsize_show_title_excerpt') == 'true' ) {

          // get the first post and the excerpt of it and then revert the query
          $max_temp                 = $post;
          $post                     = get_post( $fullsize_gallery_posts->posts[0]->ID );

          // setup the post data to receive excerpt and title
          setup_postdata( $post );

          $showtitle_first_caption  = get_the_excerpt();
          $showtitle_first_title    = get_the_title();

          // reset the post data to get back the temp post
          wp_reset_postdata();

          $post                     = $max_temp;
				?>
				<div id="showtitle" class="clearfix">
					<div class="clearfix title">
					  <?php if ( $main_homepage && get_option_max('fullsize_show_title') == 'true' || $meta['max_show_page_fullsize_title'] == 'true' ) : ?>
						<span class="clearfix imagetitle"><a href="#"><?php echo $showtitle_first_title; ?></a></span>
						<?php endif; ?>
						<?php if ( get_option_max('fullsize_show_title_excerpt') == 'true' ){ ?><span class="imagecaption hidden"><?php echo $showtitle_first_caption ?></span><?php } ?>
						<span class="imagecount small">1/1</span>
 					  <?php if ( get_option_max('fullsize_show_title_excerpt') == 'true' ) : ?>
						<?php if ( get_option_max('fullsize_show_title_more') == 'true' ) : ?><span class="more"><a href="#"><?php _e('Show more', MAX_SHORTNAME); ?></a></span><?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php } ?>

				<!-- Thumbnail toggle arrow -->
				<a href="#toggleThumbs" id="toggleThumbs" class="slide-up" <?php if ( !$show_slideshow ) echo ('style="display: none"') ?>><i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></a>

				<div class="controls <?php if( $autoplay == 'true' ) echo 'fullsize-playing' ?>" <?php if ( !$show_slideshow ) echo ('style="display: none"') ?>>
          <?php if(get_option_max('fullsize_hide_controls', 'false') != 'true') { ?>
 					<a href="#prev" id="fullsizePrev" class="fullsize-link fullsize-prev" title="<?php _e('Prev Image', MAX_SHORTNAME) ?>"><i class="fa fa-fast-backward"></i></a>
  				<?php } ?>
					<a href="#start" id="fullsizeStart" class="fullsize-control fullsize-start" title="<?php _e('Start Slideshow', MAX_SHORTNAME)?>"><i class="fa fa-play"></i><span><?php _e('Start Slideshow', MAX_SHORTNAME) ?></span></a>
					<a href="#stop" id="fullsizeStop" class="fullsize-control fullsize-stop" title="<?php _e('Stop Slideshow', MAX_SHORTNAME) ?>"><i class="fa fa-pause"></i><span><?php _e('Stop Slideshow', MAX_SHORTNAME) ?></span></a>
          <?php if( get_option_max('fullsize_hide_controls', 'false') != 'true') { ?>
					<a href="#next" id="fullsizeNext" class="fullsize-link fullsize-next" title="<?php _e('Next Image', MAX_SHORTNAME) ?>"><i class="fa fa-fast-forward"></i></a>
					<?php } ?>
				</div>

				<?php if ( get_option_max('fullsize_mouse_scrub')  != "true" ){ ?>
				<a id="scroll_left" href="#scroll-left" class="scroll-link scroll-left"><i class="fa fa-angle-left"></i></a>
				<a id="scroll_right" href="#scroll-right" class="scroll-link scroll-right"><i class="fa fa-angle-right"></i></a>
				<?php } ?>

				<div id="fullsizeTimerBG" <?php if ( !$show_slideshow ) echo ('style="display: none"') ?>>
          <div id="fullsizeTimer" <?php if ( !$show_slideshow ) echo ('style="display: none"') ?>></div>
				</div>

				<div id="thumbnailContainer" <?php if ( !$show_slideshow ) echo ('style="display: none"') ?> <?php if( get_option_max( 'fullsize_thumb_center', false, 'false' ) == 'true') echo 'class="centered"' ?>>

					<div id="fullsize" class="clearfix pulldown-items">

						<?php

						$img_greyscale = get_option_max('fullsize_use_greyscale') == 'true' ? " greyscaled" : "";

						// get the image we need for the different devices
						$max_mobile_detect = new Mobile_Detect();
						$_img_string = max_get_image_string();

						$_preload_images = "0";

						// disable preload of fullsize images on mobile devices but preload if option is set
						if ( $max_mobile_detect->isTablet() || $max_mobile_detect->isMobile() ){
							$_preload_images = "0";
						}else if(get_option_max('fullsize_preload') == 'true'){
							$_preload_images = "1";
						}

            // loop through full size gallery images if we have some
            if( !empty($fullsize_gallery_posts) ) :

  						if ($fullsize_gallery_posts->have_posts()) : while ($fullsize_gallery_posts->have_posts()) : $fullsize_gallery_posts->the_post();

  							// check if password protected posts should be shown
  							$show_protected_post = true;
  							if ( post_password_required() ) {
  								if( get_option_max('fullsize_exclude_protected') == 'false' ){
  									$show_protected_post = false;
  								}
  							}

  							if ( $show_protected_post ) :

  								//Get the page meta informations and store them in an array
  								$_post_meta = max_get_cutom_meta_array(get_the_ID());

                  // get background image wether it is a desktop or a mobile
  								$imgUrl_temp = max_get_post_image_url( get_the_ID(), $_img_string );

  								$imgUrl_big = $imgUrl_temp[0];
  								$photo_link = '#';
  								$photo_target = '';
  								$show_title_link = get_option_max('fullsize_remove_title_link');

  								if( empty( $show_title_link ) || 'false' == $show_title_link ){

  									// Check the link value for the post
  									if( !empty($_post_meta[MAX_SHORTNAME.'_photo_item_type_value']) && str_replace(" ", "_", strtolower($_post_meta[MAX_SHORTNAME.'_photo_item_type_value'])) == 'external'){

  										$photo_link = $_post_meta[MAX_SHORTNAME.'_photo_external_link_value'];
  										$photo_target = $_post_meta[MAX_SHORTNAME.'_external_link_target_value'];

  									}else{

  										// check if a link should be shown on a fullsize_thumb_center image title
  										if( empty( $_post_meta[MAX_SHORTNAME.'_photo_item_fsg_link'] ) || 'true' == $_post_meta[MAX_SHORTNAME.'_photo_item_fsg_link'] ){

  											if( !empty( $_post_meta[MAX_SHORTNAME.'_photo_item_custom_link'] ) && '' != $_post_meta[MAX_SHORTNAME.'_photo_item_custom_link'] ){

  												// Photo link is a custom link
  												$photo_link = $_post_meta[MAX_SHORTNAME.'_photo_item_custom_link'];
  												$photo_target = $_post_meta[MAX_SHORTNAME.'_photo_item_custom_link_target'];

  											}else{

  												// get the permalink for the photo post
  												$photo_link = get_permalink();

  											}
  										}
  									}

  								}
  							?>

  							<?php if ( has_post_thumbnail() || $isFullsizeVideo) {

  								if ( !empty($_post_meta[MAX_SHORTNAME.'_photo_item_type_value']) ){
  									$post_type = str_replace(" ", "_", strtolower($_post_meta[MAX_SHORTNAME.'_photo_item_type_value']));
  								}

  								if ( !empty( $meta[MAX_SHORTNAME.'_page_item_type_value']) && $isFullsizeVideo ){
  									$post_type = str_replace(" ", "_", strtolower($meta[MAX_SHORTNAME.'_page_item_type_value']));
  								}

  								$video_lightbox_value = "";
  								if ( $_post_meta[MAX_SHORTNAME.'_photo_item_type_value'] == 'lightbox' && !empty( $_post_meta[MAX_SHORTNAME . '_photo_lightbox_video_show'] ) && $show_title_link == "false" ) {
    								$video_lightbox_value = $_post_meta[MAX_SHORTNAME.'_photo_lightbox_video_show'];
  								}

  								// Store some values
  								$_background_color    = !empty($_post_meta[MAX_SHORTNAME . '_photo_item_background_color']) ? $_post_meta[MAX_SHORTNAME.'_photo_item_background_color'] : "";
  								$_video_embedded_url  = !empty($_post_meta[MAX_SHORTNAME . '_video_embeded_url_value']) ? $_post_meta[MAX_SHORTNAME.'_video_embeded_url_value'] : "";
  								$_video_poster_url    = !empty($_post_meta[MAX_SHORTNAME . '_video_url_poster_value']) ? $_post_meta[MAX_SHORTNAME . '_video_url_poster_value'] : "";
  								$_video_poster_value  = !empty($_post_meta[MAX_SHORTNAME . '_video_poster_value']) ? $_post_meta[MAX_SHORTNAME . '_video_poster_value'] : "";
  								$_video_url_m4v       = !empty($_post_meta[MAX_SHORTNAME . '_video_url_m4v_value']) ? $_post_meta[MAX_SHORTNAME.'_video_url_m4v_value'] : "";
  								$_video_url_ogv       = !empty($_post_meta[MAX_SHORTNAME . '_video_url_ogv_value']) ? $_post_meta[MAX_SHORTNAME.'_video_url_ogv_value'] : "";
                  $_video_url_webm      = !empty($_post_meta[MAX_SHORTNAME . '_video_url_webm_value']) ? $_post_meta[MAX_SHORTNAME.'_video_url_webm_value'] : "";
  								$_video_fill_value    = !empty($_post_meta[MAX_SHORTNAME . '_video_fill_value']) ? $_post_meta[MAX_SHORTNAME.'_video_fill_value'] : "";
                  $_show_more           = !empty($_post_meta[MAX_SHORTNAME . '_photo_item_fsg_link']) ? $_post_meta[MAX_SHORTNAME.'_photo_item_fsg_link'] : "" ;
                  $_video_lightbox      = $video_lightbox_value;

                  // function to encode the excerpt properly
                  if ( function_exists('json_encode') ) {
                    $encoded_excerpt = json_encode(get_the_excerpt());
                    if( preg_match('/^"(.*)"$/', $encoded_excerpt, $matches) ) {
                      $encoded_excerpt = $matches[1];
                    }
                    $json_excerpt = $encoded_excerpt;
                  }

                  // get the link for the lightbox
                  $_lightbox_link = "";
                  if( $_post_meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] != 'photo' && $_video_lightbox == 'true'  ) :

                    switch($_post_meta[MAX_SHORTNAME.'_photo_lightbox_type_value']) {

                      case 'youtube' : $_lightbox_link = $_post_meta[MAX_SHORTNAME.'_photo_video_youtube_value']; // youtube lightbox link
                      break;

                      case 'vimeo' : $_lightbox_link = $_post_meta[MAX_SHORTNAME.'_photo_video_vimeo_value']; // vimeo lightbox link
                      break;

                      case 'custom' : $_lightbox_link = $_post_meta[MAX_SHORTNAME.'_photo_item_custom_lightbox']; // custom lightbox link
                      break;

                      default: $_lightbox_link = "";
                      break;

                    }

                  endif;

  								// Add a data string to store post meta information in a json format string
  								$data_add  = " data-url='{";
  								$data_add .= "\"type\":\"".$post_type."\",";
  								$data_add .= "\"postID\":\"".get_the_ID()."\",";
  								$data_add .= "\"excerpt\":\"". htmlentities($json_excerpt, ENT_QUOTES, "UTF-8") ."\",";
  								$data_add .= "\"permalink\":\"".$photo_link."\",";
  								$data_add .= "\"target\":\"".$photo_target."\",";
  								$data_add .= "\"more\":\"".$_show_more."\",";
  								$data_add .= "\"backgroundcolor\":\"".$_background_color."\",";
  								$data_add .= "\"embedded_code\":\"".$_video_embedded_url."\",";
  								$data_add .= "\"lightbox_video\":\"".$_video_lightbox."\",";
  								$data_add .= "\"lightbox_link\":\"".$_lightbox_link."\"";

  								if($post_type == 'selfhosted'){

  									 // Video Preview is an Imager from an URL
  									if($_video_poster_value == 'url'){
  										$data_add .= ",\"poster_url\":\"". $_video_poster_url ."\"";
  									}
  									// Video Preview is the post featured image or the URL was chosen but not set
  									if( $_video_poster_value == 'featured' || ( $_video_poster_value == 'url' && ($_video_poster_value == "" || !$_video_poster_url) ) ){
  										$data_add .= ",\"poster_url\":\"". wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ) ."\"";
  									}

  									$data_add .= ",\"url_m4v\":\"". $_video_url_m4v ."\",";
  									$data_add .= "\"url_ogv\":\"". $_video_url_ogv ."\",";
  									$data_add .= "\"url_webm\":\"". $_video_url_webm ."\",";
  									$data_add .= "\"stretch_video\":\"". $_video_fill_value ."\"";
  								}

  								$data_add .= "}'";

  								$_tim_width = false;
  								$_img_width = "";

  								// get the imgUrl for showing the post image
  								$_cropping = !empty($_post_meta[MAX_SHORTNAME.'_photo_cropping_direction_value']) ? $_post_meta[MAX_SHORTNAME.'_photo_cropping_direction_value'] : false;
  								$_item_type = !empty($_post_meta[MAX_SHORTNAME.'_photo_item_type_value']) ? str_replace(" ", "_", strtolower($_post_meta[MAX_SHORTNAME.'_photo_item_type_value'])) : "";

                  if( get_option_max('fullsize_use_square') == 'true' ){
                    // get the squared images
  								  $_tim_width = get_option_max('fullsize_thumb_height');
  									$_img_width = 'width="'.get_option_max('fullsize_thumb_height').'"';
  								  $imgUrl = max_get_custom_image_url(get_post_thumbnail_ID(get_the_ID()), get_the_ID(), $_tim_width, get_option_max('fullsize_thumb_height'), $_cropping );
  								}else{
                    // get the original image url
                    $imgUrl = max_get_image_path(get_the_ID(), 'mobile');
  								}

                  // get the thumbnail height
                  $thumb_height = get_option_max('fullsize_thumb_height');
                  // check if we are on a mobile device to reduce the thumbnail height
                  if ( $max_mobile_detect->isMobile() && !$max_mobile_detect->isTablet()) {
                    // only resize if the height is large than 50 to avoid too small thumbnails, otherwise use 50px
                    $thumb_height = $thumb_height / 2 <= 50 ? 50 :  get_option_max('fullsize_thumb_height') / 2;
                  }

  								?>
  								<a <?php echo $data_add ?> class="item <?php echo $_item_type .' '; echo $img_greyscale ?>" href="<?php echo $imgUrl_big; ?>" title="<?php the_title() ?>" data-1x="<?php echo $imgUrl_big ?>" data-2x="<?php echo $imgUrl_big ?>">

                    <?php
                    // check for image source on lazy load
                    if( get_option_max('fullsize_lazyload_thumbnails') == 'true' )
                    {
                      $image_source = get_template_directory_uri()."/images/dummy-image.jpg";
                      $data_src     = ' data-src="'.$imgUrl.'"';
                    } else {
                      $image_source = $imgUrl;
                      $data_src     = '';
                    }
                    ?>

  									<img src="<?php echo $image_source; ?>"<?php echo $data_src; ?> height="<?php echo $thumb_height ?>" <?php echo $_img_width ?> class="is-thumb img-color" title="<?php strip_tags(the_title()) ?>" alt="<?php if(get_the_excerpt()){ echo strip_tags(get_the_excerpt()); }else{ echo strip_tags(get_the_title()); } ?>" data-1x="<?php echo $imgUrl ?>" />
  									<span class="overlay" data-title="<?php strip_tags( the_title() ); ?>"></span>
  								</a>
  							<?php }	?>

  						<?php endif; ?>

  					  <?php endwhile; ?>

  						<?php endif; ?>

						<?php endif; ?>
						<?php wp_reset_query() ?>

						<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
							<div class="scroll-bar"></div>
						</div>

					</div><!-- // end of #fullsize -->

				</div><!--// #thumbnailContainer -->

			</div>

		</div><!--// #thumbnails -->

		<?php if($_query_has_videos === true){ ?>
		<div id="superbgplayer" class="video-hide">
			<div id="superbgimageplayer" class="video-hide">
				<div id="youtubeplayer" class="video-hide"></div>
				<div id="vimeoplayer" class="video-hide"></div>
				<div id="selfhostedplayer" class="video-hide"></div>
			</div>
		</div>
		<?php } ?>

		<script type="text/javascript">

			var isLoaded            = false,
			    isMobile            = false,
          $fullsize           = jQuery('#fullsize'),
          $fullsizetimer      = jQuery('#fullsizeTimer'),
          $superbgimage       = jQuery('#superbgimage'),
          $superbgimageplayer = jQuery('#superbgimageplayer'),
          $fsg_playbutton     = jQuery('#fsg_playbutton'),
			    $showtitle          = jQuery('#showtitle'),
			    $branding           = jQuery('#branding'),
			    $scanlines          = jQuery('#scanlines');

			if(navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod'){
				var isMobile = true;
			}

			jQuery(function($){

				// Options for SuperBGImage
				jQuery.fn.superbgimage.options = {
					transition: <?php echo get_option_max('fullsize_transition') ?>,
					vertical_center: 1,
					slideshow: <?php if($autoplay == 'true' && $show_slideshow === true ){ ?> 1<?php }else{ ?> 0<?php } ?>,
					speed: '<?php echo get_option_max('fullsize_speed') ?>', // animation speed
					randomimage: 0,
					inlineMode: 0,
					preload: <?php echo $_preload_images ?>,
					slide_interval: <?php echo $slideshow_interval ?>, // invervall of animation
					<?php
					// check if more than one image is set as fullsize image
					if( $show_slideshow ) { ?>
					onClick: false, // function-callback click image
					onHide: superbgimage_hide, // function-callback hide image
					<?php }	?>
					onShow: superbgimage_show // function-callback show image
				};

				function checkTitleLeftMargin($div1, $div2){
          var x1 = $div1.offset().left;
          var y1 = $div1.offset().top;
          var h1 = $div1.outerHeight(true);
          var w1 = $div1.outerWidth(true);
          var b1 = y1 + h1;
          var r1 = x1 + w1;
          var x2 = $div2.offset().left;
          var y2 = $div2.offset().top;
          var h2 = $div2.outerHeight(true);
          var w2 = $div2.outerWidth(true);
          var b2 = y2 + h2;
          var r2 = x2 + w2;

          if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
          return true;
				}

				// Show thumnails if option is activated
				jQuery('#fullsize a' + "[rel='" + jQuery.superbg_imgActual + "']").livequery(function(){

						var dataUrl = jQuery(this).attr('data-url');
						window.videoUrl = jQuery.parseJSON( dataUrl );

						if( window.videoUrl.type != "selfhosted" || window.videoUrl.type != "youtube_embed" || window.videoUrl.type != "vimeo_embed" ){
							jQuery('#fullsize a' + "[rel='" + jQuery.superbg_imgActual + "']").expire();
						}

					});

					// function callback on clicking image, show next slide
					function superbgimage_click(img) {
						$fullsize.nextSlide();
						$fullsizetimer.startTimer( <?php echo $slideshow_interval ?> );
					}

					function superbgimage_hide(img) {

            // if page has video no-pointer-class remove it
            if( jQuery('#primary').hasClass('no-pointer-events') ) {
              jQuery('#primary').removeClass('no-pointer-events');
            }

            // hide the play button if visible
            if( !Modernizr.csstransitions ){
              $fsg_playbutton.fadeOut(250);
        		}else{
        		  if( !$fsg_playbutton.hasClass('fsg-playbutton-hide') ) {
          		  $fsg_playbutton.addClass('fsg-playbutton-hide');
          		}
        		}

            // add zIndex class
						jQuery('#main, #page').addClass('zIndex').unbind('click');

						$fsg_playbutton.add( jQuery('#main')).add(jQuery('#page') ).unbind('click touchstart touchend');
						$fullsizetimer.stopTimer();

						<?php // check if the fullsize overlay title text should be shown ?>
						<?php if ( get_option_max('fullsize_show_title') ){ ?>
						// hide/show title
						jQuery('#showtitle').removeClass('showtitle-visible');
						<?php } ?>


					}

					// function callback on showing image
					// get title and display it
					function superbgimage_show(img) {

        		// hide active superbgimage	and show the player iframe
            if( !Modernizr.csstransitions ){
              jQuery('#superbgimage').stop(false, true).fadeIn(250);
        		}else{
        		  jQuery('#superbgimage').removeClass('opacity-hide');
        		}

            // hide the previous loaded video containers
						jQuery('#superbgimageplayer, #superbgplayer').removeClass().addClass('video-hide');

            // remove all the video players from the respective containers
            jQuery('#youtubeplayer, #vimeoplayer, #selfhostedplayer').removeClass().addClass('video-hide').html('');

						jQuery('#main, #page').addClass('zIndex').unbind('click');

						var dataUrl = "";
						window.videoUrl = {};

						// Show scanlines only if not in fullscreen mode
						if( jQuery('#expander').hasClass('slide-up') ){
							if(isMobile === false){

							  if( !Modernizr.csstransitions ){
							    $scanlines.show().stop(false, true).animate({opacity: 1}, 450);
								}else{
  								$scanlines.removeClass('opacity-hide');
								}

							}
						}

						jQuery('#fullsize a' + "[rel='" + jQuery.superbg_imgActual + "']").livequery(function(){

							dataUrl = jQuery(this).attr('data-url');
							window.videoUrl = jQuery.parseJSON(dataUrl);

							// change the background color of the body
							if(window.videoUrl.backgroundcolor != ""){
								jQuery('#superbgimage, #superbgimageplayer ').css({backgroundColor: window.videoUrl.backgroundcolor });
							}

							// add alt tag and ken burns to current fullsize gallery image
							jQuery('#superbgimage img.activeslide')
								.attr('alt', window.videoUrl.excerpt);

							if( window.videoUrl.type == "selfhosted" || window.videoUrl.type == "youtube_embed" || window.videoUrl.type == "vimeo_embed" ){

								<?php if(get_option_max('fullsize_autoplay_video') == 'true'){	?>
								jQuery('#fullsize').stopSlideShow();
								<?php } ?>

                // resize the superbgimage container
                $superbgimage.superbgResize();

                // block UI to make the thumbnails unclickable until video is loaded
                jQuery.blockUI.defaults.css = {};
                jQuery.blockUI({
                  message: $('#my-loading'),
                  overlayCSS:  {
                    backgroundColor: 'transparent',
                    opacity: .5,
                    cursor: 'wait'
                  }
                });

								$.getScript("<?php echo get_template_directory_uri(); ?>/js/post-video.js", function(data, textStatus, jqxhr){
									jQuery('#superbgimageplayer, #superbgplayer').removeClass('video-hide');
								})

							}else{

                // hide the play button if visible
                if( !Modernizr.csstransitions ){
                  $fsg_playbutton.fadeOut(250);
            		}else{
            		  if( !$fsg_playbutton.hasClass('fsg-playbutton-hide') ) {
              		  $fsg_playbutton.addClass('fsg-playbutton-hide');
              		}
            		}

                // get back the scanlines
								if( jQuery('#expander').hasClass('slide-up') && isMobile === false ){

  							  if( !Modernizr.csstransitions ){
  							    $scanlines.show().stop(false, true).animate({opacity: 1}, 450);
  								}else{
    								$scanlines.removeClass('opacity-hide');
  								}

								}

								if( jQuery.fn.superbgimage.options.slideshow == 1 ){
									jQuery.fn.superbgimage.options.slide_interval = <?php echo $slideshow_interval ?>;
									$fullsizetimer.startTimer( <?php echo $slideshow_interval ?> );
									$fullsize.startSlideShow();
								}

							}

							<?php
							// check if the fullsize overlay title text should be shown
							if ( get_option_max('fullsize_show_title') ){
              ?>

  							// change title and show
  							jQuery('#showtitle span.imagetitle a').html( jQuery('#thumbnails a' + "[rel='" + img + "'] img").attr('title') );

                if( $showtitle.size() && $branding.size() ){
                  var collision = checkTitleLeftMargin( $showtitle, $branding );
                  if( collision ) {
                    if( !$showtitle.hasClass('showtitle-left-margin') ) $showtitle.addClass('showtitle-left-margin');
                  }else{
                    if( $showtitle.hasClass('showtitle-left-margin') ) $showtitle.removeClass('showtitle-left-margin');
                  }
                }

  							<?php
  							// Add margin to showtitle to prevent overlay of active sidebar
  							if( ( is_home() ) || ( $isFullsizeGallery === true && is_active_sidebar('sidebar-fullsize-gallery') )	){
  							?>
    							jQuery(window).smartresize(function() {

                    if( $showtitle.size() && $branding.size() ){
                      var collision = checkTitleLeftMargin( $showtitle, $branding );
                      if( collision ) {
                        if( !$showtitle.hasClass('showtitle-left-margin') ) $showtitle.addClass('showtitle-left-margin');
                      }else{
                        if( $showtitle.hasClass('showtitle-left-margin') ) $showtitle.removeClass('showtitle-left-margin');
                      }
                    }

                  })
  							<?php
  							}
  							?>

  							<?php if ( get_option_max('fullsize_show_title_excerpt') == 'true' ){ ?>
  							if(window.videoUrl.excerpt != ""){
  								jQuery('#showtitle span.imagecaption')
  									.html( window.videoUrl.excerpt ).removeClass('hidden');
  							}else{
  								jQuery('#showtitle span.imagecaption').addClass('hidden');
  							}
  							<?php } ?>

                /* change full size gallery title links
                 *
                 * @desc  Shows lightbox videos in a full size gallery
                 * @since Invictus 3.0
                 *
                 */

                if( !jQuery('#responsiveTitle').hasClass('hidden') ){
                  jQuery('#responsiveTitle').addClass('hidden');
                }else{
                  jQuery('#responsiveTitle').removeClass('hidden');
                }

  							if( window.videoUrl.lightbox_video == "true" && window.videoUrl.lightbox_link != "" ) {
                  // change the link on the title and more link for showing a lightbox
                  jQuery('#showtitle div a, #responsiveTitle a').attr({'href': window.videoUrl.lightbox_link, 'target': "", 'data-rel': 'prettyPhoto' });
                }else{
                  // change the title href link or add a lightbox link
    							jQuery('#showtitle div a, #responsiveTitle a').attr({ 'href': window.videoUrl.permalink, 'target' : window.videoUrl.target }).removeAttr('data-rel').unbind('click');
                }

  							jQuery('#showtitle .imagecount').html(img + '/' + jQuery.superbg_imgIndex);

                // check if more link should be shown
                if(window.videoUrl.more != 'true'){
                  jQuery('#showtitle .more').hide();
                }else{
                  jQuery('#showtitle .more').show();
                }

  							if(jQuery(window).width() >= 481){
  								jQuery('#showtitle').addClass('showtitle-visible');
  							}else{
    							jQuery('#showtitle').removeClass('showtitle-visible');
  							}

  						<?php } ?>

						})

					}

					// stop slideshow
					jQuery('#fullsizeStop').livequery('click',function() {

						jQuery.fn.superbgimage.options.slideshow = 0;
						$fullsizetimer.stopTimer();
						jQuery('#fullsize').stopSlideShow();

						// show/hide controls
						jQuery(this).parent().toggleClass('fullsize-playing');

						return false;

					});

					// start slideshow
					jQuery('#fullsizeStart:not(.disabled)').livequery('click', function() {

						jQuery.fn.superbgimage.options.slideshow = 1;

						// show/hide controls
						jQuery(this).parent().toggleClass('fullsize-playing');

						jQuery.fn.superbgimage.options.slide_interval = <?php echo $slideshow_interval ?>;
						$fullsizetimer.startTimer( <?php echo $slideshow_interval ?> );
						$fullsize.startSlideShow();

						return false;

					});

				jQuery('body').addClass('fullsize-gallery');

			});

		</script>
