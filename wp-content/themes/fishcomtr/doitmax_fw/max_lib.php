<?php

/*-----------------------------------------------------------------------------------*/
/*	Custom function for pagination
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'max_pagination' ) ):

	function max_pagination($query = false, $pages = '', $range = 4){

	   global $wp_query;
	   if(!$query) $query = $wp_query;

		 $showitems = ($range * 2)+1;

		 global $paged, $posts;

		 if(empty($paged)) $paged = 1;

		 if($pages == '')
		 {
			 $pages = $query->max_num_pages;
			 if(!$pages)
			 {
				 $pages = 1;
			 }
		 }

		 if(1 != $pages)
		 {
			 echo "<div class=\"clearfix pagination\"><span>".__('Page', MAX_SHORTNAME)." ".$paged." ".__('of')." ".$pages."</span>";
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; ".__('Next', MAX_SHORTNAME)."</a>";
			 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; ".__('Previous', MAX_SHORTNAME)."</a>";

			 for ($i=1; $i <= $pages; $i++)
			 {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				 {
					 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
				 }
			 }

			 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">".__('First', MAX_SHORTNAME)." &rsaquo;</a>";
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__('Last', MAX_SHORTNAME)." &raquo;</a>";
			 echo "</div>\n";
		 }
	}

endif;



/*-----------------------------------------------------------------------------------*/
/*	Template for comments and pingbacks.
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'max_comment' ) ) :

  function max_comment( $comment, $args, $depth ) {
  	$GLOBALS['comment'] = $comment;
  	switch ( $comment->comment_type ) :
  		case '' :
  	?>
  	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  		<div id="comment-<?php comment_ID(); ?>">
  		<div class="comment-author vcard">
  			<?php echo get_avatar( $comment, 40 ); ?>
  			<?php printf( __( '<span class="says">by</span> %s'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
  		</div><!-- .comment-author .vcard -->

  		<div class="comment-meta commentmetadata">
  			<?php
  				/* translators: 1: date, 2: time */
  				printf( __( '%1$s', MAX_SHORTNAME), get_comment_date(),  get_comment_time() ); ?>  <?php edit_comment_link( __( '(Edit)', MAX_SHORTNAME), ' ' );
  			?>
  		</div><!-- .comment-meta .commentmetadata -->

  		<div class="comment-body"><?php comment_text(); ?></div>

  		<div class="reply">
  			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
  		</div><!-- .reply -->
  	</div><!-- #comment-##  -->

  	<?php
  		break;
  		case 'pingback'  :
  		case 'trackback' :
  	?>
  	<li class="post pingback">
  		<p><?php _e( 'Pingback:','invictus' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', MAX_SHORTNAME), ' ' ); ?></p>
  	<?php
  			break;
  	endswitch;
  }

endif;

/*-----------------------------------------------------------------------------------*/
/*	Get image cropping direction
/*-----------------------------------------------------------------------------------*/

function get_cropping_direction($meta_value) {

	switch($meta_value){

		case 'Position in the Center (default)' :
		case 'c':
			$dir = 'c';
		break;

		case 'Align top' :
		case 't':
			$dir = 't';
		break;

		case 'Align top right':
		case 'tr':
			$dir = 'tr';
		break;

		case 'Align top left':
		case 'tl':
			$dir = 'tl';
		break;

		case 'Align bottom':
		case 'b':
			$dir = 'b';
		break;

		case 'Align bottom right':
		case 'br':
			$dir = 'br';
		break;

		case 'Align bottom left':
		case 'bl':
			$dir = 'bl';
		break;

		case 'Align left':
		case 'l':
			$dir = 'l';
		break;

		case 'Align right':
		case 'r':
			$dir = 'r';
		break;

		default:
			$dir = 'c';
		break;

	}

	return $dir;

}

/*-----------------------------------------------------------------------------------*/
/*	Get hex to rgb and rgb to hex
/*-----------------------------------------------------------------------------------*/

	function max_HexToRGB($hex, $alpha = false) {
		$hex = str_replace("#", "", $hex);

		$color = array();

		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}

		if($alpha){
			$color['a'] = $alpha;
		}

		return $color;
	}


	function max_RGBToHex($r, $g, $b) {
		//String padding bug found and the solution put forth by Pete Williams (http://snipplr.com/users/PeteW)
		$hex = "#";
		$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);

		return $hex;
	}

/*-----------------------------------------------------------------------------------*/
/*	Google Font Lib
/*-----------------------------------------------------------------------------------*/

// check, if we have to use Google Font
$use_google_font = get_option_max("font_google_deactivate", "false");
if( $use_google_font != "true" ) {
	include_once(MAX_FW_PATH.'/includes/google.font.inc.php');
}

