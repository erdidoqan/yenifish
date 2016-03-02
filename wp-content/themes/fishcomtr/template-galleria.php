<?php
/**
 * Template Name: Portfolio Galleria Template
 *
 * @package WordPress
 * @subpackage Photonova
 * @since Photonova 1.0
 */

global $body_class_array, $meta;

wp_enqueue_script('galleria');
wp_enqueue_style('galleria-css', get_template_directory_uri().'/js/galleria/galleria.classic.css', false, false);

/*-----------------------------------------------------------------------------------*/
/*  Main Settings and variables
/*-----------------------------------------------------------------------------------*/
$meta = max_get_cutom_meta_array();

$meta[MAX_SHORTNAME."_page_gallery_fullwidth"] = false;

get_header();

$categories    = get_post_meta($post->ID, 'max_select_gallery', true);

$orderby = get_post_meta($post->ID, 'max_gallery_order', true);
$order   = get_post_meta($post->ID, 'max_gallery_sort', true);

// get the portfolio posts
$portfolio_args = array(
	'post_type'   => 'gallery',
	'orderby'     => $orderby,
	'order'       => $order,
	'showposts'   => 9999,
	'tax_query'   => array(
		array(
			'taxonomy'  => GALLERY_TAXONOMY,
			'terms'     => max_set_term_order($categories),
			'field'     => 'term_id',
		)
	)
);

// get the password protected login template part
if ( post_password_required() ) {
	get_template_part( 'includes/page', 'password.inc' );
} else {
?>

<div id="single-page" class="clearfix left-sidebar">

	<div id="primary" class="hfeed">

		<div id="content" role="main">

			<div <?php if(!is_front_page() && !is_Home()) the_post(); post_class(); ?> id="post-<?php the_ID(); ?>">

				<?php
				// get the page header template part
				locate_template( array( 'includes/page-header.inc.php'), true, true );
				?>

				<?php
				// query posts with arguments from above ($portfolio_args)
      			$portfolio_posts = new WP_Query($portfolio_args);

				if ($portfolio_posts->have_posts()) :

					// open galleria container
					$gal_output = '<div id="galleria" class="clearfix">';

       				while ($portfolio_posts->have_posts()) : $portfolio_posts->the_post();

						// get the url for showing the poster url
          				$_stage_url = max_get_image_path(get_the_ID(), 'tablet');
          				$_thumbnail_url = max_get_image_path(get_the_ID(), 'thumbnail');

						// get post custom meta
						$_post_meta = max_get_cutom_meta_array(get_the_ID());

						// attach image to output
						$gal_output .= '<a href="'. $_stage_url .'">';
						$gal_output .= '<img title="' . get_the_title() . '"';
						$excerpt     = get_the_excerpt();

						if(!empty($excerpt)) :
							$gal_output .= ' alt="' . $excerpt . '"';
						else:
							$gal_output .= ' alt="' . get_the_title() . '"';
						endif;

						$gal_output .= ' src="' . $_thumbnail_url . '">
									</a>';

					endwhile;

					// close galleria container
					$gal_output .= '</div>';
					wp_reset_query();

				endif;

				echo $gal_output;
				?>

				<?php if($post->post_content != "") : ?>
				<p>&nbsp;</p><br  />
				<div class="clearfix">
				<?php the_content() ?>
				</div>
				<?php endif; ?>

				<?php comments_template( '', true ); ?>

			</div><!-- #post -->

		</div><!-- #content -->

	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-gallery-galleria'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<script type="text/javascript">
//<![CDATA[
jQuery(function(){

	jQuery(window).on('load', function(){

		// Initialize Galleria
		Galleria.loadTheme('<?php echo get_template_directory_uri() ?>/js/galleria/galleria.classic.min.js');

		Galleria.run('#galleria', {
			responsive: true,
			<?php if( $meta[MAX_SHORTNAME.'_page_galleria_autoplay'] == 'true' ){ ?>
			autoplay: <?php echo $meta[MAX_SHORTNAME.'_page_galleria_autoplay']; ?>,
			<?php } ?>
			height: <?php echo $meta[MAX_SHORTNAME.'_page_galleria_height']; ?>,
			lightbox: true,
			showInfo: true,
			imageCrop: '<?php echo $meta[MAX_SHORTNAME.'_page_galleria_crop'] ?>',
			wait: true
		});

	});

});
//]]>
</script>
<?php } ?>
<?php get_footer(); ?>