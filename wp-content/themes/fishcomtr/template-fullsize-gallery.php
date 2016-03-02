<?php
/**
 * Template Name: Portfolio Fullsize Background Gallery
 *
 * @package WordPress
 * @subpackage Invictus
 */

global $isFullsizeGallery, $fullsize_gallery_posts;


if ( !post_password_required() ) {
	$isFullsizeGallery = true;
	$showSuperbgimage = true;
}

// Generated values !! DO NOT CHANGE !!
// get the posts for the supersized background

// get post order
$order_string = get_post_meta($post->ID, 'max_gallery_order', true);
$order_by = "&orderby=".$order_string;

$sort_string = get_post_meta($post->ID, 'max_gallery_sort', true);
$sort_by = "&order=".$sort_string;

//Get the page meta informations and store them in an array
$meta = max_get_cutom_meta_array();

get_header();

?>


<?php
	// get the password protected login template part
	if ( post_password_required() ) {
		get_template_part( 'includes/page', 'password.inc' );
	} else{

	$show_fullsize_overlay = get_post_meta($post->ID, 'max_show_page_fullsize_overlay', true);
	?>

	<div id="single-page" class="clearfix left-sidebar">

		<?php
		/* Get the sidebar if we have set one - otherwise show nothing at all */
		$sidebar_string = max_get_custom_sidebar('sidebar-fullsize-gallery'); /* get the custom or default sidebar name */

		// include the sidebar.php template
		get_sidebar();
		?>

		<div id="primary" class="template-fullsize-gallery">

			<div id="content" role="main">
			<?php if($show_fullsize_overlay == "true"){ ?>
  			<header <?php post_class('entry-header'); ?> id="post-<?php echo the_ID() ?>" >

  				<h1 class="page-title"><?php the_title() ?></h1>
  				<?php
  				// check if there is a excerpt
  				if( max_get_the_excerpt() && $show_fullsize_overlay == "true" ){
  				?>
  				<h2 class="page-description"><?php max_get_the_excerpt(true) ?></h2>
  				<?php } ?>

  			</header>
			<?php } ?>
			</div>

		</div>

	</div>
<?php

// get the portfolio posts
$portfolio_args = array(
	'post_type'   => POST_TYPE_GALLERY,
	'orderby'     => $order_string,
	'order'       => $sort_string,
	'showposts'   => get_post_meta( $post->ID, MAX_SHORTNAME.'_page_fullsize_count', true ),
	'tax_query'   => array(
		array(
			'taxonomy'  => GALLERY_TAXONOMY,
			'terms'     => max_set_term_order(get_post_meta($post->ID, 'max_select_gallery', true)),
			'field'     => 'term_id',
		)
	)
);

// query posts with arguments from above ($portfolio_args)
$fullsize_gallery_posts = new WP_Query($portfolio_args);
$cntPosts = $fullsize_gallery_posts->post_count;

// sort the posts in correct numeric order
if( !empty($order_string) && $order_string === 'title' ) {
  usort($fullsize_gallery_posts->posts, 'max_numeric_post_sort');

  if( $sort_string == 'DESC' ) {
    $fullsize_gallery_posts->posts = array_reverse($fullsize_gallery_posts->posts);
  }

}

// check if there are video posts in the query
$_query_has_videos = false;

if ($fullsize_gallery_posts->have_posts()) : while ($fullsize_gallery_posts->have_posts()) : $fullsize_gallery_posts->the_post();
	if( get_post_meta( $post->ID, MAX_SHORTNAME.'_photo_item_type_value', true) == 'selfhosted' ||
		get_post_meta( $post->ID, MAX_SHORTNAME.'_photo_item_type_value', true) == 'youtube_embed' ||
		get_post_meta( $post->ID, MAX_SHORTNAME.'_photo_item_type_value', true) == 'vimeo_embed'  ){
		$_query_has_videos = true;
	}
endwhile;
endif;

// check if a slide show is available => more than 1 image for the gallery
$show_slideshow = false;
if( $cntPosts > 1 ) {
	$show_slideshow = true;
}
?>

<?php } ?>
<?php get_footer(); ?>