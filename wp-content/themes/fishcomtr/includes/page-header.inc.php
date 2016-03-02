<?php
global $hasExcerpt;

$meta = max_get_cutom_meta_array();

/* get the mobile detect class */
$_show_page_heder  = !empty( $meta[MAX_SHORTNAME."_page_show_header"] ) ? $meta[ MAX_SHORTNAME."_page_show_header" ] : 'true';

?>
<?php if( $_show_page_heder === 'true' ) : ?>

<header id="post-<?php the_ID(); ?>-header" class="entry-header">

	<h1 class="page-title"><?php the_title(); ?></h1>
	<?php
	// check if there is a excerpt
	if( max_get_the_excerpt() ){
		$hasExcerpt = true;	?>
	<h2 class="page-description"><?php max_get_the_excerpt(true) ?></h2>
	<?php } ?>
</header><!-- .entry-header -->

<?php endif; ?>