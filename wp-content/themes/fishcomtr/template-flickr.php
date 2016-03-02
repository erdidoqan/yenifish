<?php
/**
 * Template Name: Portfolio Flickr Stream
 *
 * @package WordPress
 * @subpackage invictus
 * @since invictus 1.0
 */

//Get the page meta informations and store them in an array
$meta = max_get_cutom_meta_array($post->ID);

get_header();

$itemCaption = false;

?>

<style type="text/css">
	/** Masonry Portfolio **/
	.page-template-template-flickr-php #flickrPortfolio li {
		visibility: hidden;
	}

</style>


<div id="single-page" class="clearfix left-sidebar">

	<div id="primary" class="portfolio-three-columns" >

		<div id="content" role="main" class="clearfix">

			<?php
			// get the page header template part
			locate_template( array( 'includes/page-header.inc.php'), true, true );
			?>

			<?php /* -- added 2.0 -- */ ?>
			<?php the_content() ?>

			<?php if ( !post_password_required() ) { ?>
			<div class="portfolio-holder">

				<div id="max-preloader">
					<div class="max-loader">
					</div>
				</div>

				<ul id="flickrPortfolio" class="clearfix portfolio-list">
				</ul>

			</div>
			<?php } ?>
			<?php /* -- end -- */ ?>

    		<?php comments_template( '', true ); ?>

		</div><!-- #content -->

	</div><!-- #primary -->

    <?php
    /* Get the sidebar if we have set one - otherwise show nothing at all */
    $sidebar_string = max_get_custom_sidebar('sidebar-gallery-flickr'); /* get the custom or default sidebar name */

    // include the sidebar.php template
    get_sidebar();
    ?>

</div>

