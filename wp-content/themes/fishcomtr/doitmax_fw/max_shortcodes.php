<?php
/**
 * Shortcodes for theme
 *
 * @since maxFrame 1.0
 */

/*-----------------------------------------------------------------------------------*/
/*	Typography Shortcodes
/*-----------------------------------------------------------------------------------*/

//*** Highlight Shortcode @done ***/
if ( ! function_exists( 'max_highlight_shortcode' ) ):

  function max_highlight_shortcode($atts, $content) {
  	extract(shortcode_atts(array(
  		'type' => 'dark',
  	), $atts));
  	return '<span class="highlight-'.esc_attr($type).'">'.do_shortcode($content).'</span>';
  }

endif;

add_shortcode('highlight', 'max_highlight_shortcode');


//*** Blockquote Shortcodes @done ***/
if ( ! function_exists( 'max_blockquote_shortcode' ) ):

  function max_blockquote_shortcode($atts, $content) {
     extract( shortcode_atts( array(
     'author' => '',
  	), $atts ) );
  	return '<blockquote>'.do_shortcode($content).'<span class="author">'.esc_attr($author).'</span></blockquote>';
  }

endif;

add_shortcode('blockquote', 'max_blockquote_shortcode');


//*** Dropcap @done ***/
if ( ! function_exists( 'max_dropcap_shortcode' ) ):

  function max_dropcap_shortcode($atts, $content) {
  	extract(shortcode_atts(array(
  		'type' => 'default'
  	), $atts));

  	$fc = substr($content, 0, 1);
  	$length = strlen($content);
  	$rest = substr($content, 1, $length);

  	$add_class = "";

  	if(esc_attr($type) != ""){
  		$add_class = " dropcap-".esc_attr($type);
  	}

  	$html = '<span class="dropcap'.$add_class.'">'.$fc.'</span>';
  	$html.= do_shortcode($rest);

  	return $html;
  }

endif;

add_shortcode('dropcap', 'max_dropcap_shortcode');


//*** Tipsy ToolTip Shortcode @done ***/
if ( ! function_exists( 'max_tipsy_tooltip_shortcode' ) ):

  function max_tipsy_tooltip_shortcode($atts, $content) {
  	extract(shortcode_atts(array(
  		'url' => '',
  		'title' => '',
  		'target' => '_self'
  	), $atts));
  	return '<a href="'.esc_attr($url).'" class="tooltip" title="'.esc_attr($title).'" self="'.esc_attr($target).'" >'.html_entity_decode(strip_tags($content)).'</a>';
  }

endif;

add_shortcode('tooltip', 'max_tipsy_tooltip_shortcode');


//*** Horizontal divider line Shortcode @done***/
if ( ! function_exists( 'max_horizontal_line_shortcode' ) ):

  function max_horizontal_line_shortcode($atts, $content) {
  	extract(shortcode_atts(array(
  		'top' => 0,
  		'bottom' => 18,
    ), $atts ) );

  	return '<hr class="shortcode" style="margin-top:'.esc_attr($top).'px; margin-bottom:'.esc_attr($bottom).'px" />';
  }

endif;

add_shortcode('hr', 'max_horizontal_line_shortcode');


//*** Lists Shortcode ***/
if ( ! function_exists( 'max_list_shortcode' ) ):

  function max_list_shortcode($atts, $content) {
  	extract(shortcode_atts(array(
  		'type' => '',
  	), $atts));
  	return '<ul class="'.esc_attr($type).'">'.do_shortcode($content).'</ul>';
  }

endif;

add_shortcode('list', 'max_list_shortcode');


//*** Arrowed list Shortcodes ***/
if ( ! function_exists( 'max_list_with_arrows' ) ):

  function max_list_with_arrows($atts, $content) {
  	return '<ul class="arrows">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
  }

endif;

add_shortcode('list_arrow', 'max_list_with_arrows');

/*-----------------------------------------------------------------------------------*/
/*	Box Shortcodes
/*-----------------------------------------------------------------------------------*/

