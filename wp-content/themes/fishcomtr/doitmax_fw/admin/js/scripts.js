(function ($) {
	$.fn.delay = function(time,func){
		return this.each(function(){
			setTimeout(func,time);
		});
	};
	// Slide Fade toggle
	$.fn.slideFadeToggle = function(speed, easing, callback) {
		// nice slide fade toggle animation - pew pew pew
		return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
	}

})(jQuery);

(function ($) {

	activateTabs = {
		init: function () {
			// Activate
			jQuery("#options_tabs").tabs({ fx: { opacity: 'toggle', duration: 150 } });
			// Append Toggle Button
			// Toggle Tabs
			jQuery('.toggle_tabs').toggle(function() {
				jQuery("#options_tabs").tabs('destroy');
				jQuery(this).addClass('off');
			}, function() {
				jQuery("#options_tabs").tabs();
				jQuery(this).removeClass('off');
			});
		}
	};

})(jQuery);

jQuery(document).ready(function($){

  // Option tabs within theme options
  $('#maxFrame-admin').on('click', '.nav-tab', function(e){

    var id = this.hash.replace('#', '');

    if( !$(this).hasClass('nav-tab-active') ){ //this is the start of our condition

      $( '.nav-tab' , jQuery(this).parents('.inside') ).removeClass('nav-tab-active');
      $(this).addClass('nav-tab-active');

      $( '.nav-pane', jQuery(this).parents('.inside') ).addClass('nav-pane-hide');
      $('#tab_' + id).removeClass('nav-pane-hide');
   }

   e.preventDefault();
   return false;

  });

    $('a.delete-gallery').click(function(e){
      e.preventDefault();
      $("#invictus_post_gallery").val('');
      $('#max-gallery-list').html(' ')
    })


    if(typeof wp != 'undefined'){

      if(typeof wp.media != 'undefined'){

        wp.media.neviagallery = {

            frame: function() {
                if ( this._frame )
                    return this._frame;
                var selection = this.select();
                this._frame = wp.media({
                    id:         'my-frame',
                    frame:      'post',
                    state:      'gallery-edit',
                    title:      wp.media.view.l10n.editGalleryTitle,
                    editing:    true,
                    multiple:   true,
                    selection:  selection
                });

                this._frame.on( 'update',
                   function() {
                    var controller = wp.media.neviagallery._frame.states.get('gallery-edit');
                    var library = controller.get('library');
                                // Need to get all the attachment ids for gallery
                                var ids = library.pluck('id');
                                $('#invictus_post_gallery').val(ids);
                                //update gallery list

                                $('#max-gallery-list').slideUp();
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    dataType:'html',
                                    data: {
                                        action: 'attachments_update',
                                        ids: ids

                                    },
                                    success:function(res) {
                                        $('#max-gallery-list').html(res).slideDown();
                                        $('#max-gallery-list').next('p').hide();
                                    }
                                });
                            });
                return this._frame;


            },
            // Gets initial gallery-edit images. Function modified from wp.media.gallery.edit
            // in wp-includes/js/media-editor.js.source.html
            select: function() {
                var shortcode = wp.shortcode.next( 'gallery', wp.media.view.settings.neviagallery.shortcode ),
                defaultPostId = wp.media.gallery.defaults.id,
                attachments, selection;

                // Bail if we didn't match the shortcode or all of the content.
                if ( ! shortcode )
                    return;

                // Ignore the rest of the match object.
                shortcode = shortcode.shortcode;

                if ( _.isUndefined( shortcode.get('id') ) && ! _.isUndefined( defaultPostId ) )
                    shortcode.set( 'id', defaultPostId );

                attachments = wp.media.gallery.attachments( shortcode );
                selection = new wp.media.model.Selection( attachments.models, {
                    props:    attachments.props.toJSON(),
                    multiple: true
                });

                selection.gallery = attachments.gallery;

                // Fetch the query's attachments, and then break ties from the
                // query to allow for sorting.
                selection.more().done( function() {
                    // Break ties with the query.
                    selection.props.set({ query: false });
                    selection.unmirror();
                    selection.props.unset('orderby');
                });

                return selection;
            },

            init: function() {
                $('.addgallery').live('click', function( event ){
                    event.preventDefault();
                    wp.media.neviagallery.frame().open();
                });
            }
        };

        wp.media.neviagallery.init();

      }

    }



  // bind meta box dependencies
	jQuery('.max_meta_dependency').max_form_dependencies();

	// change control checkbox to iphone style
  jQuery('.max_control_checkbox:checkbox').iphoneStyle();

	jQuery('#options_tabs .ui-tabs-panel:first').removeClass('ui-tabs-hide');
	activateTabs.init()

	// En/disable Social input fields

	if( jQuery('#maxFrame-admin #option_header_social').size() > 0 ){

		jQuery(" #option_header_social input[type=checkbox] ").each(function(){
			if ( jQuery(this).is(':checked') ){
				jQuery(this).closest('li').find('input.socialurl').removeAttr('disabled').removeClass('disabled');
			}else{
				jQuery(this).closest('li').find('input.socialurl').attr('disabled','disabled').addClass('disabled');
			}
		})

		jQuery(" #option_header_social input[type=checkbox] ").click(function(){
			if ( jQuery(this).is(':checked') ){
				jQuery(this).closest('li').find('input.socialurl').removeAttr('disabled').removeClass('disabled');
			}else{
				jQuery(this).closest('li').find('input.socialurl').attr('disabled','disabled').addClass('disabled');
			}
		})


	}

	// Description pulldown
	if( jQuery('#maxFrame-admin a.info-icon').size() > 0 ){

		jQuery('#maxFrame-admin a.info-icon').click(function(){
			jQuery(this).next().stop(false,true).toggle();
			return false;
		});

	}

});

