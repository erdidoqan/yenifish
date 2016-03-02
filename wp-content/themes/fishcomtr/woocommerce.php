<?php
/**
 * WooCommerce Page Template
 * @package WordPress
 * @subpackage Invictus
 */

get_header(); ?>

	<div id="single-page" class="clearfix left-sidebar">

		<div id="primary">

			<div id="content" role="main">

				<?php woocommerce_content(); ?>

			</div><!-- #content -->

		</div><!-- #primary -->

	    <?php
	    /* Get the sidebar if we have set one - otherwise show nothing at all */
	    $sidebar_string = max_get_custom_sidebar('sidebar-blog'); /* get the custom or default sidebar name */
	    $header_type    = get_option_max( "header_type", 'default' ); // check for header type
	    $fill_content   = $header_type == 'full-width' ? get_option_max( "layout_fill_content", 'false' ) : 'false'; // check if we have a full-width nav and fill content is activated

	    if ( !post_password_required() && $fill_content == 'false' || ( $fill_content == 'true' && is_active_sidebar($sidebar_string) ) ) { ?>
	    <div id="sidebar">
	      <?php
	      /* Widgetised Area */ if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( $sidebar_string ) );
	      wp_reset_query();
	      ?>
	    </div>
	    <?php } ?>

	</div>

<?php get_footer(); ?>