<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */

get_header();
?>

<div id="primary">
	<div id="content" role="main">

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<nav id="nav-above">
			<header class="section-heading"><?php _e( 'Post navigation', 'invictus' ); ?></header>
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'invictus' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'invictus' ) . '</span>' ); ?></div>
		</nav><!-- #nav-above -->

		<?php get_template_part( 'content', 'single' ); ?>

		<nav id="nav-below">
			<header class="section-heading"><?php _e( 'Post navigation', 'invictus' ); ?></header>
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'invictus' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'invictus' ) . '</span>' ); ?></div>
		</nav><!-- #nav-below -->

		<?php comments_template( '', true ); ?>

	<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php
/* Get the sidebar if we have set one - otherwise show nothing at all */
$sidebar_string = max_get_custom_sidebar('sidebar-blog-post'); /* get the custom or default sidebar name */

// include the sidebar.php template
get_sidebar();
?>

<?php get_footer(); ?>