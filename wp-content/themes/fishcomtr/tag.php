<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage invictus
 * @since invictus 1.0
 */

global $showSuperbgimage, $imgDimensions;

$showSuperbgimage = true;

get_header();

// set the image dimensions for this portfolio template
$imgDimensions  = array( 'width' => 660, 'height' => 480 );
$substrExcerpt  = 70;
$itemCaption    = true;
$post_type      = get_post_type();
$resize_images  = true;

?>

<div id="single-page" class="clearfix left-sidebar">

	<div id="primary" class="portfolio-three-columns" >

		<div id="content" role="main">

			<header class="entry-header">

				<h1 class="page-title"><?php single_tag_title() ?></h1>

			</header><!-- .entry-header -->

			<?php

			// Only get gallery posts
			if($post_type == "gallery"){
			$tag_posts = query_posts( array('tag'=> get_query_var('tag'), 'post_type' => 'gallery', 'paged' => $paged, 'order' => get_option_max('photo_post_archive_sorting') ) );
			}
			// Only get blog posts
			if($post_type == "post"){
			$tag_posts = query_posts( array('tag'=> get_query_var('tag'), 'post_type' => 'post', 'paged' => $paged) );
			}

			if($post_type == "gallery"){
			// including the loop template tag-loop.inc.php
			get_template_part( 'includes/tag', 'loop.inc');
			}

			if($post_type == "post"){
			// including the loop template blog-loop.inc.php
			get_template_part( 'includes/blog', 'loop.inc' );
			}
			?>

		</div><!-- #content -->

	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-tag'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<?php get_footer(); ?>
