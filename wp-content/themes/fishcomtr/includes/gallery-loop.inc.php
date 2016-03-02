<?php
/**
 * The loop that displays portfolio items.
 *
 *
 * @package WordPress
 * @subpackage invictus
 * @since invictus 1.0
 */

global $wp_query, $imgDimensions, $substrExcerpt, $itemCaption, $paged, $meta, $the_term, $hideExcerpt, $isLightboxGallery, $p_tpl, $infiniteScroll, $portfolio_posts, $resize_images;

//Get the page meta informations and store them in an array
$meta = max_get_cutom_meta_array();

// store some variables
$infiniteScroll = false; // set infiniteScroll to false by defaults
$pageInfo       = get_post_meta($post->ID, 'max_show_gallery_info', true); // show additional page info or not?
$categories     = get_post_meta($post->ID, 'max_select_gallery', true); // get the portfolio categories
$per_page_meta  = get_post_meta($post->ID, 'max_gallery_per_page', true); // get the per page meta value
$per_page       = !empty($per_page_meta) ? $per_page_meta : PER_PAGE_DEFAULT; // Get posts per page (new since 3.0)

// get page template
$custom_fields = get_post_custom_values('_wp_page_template', $post->ID);
$p_tpl = $custom_fields[0];

// set the resize of the images to false by default to use the WordPress thumbnails
$resize_images  = true;
$image_size     = 'tablet';

// If template is a standard portfolio template
if ($p_tpl        == "template-one-column.php" ||
	$p_tpl          == "template-two-column.php" ||
	$p_tpl          == "template-three-column.php" ||
	$p_tpl          == "template-four-column.php"||
	$p_tpl          == "template-lightbox.php" ||
	$p_tpl          == "template-grid-fullsize.php" ||
	$p_tpl          == "template-scroller.php" ){
	$infiniteScroll = true;
}

// if we have a one column template
if ($p_tpl        == "template-one-column.php" ) {
	$resize_images = get_post_meta($post->ID, '_' . MAX_SHORTNAME . '_page_original_aspect', true) == 'true' ? false : true;
}

// Template is the One Column Template so show larger images
if ( $p_tpl == "template-one-column.php" ) {
  $image_size    = 'tablet';
}

// Template is the Fullsize Scroller Template
if( $p_tpl == "template-scroller.php" ){
	$per_page          = 9999;
	$pageInfo          = false;
	$infiniteScroll    = false;
	$image_size        = max_get_image_string();
	$resize_images     = false;
}

// Template is the Fullsize Grid Template
if( $p_tpl == "template-grid-fullsize.php" ) :
  $pageInfo         = false;
  $image_size       = 'content';
endif;

// Template is the Sortable Grid Template
if( $p_tpl == "template-sortable.php"){
	$pageInfo      = false;
	$categories    = get_post_meta($post->ID, 'max_sortable_galleries', true);
	$per_page      = 9999;
}

// query the posts if we are not in a tax page template
if(!is_tax()):

  global $max_random_posts_query;

  $orderby = get_post_meta($post->ID, 'max_gallery_order', true);
  $order   = get_post_meta($post->ID, 'max_gallery_sort', true);

  $seed = date('Ymdhi');  // Use date('Ymdhi') to get a change minutely
  $max_random_posts_query = " ORDER BY rand($seed) "; // Turn on filter

  // get the portfolio posts
  $portfolio_args = array(
  	'post_type'   => POST_TYPE_GALLERY,
  	'orderby'     => $orderby,
  	'order'       => $order,
  	'showposts'   => $per_page,
  	'paged'       => $paged,
  	'tax_query'   => array(
  		array(
  			'taxonomy'  => GALLERY_TAXONOMY,
  			'terms'     => max_set_term_order($categories),
  			'field'     => 'term_id',
  		)
  	)
  );

  // query posts with arguments from above ($portfolio_args)
  $portfolio_posts = new WP_Query($portfolio_args);

else :

  // it's a taxonomy, query the posts
  $tax      = $wp_query->get_queried_object();
  $args     = array(
	'post_type' => POST_TYPE_GALLERY,
	'paged'     => $paged,
	'showposts' => $per_page,
	'orderby'   => $orderby,
	'order'     => $order,
	'tax_query' => array(
  		array(
  			'taxonomy'  => GALLERY_TAXONOMY,
  			'terms'     => $tax->term_id,
  			'field'     => 'term_id',
  		)
  	)
  );
  $portfolio_posts = new WP_Query($args);

endif;

