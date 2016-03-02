<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */

global $showSuperbgimage, $fromGallery, $taxonomy_name, $the_term, $post_terms, $isFullsizeGallery, $isPost, $isBlog, $main_homepage, $_query_has_videos, $isFullsizeFlickr, $infiniteScroll, $max_retina_sizes;

  $autoplay = '0';

  if( !is_home() && !$main_homepage && !$isFullsizeGallery ){
  	wp_reset_query();
  }

  $show_page_fullsize = get_post_meta(get_the_ID(), 'max_show_page_fullsize', true);

  // Check for WP-E-Commerce
  if (function_exists( 'is_plugin_active' ) ) :
  	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  	if(is_plugin_active( 'wp-e-commerce/wp-shopping-cart.php' ) && get_post_type() == 'wpsc-product'){
  		$showSuperbgimage = true;
  		$show_page_fullsize = true;
  	}
  endif;

  // Check for BBPress
  if( function_exists('is_bbpress') ) :
  	if( is_bbpress() === true ){
  		$showSuperbgimage = true;
  	}
  endif;

  // Check if social icons should be used
  if(get_option_max('social_use')=='true') :

  	global $social_array;

  	// Prepare Social network icons
  	$iconArray = array();
  	$iconUrl = array();
  	$iconPath = get_template_directory_uri()."/images/social/";
  	if( is_array( get_option_max('social_show') ) ){
  		foreach(get_option_max('social_show') as $index => $value) {
  			$iconArray[$index] = $value;
  			$iconUrl[$index] = get_option_max('social_'.$value);
  		}
  	}
  endif;

  ?>

	</div><!-- #main -->
</div><!-- #page -->

<?php
// Check to show the footer
$max_show_footer = get_option_max("footer_hide");
if( empty( $max_show_footer ) || $max_show_footer !== 'true' ) : ?>

<footer id="colophon" role="contentinfo">

	<span class="footer-info">
		<?php echo stripslashes( get_option_max('copyright') ) ?>
	</span>

	<?php

	// Check if we have to show the fullsize key nav icon
	if ( get_option_max('fullsize_key_nav') == "true" ){
		echo '<a href="#keynav" id="fullsizeKeynav" class="keynav tooltip" title="' .__('Use Keynav to navigate', MAX_SHORTNAME) .'"></a>';
	}

	// Check if social array is enabled
	if(get_option_max('social_use')=='true' && is_array(get_option_max('social_show'))){

	echo '<div id="sociallinks" class="clearfix">';

	// check if social bartender plugin is installed
	if( function_exists( 'social_bartender' ) ){
		social_bartender();
	}else{

		//Start the generated social network loop
		echo '<ul>';

		$blank = get_option_max('social_show_blank') == 'true' ? 'target="_blank"' : '';

		for ($iconCount = 0; $iconCount < count($iconArray); $iconCount++) {
			if ($iconArray[$iconCount] != "") {
				if ($iconUrl[$iconCount] !="") {
					echo '<li><a href="'.$iconUrl[$iconCount].'" title="'.$iconArray[$iconCount].'" '.$blank.' class="tooltip"><img alt="'.$iconArray[$iconCount].'" src="' . $iconPath . '' . $iconArray[$iconCount] . '.png" /></a></li>';
				}
			}
		}

		echo '</ul>';
	}

	echo '</div>';

	}

	if ( has_nav_menu( 'footer-navigation' ) ) { /* if menu location 'footer-navigation' exists then use custom menu */
		$footer_nav = get_option_max( 'mobile_show_footer_nav' );
		$show_footer_nav = !empty( $footer_nav ) ? $footer_nav : 'false';
	?>
	<span class="footer-navigation footer-navigation--<?php echo  $show_footer_nav; ?>">
	<?php wp_nav_menu( array( 'theme_location' => 'footer-navigation', 'menu_class' => 'footer-navigation', 'container' => '', 'walker' => new MaxFrameDefaultWalker() ) ); ?>
	</span>
	<?php }	?>

</footer><!-- #colophon -->
<?php endif; ?>

<?php if( ( $main_homepage === true || $isFullsizeGallery === true ) && !$isFullsizeFlickr )
	// get the thumbnails if the page is the homepage
	get_template_part( 'includes/scroller', 'thumbnails.inc' );
?>

<?php

	// check if it is not the homepage and get the random background image post
	if(!$isPost && !empty($post)){
		$imageURL = get_post_meta($post->ID, 'max_show_page_fullsize_url', true);
	}else{
		if($isBlog === true){
			$imageURL = get_post_meta($post->ID, MAX_SHORTNAME.'_show_page_fullsize_url', true);
		}else{
			$imageURL = get_post_meta($post->ID, MAX_SHORTNAME.'_show_page_fullsize_url_value', true);
		}
	}