//*** Box with headline @done ***/
function box_with_headline_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'type' => 'default',
		'title' => 'This is the info box title',
	), $atts));

	if(esc_attr($title) != ""){
		$has_title = true;
	}else{
		$has_title = false;
	}

	$output  = "";
	$output .= '<div class="info-box info-' .esc_attr($type). '">';
	$output .= $has_title === true ? '<div class="box-title">'.esc_attr($title).'</div>' : "";
	$output .= '<div class="box-content"><p>' . html_entity_decode(do_shortcode($content)) . '</p>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('box_info', 'box_with_headline_shortcode');


//*** Toggle box @done ***/
function toggle_box_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'type' => 'default',
		'title' => 'Your Title',
		'state' => 'open'
	), $atts));

	if(esc_attr($type) != ""){
		$type = " toggle-".esc_attr($type);
	}

	$output  = "";
	$output .= '<div data-id="'.$state.'" class="clearfix toggle toggle-box' .$type. '">';
	  $output .= '<div class="box-title"><a href="#">'.esc_attr($title).'</a></div>';
    $output .= '<div class="toggle-inner box-content">';
      $output .= '<div class="box-inner">' . html_entity_decode(do_shortcode($content)) . '</div>';
    $output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('toggle_box', 'toggle_box_shortcode');


//*** Old Tabs shortcode ***/
function tabs_shortcode($atts, $content) {
	global $mytab_cnt_1, $mytab_cnt_2;

	extract(shortcode_atts(array(
    ), $atts));

	$mytab_cnt_1++;
	$mytab_cnt_2++;
	$cnt = 1;

	$output = "";

	$output .= '<div class="clearfix"><div class="tabs"><div class="tab-wrapper">';
	$output .= '<ul class="nav">';

	foreach ($atts as $tab) {
		$output .= '<li><a title="' .$tab. '" href="#tab-' . $mytab_cnt_1 . '">' .$tab. '</a></li>';
		$mytab_cnt_1++;
		$cnt++;
	}
	$output .= '</ul>';

	$output .= do_shortcode($content);
	$output .= '</div></div></div>';

	return $output;
}
add_shortcode('tabs', 'tabs_shortcode');


//*** Old Tabpane shortcode ***/
function tab_panes_shortcode( $atts, $content = null ) {
	global $mytab_cnt_2;

	extract(shortcode_atts(array(
    ), $atts));

	$output = "";
	$output .= '<div class="tab" id="tab-' . $mytab_cnt_2 . '"><div class="inner">' . do_shortcode($content) .'</div></div>';
	$mytab_cnt_2++;

	return $output;
}
add_shortcode('tab_pane', 'tab_panes_shortcode');


//*** New Tabs shortcode @done ***/
if (!function_exists('max_tabs')) {
	function max_tabs( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );

		// Extract the tab titles for use in the tab widget.
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }

		$output = '';

		if( count($tab_titles) ){
		    $output .= '<div id="tabs-'. rand(1, 100) .'" class="tabs"><div class="tab-wrapper">';
        $output .= '<ul class="nav clearfix">';

			foreach( $tab_titles as $tab ){

				$output .= '<li><a title="' .$tab[0]. '" href="#tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}

		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div></div>';
		} else {
			$output .= do_shortcode( $content );
		}

		return $output;
	}
	add_shortcode( 'tab_box', 'max_tabs' );
}

//*** New Tabpane shortcode @done ***/
if (!function_exists('max_tab')) {
	function max_tab( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );

		return '<div id="tab-'. sanitize_title( $title ) .'" class="tab"><div class="inner">'. do_shortcode( $content ) .'</div></div>';
	}
	add_shortcode( 'tab', 'max_tab' );
}


/*-----------------------------------------------------------------------------------*/
/*	Media Shortcodes
/*-----------------------------------------------------------------------------------*/