function max_get_google_font() {

	global $google_font_array;

	// get the fonts
	$body_font             = get_option_max('font_body');
	$widget_font           = get_option_max('font_widget');
	$nav_font              = get_option_max('font_navigation');
	$pulldown_font         = get_option_max('font_navigation_pulldown');
	$fsg_title_font        = get_option_max('font_fullsize_title');
	$fsg_excerpt_font      = get_option_max('font_fullsize_excerpt');
	$welcome_teaser_font   = get_option_max('font_welcome_teaser');
	$blog_font             = get_option_max('font_blog_header');

	$font_array = array( $body_font['font_family'], $widget_font['font_family'], $nav_font['font_family'], $pulldown_font['font_family'], $blog_font['font_family'] );

	$_google_fonts = array();
	for($h = 1; $h <= 6; $h++){
		$_google_fonts['h'.$h] = get_option_max('font_h'.$h);
	}

	foreach($_google_fonts as $get_google_font){
		// get the headline font
		$_temp_font_array[] = $get_google_font['font_family'];
	}

	// combine both arrays
	$max_option = array_merge($font_array, $_temp_font_array);

	if( !is_array($max_option) ){
		$max_option = array( $max_option );
	}

	$output = "";

	$_temp_fonts = array();

	foreach($max_option as $index => $family){

		if(!in_array($family, $_temp_fonts)){

			$_temp_fonts[] = $family;

			switch($family) {

				// Arial Standard
				case  'Arial, Helvetica, sans-serif':
				case  'Verdana, Geneva, sans-serif':
				case  'Tahoma, Geneva, sans-serif':
				case  'Georgia, Times, serif':
				case  'Lucida Console, Monaco, monospace':

					$output .= "";

				break;

				default:
					$opt_subset = get_option_max("font_subsets");

					$opt_subset = !isset($opt_subset) ? "none" : get_option_max('font_subsets');

					switch($opt_subset){
						case 'cyrillic':
							$subset = '&subset=latin,cyrillic-ext,latin-ext,cyrillic';
						break;
						case 'greek':
							$subset = '&subset=latin,greek-ext,latin-ext,greek';
						break;

						default:
							$subset = '&subset=latin,latin-ext';
						break;
					}

          			$protocol = is_ssl() ? 'https' : 'http';
					wp_register_style('googleFonts_'.preg_replace('/\s+/', '_', $family), "$protocol://fonts.googleapis.com/css?family=".$google_font_array[$family].$subset);
					wp_enqueue_style( 'googleFonts_'.preg_replace('/\s+/', '_', $family));

				break;
			}
		}
	}
}

// check, if we have to use Google Font
if( $use_google_font != "true" ) {
	add_action('wp_print_styles', 'max_get_google_font');
}

/*-----------------------------------------------------------------------------------*/
/*	Google Font HTML output
/*-----------------------------------------------------------------------------------*/

