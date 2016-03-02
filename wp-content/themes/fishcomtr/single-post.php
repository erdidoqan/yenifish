<?php
/**
 * Template for displaying the Blog Detail Page
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 1.0
 */

global $meta, $isPost, $post_meta, $isBlog;

$showSuperbgimage = true;
$isPost = true;
$isBlog = true;

//Get the post meta informations and store them in an array
$meta = max_get_cutom_meta_array(get_the_ID());

if( isset( $meta[MAX_SHORTNAME.'_photo_slider_select'] ) ) :

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

get_header();

the_post();

// Check for full width blog detail page
if( get_option_max( 'general_show_fullblog_details', 'false' ) == 'true'){
	$post_sidebar = 'no-sidebar';
	$post_width = MAX_FULL_WIDTH;
}else{
	$post_sidebar = 'left-sidebar';
	$post_width = MAX_CONTENT_WIDTH;
}

?>

<div id="single-page" class="clearfix blog <?php echo $post_sidebar ?>">

	<div id="primary" class="hfeed">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">

				<h1 class="entry-title"><?php the_title(); ?></h1>

				<?php if ( !post_password_required() ) : ?>

				<div class="clearfix entry-meta entry-meta-head">

					<ul>
					<?php
					// get entry categories
					$post_categories = wp_get_post_categories( $post->ID );
					$cat_list = array();
					foreach ( $post_categories as $c ) {
						$cat = get_category( $c );
						$cat_list[] .= '<a href="'. get_category_link( $c ) .'">'. $cat->name .'</a>';
					}

					$cat_list = implode(', ', $cat_list);

					// show post meta
					$blog_meta = get_option_max('blog_meta_show');

					if( empty($blog_meta) || $blog_meta != 'true') {

						if( get_option_max('blog_meta_show_author') != 'true' ) {
							printf( __( '<li>By <span class="vcard author"><span class="fn">%1$s</span><span class="role">Author</span></span>&nbsp;/</li> ', MAX_SHORTNAME), get_the_author() );
						}

						if( get_option_max('blog_meta_show_date') != 'true' ) {
							printf( __( '<li><span class="published">%1$s</span>&nbsp;/</li>', MAX_SHORTNAME), get_the_time(get_option('date_format')) );
						}

						if( get_option_max('blog_meta_show_category') != 'true' ) {
							printf( __( '<li>In <span>%1$s</span></li>', MAX_SHORTNAME), substr($cat_list, 0) );
						};

						if ( 'open' == $post->comment_status && get_option_max('blog_meta_show_comment') != 'true' ) :
							echo '<li class="cnt-comment">&nbsp;/&nbsp;<a href="'. get_permalink() .' #comments-holder"><span class="icon"></span>';
							comments_number( __('No Comments', MAX_SHORTNAME), '1 '. __('Comment', MAX_SHORTNAME), '% '. __('Comments', MAX_SHORTNAME) );
							echo '</a></li>';
						endif;

						printf( __( '<li class="last-update">Last Update <span class="updated">%1$s</span>&nbsp;/</li>', MAX_SHORTNAME), get_the_time(get_option('date_format')) );

					}
					?>
					</ul>

					<!-- Entry nav -->
					<ul class="nav-posts">
						<?php if(get_previous_post()) {?>
						<li class="nav-previous tooltip" title="<?php _e('Previous post', MAX_SHORTNAME) ?>"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', MAX_SHORTNAME ) . '</span> %title' ); ?></li>
						<?php } ?>
						<?php if(get_next_post()) {?>
						<li class="nav-next tooltip" title="<?php _e('Next post', MAX_SHORTNAME) ?>"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', MAX_SHORTNAME ) . '</span>' ); ?></li>
						<?php } ?>
					</ul>

				</div><!-- .entry-meta -->

				<?php endif; ?>

			</header><!-- .entry-header -->

			<div id="content" role="main">

				<?php if ( !post_password_required() ) : ?>

				<?php
				/*-----------------------------------------------------------------------------------*/
				/*  Get the needed Slider Template if a slider is selected
				/*-----------------------------------------------------------------------------------*/
				if( isset($meta[MAX_SHORTNAME.'_photo_slider_select']) && $meta[MAX_SHORTNAME.'_photo_slider_select'] != "" && $meta[MAX_SHORTNAME.'_photo_slider_select'] != "none" && $meta[MAX_SHORTNAME.'_photo_item_type_value'] == "none" ){
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

					if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {

						// Get the thumbnail
						$imgID = get_post_thumbnail_id();
						$imgUrl_full = max_get_image_path($post->ID, 'full');

						// Check if images should be cropped
						$timb_height ='';
						$timb_img_height = '';

						if(get_option_max( 'image_blog_detail_original_ratio' ) != 'true' ) {
							$timb_height = 250;
							if ( get_option_max( 'general_show_fullblog_details', 'false' ) == 'true' ){
							  $timb_height = 354;
							}
						}

          			// get the imgUrl for showing the post image
						$imgUrl = max_get_custom_image_url(get_post_thumbnail_ID(), get_the_ID(), $post_width, $timb_height, get_cropping_direction( $meta[MAX_SHORTNAME.'_photo_cropping_direction_value'] ) );

					?>

					<div class="entry-image">

					  <?php
					  $img_excerpt = get_the_excerpt();
					  $img_title   = get_the_title();
					  $img_alt     = get_the_title();

					  // check wether to choose image or post meta informations on the lightbox
					  if( get_option_max('general_use_image_meta') == 'true' ) :

					    // get the meta from the image information on the media library
		                $img_title = get_post_field('post_title', get_post_thumbnail_id());
		                $img_excerpt = get_post_field('post_excerpt', get_post_thumbnail_id());
		                $img_alt = get_post_field('_wp_attachment_image_alt', get_post_thumbnail_id());

					  endif;
					  ?>

							<?php
						// check if a lightbox should be shown
						if ( @$meta[MAX_SHORTNAME.'_photo_lightbox'] != 'true' ) {
						?>
						<a href="<?php echo $imgUrl_full; ?>" data-link="<?php echo get_permalink($post_id) ?>" class="scroll-link" style="display: block;" data-rel="prettyPhoto" title="<?php echo $img_excerpt; ?>">
						<?php } ?>
							<img src="<?php echo $imgUrl; ?>" class="fade-image<?php if( get_option_max('image_show_fade') != "true") { echo(" no-hover"); } ?>" alt="<?php echo $img_title; ?>" />
							<?php
						// check if a lightbox should be shown
						if ( @$meta[MAX_SHORTNAME.'_photo_lightbox'] != 'true' ) {
						?>
						</a>
						<?php } ?>

					</div>

					<?php }
				} ?>

				<?php endif; ?>

				<a href="<?php echo $facebook_link; ?>">Link</a>

				<div class="clearfix">

					<?php if ( !post_password_required() ) : // including the loop template social-share.inc.php
						get_template_part( 'includes/social', 'share.inc' );
					endif; ?>

					<?php if( get_the_tag_list() ){ ?>
					<ul class="clearfix entry-tags">
						<?php echo get_the_tag_list('<li class="title">Tags:<li>','<li>','</li>'); ?>
					</ul>
					<?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div><!-- .entry-content -->

				</div>

			<?php if ( !post_password_required() ) : ?>

			<?php
			// Check if author should be shown
			if ( get_option_max('general_show_author') == "true" ) {
				echo do_shortcode("[authorbox]");
			}
			?>

			<?php echo do_shortcode("[related_posts]"); ?>

			<?php comments_template( '', true ); ?>

			<div class="pagination hidden"><p><?php posts_nav_link(' '); ?></p></div>

			<?php endif; ?>

			</div><!-- #content -->

		</article>

	</div><!-- #primary -->

	<?php
	if( $post_sidebar === 'left-sidebar') :
		/* Get the sidebar if we have set one - otherwise show nothing at all */
		$sidebar_string = max_get_custom_sidebar('sidebar-blog-post'); /* get the custom or default sidebar name */

		// include the sidebar.php template
		get_sidebar();
	endif;
	?>

</div>

<?php get_footer(); ?>

