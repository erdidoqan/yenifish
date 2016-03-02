<?php
/**
 * Template Name: Portfolio Masonry
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 1.0
 */

get_header();

// get the isotope javascript script
wp_enqueue_script( 'isotope' );

$imgDimensions = array();

// get the columns to show
$opt_columns_meta   = get_post_meta( $post->ID, MAX_SHORTNAME."_page_masonry_columns", true );
$opt_columns        = empty($opt_columns_meta) ? 3 : $opt_columns_meta;
$columns            = empty($opt_columns) ? 6 : $opt_columns;
$imgAspectRatio     = get_post_meta( $post->ID, MAX_SHORTNAME."_page_masonry_aspect", true);

// set the image dimensions for this portfolio template
$imgDimensions['width'] = 768;

if( $columns >= 6 ) {
  $imgDimensions['width'] = 480;
}

// Squared Aspect Ratio
if( !empty($imgAspectRatio) && $imgAspectRatio == 'squared' ) :
  $imgDimensions['height'] = $imgDimensions['width'];
endif;

// 2:3 Portrait Apsect Ratio
if( !empty($imgAspectRatio) && $imgAspectRatio == 'portrait' ) :
  $imgDimensions['height'] = $imgDimensions['width'] * 1.5;
endif;


$itemCaption = true;

?>
<?php
// get the password protected login template part
if ( post_password_required() ) {
	get_template_part( 'includes/page', 'password.inc' );
} else {
?>
		<style type="text/css">

			/** Masonry Portfolio **/
			.portfolio-fullsize-grid .portfolio-list li {
        width: 100%;
        float: left;
        padding: 2px;
        margin: 0;
        box-sizing: border-box;
        visibility: hidden;
  		}

		</style>

		<div id="primary" class="portfolio-fullsize-grid">

			<div id="content" role="main">

        <?php
        // get the page header template part
        locate_template( array( 'includes/page-header.inc.php'), true, true );
        ?>

				<?php /* -- added 2.0 -- */ ?>
				<?php the_content() ?>
				<?php /* -- end -- */ ?>

				<?php
					// including the loop template gallery-loop.php
					get_template_part( 'includes/gallery', 'loop.inc' );
				?>
			</div><!-- #content -->

		</div><!-- #primary -->

<?php } ?>

	<script type="text/javascript">

		//<![CDATA[
		jQuery(window).load(function(){

      var $iso_container  = jQuery('#portfolioList'),
          $containerProxy = $iso_container.clone().empty().css({ visibility: 'hidden' }), // create a clone that will be used for measuring container width
          $iso_items = $iso_container.find('li.item');

      $iso_container.after( $containerProxy );

      jQuery(window).smartresize( function() {

        var viewport   = { width: jQuery(window).width(), height: jQuery(window).height() };
        var columns = <?php echo $columns; ?>;

        if ( viewport.width <= 979 ) columns = 4;
        if ( viewport.width <= 767 ) columns = 2;
        if ( viewport.width <= 480 ) columns = 1;

        // calculate columnWidth
        var colWidth = Math.floor( $containerProxy.width() / columns );

        // resize the element depending on the columns and browsers width. Also handle new DOM elements with livequery
        $iso_items.livequery(function(){
          jQuery(this).css({ width: colWidth });
        })

        // set width of container based on columnWidth
        $iso_container.css({
          width: colWidth * columns
        })

        .isotope({
          itemSelector : '.portfolio-list li.item',
          resizable: false, // disable automatic resizing when window is resized

          // set columnWidth option for masonry
          masonry: {
            gutterWidth: 0 //remove gutter
          }
        });

        // trigger smartresize for first time
      }).smartresize();

			$iso_container.css({ background: 'none' }).find('li.item').css({ visibility: 'visible' });

		});
		//]]>
	</script>

<?php get_footer(); ?>