function max_get_google_font_html(){

	// get the fonts
	$body_font             = get_option_max('font_body');
	$widget_font           = get_option_max('font_widget');
	$nav_font              = get_option_max('font_navigation');
	$pulldown_font         = get_option_max('font_navigation_pulldown');
	$fsg_title_font        = get_option_max('font_fullsize_title');
	$fsg_excerpt_font      = get_option_max('font_fullsize_excerpt');
	$welcome_teaser_font   = get_option_max('font_welcome_teaser');
	$blog_font             = get_option_max('font_blog_header');

	$font_array = array( $body_font['font_family'], $widget_font['font_family'], $nav_font['font_family'], $pulldown_font['font_family'], $blog_font['font_family'] );

	$_google_fonts = array();
	for($h = 1; $h <= 6; $h++){
		$_google_fonts['h'.$h] = get_option_max('font_h'.$h);
	}

	foreach($_google_fonts as $get_google_font){
		// get the headline font
		$_temp_font_array[] = $get_google_font['font_family'];
	}

	// combine both arrays
	$get_fonts = array_merge($font_array, $_temp_font_array);

	// Main Color styles ?>
<style type="text/css">

	body.black-theme,
	body.white-theme  {
		font: <?php echo $body_font['font_size'] ?>px/<?php echo $body_font['line_height'] ?>px <?php echo max_get_font_string( $body_font['font_family'] ) ?>; font-weight: <?php echo $body_font['font_weight']; ?>;
		color: <?php echo $body_font['font_color'] ?>
	}

	#showtitle, #slidecaption, #responsiveTitle  {
		font-family: <?php echo max_get_font_string( $_google_fonts['h1']['font_family'] ).', "Helvetica Neue", Helvetica, Arial, sans-serif' ?>;
		font-weight: 300;
	}

	nav#navigation ul li a {
		color: <?php echo $nav_font['font_color'] ?>; font: <?php echo $nav_font['font_size'] ?>px/<?php echo $nav_font['line_height'] ?>px <?php echo max_get_font_string( $nav_font['font_family'] ) ?>; font-weight: <?php echo $nav_font['font_weight']; ?>
	}

	nav#navigation ul ul.sub-menu li a  {
		color: <?php echo $pulldown_font['font_color'] ?>; font: <?php echo $pulldown_font['font_size'] ?>px/<?php echo $pulldown_font['line_height'] ?>px <?php echo max_get_font_string( $pulldown_font['font_family'] ) ?>; font-weight: <?php echo $pulldown_font['font_weight']; ?>
	}

	h1, h1 a:link, h1 a:visited { color: <?php echo $_google_fonts['h1']['font_color'] ?>; font: <?php echo $_google_fonts['h1']['font_size'] ?>px/<?php echo $_google_fonts['h1']['line_height'] ?>px <?php echo max_get_font_string( $_google_fonts['h1']['font_family'] ) ?>; font-weight: <?php echo $_google_fonts['h1']['font_weight']  ?>; }
	h2 { color: <?php echo $_google_fonts['h2']['font_color'] ?>; font: <?php echo $_google_fonts['h2']['font_size'] ?>px/<?php echo $_google_fonts['h2']['line_height'] ?>px <?php echo max_get_font_string( $_google_fonts['h2']['font_family'] ) ?>; font-weight: <?php echo $_google_fonts['h2']['font_weight']; ?>; }
	h3 { color: <?php echo $_google_fonts['h3']['font_color'] ?>; font: <?php echo $_google_fonts['h3']['font_size'] ?>px/<?php echo $_google_fonts['h3']['line_height'] ?>px <?php echo max_get_font_string( $_google_fonts['h3']['font_family'] ) ?>; font-weight: <?php echo $_google_fonts['h3']['font_weight']; ?>; }
	h4 { color: <?php echo $_google_fonts['h4']['font_color'] ?>; font: <?php echo $_google_fonts['h4']['font_size'] ?>px/<?php echo $_google_fonts['h4']['line_height'] ?>px <?php echo max_get_font_string( $_google_fonts['h4']['font_family'] ) ?>; font-weight: <?php echo $_google_fonts['h4']['font_weight']; ?>; }
	h5 { color: <?php echo $_google_fonts['h5']['font_color'] ?>; font: <?php echo $_google_fonts['h5']['font_size'] ?>px/<?php echo $_google_fonts['h5']['line_height'] ?>px <?php echo max_get_font_string( $_google_fonts['h5']['font_family'] ) ?>; font-weight: <?php echo $_google_fonts['h5']['font_weight']; ?>; }
	h6 { color: <?php echo $_google_fonts['h6']['font_color'] ?>; font: <?php echo $_google_fonts['h6']['font_size'] ?>px/<?php echo $_google_fonts['h6']['line_height'] ?>px <?php echo max_get_font_string( $_google_fonts['h6']['font_family'] ) ?>; font-weight:  <?php echo $_google_fonts['h6']['font_weight']; ?>; }


	#sidebar h1.widget-title, #sidebar h2.widget-title {
		color: <?php echo $widget_font['font_color'] ?>; font: <?php echo $widget_font['font_size'] ?>px/<?php echo $widget_font['line_height'] ?>px <?php echo max_get_font_string( $widget_font['font_family'] ) ?> !important; font-weight: <?php echo $widget_font['font_weight']; ?>;
	}

	#welcomeTeaser, #sidebar .max_widget_teaser {
  	font-family: <?php echo $welcome_teaser_font['font_family'] ?>;
  	font-size: <?php echo $welcome_teaser_font['font_size'] ?>px;
  	color: <?php echo $welcome_teaser_font['font_color'] ?>;
  	line-height: <?php echo $welcome_teaser_font['line_height'] ?>px;
  	font-weight: <?php echo $welcome_teaser_font['font_weight'] ?>;
	}

  <?php if ( !empty($blog_font) ){?>
  .blog h2.entry-title,
  .tag h2.entry-title {
		font: <?php echo $blog_font['font_size'] ?>px/<?php echo $blog_font['line_height'] ?>px <?php echo max_get_font_string( $blog_font['font_family'] ) ?>; font-weight: <?php echo $blog_font['font_weight']; ?>;
		color: <?php echo $blog_font['font_color'] ?>
  }
  <?php } ?>

	<?php if ( get_option_max( 'homepage_teaser_font_size_bold' ) !="" ){?>
	#welcomeTeaser .inner strong, #sidebar .max_widget_teaser strong { font-size: <?php echo get_option_max( 'homepage_teaser_font_size_bold') ?>%; }
	<?php } ?>

	<?php if ( get_option_max( 'font_fullsize_title' ) != ""){?>
	#showtitle .imagetitle { color: <?php echo $fsg_title_font['font_color'] ?>!important; font: <?php echo $fsg_title_font['font_size'] ?>px/<?php echo $fsg_title_font['line_height'] ?>px <?php echo max_get_font_string( $fsg_title_font['font_family'] ) ?>!important; font-weight: <?php echo $fsg_title_font['font_weight']  ?> !important; }
	<?php } ?>

	<?php if ( get_option_max( 'font_fullsize_excerpt' ) != ""){?>
	#showtitle .imagecaption { color: <?php echo $fsg_excerpt_font['font_color'] ?>; font: <?php echo $fsg_excerpt_font['font_size'] ?>px/<?php echo $fsg_excerpt_font['line_height'] ?>px <?php echo max_get_font_string( $fsg_excerpt_font['font_family'] ) ?>!important; font-weight: <?php echo $fsg_excerpt_font['font_weight']  ?> !important; }
	<?php } ?>

