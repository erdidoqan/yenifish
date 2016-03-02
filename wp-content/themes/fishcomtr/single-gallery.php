<?php
/**
 * @package WordPress
 * @subpackage invictus
 */

global $meta, $isPost;

$showSuperbgimage = true ;
$fromGallery = true;
$isPost = true;

// store post id for use in other loops
$_stored_postid = $post->ID;

//Get the page meta informations and store them in an array
$meta = max_get_cutom_meta_array();

if(isset($meta[MAX_SHORTNAME.'_photo_slider_select'])) :

	/*-----------------------------------------------------------------------------------*/
	/*  Get Slides Slider JS if needed
	/*-----------------------------------------------------------------------------------*/
	if( $meta[MAX_SHORTNAME.'_photo_slider_select'] == 'slider-slides'){
		wp_enqueue_script('jquery-slides', get_template_directory_uri() .'/slider/slides/slides.min.jquery.js', array('jquery'));
		wp_enqueue_style('slides-css', get_template_directory_uri().'/slider/slides/slider-slides.css', false, false);
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Get Nivo Slider JS if needed
	/*-----------------------------------------------------------------------------------*/

	if($meta[MAX_SHORTNAME.'_photo_slider_select'] == 'slider-nivo'){
		wp_enqueue_script('jquery-nivo', get_template_directory_uri() .'/slider/nivo/jquery.nivo.slider.js', array('jquery'));
		wp_enqueue_style('nivo-css', get_template_directory_uri().'/slider/nivo/nivo-slider.css', false, false);
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Get Kwicks Slider JS if needed
	/*-----------------------------------------------------------------------------------*/
	if($meta[MAX_SHORTNAME.'_photo_slider_select'] == 'slider-kwicks'){
		wp_enqueue_script('jquery-kwicks', get_template_directory_uri() .'/slider/kwicks/jquery.kwicks.min.js', array('jquery'));
		wp_enqueue_script('jquery-flexslider', get_template_directory_uri() .'/slider/flexslider/jquery.flexslider.min.js', array('jquery'));

		wp_enqueue_style('nivo-css', get_template_directory_uri().'/slider/flexslider/flexslider.css', false, false);
		wp_enqueue_style('kwicks-css', get_template_directory_uri().'/slider/kwicks/kwicks-slider.css', false, false);
	}

endif;

/*-----------------------------------------------------------------------------------*/
/*  Get JPlayer JS if needed
/*-----------------------------------------------------------------------------------*/
if( $meta[MAX_SHORTNAME.'_photo_item_type_value'] == 'selfhosted' || $meta[MAX_SHORTNAME.'_photo_item_type_value'] == 'embedded' )  {
	wp_enqueue_script('swobject', get_template_directory_uri() .'/js/swfobject.js', 'jquery');
	wp_enqueue_script('jwplayer', get_template_directory_uri() .'/js/jwplayer/jwplayer.js', 'jquery');
}

wp_reset_query();

get_header();

?>

<div id="single-page" class="clearfix left-sidebar">

    <div id="primary">

		<?php

		the_post();

		// get the posts terms for further use
		$terms = wp_get_post_terms($post->ID, GALLERY_TAXONOMY);
		$term_list = "";
		$post_terms = array();
		foreach ($terms as $term) {
			$term_list[] = '<a href="' . get_term_link($term->slug, GALLERY_TAXONOMY) . '">'.$term->name.'</a>';
			$post_terms[$term->term_id] =  $term->slug;
		}
		$term_list = @implode(', ', $term_list);

		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">

				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php
				// check if there is a excerpt
				if( max_get_the_excerpt() ){
				?>
				<h2 class="entry-description"><?php max_get_the_excerpt(true) ?></h2>
				<?php } ?>

				<div class="clearfix entry-meta entry-meta-head">

					<ul>
					<?php
					// show post meta
					$post_meta = get_option_max('images_meta_show', 'false');

					if( empty($post_meta) || $post_meta != 'true') {

						if( get_option_max( 'images_meta_show_author', 'false' ) != 'true' ) {
							printf( __( '<li>By <span class="vcard author"><span class="fn">%1$s</span><span class="role">Author</span></span>&nbsp;/</li> ', MAX_SHORTNAME), get_the_author() );
						}

						if( get_option_max( 'images_meta_show_date', 'false' ) != 'true' ) {
							printf( __( '<li><span class="published">%1$s</span>&nbsp;/</li>', MAX_SHORTNAME), get_the_time(get_option('date_format')) );
						}

						if( get_option_max( 'images_meta_show_category', 'false' ) != 'true' ) {
							printf( __( '<li>In <span>%1$s</span></li>', MAX_SHORTNAME), substr($term_list, 0) );
						};

						if ( 'open' == $post->comment_status && get_option_max( 'images_meta_show_comment' , 'false' ) != 'true' ) :
							echo '<li class="cnt-comment">&nbsp;/&nbsp;<a href="'. get_permalink() .' #comments-holder"><span class="icon"></span>';
							comments_number( __('No Comments', MAX_SHORTNAME), '1 '. __('Comment', MAX_SHORTNAME), '% '. __('Comments', MAX_SHORTNAME) );
							echo '</a></li>';
						endif;

						printf( __( '<li class="last-update">Last Update <span class="updated">%1$s</span>&nbsp;/</li>', MAX_SHORTNAME), get_the_time(get_option('date_format')) );

					}
					?>
					</ul>

					<!-- Entry nav -->
					<?php
					// show post meta
					$post_nav = get_option_max('images_post_nav_show', 'false');

					if( empty($post_nav) || $post_nav != 'true') {

						// Get all Images from the Gallery for navigation
						$term_ids = array();
						foreach($post_terms as $index => $value){
							$term_ids[$index] = $index;
						}
						$_nav_ids = max_get_custom_prev_next($term_ids);
						?>
						<ul class="nav-posts">
							<?php if($_nav_ids['prev_id']){ ?>
							<li class="nav-previous tooltip" title="<?php _e('Previous post', MAX_SHORTNAME) ?>"><a href="<?php echo get_permalink( $_nav_ids['prev_id'] ) ?>"><span class="meta-nav"><?php _e( 'Previous post link', MAX_SHORTNAME ) ?></span></a></li>
							<?php } ?>
							<?php if($_nav_ids['next_id']){ ?>
							<li class="nav-next tooltip" title="<?php _e('Next post', MAX_SHORTNAME) ?>"><a href="<?php echo get_permalink( $_nav_ids['next_id'] ) ?>"><span class="meta-nav"><?php _e( 'Next post link', MAX_SHORTNAME ) ?></span></a></li>
							<?php } ?>
						</ul>

					<?php } ?>

				</div><!-- .entry-meta -->

			</header><!-- .entry-header -->

			<?php if ( !post_password_required() ) { ?>

			<div id="content" role="main">

				<?php
				/*-----------------------------------------------------------------------------------*/
				/*  Get the needed Slider Template if a slider is selected
				/*-----------------------------------------------------------------------------------*/
				if( isset($meta[MAX_SHORTNAME.'_photo_slider_select']) && $meta[MAX_SHORTNAME.'_photo_slider_select'] != "" && $meta[MAX_SHORTNAME.'_photo_slider_select'] != "none" && $meta[MAX_SHORTNAME.'_photo_item_type_value'] == 'projectpage' ){
					// strip of "slider-"
					$slider_tpl = explode("-", $meta[MAX_SHORTNAME.'_photo_slider_select'] );
					get_template_part( 'includes/slider', $slider_tpl[1].'.inc' );
				}
				/*-----------------------------------------------------------------------------------*/
				/*  Get the needed Image or Video
				/*-----------------------------------------------------------------------------------*/
				else if( $meta[MAX_SHORTNAME.'_photo_item_type_value'] == 'selfhosted' ||
					$meta[MAX_SHORTNAME.'_photo_item_type_value'] == 'youtube_embed' ||
					$meta[MAX_SHORTNAME.'_photo_item_type_value'] == "vimeo_embed" )
				{



					get_template_part( 'includes/post', 'video.inc' );

				}else{

					// start featured image code here
					if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {

						// Get the thumbnail
						$post_image_url = max_get_post_image_url($post_id, 'full');
						$showUrl = $post_image_url[0];

						// Check if images should be cropped
						$timb_height ='';
						$timb_img_height = '';

						if(get_option_max( 'image_project_original_ratio' ) != 'true' ) {
							$timb_height = 270;
							$timb_img_height = 'height="270"';

			                // get the imgUrl for showing the post image
			                $imgUrl = max_get_custom_image_url(get_post_thumbnail_ID(), get_the_ID(), MAX_CONTENT_WIDTH, $timb_height, get_cropping_direction( $meta[MAX_SHORTNAME.'_photo_cropping_direction_value'] ) );

						}else{
				           // get the default image if we don't have to crop
			    	        $imgUrl = max_get_image_path( get_the_ID(), 'large' );
			            }

				?>

					<div class="entry-image">
						<?php
							// Check if it is an image or video
							if( $meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] == "YouTube-Video" || $meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] == 'youtube' ){
								$showUrl = $meta[MAX_SHORTNAME.'_photo_video_youtube_value'];
							}
						?>

						<?php
							// Check if it is an image or video
							if( $meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] == "Photo" || $meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] == "photo"){
							}
						?>

						<?php
							// Check if it is an image or video
							if( $meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] == "Vimeo-Video" || $meta[MAX_SHORTNAME.'_photo_lightbox_type_value'] == "vimeo"){
								$showUrl = $meta[MAX_SHORTNAME.'_photo_video_vimeo_value'];
							}
						?>

					  <?php
					  $img_excerpt = get_the_excerpt();
					  $img_title   = get_the_title();
					  $img_alt     = get_the_title();

					  // check wether to choose image or post meta informations on the lightbox
					  if( get_option_max('general_use_image_meta') == 'true' ) :

					    // get the meta from the image information on the media library
	        $img_title = get_post_field('post_title', get_post_thumbnail_id());
	        $img_excerpt = get_post_field('post_excerpt', get_post_thumbnail_id());

					  endif;
					  ?>

						<?php
						// check if a lightbox should be shown
						if ( @$meta[MAX_SHORTNAME.'_photo_lightbox'] != 'true' ) {
						?>
						<a href="<?php echo $showUrl; ?>" data-link="<?php echo get_permalink($post_id) ?>" class="scroll-link" style="display: block;" data-rel="prettyPhoto" title="<?php echo strip_tags($img_excerpt); ?>">
						<?php } ?>
						   <img src="<?php  echo $imgUrl; ?>" class="fade-image<?php if( get_option_max('image_show_fade') != "true") { echo(" no-hover"); } ?>" alt="<?php echo strip_tags($img_title); ?>" title="<?php echo strip_tags($img_title); ?>" />
						<?php if ( @$meta[MAX_SHORTNAME.'_photo_lightbox'] != 'true' ) { ?>
						</a>
						<?php } ?>

					</div>

				<?php }  ?>
				<?php // end featured image code here ?>
				<?php } ?>

				<div class="clearfix">

					<?php if( $meta[MAX_SHORTNAME.'_photo_copyright_information_value'] != "" || $meta[MAX_SHORTNAME.'_photo_copyright_link_value'] || $meta[MAX_SHORTNAME.'_photo_location_value'] != "" || $meta[MAX_SHORTNAME.'_photo_date_value'] != "" ) { ?>
					<div class="entry-meta">
						<ul class="clearfix ">
							<?php if( $meta[MAX_SHORTNAME.'_photo_copyright_link_value'] != "" ){ ?>

							<li><?php _e('Copyright','invictus') ?>: <a href="<?php echo $meta[MAX_SHORTNAME.'_photo_copyright_link_value'] ?>" title="<?php echo $meta[MAX_SHORTNAME.'_photo_copyright_information_value'] ?>" target="_blank"><?php echo $meta[MAX_SHORTNAME.'_photo_copyright_information_value'] ?></a></li>

							<?php } else { ?>

							<li><?php _e('Copyright','invictus') ?>: <?php echo $meta[MAX_SHORTNAME.'_photo_copyright_information_value'] ?></li>

							<?php } ?>

							<?php if( $meta[MAX_SHORTNAME.'_photo_location_value'] != "" ) { ?> <li><?php _e('Location','invictus') ?>: <span><?php echo $meta[MAX_SHORTNAME.'_photo_location_value'] ?></span></li> <?php } ?>
							<?php if( $meta[MAX_SHORTNAME.'_photo_date_value'] != "" ) { ?> <li><?php _e('Date','invictus') ?>: <span><?php echo date(get_option('date_format'),$meta[MAX_SHORTNAME.'_photo_date_value']) ?></span></li> <?php } ?>
						</ul>
					</div><!-- .entry-meta -->
					<?php } ?>


					<?php
						// including the loop template social-share.inc.php
						get_template_part( 'includes/social', 'share.inc' );
					?>

					<?php if(get_the_tag_list()){ ?>
					<ul class="clearfix entry-tags">
						<?php echo get_the_tag_list('<li class="title">Tags:<li>','<li>','</li>'); ?>
					</ul>
					<?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div><!-- .entry-content -->


				</div>

			<?php
			// Check if other images of a gallery should be shown
			if ( get_option_max('image_show_gallery_images') == "true" ){

					// fetch the gallery terms attached to this photo posts
					$obj_galleryTerms = wp_get_post_terms($post->ID, GALLERY_TAXONOMY);
					foreach($obj_galleryTerms as $index => $value){
						$galleryTerms[$value->term_id] = $value->term_id;
					}

	    // get the gallery posts
	    $gallery_args = array(
	    	'post_type'   => 'gallery',
	    	'orderby'     => 'rand',
	    	'order'       => 'DESC',
	    	'showposts'   => get_option_max('image_count_gallery_images'),
	    	'tax_query'   => array(
	    		array(
	    			'taxonomy'  => GALLERY_TAXONOMY,
	    			'terms'     => max_set_term_order($galleryTerms),
	    			'field'     => 'term_id',
	    		)
	    	)
	    );

	    // query posts with arguments from above ($gallery_args)
	    $gallery_posts = new WP_Query($gallery_args);

					$imgDimensions = array( 'width' => 400, 'height' => 300 );

				?>

				<?php if ( $gallery_posts->have_posts() ){ // show posts if query found some ?>

					<div id="relatedGalleryImages" class="entry-related-images portfolio-four-columns">
						<h3 class="related-title"><?php _e('More from this Gallery', MAX_SHORTNAME) ?></h3>

						<div id="max-preloader">
							<div class="max-loader">
							</div>
						</div>

						<ul id="portfolioList" class="clearfix portfolio-list">

							<?php
							// start the posts loop
							while ($gallery_posts->have_posts()) : $gallery_posts->the_post();

						          // get the default image if we don't have to crop
						          $_imgUrl = max_get_custom_image_url(get_post_thumbnail_id( get_the_ID() ), null, 400, 300, get_cropping_direction( get_post_meta(get_the_ID(), MAX_SHORTNAME.'_photo_cropping_direction_value', true) ) );

								?>
								<li data-id="id-<?php echo get_the_ID() ?>" class="item <?php echo max_get_post_lightbox_class(); ?><?php if( get_option_max('image_show_fade') != "true") { echo(" no-hover"); } ?>">
									<div class="shadow">
										<?php echo '<a href="' . get_permalink() . '" title="' . strip_tags(get_the_title()) . '"><img src="' . $_imgUrl .'" alt="' . strip_tags(get_the_title()) . '" /></a>'; ?>
									</div>
									<?php
									// check if caption option is selected
									if ( get_option_max( 'image_show_caption' ) == 'true' ) {
									?>
									<div class="item-caption">
										<strong><?php echo get_the_title() ?></strong>
									</div>
									<?php } ?>
								</li>
							<?php endwhile; // end of the loop. ?>

						</ul>

					</div>

				<?php } ?>

			<?php } ?>

			<?php wp_reset_query();	// reset the gallery image query ?>

			<?php
				// Check if author should be shown and get the Author Infos
				if ( get_option_max('general_show_photo_author') == "true" ){
					echo do_shortcode("[authorbox]");
				}
			?>

			<?php
				// Get Related Posts
				echo do_shortcode("[related_posts]");
			?>

			<?php comments_template( '', true ); ?>

		</div><!-- #content -->

		<?php }else{ ?>

		<div id="content" role="main">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="clearfix">

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

				</div>

			</article><!-- #post-<?php the_ID(); ?> -->

		</div><!-- #content -->

		<?php } ?>

		</article><!-- #post-<?php the_ID(); ?> -->

	</div><!-- #primary -->

	<?php
	/* Get the sidebar if we have set one - otherwise show nothing at all */
	$sidebar_string = max_get_custom_sidebar('sidebar-gallery-project'); /* get the custom or default sidebar name */

	// include the sidebar.php template
	get_sidebar();
	?>

</div>

<?php get_footer(); ?>