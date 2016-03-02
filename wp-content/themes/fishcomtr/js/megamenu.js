jQuery(document).ready(function($){

    var max_megamenu_media_frame;

    $(document).on('click', '.max-megamenu-upload-thumbnail', function(e) {
        e.preventDefault();

        var button = $(this);

        if ( max_megamenu_media_frame ) {
            max_megamenu_media_frame.open();
            return;
        }

        max_megamenu_media_frame = wp.media.frames.max_megamenu_media_frame = wp.media({
            className: 'media-frame max-megamenu-media-frame',
            frame: 'select',
            multiple: false,
            library: {
                type: 'image'
            }
        });

        max_megamenu_media_frame.on('select', function(){
            var media_attachment = max_megamenu_media_frame.state().get('selection').first().toJSON();
            $(button).closest('.menu-item-settings').find('.edit-menu-item-megamenu-thumbnail').val(media_attachment.url);
            $(button).closest('.menu-item-settings').find('.max-megamenu-thumbnail-image').attr('src', media_attachment.url).show();
            $(button).closest('.menu-item-settings').find('.remove-max-megamenu-thumbnail').show();
        });

        max_megamenu_media_frame.open();
    });

    $(document).on('click', '.remove-max-megamenu-thumbnail', function(e) {
        e.preventDefault();
        $(this).hide();
        $(this).closest('label').find('input').val('');
        $(this).closest('label').find('img').attr('src', '').hide()
    });

});