</style>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/*	Get Font Select
/*-----------------------------------------------------------------------------------*/

function max_google_font_select() {

	global $google_font_array;

	$output= '<optgroup label="Standard Fonts">
			<option value="Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif</option>
			<option value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>
			<option value="Tahoma, Geneva, sans-serif">Tahoma, Geneva, sans-serif</option>
			<option value="Georgia, Times, serif">Georgia, Times, serif</option>
			<option value="Lucida Console, Monaco, monospace">Lucida Console, Monaco, monospace</option>
		</optgroup>
		<optgroup label="Google API Fonts">';

	// loop throug font array

	if( !empty($google_font_array) && is_array($google_font_array) ) {
		foreach ($google_font_array as $index => $value ){
			$output .= '<option value="'.$index.'">'.$index.'</option>';
		}
	}

	$output .= '</optgroup>';

	echo $output;
}

/*-----------------------------------------------------------------------------------*/
/*	Get the font string
/*-----------------------------------------------------------------------------------*/

function max_get_font_string( $font ){

	switch($font) {

		// Arial Standard
		case  'Arial, Helvetica, sans-serif':
		case  'Verdana, Geneva, sans-serif':
		case  'Tahoma, Geneva, sans-serif':
		case  'Georgia, Times, serif':
		case  'Lucida Console, Monaco, monospace':
			$output = $font;
		break;

		default: $output = '"'.$font.'"';

	}

	return $output;
}

/*-----------------------------------------------------------------------------------*/
/*	Catch the Taxonomy Cats for Galleries
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'max_get_galleries' ) ):

	function max_get_galleries( $addSelect = false ){

		$wp_gal_cats = array();

		// catch the custom categories
		$gallery_cats = get_categories('taxonomy='.GALLERY_TAXONOMY.'&amp;orderby=name&hide_empty=0&hierarchical=1');

		foreach ($gallery_cats as $term_list ) {
			 $wp_gal_cats[$term_list->term_id] = $term_list->name;
		}

		return $wp_gal_cats;
	}

endif;

add_action('init', 'max_get_galleries');

/*-----------------------------------------------------------------------------------*/
/*	Check for a valid timestamp
/*-----------------------------------------------------------------------------------*/

function max_is_valid_timestamp($timestamp){
    return ((string) (int) $timestamp === $timestamp)
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Function to sort the posts real numeric after query
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'max_numeric_post_sort' ) ):

  function max_numeric_post_sort($a,$b) {
     $akey = $a->post_title;
     if (preg_match('/^(\d+) /',$akey,$matches)) {
        $akey = sprintf('%010d ',$matches[0]) . $akey;
     }
     $bkey = $b->post_title;
     if (preg_match('/^(\d+) /',$bkey,$matches)) {
        $bkey = sprintf('%010d ',$matches[0]) . $bkey;
     }
     if ($akey == $bkey) {
        return 0;
     }
     return ($akey < $bkey) ? -1 : 1;
  }

endif;

/*-----------------------------------------------------------------------------------*/
/*	Custom Function check for retina cookie
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'CJG_retina' );

function CJG_retina(){
    global $is_retina;
    $is_retina = isset( $_COOKIE["device_pixel_ratio"] ) AND $_COOKIE["device_pixel_ratio"] >= 2;
}

?>
