<?php
/**
 * Template Name: Portfolio Lightbox Gallery
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
$hideExcerpt = true;

// its a lightbox gallery template
$isLightboxGallery = true;

// get the image dimensions
$imgDimensions = array( 'width' => 320, 'height' => 240 );

?>
<div id="single-page" class="clearfix left-sidebar">

	<div id="primary" class="portfolio-three-columns" >

		<div id="content" role="main">

			<?php
			// get the page header template part
			locate_template( array( 'includes/page-header.inc.php'), true, true );
			?>

			<?php the_content() ?>

			<?php
			// including the loop template gallery-loop.php
			get_template_part( 'includes/gallery', 'loop.inc' );
			?>

    		<?php if ( !post_password_required() ) : comments_template( '', true ); endif; ?>

		</div><!-- #content -->

	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-gallery-lightbox'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<?php get_footer(); ?>
