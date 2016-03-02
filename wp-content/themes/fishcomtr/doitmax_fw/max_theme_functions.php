<?php
/* Option related functions

/*-----------------------------------------------------------------------------------*/
/*	Get your custom logo
/*-----------------------------------------------------------------------------------*/

function max_get_custom_logo() {


	if( get_option_max('custom_logo') != '' || get_option_max('custom_footer_logo') != '' ) {
		$output = "	<style type=\"text/css\">\n";

		if(get_option_max('custom_logo') != '') {
			$output .= "#site-title a { background-image: url(". get_option_max('custom_logo') .") !important; }\n";
		}

		$output .= "</style>\n";

		echo $output;

	}

}
//add_action('wp_head', 'max_get_custom_logo');

/*-----------------------------------------------------------------------------------*/
/* Add the FavIcon to the Page
/*-----------------------------------------------------------------------------------*/

function max_get_favicon() {

	$output = "";

	?>
	<!-- Icons & Favicons (for more: http://themble.com/support/adding-icons-favicons/)
	================================================== -->
	<?php

	// Default favicon
	if ( get_option_max('custom_favicon') != '') :
		$output .= '<link rel="shortcut icon" href="'. get_option_max('custom_favicon') .'"/>';
	else :
		$output .= '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/favicon.png" />';
	endif;

	// iPhone favicons
	if ( get_option_max('custom_favicon_iphone') != '' ) :
		$output .= '<link rel="apple-touch-icon-precomposed" href="'. get_option_max('custom_favicon_iphone') .'">';
	endif;

	// iPad favicons
	if ( get_option_max('custom_favicon_ipad') != '' ) :
		$output .= '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'. get_option_max('custom_favicon_ipad') .'">';
	endif;

	// iPhone 4 Retina display
	if ( get_option_max('custom_favicon_iphone_2x') != '' ) :
		$output .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'. get_option_max('custom_favicon_iphone_2x') .'">';
	endif;

	// iPad Retina display
	if ( get_option_max('custom_favicon_ipad_2x') != '' ) :
		$output .= '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'. get_option_max('custom_favicon_ipad_2x') .'">';
	endif;

	echo $output;
}

add_action('wp_head', 'max_get_favicon');


/*-----------------------------------------------------------------------------------*/
/* Get prettyPhoto JS lightboxes
/*-----------------------------------------------------------------------------------*/

function max_get_prettyPhoto_js() {

	// write needed JS variables to document for further access
	wp_localize_script( 'prettyphoto', 'max_prettyphoto_vars', array(
		'nonce'                 => wp_create_nonce( 'max_prettyphoto_vars' ),
		'disable_lightbox'      => get_option_max( 'pretty_enable_lightbox', 'false' ),
		'allow_expand'          => get_option_max( 'pretty_allow_expand', 'false' ),
		'animationSpeed'        => get_option_max( 'pretty_speed', 'normal' ),
		'slideshow'             => get_option_max( 'pretty_interval', 350 ),
		'theme'                 => get_option_max( 'pretty_theme', 'dark_square' ),
		'show_title'            => get_option_max( 'pretty_title_show', 'false'),
		'overlay_gallery_max'   => get_option_max( 'pretty_thumbnail_limit', 30 ),
		'overlay_gallery'       => get_option_max( 'pretty_gallery_show', 'false'),
		'social_tools'          => get_option_max( 'pretty_social_tools', 'false' ),
	));

}

// check, if we have to add the prettyPhoto variables
if( get_option_max( "pretty_enable_lightbox", 'false' ) == 'false' ) :
	add_action('wp_head', 'max_get_prettyPhoto_js');
endif;

/*-----------------------------------------------------------------------------------*/
/* Change the Twitter widget layout
/*-----------------------------------------------------------------------------------*/

function max_get_twitter_js() {

	// get the body font
	$body_font = get_option_max( 'font_body' );

?>

<script type="text/javascript">
	jQuery(document).ready(function($){

		// Customize twitter feed
		var hideTwitterAttempts = 0,
				twitterLoaded = false,
				ibody;
		function hideTwitterBoxElements() {
				var twitterAttempts = setTimeout( function() {
						if ( $('[id*=twitter]').length ) {

							$('[id*=twitter]').each( function(){

									$(this).width( '100%' ); //override the width

									ibody = $(this).contents().find( 'body' );

									if ( ibody.find( '.timeline .stream .h-feed li.tweet' ).length ) {

										// change the body color
										ibody.find( 'html, body, h1, h2, h3, blockquote, p, ol, ul, li, img, iframe, button' ).css({ 'font-family': '<?php echo max_get_font_string( $body_font['font_family'] ); ?>', 'color': '<?php echo $body_font['font_color'] ?>' });

										// change the link color
										ibody.find('.thm-dark .p-author .profile .p-name').css({ 'color' : '<?php echo get_option_max( 'color_main_link' ) ?>' });

										// add a border bottom
										ibody.find('li.tweet').css({ 'border-bottom': '1px dotted' });

										twitterLoaded == true;

									} else {

										$(this).hide();

									}

							});

						}
						hideTwitterAttempts++;
						if ( hideTwitterAttempts < 3 && twitterLoaded === false ) {
								hideTwitterBoxElements();
						}
				}, 1500);
		}

		// somewhere in your code after html page load
		hideTwitterBoxElements();
	})

	</script>

<?php

}

/*-----------------------------------------------------------------------------------*/
/* Output Custom CSS from theme options
/*-----------------------------------------------------------------------------------*/

function max_custom_css() {

		$output = '';

		$css = get_option_max('custom_css');

		if ($css <> '') {
			$output .= $css . "\n";
		}

		// Output styles
		if ($output <> '') {
			$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}

}

add_action('wp_head', 'max_custom_css');

/*-----------------------------------------------------------------------------------*/
/*	Get Video JS
/*-----------------------------------------------------------------------------------*/

function max_get_video_js($post_id) {

	if(!empty($post_id)){
		$meta = max_get_cutom_meta_array($post_id);
	}

	// Video Preview is an Imager from an URL
	if($meta[MAX_SHORTNAME.'_video_poster_value'] == 'url'){
		$_poster_url = $meta[MAX_SHORTNAME.'_video_url_poster_value'];
	}

	// Video Preview is the post featured image or the URL was chosen but not set
	if( $meta[MAX_SHORTNAME.'_video_poster_value'] == 'featured' || ( $meta[MAX_SHORTNAME.'_video_poster_value'] == 'url' && $meta[MAX_SHORTNAME.'_video_poster_value'] == "" ) ){
		$_imgID = get_post_thumbnail_id(get_the_ID());
		$_previewUrl = max_get_image_path($post_id, 'full');

		// get the imgUrl for showing the post image
		$_poster_url = max_get_custom_image_url(get_post_thumbnail_ID(get_the_ID()), get_the_ID(), MAX_CONTENT_WIDTH );

	}

	$_m4v = $meta[MAX_SHORTNAME.'_video_url_m4v_value'];
	$_ogv = $meta[MAX_SHORTNAME.'_video_url_ogv_value'];
	$_webm = $meta[MAX_SHORTNAME.'_video_url_webm_value'];

	echo do_shortcode('[video width="'. MAX_CONTENT_WIDTH .'" height="'.$meta[MAX_SHORTNAME.'_video_height_value'].'" mp4="' . $_m4v .'" ogv="' . $_ogv . '" webm="' . $_webm . '" poster="' . $_poster_url .'"  controls="controls">]');

}

/*-----------------------------------------------------------------------------------*/
/*	Get Infinite Scroll JS
/*-----------------------------------------------------------------------------------*/

function max_get_infinitescroll_js() {
?>
	<script type="text/javascript">

		//<![CDATA[
		jQuery(document).ready(function($) {

			var $container   = jQuery('#portfolioList'),
					$pagination  = jQuery('.pagination');

					// hide pagination
					$pagination.hide();

			if(jQuery('.pagination').size() > 0){

				jQuery(window).load(function(){

					$container.infinitescroll({
						navSelector  : '.pagination',    // selector for the paged navigation
						nextSelector : '.pagination a',  // selector for the NEXT link (to page 2)
						itemSelector : '.portfolio-list li.item', // selector for all items you'll retrieve
						bufferPx     : 100,
						prefill      : true,
						loading: {
							msgText: '<?php _e('Loading new photos...', MAX_SHORTNAME) ?>',
							finishedMsg: 'No more photos to load.',
							img: '<?php echo get_template_directory_uri(); ?>/css/<?php echo get_option_max('color_main') ?>/loading.gif',
								selector: '.infscr-loading'
							}
						},

						// call Isotope as a callback
						function( newElements ) {

							$container.livequery(function(){
							})

							$( newElements ).find('img').imagesLoaded(function(){

								if( $container.data('isotope') ){
									$( newElements ).css({ width: $container.find('li:first').outerWidth() }); // set the width to the current first item width
									$container.isotope( 'appended', $( newElements ) ); // append item set to existing isotope
								}else{
									$container.append( $( newElements ) );
								}

								$container.css({ background: 'none' }).find('li.item').css({ visibility: 'visible' });

							});
						}
					);

				});

			}

		});
		//]]>
	</script>

<?php
}