<?php
/**
 * @package WordPress
 * @subpackage Invictus
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php
		// check if there is a excerpt
		if( max_get_the_excerpt() ){
		?>
		<h2 class="page-description"><?php max_get_the_excerpt(true) ?></h2>
		<?php } ?>

		<?php
		if (has_post_thumbnail( $post->ID ) ):
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			$imageFull = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

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

			<div class="entry-image">
			<a href="<?php echo $imageFull[0] ?>" data-rel="prettyPhoto" data-link="<?php get_permalink($post_id) ?>" title="<?php echo strip_tags($img_excerpt); ?>">
				<img src="<?php echo $image[0] ?>" width="<?php echo MAX_CONTENT_WIDTH ?>" class="fade-image" alt="<?php echo strip_tags($img_title) ?>" />
			</a>
			</div>
			<br />
		<?php endif; ?>

		<?php if ( 'post' == $post->post_type ) : ?>
		<div class="entry-meta">
			<?php
				printf( __( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'invictus' ),
					get_permalink(),
					get_the_date( 'c' ),
					get_the_date(),
					get_author_posts_url( get_the_author_meta( 'ID' ) ),
					sprintf( esc_attr__( 'View all posts by %s', 'invictus' ), get_the_author() ),
					get_the_author()
				);
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
	<div class="entry-summary">
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'invictus' ) ); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'invictus' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'invictus' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

  	<?php comments_template( '', true ); ?>

	<?php endif; ?>


</article><!-- #post-<?php the_ID(); ?> -->