if( !$isFullsizeGallery && !$isFullsizeFlickr ) {

  $page_id     = get_queried_object_id();

 	$_background_type = get_post_meta($page_id, 'max_show_page_fullsize_type', true);

	if( $_background_type == 'default') :  // check if default theme option is set

  	// get the theme option background type
    $_background_option = get_option_max('general_blog_background');

    if( $_background_option == 'slideshow' ) : // background is set to slideshow so get the gallery id's from the option set and reset the background type to slideshow

      $_option_gallery_array = get_option_max('general_blog_background_galleries');

      // loop through selected galleries to create a wellformed id array
      $_gallery_array = array();
      foreach($_option_gallery_array as $index => $value) :
        $_gallery_array[$value] = $value;
      endforeach;

      $_background_type = 'slideshow';

    elseif ( $_background_option == 'single' ) : // background is set to single image so get the single image url and reset the background type to single

      // get the url from the option
      $imageURL = get_option_max('general_blog_background_image');
      $_background_type = 'single';
      $_gallery_array = "";

    endif;

	else :

	  // use the galleries from page meta settings
	  if(!empty($post)) {
  	  $_gallery_array = get_post_meta($post->ID, 'max_show_page_fullsize_gallery', true);
    }

  endif;

	if ( ( !is_home() && $show_page_fullsize == 'true' ) || $showSuperbgimage === true ){

		// Check if we have to choose a images from current gallery
		if( $fromGallery !== true ){

			if( is_array($_gallery_array) && count($_gallery_array) > 0 ){

				if($_background_type == 'single'){
					$random_post = max_query_term_posts( 1, $_gallery_array, 'gallery', 'rand' );
				}

				if($_background_type == 'slideshow'){
					$autoplay = '1';
					$random_post = max_query_term_posts( -1, $_gallery_array, 'gallery', 'rand' );
				}

			}else if( $imageURL == "" ){

				if( !$taxonomy_name )
				{
					$random_post = max_query_term_posts( 1, get_option_max('fullsize_featured_cat'), 'gallery', 'rand' );
				}
				else
				{
					$random_post = max_query_term_posts( 1, $the_term->term_id, 'gallery', 'rand' );
				}
			}

		}

		// reset the query
		wp_reset_query();


?>
		<div id="superbgimage">

			<?php

  		if( $isPost === true && ( get_post_meta($post->ID, MAX_SHORTNAME.'_show_post_fullsize_value', true) == 'true' || get_post_meta($post->ID, 'max_show_page_fullsize', true) == 'true' ) ) {

    		if($_background_type == 'slideshow' && !empty($_background_type) && !is_category() && !is_tax() && !is_archive() && !is_404() && !is_tag() && !is_search() ) {

          // get the current gallery terms
          if(get_post_type() == POST_TYPE_GALLERY) :
            $_gallery_terms = wp_get_post_terms($post->ID, GALLERY_TAXONOMY);
          endif;

          // build the gallery term array
          if(!empty($_gallery_terms)) :
            foreach($_gallery_terms as $index => $value) :
              $_gallery_array[$value->term_id] = $value->term_id;
            endforeach;
          endif;

  				 // query the posts
					$random_post = max_query_term_posts(-1, $_gallery_array, POST_TYPE_GALLERY, 'rand' );

					$autoplay = '1';

					if (have_posts()) : while (have_posts()) : the_post();

						// Random image from featured homepage gallery
						$imgUrl_temp = max_get_post_image_url(get_the_ID(), "full");
						$imgUrl = $imgUrl_temp[0];

						echo '<a class="item" href="'. $imgUrl .'"></a>';

					endwhile;
					endif;

				}else if( $_background_type == 'single' || empty($_background_type) || !isset($_background_type) ){

					// Random image from post gallery
					if(get_post_meta($post->ID, MAX_SHORTNAME.'_show_random_fullsize_value', true) == 'true'){

            // get the current gallery terms
            if(get_post_type() == "gallery") :
              $term_array = wp_get_post_terms($post->ID, GALLERY_TAXONOMY);
            endif;

            // build the gallery term array
            foreach($term_array as $index => $value) :
              $term_id_array[$value->term_id] = $value->term_id;
            endforeach;

						$random_post = max_query_term_posts(1, $term_id_array, 'gallery', 'rand' );

						// No image url set => show featured image
						$imgUrl_temp = max_get_post_image_url($random_post[0]->ID, "full");
						$imgUrl = $imgUrl_temp[0];

					}else{

						if($imageURL == ""){

							// No image url set => show featured image
							$imgUrl_temp = max_get_post_image_url($post->ID, "full");
							$imgUrl = $imgUrl_temp[0];

						}else{
							// Image url is set
							$imgUrl = $imageURL;
						}

					}

				}

			}
			?>

			<?php
			$img_output = "";

			// Get Background image for pages
			if( $show_page_fullsize == 'true' && !$isPost ){

				if( $_background_type == 'slideshow' && $random_post && !is_category() && !is_tax() && !is_archive() && !is_404() && !is_tag() && !is_search() ){

  				$random_post = max_query_term_posts( -1, $_gallery_array, 'gallery', 'rand' );

					if (have_posts()) : while (have_posts()) : the_post();

						// Random image from featured homepage gallery
						$imgUrl_temp = max_get_post_image_url(get_the_ID(), "full");
						$imgUrl = $imgUrl_temp[0];

            echo '<a class="item" href="'. $imgUrl .'"></a>';

					endwhile;
					endif;

				}else{

					if( $imageURL == "" ){

						// Random image from featured homepage gallery
						$imgUrl_temp = max_get_post_image_url($random_post[0]->ID, "full");
						$imgUrl = $imgUrl_temp[0];

					}else{

						// show image from entered URL
						$imgUrl = $imageURL;

					}

				}

			}

			wp_reset_query();

			/** Its an archive page **/
			if(is_archive()) {
				$imgUrl = get_option_max('page_background_archive');
			}

			/** Its a 404 page **/
			if(is_404()) {
				$imgUrl = get_option_max('page_background_404');
			}

			/** Its a tag archive page **/
			if(is_tag()) {
				$imgUrl = get_option_max('page_background_tag');
			}

			/** Its an search result page **/
			if(is_search()) {
				$imgUrl = get_option_max('page_background_search');
			}

			/** Its a category page **/
			if(is_category()) {
				$imgUrl = get_option_max('page_background_category');
			}

			/** Its a taxonomy page **/
			if(is_tax()) {
				$imgUrl = get_option_max('page_background_taxonomy');
			}

			/** Its a attachment page */
			if(is_attachment()) {

  			// get the current attachment image as background
  			if(get_option_max('page_background_attachment') == 'true') {
				  echo wp_get_attachment_image( $post->ID, 'full' ); // filterable image width with, essentially, no limit for image height.
    			$imgUrl = $next_attachment_url;
  			}else{
  			  // get the image url set in the options
    			if( get_option_max('page_background_taxonomy') != "") :
      		  $imgUrl = get_option_max('page_background_taxonomy');
    		  endif;
  			}

			}

			if( !empty($imgUrl) && ( empty($_background_type) || $_background_type != 'slideshow') ){

				$img_output = '<a class="item" href="'. $imgUrl .'"></a>';

			}else{
  			$img_output = '';
			}

			echo $img_output;

			?>

		</div>

		<script>

			jQuery(function($){
				// Options for SuperBGImage
				$.fn.superbgimage.options = {
					<?php if( $_background_type == 'slideshow' ){ ?>
					slide_interval: <?php echo get_post_meta($post->ID, 'max_show_page_fullsize_interval', true) ?>,
					<?php } ?>
					slideshow: <?php echo $autoplay; ?>, // 0-none, 1-autostart slideshow
					randomimage: 0,
					preload: 0,
					z_index: 5
				};

				// initialize SuperBGImage
				$('#superbgimage').superbgimage().hide();

			});

		</script>

  <?php }
  }
  ?>

  <?php
  	// Get Google Analyric Code if set in options menu
  	$google_id = get_option_max('google_analytics_id');
  	if(!empty($google_id)){

  		// including the google anylytics template google-analytics.inc.php
  		get_template_part( 'includes/google', 'analytic.inc' );

  	}

  ?>
  <?php wp_footer(); ?>

  <script type='text/javascript' src='http://a.vimeocdn.com/js/froogaloop2.min.js'></script>

  <?php
  if(!empty($post)) {
    // get infinite scroll JS if needed
    $infinite_scroll_meta = get_post_meta($post->ID, MAX_SHORTNAME.'_page_infinite_scroll', TRUE);
    if( !empty( $infinite_scroll_meta ) && $infinite_scroll_meta == 'true' && $infiniteScroll === true  ){
      max_get_infinitescroll_js();
      echo '<div class="infscr-loading"></div>';
    }
  }
  ?>

	<!-- the loader -->
	<div id="my-loading" style="display:none;">
		<div><i class="fa fa-spinner fa-spin"></i><span><?php _e('Loader', MAX_SHORTNAME) ?></span></div>
	</div>

</body>
</html>