(function ($)
{
	$.fn.max_form_dependencies = function (variables)
	{

		return this.each(function ()
		{
			var container = jQuery(this),
				settings = {
							elem: container,
							height : container.css({display:"block", height:"auto"}).height(),
							padding : { top: container.css("paddingTop"), bottom: container.css("paddingBottom")  },
							required : jQuery('.max_dependency', this).val().split('::')
						};

				var loop = false;
				var tmp = settings.required[1].split(',');

				if(tmp.length > 1) {
					loop = true;
				}

				var container_id = jQuery('.max_dependency', this).parents('.max_meta_dependency:eq(0)').attr('id');

				var event_id = container_id.split(':__:');

				if(typeof event_id[1] != 'undefined') {
					event_id = event_id[event_id.length-1];
				}else{
					event_id = event_id[0];
				}

				container.css({display:'none'});

				//find the next sibling that has the desired class on our option page
				var elementWrapper = container.siblings('div[id$='+settings.required[0]+']');

				// if we couldn find one check if we are inside a metabox panel by search for the ".inside" parent div
				if(elementWrapper.length == 0) elementWrapper = container.parents('.inside').find('div[id$='+settings.required[0]+']');

				// bind the event and set the current state of visibility
				var checker = jQuery(':input[name$="'+settings.required[0]+'"]', elementWrapper);

				//if we couldnt find the elment to watch we might need to search on the whole page, it could be outside of the group as a "global" setting
				if(checker.length == 0) { checker = jQuery(':input[name$="'+settings.required[0]+'"]') };

				//set current state:
				if(checker.is(':checkbox'))
				{
					if((checker.attr('checked') && settings.required[1]) || (!checker.attr('checked') && !settings.required[1]) ) { container.css({display:'block'}); }
				}
				else
				{
					if(checker.val() == settings.required[1] ||
					  (checker.val() != "" && settings.required[1] == "{true}") || (checker.val() == "" && settings.required[1] == "{false}") ||
					  (settings.required[1].indexOf('{contains}') !== -1 && checker.val().indexOf(settings.required[1].replace('{contains}','')) !== -1) ||
						(settings.required[1].indexOf('{not}') !== -1 && checker.val().indexOf(settings.required[1].replace('{not}','')) === -1) ||
					  (settings.required[1].indexOf('{higher_than}') !== -1 && parseInt(checker.val()) >= parseInt((settings.required[1].replace('{higher_than}',''))))

					)
					{ container.css({display:'block'}); }
				}

				//bind change event for future state changes
				checker.bind('change', {set: settings}, methods.change);

		});
	};



	var methods =
	{
		change: function (passed)
		{

			var data = passed.data.set,
				check = jQuery(this);

				//alert(data.required[1] + ' _ ' + data.required[1].indexOf('{not}') )

			if(
			   	check.val() == data.required[1] ||
			   	( check.val() != "" && data.required[1] == "{true}" ) ||
			   	( check.val() == "" && data.required[1] == "{false}" ) ||
			   	( check.is(':checkbox') && (check.attr('checked' ) && data.required[1] || !check.attr('checked') && !data.required[1])) ||
				( data.required[1].indexOf('{contains}') !== -1 && check.val().indexOf(data.required[1].replace('{contains}','')) !== -1 ) ||
				( data.required[1].indexOf('{not}') !== -1 && check.val().indexOf(data.required[1].replace('{not}','')) === -1 ) ||
				( data.required[1].indexOf('{higher_than}') !== -1 && parseInt(check.val()) >= parseInt( (data.required[1].replace('{higher_than}','') ) ) ) ||
				( data.required[1].indexOf('{lower_than}') !== -1 && parseInt(check.val()) <= parseInt( (data.required[1].replace('{lower_than}','') ) ) )
			) {

				if(data.elem.css('display') == 'none') {

					if(data.height == 0) {
						data.height = data.elem.css({
							visibility:"hidden",
							position:'absolute'
						}).height();
					}

					data.elem

						.css({
							height:0,
							opacity:0,
							overflow:"hidden",
							display:"block",
							paddingBottom:0,
							paddingTop:0,
							visibility:"visible",
							position:'relative'

						})

						.animate({
							height: data.height,
							opacity: 1,
							paddingTop: data.padding.top,
							paddingBottom: data.padding.bottom
						},

						function () {
							data.elem.css({
								overflow:"visible",
								height:"auto"
							});
						});
				}

			}else{

				if(data.elem.css('display') == 'block') {
					data.elem
						.css({ overflow:"hidden" })
						.animate({
							height: 0,
							opacity: 0,
							paddingBottom: 0,
							paddingTop: 0
						},
						function () {
							data.elem.css({
								 display: "none",
								 overflow: "visible",
								 height: "auto"
							});
						});
					}
				}
			}
		};

 	var max_upload = {

		clickEvent: function () {

      // Prepare the variable that holds our custom media manager.
      var max_media_frame;
      var formlabel = 0;

      // Bind to our click event in order to open up the new media experience.
      jQuery(document.body).on('click', '.max_media_upload', function(e){ //max_media_upload is the class of our form button

        // Prevent the default action from occuring.
        e.preventDefault();

        // Get our Parent element
        formlabel = jQuery(this).parent();

        // If the frame already exists, re-open it.
        if ( max_media_frame ) {
          max_media_frame.open();
          return;
        }

        max_media_frame = wp.media.frames.max_media_frame = wp.media({

          //Create our media frame
          className: 'media-frame max-media-frame',
          frame: 'select', //Allow Select Only
          multiple: false, //Disallow Mulitple selections
          title: "Select an image",
          library: {
            type: 'image' //Only allow images
          },
          button: {
            text:  "Use selected image"
          }

        });

        max_media_frame.on('select', function(){

          // Grab our attachment selection and construct a JSON representation of the model.
          var media_attachment = max_media_frame.state().get('selection').first().toJSON();

          $img = jQuery('<img />');
          $img.attr('src', media_attachment.url);

          // Send the attachment URL to our custom input field via jQuery.
          formlabel
            .find('input.media_upload_input').val(media_attachment.id)

          if(formlabel.find('.max_pic_preview').find('img').length) {
            formlabel.find('.max_pic_preview').find('img').attr('src', media_attachment.url);
          }else{
            formlabel.find('.max_pic_preview').append($img);
          }

        });

        // Now that everything has been set, let's open up the frame.
        max_media_frame.open();

      });

		},

		// delete media upload action
		deleteImage: function () {

			jQuery('.media_upload_delete').click(function () {

				var $img = jQuery(this).parents('.max_image_row').find('.media_upload_image img');
				var $inp = jQuery(this).parents('.max_image_row').find('.media_upload_input');

				$img.fadeOut(350, function () {
					$inp.val('');
				})

				return false;
			})

			jQuery('.max_media_remove').live('click', function () {

				var $img = 	jQuery(this).parents('.max_image_row').find('.media_upload_image');
				var $inp = 	jQuery(this).parents('.max_image_row').find('.media_upload_input');

				jQuery(this).parents('.max_image_row').slideFadeToggle(350, function () {
					jQuery(this).remove();
				})

				return false;

			})
		}

	}

	jQuery(function()
	{
		max_upload.clickEvent();
		max_upload.deleteImage();

		// add new slide button
		jQuery('#max_featured_image_wrap').appendo({
			labelAdd: 'Add New Image',
			copyHandlers: false,
			allowDelete: false,
			subSelect: 'div.max_image_row:last',
			onAdd: function (elem) {

				// add a new element
				var num = jQuery('#max_featured_image_wrap input[name=max_featured_hidden]').val();
				var inp = elem.find('input.media_upload_input');
				var img	= elem.find('.max_pic_preview img');

				// set new name for input fields
				elem.find('input.media_upload_input').each(function () {

					// set new id for hidden img field
					if( jQuery(this).attr('id') != "" ) {
						var newId = jQuery(this).attr('id').replace( /[/\d+\/]/,num)
						jQuery(this).attr('id', newId);
					}

				})

				jQuery('#max_featured_image_wrap input.media_upload_input:last').val('').attr('rel','');

				// change ID of add link
				elem.find('.max_media_upload').each(function () {
					var newID = jQuery(this).attr('id').replace(/\d+/, num);
					jQuery(this).attr('id', newID );
				})

				jQuery('.max_media_upload').unbind();

				jQuery('.max_meta_dependency',elem).max_form_dependencies();

				// clear image
				img.remove();

				jQuery('#max_featured_image_wrap input[name=max_featured_hidden]').val(num-1);

			}

		});

		// jQuery UI sortable
		jQuery("#max_featured_image_wrap").sortable({
				placeholder: 'ui-state-highlight',
				forcePlaceholderSize: true,
				forceHelperSize: true,

				// rename image fields
				update: function (event, ui) {

					var items = jQuery(this).find('input.media_upload_input');
					var num = items.size()

					// get the name and make the new name for each item
					items.each(function (i) {
						//jQuery(this).attr('name', jQuery(this).attr('name').replace( jQuery(this).attr('name').substr(-3) ,'['+i+']') )
					})
				}
		});

	})

})(jQuery);
