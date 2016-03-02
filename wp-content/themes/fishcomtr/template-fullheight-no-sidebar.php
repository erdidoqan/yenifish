<?php

/**
 * Template Name: Full-Height Browser, no Sidebar
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 3.1
 */

get_header();
?>
<div id="fullheightTemplate" class="fullheight-content">

  <div id="primary" class="template-fullsize">

	<div id="content" role="main" class="clearfix">

		<?php the_content() ?>

	</div>

  </div>

</div>
<?php
get_footer(); ?>