//*** Image Float Shortcode @done ***/
function image_float_shortcode($atts, $content) {

	global $blog_id;

	extract(shortcode_atts(array(
		'url' => '',
		'width' => '',
		'height' => '',
		'type' => 'left',
		'title' => '',
		'gallery' => '',
		'crop' => 'c',
		'lightbox' => 'false'), $atts));

	$_gal = '';
	$_esc_gallery = esc_attr($gallery);
	if( 'true' == $_esc_gallery ){
		$_gal = '[galPretty]';
	}

	if(!empty($crop)){

		if (isset($blog_id) && $blog_id > 0) {
			$imageParts = explode('/files/', $url);
			if (isset($imageParts[1])) {
				$src = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
			}
		}

		// get the new image width calculation if no height or width is set
  	if($width == 0) $width = "";
  	if($height == 0) $height = "";

		$src = theme_thumb(esc_attr($url), esc_attr($width), esc_attr($height), $crop );

	}else{
		$src = theme_thumb(esc_attr($url), esc_attr($width), esc_attr($height), false );
	}

	$html  = '<div class="image-'.$type.'">';
	if($lightbox == 'true') $html .= '<a class="pretty_image" data-link="'.esc_attr($url).'" href="'.esc_attr($url).'" data-rel="prettyPhoto'.$_gal.'" title="'.$content.'">';
	$html .= '<img src="'.$src .'" width="'.esc_attr($width).'" height="'.esc_attr($height).'" alt="'.esc_attr($title).'" class="fade-image" />';
	if($lightbox == 'true') $html .= '</a>';
	if($content) $html .= '<span class="caption">'.$content.'</span>';
	$html .= '</div>';
	return $html;
}
add_shortcode('image_float', 'image_float_shortcode');

//*** PrettyPhoto Gallery @done ***/
function pretty_gallery_shortcode($atts, $content = null) {

   extract( shortcode_atts( array(
      'width'   => '',
      'height'  => '',
      'gallery' => '',
      'class'   => 'pretty-gallery',
      ), $atts ) );

      // get the available shortcodes
      $pattern = get_shortcode_regex();
      $loop = "";

      if (   preg_match_all( '/'. $pattern .'/s', $content, $matches )
          && array_key_exists( 2, $matches )
          && in_array( 'pretty_image', $matches[2] ) )
      {

          // lets replace our width, height & gallery placeholder
          $sc_placeholder = array("{{width}}", "{{height}}", "{{gallery}}");
          $sc_attributes  = array(esc_attr($width), esc_attr($height), esc_attr($gallery));

          // loop through the shortcodes and append them to the loop
          foreach($matches[0] as $sc) {
            $sc = str_replace($sc_placeholder, $sc_attributes, $sc);
            $loop .= do_shortcode($sc);
          }

      }

   return '<div class="clearfix '.esc_attr($class).'">'.$loop.'</div>';
}
add_shortcode( 'pretty_gallery', 'pretty_gallery_shortcode' );

//*** Single Pretty Image @done ***/
function pretty_image_shortcode($atts, $content = null) {

  $use_timthumb = get_option_max('image_use_timthumb');

	extract(shortcode_atts(
		array ('url'   => '',
			   'width'   => '',
			   'height'  => '',
 			   'crop'    => 'c',
			   'title'   => '',
			   'src'     => '',
			   'gallery' => '')
		, $atts));

	$_gal = '';
	$_esc_gallery = esc_attr($gallery);
	if( '' != $_esc_gallery ){
		$_gal = '['.$_esc_gallery.']';
	}

  // check for custom src url
  if( esc_attr($src) != "" ) :
    $crop_url = esc_attr($src);
  else :
    $crop_url = $url;
  endif;

	if( !empty($crop) ){

		if (isset($blog_id) && $blog_id > 0) {
			$imageParts = explode('/files/', $crop_url);
			if (isset($imageParts[1])) {
				$src = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
			}
		}

		// get the new image width calculation if no height or width is set
  	if($width == 0) $width = "";
  	if($height == 0) $height = "";

    if($use_timthumb == 'true') {
      $src = get_template_directory_uri().'/timthumb.php?src='. $crop_url . '&amp;h=' . $height . '&amp;w=' . $width .  '&amp;a=' . $crop . '&amp;q=100';
    }else{
      $src = theme_thumb( esc_attr($crop_url), esc_attr($width), esc_attr($height), $crop );
    }

	}else{

    if($use_timthumb == 'true') {
      $src = get_template_directory_uri().'/timthumb.php?src='. $crop_url . '&amp;h=' . $height . '&amp;w=' . $width .  '&amp;q=100';
    }else{
      $src = theme_thumb( esc_attr($crop_url), esc_attr($width), esc_attr($height), false );
    }

	}

	if(esc_attr($url)!=''){
		return '<a class="pretty_image" data-link="'.esc_attr($url).'" href="'.esc_attr($url).'" data-rel="prettyPhoto'.$_gal.'" title="'.esc_attr($content).'"><img src="'.$src.'" width="'.esc_attr($width).'" height="'.esc_attr($height).'" alt="'.esc_attr($title).'" class="fade-image" /></a>';
	}

}
add_shortcode('pretty_image', 'pretty_image_shortcode');

