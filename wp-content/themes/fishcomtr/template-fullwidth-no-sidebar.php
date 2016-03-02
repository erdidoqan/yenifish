<?php
/**
 * Template Name: Full-Width Browser, No Sidebar
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 1.8
 */

get_header();

?>
<div id="single-page" class="clearfix left-sidebar">

		<div id="primary">
			<div id="content" role="main">

				<?php the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			</div><!-- #content -->
		</div><!-- #primary -->

</div>

<?php get_footer(); ?>
