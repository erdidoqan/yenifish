<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */

global $showSuperbgimage;
$showSuperbgimage = true;

get_header(); ?>

<div id="single-page" class="clearfix blog left-sidebar">

	<div id="primary">
		<div id="content" role="main">

			<?php the_post(); ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: <span>%s</span>', MAX_SHORTNAME ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: <span>%s</span>', MAX_SHORTNAME ), get_the_date( 'F Y' ) ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: <span>%s</span>', MAX_SHORTNAME ), get_the_date( 'Y' ) ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', MAX_SHORTNAME ); ?>
					<?php endif; ?>
				</h1>
				<h2 class="page-description">&nbsp;</h2>
			</header>

			<?php rewind_posts(); ?>

			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-above">
					<header class="section-heading"><?php _e( 'Post navigation', MAX_SHORTNAME ); ?></header>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', MAX_SHORTNAME ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', MAX_SHORTNAME ) ); ?></div>
				</nav><!-- #nav-above -->
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<h3><?php _e('Latest posts', MAX_SHORTNAME) ?></h3>
			<ul class="square">
			<?php while ( have_posts() ) : the_post(); ?>

				<li><a href="<?php the_permalink() ?>" title="<?php echo htmlspecialchars(get_the_excerpt()) ?>"><?php echo get_the_title() ?></a></li>

			<?php endwhile; ?>
			</ul>
			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<nav id="nav-below">
					<header class="section-heading"><?php _e( 'Post navigation', MAX_SHORTNAME ); ?></header>
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', MAX_SHORTNAME ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', MAX_SHORTNAME ) ); ?></div>
				</nav><!-- #nav-below -->
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-archive-result'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>
<?php get_footer(); ?>