//*** Image with caption @done ***/
function max_caption_image($atts, $content = null) {
	extract(shortcode_atts(
		array ('url'   => '',
			   'width'   => '',
			   'height'  => '',
			   'caption' => '',
			   'crop'    => 'c',
			   'title'   => '',
			   'gallery' => '',
			   'lightbox' => 'false')
		, $atts));

	$_gal = '';
	$_esc_gallery = esc_attr($gallery);
	if( 'true' == $_esc_gallery ){
		$_gal = '[galPretty]';
	}

	if(!empty($crop)){

		if (isset($blog_id) && $blog_id > 0) {
			$imageParts = explode('/files/', $url);
			if (isset($imageParts[1])) {
				$src = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
			}
		}

		// get the new image width calculation if no height or width is set
  	if($width == 0) $width = "";
  	if($height == 0) $height = "";

    if($use_timthumb == 'true') {
      $src = get_template_directory_uri().'/timthumb.php?src='. $url . '&amp;h=' . $height . '&amp;w=' . $width .  '&amp;a=' . $crop . '&amp;q=100';
    }else{
		  $src = theme_thumb(esc_attr($url), esc_attr($width), esc_attr($height), $crop );
		}

	}else{

  	if($use_timthumb == 'true') {
	  	$src = get_template_directory_uri().'/timthumb.php?src='. $url . '&amp;h=' . $height . '&amp;w=' . $width .  '&amp;q=100';
    }else{
      $src = theme_thumb(esc_attr($url), esc_attr($width), esc_attr($height), false );
    }

	}

  $html = '<div class="img-caption">';
	if($lightbox == 'true') $html .= '<a class="pretty_image" data-link="'.esc_attr($url).'" href="'.esc_attr($url).'" data-rel="prettyPhoto'.$_gal.'" title="'.$content.'">';
  $html .= '<img src="'.$src.'" width="'.esc_attr($width).'" height="'.esc_attr($height).'" alt="'.esc_attr($title).'" class="fade-image" />';
 	if($lightbox == 'true') $html .= '</a>';
	$html .= '<span class="caption">'.do_shortcode($content).'</span></div><div class="clearfix"></div>';

  return $html;
}
add_shortcode('caption_image', 'max_caption_image');


//*** Youtube shortcode ***/
if ( ! function_exists( 'max_youtube_shortcode' ) ):

  function max_youtube_shortcode( $atts ) {

  	extract( shortcode_atts( array(
  		'id' => '',
  		'width' => '',
  		'height' => '',
  		'wmode' => 'transparent',
  		'autohide' => 0,
  		'showinfo' => 1,
  		'quality' => "hd1080",
  	), $atts ) );

  	global $wp_embed;

  	if ( empty($atts['id']) )
  	return '';

    // check for a valid URL
  	if (filter_var($id, FILTER_VALIDATE_URL) === false) {
  	  $url = "http://www.youtube.com/embed/".$id;
    }else{
      $url = $id;
    }

    // check for video quality
    $vq = esc_attr($quality);
    if ( $vq != "auto") $vq_string = "&amp;vq=".esc_attr($quality);

  	$url = esc_attr($url). '?rel=0'.$vq_string.'&amp;wmode='.esc_attr($wmode).'&amp;autohide='.esc_attr($autohide).'&amp;showinfo='.esc_attr($showinfo);

    return '<iframe width="' . esc_attr($width). '" height="' . esc_attr($height). '" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';

  }

  add_shortcode( 'youtube', 'max_youtube_shortcode' );

