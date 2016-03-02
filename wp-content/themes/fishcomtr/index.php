<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */

global $fullsize_gallery_posts;

$main_homepage = true;

// get featured galleries
$cat_string = is_array(get_option_max('fullsize_featured_cat')) ? implode( ',' , get_option_max('fullsize_featured_cat')) : get_option_max('fullsize_featured_cat');

// get post order
$order_string = get_option_max('fullsize_featured_order');
$sorting_string = get_option_max('fullsize_featured_sorting');

// get the portfolio posts
$portfolio_args = array(
	'post_type'   => POST_TYPE_GALLERY,
	'orderby'     => $order_string,
	'order'       => $sorting_string,
	'showposts'   => get_option_max('fullsize_featured_count'),
	'tax_query'   => array(
		array(
			'taxonomy'  => GALLERY_TAXONOMY,
			'terms'     => max_set_term_order( get_option_max('fullsize_featured_cat') ),
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

// check if a slide show is available => more than 1 image for the gallery
$show_slideshow = false;
if( get_option_max('fullsize_featured_count') > 1 ) {
	$show_slideshow = true;
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

get_header();

// check if title & exerpt should be shown
$show_fullsize_title = get_option_max('fullsize_featured_title_show');
?>

<div id="single-page">

	<div id="primary" class="template-fullsize-gallery">

		<div id="content" role="main">
			<header <?php post_class('entry-header'); ?> id="post-<?php the_ID(); ?>" >

				<?php if($show_fullsize_title == 'true'){ ?>
				<h1 class="page-title"><?php echo get_option_max('fullsize_featured_title') ?></h1>
				<?php } ?>
				<?php
				// check if there is a excerpt
				if( get_option_max('fullsize_featured_text') != '' && $show_fullsize_title == 'true' ){
				?>
				<h2 class="page-description"><?php echo get_option_max('fullsize_featured_text') ?></h2>
				<?php } ?>

			</header>
		</div>

	</div>

	<?php
	// Check if Homepage Sidebar is activated
	if ( get_option_max('homepage_show_homepage_sidebar') == 'true' ) {

		/* Get the sidebar if we have set one - otherwise show nothing at all */
	    $sidebar_string = max_get_custom_sidebar('sidebar-homepage'); /* get the custom or default sidebar name */

	    // include the sidebar.php template
	    get_sidebar();

    }?>

</div>

<?php get_footer(); ?>