if ( !post_password_required() ){ ?>

	<?php if ($portfolio_posts->have_posts()) : ?>

		<div class="portfolio-holder">

			<div id="max-preloader">
				<div class="max-loader">
				</div>
			</div>

			<ul id="portfolioList" class="clearfix portfolio-list loading">

				<?php while ($portfolio_posts->have_posts()) : $portfolio_posts->the_post(); ?>

				<?php
				$_term_classes = "";

				// check if the template is a quicksand sortable template
				if( $p_tpl == "template-sortable.php" ){

					// get the term slug and display it as class list
					foreach( @get_the_terms( get_the_ID(), GALLERY_TAXONOMY) as $term ) {
						$_term_classes .= urldecode($term->slug." ");
					}

				}
				?>

				<?php
				// get the lightbox class
				$lightbox_class = max_get_post_lightbox_class();
				if( get_option_max('image_always_lightbox') == 'true' ) :
					$video_class = "";
					if( $lightbox_class === 'video') $video_class = " video";
					$lightbox_class = $video_class.' detail-link';
				endif;
				?>

				<li data-time="<?php the_time('Ymdhi') ?>" data-modified="<?php the_modified_time('Ymdhi') ?>" data-menuorder="<?php echo $post->menu_order ?>" data-id="id-<?php echo get_the_ID() ?>" class="item <?php echo $lightbox_class ?> <?php echo $_term_classes; ?><?php if( get_option_max( 'image_show_caption' ) == "always") { echo(" show-title"); } ?><?php if( get_option_max('image_show_fade') != "true" || get_post_meta(get_query_var('page_id'), MAX_SHORTNAME.'_disable_post_lightbox', true) == 'true' || get_post_meta(get_the_ID(),  MAX_SHORTNAME.'_photo_item_type_value', true) == 'disable_link' ) { echo(" no-hover"); } ?>">
					<figure class="shadow">

						<?php
						// get the gallery item
						if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {

							max_get_post_custom_image( get_post_thumbnail_id() , false, false, $image_size);

						} else {
							echo max_get_dummy_image( true );
						}

						if($itemCaption === true) {

							// check if caption option is selected
							if ( get_option_max( 'image_show_caption' ) == 'true' || get_option_max( 'image_show_caption' ) == 'always'  ) {
							?>

							<figcaption class="item-caption">
								<div>
									<strong class="title"><?php echo get_the_title() ?></strong>
									<?php if( !$hideExcerpt &&  get_the_excerpt() != "" && get_option_max('image_caption_excerpt', 'false') == 'false' ) { ?>
									<?php echo '<span class="excerpt">'. strip_tags(get_the_excerpt()) . '</span>'; ?>
									<?php }	?>
								</div>
							</figcaption>

						<?php
							}
						}
						?>

						<?php if( get_option_max('image_always_lightbox') == 'true' ) : ?>
						<a href="<?php the_permalink() ?>" class="hover-link-icon"><?php _e('Link to detail page', MAX_SHORTNAME) ?></a>
						<?php endif; ?>

					</figure>

					<?php
					// check if additional options is selected
					if ( $pageInfo == 'true' ) : ?>
					<div class="item-information">
						<ul>
							<?php if( get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_copyright_link_value', true) != "" ){ ?>

							<li><?php _e('Copyright','invictus') ?>: <a href="<?php echo get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_copyright_link_value', true) ?>" title="<?php echo get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_copyright_information_value', true) ?>" target="_blank"><?php echo get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_copyright_information_value', true) ?></a></li>

							<?php } else { ?>

							<li><?php _e('Copyright','invictus') ?>: <?php echo get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_copyright_information_value', true) ?></li>

							<?php } ?>

							<li><?php _e('Location','invictus') ?>: <span><?php echo get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_location_value', true) ?></span></li>
							<?php if(get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_date_value',true) != "" && max_is_valid_timestamp(get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_date_value',true)) === true ){ ?>
							<li><?php _e('Date','invictus') ?>: <span><?php echo date(get_option('date_format'), get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_date_value', true)) ?></span></li>
							<?php }else{ ?>
							<li><?php _e('Date','invictus') ?>: <span>-</span></li>
							<?php } ?>
						</ul>
					</div>
					<?php endif;	?>

				</li>

				<?php endwhile; ?>
			</ul>

		</div>

    	<br />
		<?php
		/* Display navigation to next/previous pages when applicable */
		if (function_exists("max_pagination")) :
 			max_pagination($portfolio_posts);
		endif;
		?>

		<?php else : ?>

		<?php if($post->post_content == "") : ?>
		<h2><?php _e("Whoops! Can't seem to find any galleries!", MAX_SHORTNAME) ?></h2>
		<p><?php _e('It seems you have not selected any galleries to show on this template. Please select at least one gallery to show some photo posts on this page template.', MAX_SHORTNAME); ?></p>
		<?php endif; ?>

	<?php endif; ?>

<?php } ?>
<?php wp_reset_query(); ?>