endif;

//*** Vimeo shortcode @done ***/
if ( ! function_exists( 'max_vimeo_shortcode' ) ):

  function max_vimeo_shortcode( $atts ) {
     extract( shortcode_atts( array(
        'id' => '',
        'width' => '',
        'height' => '',
        'title' => '1',
        'byline' => '1',
        'portrait' => '1'
        ), $atts ) );

      // check for a valid URL
    	if (filter_var(esc_attr($id), FILTER_VALIDATE_URL) === false) {
    	  $url = "http://player.vimeo.com/video/" . esc_attr($id);
      }else{
        $url = esc_attr($id);
      }

      return '<iframe src="' . ($url) . '?title=' . esc_attr($title) . '&amp;byline=' . esc_attr($byline) . '&amp;portrait=' . esc_attr($portrait) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"></iframe>';
  }

endif;

add_shortcode( 'vimeo', 'max_vimeo_shortcode' );

/*-----------------------------------------------------------------------------------*/
/*	Posts Shortcodes
/*-----------------------------------------------------------------------------------*/

//*** show recent posts ***/
function recent_posts_shortcode($atts){
	extract(shortcode_atts(array(
		'limit'       => 4,
		'type'        => 'gallery',
		'category'    => '',
		'img'         => 'true',
		'title'       => __( 'Recent Posts', MAX_SHORTNAME ),
		), $atts));

 	global $imgDimensions, $post;

	$imgDimensions = array( 'width' => 400, 'height' => 300 );

	// get the catID string
	if(esc_attr($type) == 'post'): // its a regular post type

  	// get the gallery posts
  	$query_args    = array(
  		'post_type'   => esc_attr($type),
  		'showposts'   => esc_attr($limit)
   	);

    if( esc_attr($category) != "") :
      $query_args['cat'] = esc_attr($category);
    endif;

  endif;

	if( esc_attr($type) == POST_TYPE_GALLERY) : // its a gallery post type

  	// get the gallery posts
  	$query_args = array(
  		'post_type'   => esc_attr($type),
  		'showposts'   => esc_attr($limit)
  	);

    if( esc_attr($category) != "") :
      $query_args['tax_query'] = array(
        array(
          'taxonomy'  => GALLERY_TAXONOMY,
          'terms'     => esc_attr($category),
          'field'     => 'term_id',
        )
      );
    endif;

  endif;

	// query posts with arguments from above ($query_args)
	$q = new WP_Query($query_args);

	$type = esc_attr($img)=='false' ? "square" : "";
	$float = esc_attr($img)=='false' ? "recent-no-float" : "";

	$list  = '<div id="recent-posts" class="portfolio-four-columns '. $float .'"><h3 class="recent-title">' . esc_attr($title) . '</h3> <ul class="portfolio-list clearfix '.$type.'">';

	while($q->have_posts()) : $q->the_post();
		if(esc_attr($img)=='true'){

			$list .= '<li class="item"><div class="shadow"><div class="entry-image">';

      $cropping_direction = get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_cropping_direction_value', true);

 			// get the imgUrl for showing the post image
  		$imgUrl = max_get_custom_image_url(get_post_thumbnail_ID(), get_the_ID(), esc_attr($imgDimensions['width']), esc_attr($imgDimensions['height']), get_cropping_direction( get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_cropping_direction_value', true) ) );

			// get the gallery item
			$list .= '<a href="'. get_permalink($post->ID) . '" title="'.get_the_title().'"><img src="'.$imgUrl.'" width="'.esc_attr($imgDimensions['width']).'" height="'.esc_attr($imgDimensions['height']).'" alt="'.get_the_title().'" class="fade-image" /></a>';

			$list .= '</div>';
			$list .= '<div class="entry-header"><a href="'. get_permalink($post->ID) . '" title="'.get_the_title().'">'.get_the_title().'</a></div>';
      $list .= '<div class="entry-meta">'.get_the_time('M j, Y').' by '.get_the_author().'</div>';
      $list .= '</div>';
			$list .= '</li>';

		}else{

			$list .= '<li class="item">';
			$list .= '<div class="entry-header"><a href="'. get_permalink($post->ID) . '" title="'.get_the_title().'">'.get_the_title().'</a>';
      $list .= '<span class="entry-meta"> - '.get_the_time('M j, Y').' by '.get_the_author().'</span></div>';
			$list .= '</li>';

		}

	endwhile;

	wp_reset_query();

	return $list . '</ul></div>';
}
add_shortcode('recent_posts', 'recent_posts_shortcode');

//*** show related posts ***/
function related_posts_shortcode( $atts ) {

	extract(shortcode_atts(array(
	  'limit'       => '4',
		'width'       => 400,
		'height'      => 300,
		'taxonomy'    => GALLERY_TAXONOMY
	), $atts));

	global $post, $imgDimensions;

	$imgDimensions = array( 'width' => $width, 'height' => $height );

	if ($post->ID) {

		// Get tags
		$filter = 'post_tag';
		$tags = wp_get_post_terms($post->ID, 'post_tag', array("fields" => "ids"));
		$list = "";
		$tag_arr = "";

		if($tags) {

      $args = array(
        'tag__in'               => $tags,
        'post__not_in'          => array($post->ID),
        'post_type'             => get_post_type(),
        'showposts'             => $limit,
        'ignore_sticky_posts'   => 1
      );

      $related_posts = new WP_Query($args);

			if ( $related_posts ) {

				$list = '<div id="related-posts" class="entry-related-images portfolio-four-columns"><h3 class="related-title">' . __( 'Related Posts', MAX_SHORTNAME ) . '</h3><ul class="clearfix portfolio-list">';

        if( $related_posts->have_posts() ) {

          while ($related_posts->have_posts()) : $related_posts->the_post();

  					if ( has_post_thumbnail( get_the_ID() ) ) {

  						$hover_class = "";
  						if( get_option_max('image_show_fade') != "true") {
  							$hover_class = ' no-hover';
  						}

  						$list .= '<li class="item '. max_get_post_lightbox_class() . $hover_class .'"><div class="shadow">';

  						// get the imgUrl for showing the post image
  						$_imgUrl = max_get_custom_image_url(get_post_thumbnail_ID(get_the_ID()), get_the_ID(), esc_attr($width), esc_attr($height), get_cropping_direction( get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_cropping_direction_value', true) ) );

  						// get the gallery item
  						$list .= '<a href="'.get_permalink(get_the_ID()).'" title="'.get_the_title().'"><img src="' . $_imgUrl .'" alt="'.get_the_title().'" /></a></div>';

  						// check if caption option is selected
  						if ( get_option_max( 'image_show_caption' ) == 'true' ) {
  							$list .= '<div class="item-caption"><strong>' . wptexturize(get_the_title()) . '</strong></div>';
  						}
  						$list .= '</li>';

  					}else{

  						continue;

  					}

  				endwhile;

				}

				wp_reset_query();

				$list .= '</ul></div>';

			}

		}
		return $list;
	}
	return;
}
add_shortcode('related_posts', 'related_posts_shortcode');


//*** Author Box Shortcode ***/
function max_author_box() {

	$author_name = get_the_author();
	$site_link = get_the_author_meta('user_url');
	$author_desc = get_the_author_meta('description');
	$facebook_link = get_the_author_meta('aim');
	$twitter_link = get_the_author_meta('yim');

	$return_text = '<div id="author-info" class="clearfix">
						<h3 class="author-title">'. __('About the author', MAX_SHORTNAME) . '</h3>
						<div class="author-holder">
							<div class="author-image">
								<a href="'.$site_link.'">' . get_avatar( get_the_author_meta('email'), '80' ) . '</a>
							</div>
							<div class="author-bio">
								<p>'.$author_desc.'</p>
							</div>
						</div>
					</div>';

	return $return_text;

}
add_shortcode('authorbox', 'max_author_box');

// Google Maps shortcode
function googlemap_shortcode( $atts ) {
    extract(shortcode_atts(array(
        'width' => '500px',
        'height' => '300px',
        'apikey' => get_option_max("general_google_map_api"),
        'marker' => '',
        'center' => '',
        'zoom' => '13'
    ), $atts));

    if ($center) $setCenter = 'map.setCenter(new GLatLng('.$center.'), '.$zoom.');';
    if ($marker) $setMarker = 'map.addOverlay(new GMarker(new GLatLng('.$marker.')));';

    $rand = rand(1,100) * rand(1,100);

    return '
		<div id="map_canvas_'.$rand.'" class="google_maps_canvas"></div>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key='.$apikey.'" type="text/javascript"></script>

	    <script type="text/javascript">
		    function initialize() {
		      if (GBrowserIsCompatible()) {
		        var map = new GMap2(document.getElementById("map_canvas_'.$rand.'"));
		        '.$setCenter.'
		        '.$setMarker.'
		        map.setUIToDefault();
		      }
		    }
		    initialize();
	    </script>
    ';

}
add_shortcode('googlemap', 'googlemap_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Widget Shortcode
/*-----------------------------------------------------------------------------------*/

function widget_shortcode($atts) {

    global $wp_widget_factory;

    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));

    $widget_name = esc_html($widget_name);

    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));

        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct", MAX_SHORTNAME),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;

    ob_start();

    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));

    $output = ob_get_contents();
    ob_end_clean();
    return $output;

}
add_shortcode('widget','widget_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

/** Two columns **/
function max_two_col($atts, $content = null) {
	return '<div class="col_2">'.do_shortcode($content).'</div>';
}
function max_two_col_last( $atts, $content = null) {
	return '<div class="col_2 col_last">'.do_shortcode($content).'</div><div class="clearfix"> </div>';
}
add_shortcode('two_col', 'max_two_col');
add_shortcode('two_col_last', 'max_two_col_last');

/** Three columns **/
function max_three_col($atts, $content = null) {
	return '<div class="col_3">'.do_shortcode($content).'</div>';
}
function max_three_col_last( $atts, $content = null) {
	return '<div class="col_3 col_last">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('three_col', 'max_three_col');
add_shortcode('three_col_last', 'max_three_col_last');

/** Four columns **/
function max_four_col($atts, $content = null) {
	return '<div class="col_4">'.do_shortcode($content).'</div>';
}
function max_four_col_last( $atts, $content = null) {
	return '<div class="col_4 col_last">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('four_col', 'max_four_col');
add_shortcode('four_col_last', 'max_four_col_last');

/** 2/3 columns **/
function max_one_third_col($atts, $content = null) {
	return '<div class="col_one_third">'.do_shortcode($content).'</div>';
}
function max_two_third_col($atts, $content = null) {
	return '<div class="col_two_third">'.do_shortcode($content).'</div>';
}
function max_one_third_col_last( $atts, $content = null) {
	return '<div class="col_one_third col_one_third_last">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
function max_two_third_col_last( $atts, $content = null) {
	return '<div class="col_two_third col_two_third_last">'.do_shortcode($content).'</div><div class="clearfix"></div>';
}
add_shortcode('one_third', 'max_one_third_col');
add_shortcode('two_third', 'max_two_third_col');
add_shortcode('one_third_last', 'max_one_third_col_last');
add_shortcode('two_third_last', 'max_two_third_col_last');

?>