<?php if ( !post_password_required() ) { ?>
<script type="text/javascript">

	jQuery(function($){

		function findWithAttr(array, attr, value) {
			for(var i = 0; i < array.length; i += 1) {
				if(array[i][attr] === value) {
					return i;
				}
			}
		}

		var settings = {

			id: 'flickrPortfolio',

			//Flickr
			source					: <?php echo $meta['max_portfolio_flickr_source']; ?>,	//1-Set, 2-User, 3-Group
			<?php if( $meta['max_portfolio_flickr_source'] == 1 ){ ?>
			set						: '<?php echo $meta['max_portfolio_flickr_set']; ?>', //Flickr set ID (found in URL)
			<?php } ?>
			<?php if( $meta['max_portfolio_flickr_source'] == 2 ){ ?>
			user					: '<?php echo $meta['max_portfolio_flickr_user']; ?>', //Flickr user ID (http://idgettr.com/)
			<?php } ?>
			<?php if( $meta['max_portfolio_flickr_source'] == 3 ){ ?>
			group					: '<?php echo $meta['max_portfolio_flickr_group']; ?>', //Flickr group ID (http://idgettr.com/)
			<?php } ?>
			total_slides	  		: <?php echo $meta['max_portfolio_flickr_count'] ?>, //How many pictures to pull (Between 1-500)
			image_size      		: '<?php echo $meta['max_portfolio_flickr_size'] ?>', //Flickr Image Size - t,s,m,z,b  (Details: http://www.flickr.com/services/api/misc.urls.html)				new_window				: 	0,
			random					: <?php $random = $meta['max_portfolio_flickr_sorting'] == 'true' ? '1' : '0'; echo $random; ?>,
			lightbox				: <?php $lightbox = $meta['max_portfolio_flickr_target'] == 'true' ? '1' : '0'; echo $lightbox; ?>,
			sort_by			     	: 1,  //1-Date Posted, 2-Date Taken, 3-Interestingness
			sort_direction			: <?php echo $meta['max_fullsize_flickr_order']; ?>,
			slides 					: [{
										}],	//Initiate slides array
			/**
			FLICKR API KEY
			NEED TO GET YOUR OWN -- http://www.flickr.com/services/apps/create/
			**/
			api_key					:	'<?php echo get_option_max("flickr_api_key") ?>' //Flickr API Key
		},
		// the available sizes from the theme options panel
		sizes_object = { z : 'Medium 640', b : 'Large', h : 'Large 1600', o : 'Original' },

		//If links should open in new window
		linkTarget = settings.new_window ? ' target="_blank"' : '',

		extraParameters = '&extras=owner_name,url_z,url_b,url_h,url_l,url_o,url_k,url_m,o_dims&format=json&nojsoncallback=1';

		//Combine options with default settings
		if (options) {
			var options = $.extend(settings, options);	//Pull from both defaults and supplied options
		}else{
			var options = $.extend(settings);			//Only pull from default settings
		}

		var sort_order = '';
		switch(options.sort_by){
			case 1:
				sort_order = 'date-posted';
				break;
			case 2:
				sort_order = 'date-taken';
				break;
			case 3:
				sort_order = 'interestingness';
				break;
			default:
				sort_order = 'date-posted';
				break;
		}

		switch(options.sort_direction){
			case 0:
				sort_order = sort_order + '-desc';
				break;
			case 1:
				sort_order = sort_order + '-asc';
				break;
			default:
				sort_order = sort_order + '-desc';
				break;
		}


		//Determine where to pull images from
		switch( settings.source ){

			case 1:		//From a Set
				var flickrURL =  'https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' + settings.api_key + '&photoset_id=' + settings.set + '&per_page=' + settings.total_slides + '&sort=' + sort_order + extraParameters;
				break;
			case 2:		//From a User
				var flickrURL =  'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=' + settings.api_key + '&user_id=' + settings.user + '&per_page=' + settings.total_slides + '&sort=' + sort_order + extraParameters;
				break;
			case 3:		//From a Group
				var flickrURL =  'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=' + settings.api_key + '&group_id=' + settings.group + '&per_page=' + settings.total_slides + '&sort=' + sort_order + extraParameters;
				break;
			case 4:		//From tags
				var flickrURL =  'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=' + settings.api_key + '&tags=' + settings.tags + '&per_page=' + settings.total_slides + '&sort=' + sort_order + extraParameters;
				break;

		}

		var flickrLoaded = false;
		$.ajaxSetup({ cache: false });

		$.ajax({ //request to Flickr
			type: 'GET',
			url: flickrURL,
			dataType: 'json',
			success: function(data){

				//Check if images are from a set
				var flickrResults = (settings.source == 1) ? data.photoset : data.photos;
				var photoURL;

				//Shuffle slide order if needed
				if (settings.random){
					arr = flickrResults.photo;
					for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);	//Fisher-Yates shuffle algorithm (jsfromhell.com/array/shuffle)
					flickrResults.photo = arr;
				}

				//Build slides array from flickr request
				$.each( flickrResults.photo, function( i, item ){

					var owner = (settings.source == 1) ? flickrResults.owner : item.owner;

					if( typeof item['url_' + settings.image_size ] === 'undefined' ) {

						// check if o size is available
						if( settings.image_size === 'o' ) {

							if( typeof item['url_k'] !== 'undefined' ) {
								settings.image_size = 'k';

							} else if( typeof item['url_h'] !== 'undefined' ) {
								settings.image_size = 'h';


							} else if( typeof item['url_l'] !== 'undefined' ) {
								settings.image_size = 'l';

							} else if( typeof item['url_c'] !== 'undefined' ) {
								settings.image_size = 'c';

							} else if( typeof item['url_z'] !== 'undefined' ) {
								settings.image_size = 'z';
							}

						}

						// check if k size is available
						else if( settings.image_size === 'k' ) {

							if( typeof item['url_h'] !== 'undefined' ) {
								settings.image_size = 'h';

							} else if( typeof item['url_l'] !== 'undefined' ) {
								settings.image_size = 'l';

							} else if( typeof item['url_c'] !== 'undefined' ) {
								settings.image_size = 'c';

							} else if( typeof item['url_z'] !== 'undefined' ) {
								settings.image_size = 'z';
							}

						}

						// check if h size is available
						else if( settings.image_size === 'h' ) {

							if( typeof item['url_l'] !== 'undefined' ) {
								settings.image_size = 'l';

							} else if( typeof item['url_c'] !== 'undefined' ) {
								settings.image_size = 'c';

							} else if( typeof item['url_z'] !== 'undefined' ) {
								settings.image_size = 'z';
							}

						}

						// check if l size is available
						else if( settings.image_size === 'l' ) {

							if( typeof item['url_c'] !== 'undefined' ) {
								settings.image_size = 'c';

							} else if( typeof item['url_z'] !== 'undefined' ) {
								settings.image_size = 'z';
							}

						}

					}

					var photoURL  = item['url_' + settings.image_size ];
					var thumbURL  = 'https://farm' + item.farm + '.static.flickr.com/' + item.server + '/' + item.id + '_' + item.secret + '_z.jpg';
					var	photoLink = "https://www.flickr.com/photos/" + owner  + "/" + item.id + "/";

					if( settings.lightbox == 1 ) {
						var lightbox = ' data-rel="prettyPhoto[flickr]';
						var hrefAttr = photoURL;
					}else{
						var lightbox = "";
						var hrefAttr = photoLink;
					}

					$('#'+settings.id).append(
						'<li id="img_'+item.id + '" class="item">'+
							'<div class="shadow">'+
								'<a href="' + hrefAttr + linkTarget + '"' + lightbox + '" title="' + item.title + '">'+
									'<img src="' + thumbURL + '" alt="' + item.title + '" />'+
								'</a>'+
							'</div>'+
							'<div class="item-caption">'+
								'<strong>' + item.title + '</strong><br />'+
							'</div>'+
						'</li>'
					);

				});


				/***End load initial images***/
				flickrLoaded = true;

				var container = $('#flickrPortfolio');

	      		/* Isotope -------------------------------------*/
	      		if( jQuery().isotope ) {

					// modified Isotope methods for gutters in masonry
					$.Isotope.prototype._getMasonryGutterColumns = function() {
					    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
					    containerWidth = this.element.width();

					    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
					    // or use the size of the first item
					    this.$filteredAtoms.outerWidth(true) ||
					    // if there's no items, use size of container
					    containerWidth;

					    this.masonry.columnWidth += gutter;

					    this.masonry.cols = Math.floor((containerWidth + gutter) / this.masonry.columnWidth);
					    this.masonry.cols = Math.max(this.masonry.cols, 1);
					};

					$.Isotope.prototype._masonryReset = function() {
					    // layout-specific props
					    this.masonry = {};
					    // FIXME shouldn't have to call this again
					    this._getMasonryGutterColumns();
					    var i = this.masonry.cols;
					    this.masonry.colYs = [];
					    while (i--) {
					        this.masonry.colYs.push(0);
					    }
					};

					$.Isotope.prototype._masonryResizeChanged = function() {
					    var prevSegments = this.masonry.cols;
					    // update cols/rows
					    this._getMasonryGutterColumns();
					    // return if updated cols/rows is not equal to previous
					    return (this.masonry.cols !== prevSegments);
					};

					jQuery('img', container).imagesLoaded(function(){
						container.isotope({
							masonry: {
								gutterWidth: 0
							}
						});

						// update columnWidth on window resize
						jQuery(window).smartresize(function(){
							container.isotope({
						masonry: {
							gutterWidth: 0
						}
							});
						});

						container.css({ background: 'none' }).find('li.item').css({ visibility: 'visible' });

					})

  				}

			} //End AJAX Callback

		});

	});


</script>
<?php } ?>
<?php get_footer(); ?>
