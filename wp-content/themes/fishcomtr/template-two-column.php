<?php
/**
 * Template Name: Portfolio 2 Columns
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 1.0
 */

get_header();

wp_reset_query();

// show the item caption of an image on hover?
$itemCaption    = true;

// Hide the excerpt on hover?
$hideExcerpt    = false;

// check for header type
$header_type	= get_option_max( "header_type", 'default' );

// check if we have a full-width nav and fill content is activated
$fill_content   = $header_type == 'full-width' ? get_option_max( "layout_fill_content", 'false' ) : 'false';

// get the image dimensions
if( $fill_content === 'false' ) {
	$imgDimensions  = array( 'width' => 400, 'height' => 300 );
}else{
	$imgDimensions  = array( 'width' => 800, 'height' => 600 );
}

?>
<div id="single-page" class="clearfix left-sidebar hisrc">

	<div id="primary" class="portfolio-two-columns" >
		<div id="content" role="main">

			<?php
			// get the page header template part
			locate_template( array( 'includes/page-header.inc.php'), true, true );
			?>

			<?php the_content() ?>

			<?php
   			// Get the image source template
			get_template_part( 'includes/gallery', 'loop.inc' ); // including the loop template gallery-loop.inc.php
			?>

    		<?php comments_template( '', true ); ?>

		</div><!-- #content -->

	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-gallery-two'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<?php get_footer(); ?>
