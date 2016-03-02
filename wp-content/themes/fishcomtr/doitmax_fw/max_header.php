<?php


/*-----------------------------------------------------------------------------------*/
/*	Register and load common JS for various WordPress features.
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'max_add_scripts' ) ):

  function max_add_scripts() {

  	global $post;

  	// get the image we need for the different devices
  	$max_mobile_detect = new Mobile_Detect();
  	$_img_string = 'full';

  	if (!is_admin()) {

      $load_scripts = array('modenizr', 'fitvids', 'jquery-livequery', 'supersubs', 'blockUI', 'superfish', 'easing', 'superbgimage', 'tipsy');

      wp_register_script('jquery-ui-custom', get_template_directory_uri() .'/js/jquery-ui.min.js', 'jquery', '1.10.3'); // register the local file
  		wp_register_script('validation', get_template_directory_uri() . '/js/jquery.validate.js', 'jquery', '1.7', TRUE);
  		wp_register_script('modenizr', get_template_directory_uri() . '/js/modenizr.min.js', 'jquery', '2.6.1 ', FALSE);
  		wp_register_script('respond', get_template_directory_uri() .'/js/respond.min.js', 'jquery', '1.0', FALSE);

  		wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', 'jquery', '1.3', TRUE);
  		wp_register_script('jquery-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', 'jquery', '1.0', TRUE);
  		wp_register_script('jquery-livequery', get_template_directory_uri() . '/js/jquery.livequery.min.js', 'jquery', '1.1.1', FALSE);

  		// check, if we have to include prettyPhoto script
      if( get_option_max( "pretty_enable_lightbox", 'false' ) == 'false' ) :
        wp_register_script('prettyphoto', get_template_directory_uri() .'/js/prettyPhoto/jquery.prettyPhoto.js', 'jquery', '3.1.5', TRUE);
        $load_scripts[] = 'prettyphoto';
      endif;

  		wp_register_script('superbgimage', get_template_directory_uri() . '/js/jquery.superbgimage.min.js', 'jquery', MAX_VERSION);
  		wp_register_script('touchswipe', get_template_directory_uri() . '/js/jquery.touchswipe.min.js', 'jquery', '1.6.3', TRUE);
  		wp_register_script('iscroll', get_template_directory_uri() . '/js/iScroll.js', 'jquery', '4.2.5', TRUE);
  		wp_register_script('blockUI', get_template_directory_uri() . '/js/jquery.blockUI.js', 'jquery', '2.66.0', false);
  		wp_register_script('superfish', get_template_directory_uri() .'/js/superfish.js', 'jquery', '1.7.3', TRUE);
  		wp_register_script('supersubs', get_template_directory_uri() .'/js/supersubs.js', 'jquery', '0.3b', TRUE);

  		// check for iphone, ipad or other mobile devices
  		if( $max_mobile_detect->isMobile() || $max_mobile_detect->isTablet() ) {
  			wp_register_script('superfish-touch', get_template_directory_uri() .'/js/jquery.sftouchscreen.js', 'jquery', '3.1', true);
  		}

  		wp_register_script('tipsy', get_template_directory_uri() .'/js/tipsy/jquery.tipsy.min.js', 'jquery', '1.0.0a', TRUE);
  		wp_register_script('isotope', get_template_directory_uri() .'/js/jquery.isotope.min.js', 'jquery', '1.5.25', TRUE);
  		wp_register_script('infinitescroll', get_template_directory_uri() .'/js/jquery.infinitescroll.min.js', 'jquery', '2.0b2.120519', TRUE);
  		wp_register_script('galleria', get_template_directory_uri() .'/js/galleria/galleria-1.2.9.min.js', 'jquery', '1.2.9', TRUE);
  		wp_register_script('flickr-fullsize', get_template_directory_uri() .'/js/supersized.flickr.js', 'jquery', '1.1.2', false);
  		wp_register_script('fitvids', get_template_directory_uri() .'/js/jquery.fitvids.min.js', 'jquery', MAX_VERSION, false);

      wp_register_script('jquery-slides', get_template_directory_uri() .'/slider/slides/slides.min.jquery.js', 'jquery', MAX_VERSION, TRUE);
      wp_register_script('jquery-nivo', get_template_directory_uri() .'/slider/nivo/jquery.nivo.slider.js', 'jquery', MAX_VERSION, TRUE);
   		wp_register_script('jquery-kwicks', get_template_directory_uri() .'/slider/kwicks/jquery.kwicks.min.js', 'jquery', MAX_VERSION, true);
  		wp_register_script('jquery-tubeplayer', get_template_directory_uri() .'/js/jquery.tubeplayer.min.js', 'jquery', "1.1.7", TRUE);

  		wp_register_script('custom-superbgimage', get_template_directory_uri() .'/js/custom-superbgimage.js', 'jquery', MAX_VERSION, TRUE);
  		wp_register_script('custom-scroller', get_template_directory_uri() .'/js/custom-scroller.js', 'jquery', MAX_VERSION, TRUE);
  		wp_register_script('custom-script', get_template_directory_uri() .'/js/custom.js', $load_scripts, MAX_VERSION, TRUE );
      wp_register_script('cookie', get_template_directory_uri() .'/js/jquery.cookie.js', 'jquery', '1.3.1');

  		wp_enqueue_script( 'jquery' );
  		wp_enqueue_script( 'jquery-ui-custom' );

      if( get_option_max( 'menu_mega_menu', 'false' ) === 'true' ) :
        wp_enqueue_script( 'megamenu' );
      endif;

      // get the isotope javascript script
      if( is_page_template('template-grid-fullsize.php') ||
          is_page_template('template-sortable.php') ||
          is_page_template('template-flickr.php') ) :

          if ( !post_password_required() ) {
          	wp_enqueue_script('isotope');
          }

      endif;

      // load tubeplayer script on fullsize video template
      if( is_page_template('template-fullsize-video.php') ) :
        wp_enqueue_script('jquery-tubeplayer');
      endif;

      // load supergbimage scripts only on galleria page templates
      if( is_page_template('template-fullsize-gallery.php') ) :
      	wp_enqueue_script('jquery-mousewheel');
      	wp_enqueue_script('jquery-tubeplayer');
        wp_enqueue_script('custom-superbgimage');
      endif;

      // load galleria only on galleria page templates
      if( is_page_template('template-galleria.php') ) :
        wp_enqueue_script('galleria');
      endif;

      // load scripts only on flickr fullsize page templates
      if( is_page_template('template-fullsize-flickr.php') ) :
        wp_enqueue_script('flickr-fullsize');
      endif;

      // load scripts only on scroller page templates
      if( is_page_template('template-scroller.php') ) :

        // add some js variables to the scroller script
        $meta_scroller_height   = get_post_meta($post->ID, MAX_SHORTNAME.'_max_scroller_height', TRUE);
        $scroller_height        = !empty($meta_scroller_height) ? $meta_scroller_height : 0;

        // add scroller height to maxframe
        $localized_data['scroller_height'] = $scroller_height;

        wp_enqueue_script('jquery-mousewheel');
        wp_enqueue_script('custom-scroller');

        wp_localize_script('custom-scroller', 'maxframe', $localized_data);

      endif;

      // get the infiniteScroll Script if needed
      if( get_post_meta(get_the_ID(), MAX_SHORTNAME.'_page_infinite_scroll', true) ) {
        wp_enqueue_script('infinitescroll');
      }

  		// Load the allover needed scripts
  		if( $max_mobile_detect->isMobile() || $max_mobile_detect->isTablet() ) {
  			wp_enqueue_script('superfish-touch');
  			wp_enqueue_script('touchswipe');
  		}

  		if( get_option_max('splash_cookie_set') == 'true' ) :
  			wp_enqueue_script( 'cookie' );
  		endif;

  		wp_enqueue_script( 'custom-script' );

      // get the wp-content folder
      $wp_content_dir = explode('/', WP_CONTENT_DIR);

      /* create localized JS array */
      $localized_array = array(
        'nonce'                 => wp_create_nonce( 'max_custom_vars' ),
        'wp_content_dir'        => end( $wp_content_dir ),
        'wp_theme_dir'          => get_template_directory_uri(),
        'ajax'                  => admin_url( 'admin-ajax.php' ),
        'force_footer'          => get_option_max( 'mobile_show_footer' ),
        'footer_nav'            => get_option_max( 'mobile_show_footer_nav' )
      );

      // write content folder to js to make it accessible via JS
      wp_localize_script( 'custom-script', 'max_custom_vars', $localized_array);

  	}

  }

