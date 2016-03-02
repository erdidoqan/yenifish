<?php
/**
 * Template Name: Sidebar Fullwidth Template
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

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-main'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<?php get_footer(); ?>
