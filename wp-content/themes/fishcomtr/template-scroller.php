<?php
/**
 * Template Name: Portfolio Fullsize Scroller
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 1.0
 */

global $meta;

$meta                   = max_get_cutom_meta_array();
$meta_scroller_height   = get_post_meta($post->ID, MAX_SHORTNAME.'_max_scroller_height', TRUE);
$scroller_height        = !empty($meta_scroller_height) ? $meta_scroller_height : 0;

get_header();

// show the item caption of an image on hover?
$itemCaption = true;

// Hide the excerpt on hover?
$hideExcerpt = false;

?>

		<div id="primary" class="clearfix portfolio-fullsize-scroller<?php if ( post_password_required() ) : ?> portfolio-fullsize-closed<?php endif; ?>">
			<div id="content" role="main" class="clearfix">

				<?php
				// get the page header template part
				locate_template( array( 'includes/page-header.inc.php'), true, true );
				?>

				<?php /* -- added 2.0 -- */ ?>
				<?php the_content() ?>
				<?php /* -- end -- */ ?>

				<?php if ( !post_password_required() ) { ?>
				<div id="customScroller" class="scroll-pane">

					<div id="max-preloader">
						<div class="max-loader">
						</div>
					</div>

					<div class="scroll-content">
					<?php
						// including the loop template gallery-loop.php
						get_template_part( 'includes/gallery', 'loop.inc' );
					?>
					</div>
					<a href="#scroll-left" id="scroll_left" class="scroller-arrow disabled">Scroll Left</a>
					<a href="#scroll-right" id="scroll_right" class="scroller-arrow">Scroll Right</a>

					<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
						<div class="scroll-bar"></div>
					</div>

				</div>
				<?php } ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