endif;

if ( ! function_exists( 'max_index_scripts' ) ) :

	// load the following scripts only on homepage
	function max_index_scripts() {
		if (is_home()){
			wp_enqueue_script('jquery-mousewheel');
			wp_enqueue_script('jquery-tubeplayer');
      wp_enqueue_script('custom-superbgimage');
		}
	}

endif;

if ( ! function_exists( 'max_ie_scripts' ) ) :

	// load the following scripts only when using IE - shame on you
	function max_ie_scripts() {
		global $is_IE;
		if($is_IE){
			wp_enqueue_script('respond');
		}
	}

endif;

if( !in_array( @$GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
  add_action('wp_enqueue_scripts', 'max_add_scripts');
  add_action('wp_enqueue_scripts', 'max_ie_scripts');
  add_action('wp_enqueue_scripts', 'max_index_scripts');
}

/*-----------------------------------------------------------------------------------*/
/*	Register and load common CSS for various WordPress features.
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'max_add_styles' ) ) :

  function max_add_styles() {

  	if ( !is_admin() ) {

      if( get_option_max( "pretty_enable_lightbox", 'false' ) == 'false' ) :
        wp_enqueue_style( 'prettyphoto', get_template_directory_uri().'/js/prettyPhoto/prettyPhoto.css', false, false );
      endif;
      wp_enqueue_style( 'responsive', get_template_directory_uri().'/css/responsive.css', false, false );
      wp_enqueue_style( 'custom', get_template_directory_uri().'/css/custom.css', false, false );
      wp_enqueue_style( 'headers', get_template_directory_uri().'/css/headers.css', false, false );
      wp_enqueue_style( 'fontawesome',  get_template_directory_uri().'/css/fonts/font-awesome.min.css', array(), '3.0.2' );

      if( get_option_max( 'menu_mega_menu', 'false' ) === 'true' ) :
        wp_enqueue_style( 'megamenu', get_template_directory_uri().'/css/megamenu.css', false, MAX_VERSION );
      endif;

      // load galleria only on galleria page templates
      if( is_page_template( 'template-galleria.php' ) ) :
        wp_enqueue_style( 'galleria-css', get_template_directory_uri().'/js/galleria/galleria.classic.css', false, false );
      endif;

      // get the color file
      if( !MAX_DEMO_MODE ) wp_enqueue_style( 'color-main', get_template_directory_uri().'/css/'.get_option_max('color_main', 'black').'.css' , false, MAX_VERSION );

  	}
  }

  if( !in_array( @$GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) :
    add_action('init', 'max_add_styles');
  endif;

endif;

?>