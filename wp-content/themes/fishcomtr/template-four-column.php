<?php
/**
 * Template Name: Portfolio 4 Columns
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 1.0
 */

get_header();

wp_reset_query();

// show the item caption of an image on hover?
$itemCaption = true;

// Hide the excerpt on hover?
$hideExcerpt    = true;

// Get the image dimensions for this template
$imgDimensions  = array( 'width' => 480, 'height' => 360 );

?>
<div id="single-page" class="clearfix left-sidebar">

	<div id="primary" class="portfolio-four-columns" >
		<div id="content" role="main">

			<?php
			// get the page header template part
			locate_template( array( 'includes/page-header.inc.php'), true, true );
			?>

			<?php /* -- added 2.0 -- */ ?>
			<?php the_content() ?>
			<?php /* -- end -- */ ?>

			<?php
   			 // Get the image source template
			get_template_part( 'includes/gallery', 'loop.inc' ); // including the loop template gallery-loop.inc.php
			?>

    		<?php comments_template( '', true ); ?>

		</div><!-- #content -->

	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar( 'sidebar-gallery-four' ); // get the custom or default sidebar name

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<?php get_footer(); ?>
