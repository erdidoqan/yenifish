<?php
/**
 * Template Name: Portfolio Fullsize Background Video
 *
 * @package WordPress
 * @subpackage Invictus
 */
global $meta, $isFullsizeVideo, $fullsize_gallery_posts;

/* Get the page meta informations and store them in an array */
$meta = max_get_cutom_meta_array();

$isFullsizeGallery = true;
$showSuperbgimage = true;
$isFullsizeVideo = true;

/* query the page object - olé */
$fullsize_gallery_posts = new WP_Query(
    array(
      'post_type' => 'page',
      'post__in'  => array( get_the_ID() )
    )
);

get_header(); ?>

<?php
/* get the password protected login template part */
if ( post_password_required() ) {
	get_template_part( 'includes/page', 'password.inc' );
}
?>

<?php if ( !post_password_required() ) { ?>

	<?php $show_fullsize_title = $meta['max_show_page_fullsize_title']; ?>

		<div id="fullsizeVideoHolder">
			<div id="fullsizeVideo" class="fullsize-video-<?php the_ID(); ?>">
				<div id="youtubeplayer" class="video-hide"></div>
				<div id="vimeoplayer" class="video-hide"></div>
				<div id="selfhostedplayer" class="video-hide"></div>
			</div>
		</div>

		<div id="single-page" class="clearfix left-sidebar">

		<?php
			/* Get the sidebar if we have set one - otherwise show nothing at all */
			$sidebar_string = max_get_custom_sidebar('sidebar-fullsize-video'); /* get the custom or default sidebar name */

			// include the sidebar.php template
			get_sidebar();
			?>

			<div id="primary" class="template-fullsize-video">

				<div id="content" role="main">


					<?php if($show_fullsize_title == true){ ?>
					<header <?php post_class('entry-header'); ?> id="post-<?php the_ID(); ?>" >
						<h1 class="page-title"><?php the_title() ?></h1>
						<?php
						/* check if there is a excerpt */
						if( max_get_the_excerpt() && $show_fullsize_title == true ){
						?>
						<h2 class="page-description"><?php max_get_the_excerpt(true) ?></h2>
						<?php } ?>
					</header>
					<?php } ?>

					<?php the_content() ?>

				</div>

			</div>

		</div>

	</div>

			<script type="text/javascript">

				jQuery(document).ready(function($) {

					jQuery('#fullsize > a').livequery(function(){

						var dataUrl = jQuery(this).attr('data-url');
						window.videoUrl = jQuery.parseJSON(dataUrl);

					});

					var json = {
						post_type: 		   window.videoUrl.type,
						postID:			     window.videoUrl.postID,
						embedded_code: 	 window.videoUrl.embedded_code,
						playerID: 		   'fullsizeVideo',
						poster_url: 	   window.videoUrl.poster_url
					}

					var selfhosted = {};
					if(window.videoUrl.type == 'selfhosted') {
						selfhosted = {
							stretch_video: 	 window.videoUrl.stretch_video,
							url_m4v: 	       window.videoUrl.url_m4v,
							url_ogv: 	       window.videoUrl.url_ogv,
							url_webm: 	     window.videoUrl.url_webm
						}
					}

					$.getScript("<?php echo get_template_directory_uri(); ?>/js/post-video.js", function(data, textStatus, jqxhr){
						jQuery('#fullsizeVideo').css({ display: 'block' });
					})

					$('body').addClass('fullsize-gallery');

				});

			</script>
<?php } ?>
<?php get_footer(); ?>