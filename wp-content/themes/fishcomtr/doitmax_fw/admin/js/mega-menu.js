/**
 *
 * @version: 1.0.0
 * @package  MaxFrame / MegaMenu
 * @author   doitmax
 * @link     http://doitmax.de
 */

( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		// show or hide megamenu fields on parent and child list items
		max_megamenu.menu_item_mouseup();
		max_megamenu.megamenu_status_update();
		//$( '.edit-menu-item-megamenu-status' ).status_update();
		max_megamenu.update_megamenu_fields();

		// setup automatic thumbnail handling
		$( '.remove-max-megamenu-thumbnail' ).manage_thumbnail_display();
		$( '.max-megamenu-thumbnail-image' ).css( 'display', 'block' );
		$( ".max-megamenu-thumbnail-image[src='']" ).css( 'display', 'none' );

		// setup new media uploader frame
		max_media_frame_setup();

	});

	// "extending" wpNavMenu
	var max_megamenu = {

		menu_item_mouseup: function() {
			$( document ).on( 'mouseup', '.menu-item-bar', function( event, ui ) {
				if( ! $( event.target ).is( 'a' )) {
					setTimeout( max_megamenu.update_megamenu_fields, 300 );
				}
			});
		},

		megamenu_status_update: function() {

			$( document ).on( 'click', '.edit-menu-item-megamenu-status', function() {
				var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

				if( $( this ).is( ':checked' ) ) {
					parent_li_item.addClass( 'max-megamenu' );
				} else 	{
					parent_li_item.removeClass( 'max-megamenu' );
				}

				max_megamenu.update_megamenu_fields();
			});
		},

		update_megamenu_fields: function() {
			var menu_li_items = $( '.menu-item');

			menu_li_items.each( function( i ) 	{

				var megamenu_status = $( '.edit-menu-item-megamenu-status', this );

				if( ! $( this ).is( '.menu-item-depth-0' ) ) {
					var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );


					if( check_against.is( '.max-megamenu' ) ) {

						megamenu_status.attr( 'checked', 'checked' );
						$( this ).addClass( 'max-megamenu' );
					} else {
						megamenu_status.attr( 'checked', '' );
						$( this ).removeClass( 'max-megamenu' );
					}
				} else {
					if( megamenu_status.attr( 'checked' ) ) {
						$( this ).addClass( 'max-megamenu' );
					}
				}
			});
		}

	};

	$.fn.manage_thumbnail_display = function( variables ) {
		var button_id;

		return this.click( function( e ){
			e.preventDefault();

			button_id = this.id.replace( 'max-media-remove-', '' );
			$( '#edit-menu-item-megamenu-thumbnail-'+button_id ).val( '' );
			$( '#max-media-img-'+button_id ).attr( 'src', '' ).css( 'display', 'none' );
		});
	}

	function max_media_frame_setup() {
		var max_media_frame;
		var item_id;

		$( document.body ).on( 'click.maxOpenMediaManager', '.max-open-media', function(e){

			e.preventDefault();

			item_id = this.id.replace('max-media-upload-', '');

			if ( max_media_frame ) {
				max_media_frame.open();
				return;
			}

			max_media_frame = wp.media.frames.max_media_frame = wp.media({

				className: 'media-frame max-media-frame',
				frame: 'select',
				multiple: false,
				library: {
					type: 'image'
				}
			});

			max_media_frame.on('select', function(){

				var media_attachment = max_media_frame.state().get('selection').first().toJSON();

				$( '#edit-menu-item-megamenu-thumbnail-'+item_id ).val( media_attachment.url );
				$( '#max-media-img-'+item_id ).attr( 'src', media_attachment.url ).css( 'display', 'block' );

			});

			max_media_frame.open();
		});

	}
})( jQuery );