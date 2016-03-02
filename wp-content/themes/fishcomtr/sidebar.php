<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */

global $sidebar_string;

$header_type	= get_option_max( "header_type", 'default' ); // check for header type
$fill_content 	= $header_type == 'full-width' ? get_option_max( "layout_fill_content", 'false' ) : 'false'; // check if we have a full-width nav and fill content is activated

if ( !post_password_required() && $fill_content == 'false' || ( $fill_content == 'true' && is_active_sidebar($sidebar_string) ) ) { ?>
	<div id="sidebar" class="widget-area" role="complementary">
  <?php
  /* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( $sidebar_string ) );
	  wp_reset_query();
	  ?>
</div>
<?php } ?>