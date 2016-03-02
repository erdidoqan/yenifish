<?php

global $cropping_array;

/*-----------------------------------------------------------------------------------*/
/* Highlight shortcode config
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {type} Style of the hightlighted text
 * @param string {content} The content of the highlighted text
 *
 * @return array
 */

  $max_shortcodes['highlight'] = array(

    'params' => array(

      'type' => array(
        'type'    => 'select',
        'label'   => __('Highlight\'s Style', MAX_SHORTNAME),
        'desc'    => __('Select the highlight\'s color style.', MAX_SHORTNAME),
        'options' => array(
          'dark'   => __('Dark', MAX_SHORTNAME),
          'light'  => __('Light', MAX_SHORTNAME),
          'yellow' => __('Yellow', MAX_SHORTNAME),
          'red'    => __('Red', MAX_SHORTNAME),
        ),
      ),

  		'content' => array(
  			'std'    => 'Enter the highlighted text',
  			'type'   => 'text',
  			'label'  => __('Text to highlight', MAX_SHORTNAME),
  			'desc'   => __('Enter the text that is going to be highlighted', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[highlight type="{{type}}"]{{content}}[/highlight]',
    'popup_title' => __('Insert Highlight Shortcode', MAX_SHORTNAME),

  );


/*-----------------------------------------------------------------------------------*/
/* Blockquote shortcode config
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {author} Author of the blockquote
 * @param string {content} The content of the blockquote
 *
 * @return array
 */

  $max_shortcodes['blockquote'] = array(

    'params' => array(

      'author' => array(
        'std'   => 'Author\'s Name',
        'type'  => 'text',
        'label' => __('Author\'s Text', MAX_SHORTNAME),
        'desc'  => __('Add the author\'s name', MAX_SHORTNAME),
      ),

  		'content' => array(
  			'std' => 'Blockquote\'s Text',
  			'type' => 'textarea',
  			'label' => __('Blockquote\'s Text', MAX_SHORTNAME),
  			'desc' => __('Add the blockquote\'s text', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[blockquote author="{{author}}"]{{content}}[/blockquote]',
    'popup_title' => __('Insert Blockquote Shortcode', MAX_SHORTNAME),

  );

/*-----------------------------------------------------------------------------------*/
/* Dropcap shortcode config
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {type} Style of the dropcap
 * @param string {content} The content of the dropcap
 *
 * @return array
 */

  $max_shortcodes['dropcap'] = array(

    'params' => array(

      'type' => array(
        'type'    => 'select',
        'label'   => __('Dropcaps\'s Style', MAX_SHORTNAME),
        'desc'    => __('Select the Dropcaps\'s style, ie dark background.', MAX_SHORTNAME),
        'options' => array(
          'default' => __('Default', MAX_SHORTNAME),
          'dark'    => __('Dark', MAX_SHORTNAME),
          'light'   => __('Light', MAX_SHORTNAME),
        ),
      ),

  		'content' => array(
  			'std'     => 'Dropcap\'s Text',
  			'type'    => 'text',
  			'label'   => __('Dropcaps\'s Text', MAX_SHORTNAME),
  			'desc'    => __('Add the full dropcap\'s text. The first letter will be styled only.', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[dropcap type="{{type}}"]{{content}}[/dropcap]',
    'popup_title' => __('Insert Dropcap Shortcode', MAX_SHORTNAME),

  );


/*-----------------------------------------------------------------------------------*/
/* Tooltip shortcode config
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {url} URL of the tooltip link
 * @param string {targe} href target of the tooltip link
 * @param string {content} The content of the dropcap
 * @param string {title} the tooltip text
 *
 * @return array
 */

  $max_shortcodes['tooltip'] = array(

    'params' => array(

      'url'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Link URL', MAX_SHORTNAME),
        'desc'    => __('Add the links\'s url eg http://example.com', MAX_SHORTNAME)
      ),

      'target' => array(
        'type'    => 'select',
        'label'   => __('Link Target', MAX_SHORTNAME),
        'desc'    => __('Select the link target, ie _blank.', MAX_SHORTNAME),
        'options' => array(
          '_self'   => __('_self', MAX_SHORTNAME),
          '_blank'  => __('_blank', MAX_SHORTNAME),
          '_parent' => __('_parent', MAX_SHORTNAME),
          '_top'    => __('_top', MAX_SHORTNAME),
        ),
      ),

  		'content' => array(
  			'std'     => 'Link text',
  			'type'    => 'text',
  			'label'   => __('Link text', MAX_SHORTNAME),
  			'desc'    => __('Add the link text.', MAX_SHORTNAME),
  		),

  		'title' => array(
  			'std'     => 'Tooltip text',
  			'type'    => 'text',
  			'label'   => __('Tooltip text', MAX_SHORTNAME),
  			'desc'    => __('Add the tooltip text. This is the tooltip that is shown on link hover.', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[tooltip url="{{url}} type="{{type}}" title="{{title}}"]{{content}}[/tooltip]',
    'popup_title' => __('Insert Tooltip Link Shortcode', MAX_SHORTNAME),
    'no_preview' => true,

  );

/*-----------------------------------------------------------------------------------*/
/* Horizontal Line shortcode config
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {margintop} top margin of the hr in px
 * @param string {marginbottom} bottom margin of the hr in px
 *
 * @return array
 */

  $max_shortcodes['horizontalline'] = array(

    'params' => array(

      'margintop' => array(
        'std'   => '0',
        'type'  => 'text',
        'label' => __('Top Margin in px', MAX_SHORTNAME),
        'desc'  => __('Add the top margin value for this hr element.', MAX_SHORTNAME),
      ),

      'marginbottom' => array(
        'std'   => '18',
        'type'  => 'text',
        'label' => __('Bottom Margin in px', MAX_SHORTNAME),
        'desc'  => __('Add the bottom margin value in px for this hr element.', MAX_SHORTNAME),
      ),

    ),

    'shortcode'   => '[hr top="{{margintop}}" bottom="{{marginbottom}}" /]',
    'popup_title' => __('Insert Horizontal Line Shortcode', MAX_SHORTNAME),

  );

/*-----------------------------------------------------------------------------------*/
/* Box with headline shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {type} style of the box
 * @param string {title} the headline text
 * @param string {content} The content of the box
 *
 * @return array
 */

  $max_shortcodes['boxinfo'] = array(

    'params' => array(

      'type' => array(
        'type'    => 'select',
        'label'   => __('Info Box\'s Style', MAX_SHORTNAME),
        'desc'    => __('Select the Info Box\'s style, ie dark style.', MAX_SHORTNAME),
        'options' => array(
          'default' => __('Default', MAX_SHORTNAME),
          'dark'    => __('Dark', MAX_SHORTNAME),
          'light'   => __('Light', MAX_SHORTNAME),
        ),
      ),

  		'title' => array(
  			'std'     => 'Info Box Title',
  			'type'    => 'text',
  			'label'   => __('Title', MAX_SHORTNAME),
  			'desc'    => __('Add the info box title. This is the text that is shown on top of the box. Leave blank to hide.', MAX_SHORTNAME),
  		),

  		'content' => array(
  			'std'     => 'Info Box\'s Text',
  			'type'    => 'textarea',
  			'label'   => __('Info Box\'s Text', MAX_SHORTNAME),
  			'desc'    => __('Add the text to show in the infobox.', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[box_info type="{{type}}" title="{{title}}"]{{content}}[/box_info]',
    'popup_title' => __('Insert Info Box Shortcode', MAX_SHORTNAME),

  );

/*-----------------------------------------------------------------------------------*/
/* Toggle Box shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {type} style of the box
 * @param string {title} the headline text
 * @param string {content} The content of the box
 *
 * @return array
 */

  $max_shortcodes['boxtoggle'] = array(

    'params' => array(

      'type' => array(
        'type'    => 'select',
        'label'   => __('Toggle Box\'s Style', MAX_SHORTNAME),
        'desc'    => __('Select the Toggle Box\'s style, ie dark style.', MAX_SHORTNAME),
        'options' => array(
          'default' => __('Default', MAX_SHORTNAME),
          'dark'    => __('Dark', MAX_SHORTNAME),
          'light'   => __('Light', MAX_SHORTNAME),
        ),
      ),

      'state' => array(
        'type'    => 'select',
        'label'   => __('Initial state', MAX_SHORTNAME),
        'desc'    => __('Select the Toggle Box\'s initial state, open or closed.', MAX_SHORTNAME),
        'options' => array(
          'open' => __('open', MAX_SHORTNAME),
          'closed'    => __('closed', MAX_SHORTNAME)
        ),
      ),

  		'title' => array(
  			'std'     => 'Toggle Box Title',
  			'type'    => 'text',
  			'label'   => __('Title', MAX_SHORTNAME),
  			'desc'    => __('Add the toggle box title. This is the text that is shown on top of the box. Leave blank to hide.', MAX_SHORTNAME),
  		),

  		'content' => array(
  			'std'     => 'Toggle Box\'s Text',
  			'type'    => 'textarea',
  			'label'   => __('Toggle Box\'s Text', MAX_SHORTNAME),
  			'desc'    => __('Add the text to show in the toggle box content.', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[toggle_box state="{{state}}" type="{{type}}" title="{{title}}"]{{content}}[/toggle_box]',
    'popup_title' => __('Insert Toggle Box Shortcode', MAX_SHORTNAME),

  );

/*-----------------------------------------------------------------------------------*/
/* Tabs Box shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @return array
 */

  $max_shortcodes['boxtabs'] = array(

    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[tab_box]{{child_shortcode}}[/tab_box]',
    'popup_title' => __('Insert Tabbed Shortcode', MAX_SHORTNAME),

    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Tab Title', MAX_SHORTNAME),
                'desc' => __('Title of the tab. Important note: May not be the same as other tabs!', MAX_SHORTNAME),
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Tab Content', MAX_SHORTNAME),
                'desc' => __('Add the tabs content', MAX_SHORTNAME)
            )
        ),
        'shortcode' => '[tab title="{{title}}"]{{content}}[/tab]',
        'clone_button' => __('Add Tab', MAX_SHORTNAME)
    )

  );


/*-----------------------------------------------------------------------------------*/
/* Image Float shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {url} url of the large uncropped image
 * @param string {width} width of the image to show
 * @param string {height} height of the image to show
 * @param string {type} position of the image / left or right
 * @param string {crop} cropping direction of the small image
 * @param string {title} alt title of the image
 * @param string {lightbox} show the large image in a lightbox or not
 * @param string {content} the image caption below the image
 *
 * @return array
 */

  $max_shortcodes['imagefloat'] = array(

    'params' => array(

      'url'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Large Image URL', MAX_SHORTNAME),
        'desc'    => __('Add the source URL of the large image you want to show. The image is cropped to the desired dimensions.', MAX_SHORTNAME)
      ),

  		'width' => array(
  			'std'     => '160',
  			'type'    => 'text',
  			'label'   => __('Image width in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px', MAX_SHORTNAME),
  		),

  		'height' => array(
  			'std'     => '120',
  			'type'    => 'text',
  			'label'   => __('Image height in px', MAX_SHORTNAME),
  			'desc'    => __('Set the height of the image in px', MAX_SHORTNAME),
  		),

      'type' => array(
        'type'    => 'select',
        'label'   => __('Position of Image', MAX_SHORTNAME),
        'desc'    => __('Select where to show the image, left or right', MAX_SHORTNAME),
        'options' => array(
          'left'    => __('Left', MAX_SHORTNAME),
          'right'   => __('Right', MAX_SHORTNAME),
        ),
      ),

      'crop' => array(
        'type'    => 'select',
        'label'   => __('Cropping Direction', MAX_SHORTNAME),
        'desc'    => __('Select the cropping direction if the images has to be cropped.', MAX_SHORTNAME),
        'options' => $cropping_array
      ),

      'title' => array(
          'std' => '',
          'type' => 'text',
          'label' => __('Image Alt Text', MAX_SHORTNAME),
          'desc' => __('Enter the image alt text to as placeholder.', MAX_SHORTNAME),
      ),

      'lightbox' => array(
        'type'    => 'select',
        'label'   => __('Lightbox Image', MAX_SHORTNAME),
        'desc'    => __('Select if you want to show a large lightbox image on click.', MAX_SHORTNAME),
        'options' => array(
          'false'   => __('No Lightbox', MAX_SHORTNAME),
          'true'    => __('Show Lightbox', MAX_SHORTNAME),
        ),
      ),

  		'content' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Image Caption', MAX_SHORTNAME),
  			'desc'    => __('Add the image caption to show below the image. Leave blank to hide.', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[image_float url="{{url}}" width="{{width}}" height="{{height}}" type="{{type}}" title="{{title}}" lightbox="{{lightbox}}" crop="{{crop}}"]{{content}}[/image_float]',
    'popup_title' => __('Insert Image Float Shortcode', MAX_SHORTNAME),

  );


/*-----------------------------------------------------------------------------------*/
/* Prettyphoto lightbox Image shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {url} url of the large uncropped image
 * @param string {width} width of the image to show
 * @param string {height} height of the image to show
 * @param string {crop} cropping direction of the small image
 * @param string {title} alt title of the image
 * @param string {lightbox} show the large image in a lightbox or not
 * @param string {content} the image caption below the image
 *
 * @return array
 */

  $max_shortcodes['prettyimage'] = array(

    'params' => array(

      'url'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Large Image URL', MAX_SHORTNAME),
        'desc'    => __('Add the source URL of the large image you want to show. The image is cropped to the desired dimensions.', MAX_SHORTNAME)
      ),

  		'width' => array(
  			'std'     => '160',
  			'type'    => 'text',
  			'label'   => __('Image width in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px', MAX_SHORTNAME),
  		),

  		'height' => array(
  			'std'     => '120',
  			'type'    => 'text',
  			'label'   => __('Image height in px', MAX_SHORTNAME),
  			'desc'    => __('Set the height of the image in px', MAX_SHORTNAME),
  		),

      'crop' => array(
        'type'    => 'select',
        'label'   => __('Cropping Direction', MAX_SHORTNAME),
        'desc'    => __('Select the cropping direction if the images has to be cropped.', MAX_SHORTNAME),
        'options' => $cropping_array
      ),

  		'title' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Alt Title', MAX_SHORTNAME),
  			'desc'    => __('Enter the alt title to show in the lightbox on top of the image.', MAX_SHORTNAME),
  		),

  		'gallery' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Gallery Slug', MAX_SHORTNAME),
  			'desc'    => __('Enter the name of the gallery slug for multiple images to show in a lightbox.', MAX_SHORTNAME),
  		),

  		'content' => array(
  			'std'     => '',
  			'type'    => 'textarea',
  			'label'   => __('Lightbox Image Description', MAX_SHORTNAME),
  			'desc'    => __('Add the image description to show below the image in a lightbox. Leave blank to hide.', MAX_SHORTNAME),
  		),

      'src'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Custom Thumbnail Image URL', MAX_SHORTNAME),
        'desc'    => __('Add the URL of a custom thumbnail image you want to show. The image is cropped to the desired dimensions.', MAX_SHORTNAME)
      ),

    ),

    'shortcode'   => '[pretty_image url="{{url}}" width="{{width}}" height="{{height}}" title="{{title}}" gallery="{{gallery}}" crop="{{crop}}" src="{{src}}"]{{content}}[/pretty_image]',
    'popup_title' => __('Insert Image Float Shortcode', MAX_SHORTNAME),
    'clone_button' => __('Add Lightbox Image', MAX_SHORTNAME)

  );

  /*-----------------------------------------------------------------------------------*/
  /* Prettyphoto lightbox gallery shortcode
  /*-----------------------------------------------------------------------------------*/
  /**
   * @since Invictus 3.0
   *
   * @param string {url} url of the large uncropped image
   * @param string {width} width of the image to show
   * @param string {height} height of the image to show
   * @param string {crop} cropping direction of the small image
   * @param string {title} alt title of the image
   * @param string {lightbox} show the large image in a lightbox or not
   * @param string {content} the image caption below the image
   *
   * @return array
   */

  // columns
  $max_shortcodes['prettygallery'] = array(

  	'params' => array(

  	   'width' => array(
    			'std'     => '160',
    			'type'    => 'text',
    			'label'   => __('Width of Images px', MAX_SHORTNAME),
    			'desc'    => __('Set the width of the containing images in px', MAX_SHORTNAME),
    		),

    		'height' => array(
    			'std'     => '120',
    			'type'    => 'text',
    			'label'   => __('Width of Images px', MAX_SHORTNAME),
    			'desc'    => __('Set the height of the containing images in px', MAX_SHORTNAME),
    		),

    		'gallery' => array(
    			'std'     => 'gallery',
    			'type'    => 'text',
    			'label'   => __('Gallery Slug', MAX_SHORTNAME),
    			'desc'    => __('Enter the name of the gallery slug for the images to show in the lightbox gallery.', MAX_SHORTNAME),
    		),

  	),
  	'shortcode' => '[pretty_gallery width="{{width}}" height="{{height}}" gallery="{{gallery}}"]{{child_shortcode}}[/pretty_gallery]', // as there is no wrapper shortcode
  	'popup_title' => __('Insert Lightbox Gallery Shortcode', MAX_SHORTNAME),
  	'no_preview' => true,

  	// child shortcode is clonable & sortable
  	'child_shortcode' => array(
  		'params' => array(

        'url'   => array(
          'std'     => '',
          'type'    => 'text',
          'label'   => __('Large Image URL', MAX_SHORTNAME),
          'desc'    => __('Add the source URL of the large image you want to show. The image is cropped to the desired dimensions.', MAX_SHORTNAME)
        ),

        'crop' => array(
          'type'    => 'select',
          'label'   => __('Cropping Direction', MAX_SHORTNAME),
          'desc'    => __('Select the cropping direction if the images has to be cropped.', MAX_SHORTNAME),
          'options' => $cropping_array
        ),

    		'title' => array(
    			'std'     => '',
    			'type'    => 'text',
    			'label'   => __('Alt Title', MAX_SHORTNAME),
    			'desc'    => __('Enter the alt title to show in the lightbox on top of the image.', MAX_SHORTNAME),
    		),

    		'content' => array(
    			'std'     => '',
    			'type'    => 'textarea',
    			'label'   => __('Lightbox Images Description', MAX_SHORTNAME),
    			'desc'    => __('Add the image description to show below the images in a lightbox. Leave blank to hide.', MAX_SHORTNAME),
    		),

  		),
  		'shortcode' => '[pretty_image url="{{url}}" width="{{width}}" height="{{height}}" gallery="{{gallery}}"]{{content}}[/pretty_image]',
  		'clone_button' => __('Add Lightbox Image', MAX_SHORTNAME)
	)


  );

/*-----------------------------------------------------------------------------------*/
/* Caption Image shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {url} url of the large uncropped image
 * @param string {width} width of the image to show
 * @param string {height} height of the image to show
 * @param string {crop} cropping direction of the small image
 * @param string {title} alt title of the image
 * @param string {lightbox} show the large image in a lightbox or not
 * @param string {content} the image caption below the image
 *
 * @return array
 */

  $max_shortcodes['captionimage'] = array(

    'params' => array(

      'url'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Large Image URL', MAX_SHORTNAME),
        'desc'    => __('Add the source URL of the large image you want to show. The image is cropped to the desired dimensions.', MAX_SHORTNAME)
      ),

  		'width' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Image width in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px', MAX_SHORTNAME),
  		),

  		'height' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Image height in px', MAX_SHORTNAME),
  			'desc'    => __('Set the height of the image in px', MAX_SHORTNAME),
  		),

      'crop' => array(
        'type'    => 'select',
        'label'   => __('Cropping Direction', MAX_SHORTNAME),
        'desc'    => __('Select the cropping direction if the images has to be cropped.', MAX_SHORTNAME),
        'options' => $cropping_array
      ),

      'title' => array(
          'std' => '',
          'type' => 'text',
          'label' => __('Image Alt Text', MAX_SHORTNAME),
          'desc' => __('Enter the image alt text to as placeholder.', MAX_SHORTNAME),
      ),

      'lightbox' => array(
        'type'    => 'select',
        'label'   => __('Lightbox Image', MAX_SHORTNAME),
        'desc'    => __('Select if you want to show a large lightbox image on click.', MAX_SHORTNAME),
        'options' => array(
          'false'   => __('No Lightbox', MAX_SHORTNAME),
          'true'    => __('Show Lightbox', MAX_SHORTNAME),
        ),
      ),

  		'content' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Image Caption', MAX_SHORTNAME),
  			'desc'    => __('Add the image caption to show below the image. Leave blank to hide.', MAX_SHORTNAME),
  		),

    ),

    'shortcode'   => '[caption_image url="{{url}}" width="{{width}}" height="{{height}}" title="{{title}}" lightbox="{{lightbox}}" crop="{{crop}}"]{{content}}[/caption_image]',
    'popup_title' => __('Insert Caption Image Shortcode', MAX_SHORTNAME),

  );

/*-----------------------------------------------------------------------------------*/
/* YouTube Embed shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {id} the youtube video id
 * @param string {width} width of the video to show
 * @param string {height} height of the video to show
 * @param string {wmode} the wmode of the flash video
 * @param string {showinfo} show the video title and info on top
 * @param string {autohide} hide the controls
 * @param string {quality} choose the default quality on start
 *
 * @return array
 */

  $max_shortcodes['videoyoutube'] = array(

    'params' => array(

      'id'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('YouTube video ID', MAX_SHORTNAME),
        'desc'    => __('Enter the YouTube Video URL or ID.', MAX_SHORTNAME)
      ),

  		'width' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Video width in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px. Only needed to preserve aspect ration.', MAX_SHORTNAME),
  		),

  		'height' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Video height in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px. Only needed to preserve aspect ration.', MAX_SHORTNAME),
  		),

      'wmode' => array(
        'type'    => 'select',
        'label'   => __('wmode Attribute', MAX_SHORTNAME),
        'desc'    => __('Select the wmode attribute for the video. Best is "transparent"', MAX_SHORTNAME),
        'options' => array(
          'transparent' => __('Transparent', MAX_SHORTNAME),
          'opaque'      => __('Opaque', MAX_SHORTNAME),
        ),
      ),

      'showinfo' => array(
        'type'    => 'select',
        'label'   => __('Show the video title?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to show the video title or not.', MAX_SHORTNAME),
        'options' => array(
          '1' => __('Yes', MAX_SHORTNAME),
          '0' => __('No', MAX_SHORTNAME),
        ),
      ),

      'autohide' => array(
        'type'    => 'select',
        'label'   => __('Autohide controls?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to autohide the controls or not.', MAX_SHORTNAME),
        'options' => array(
          '0' => __('No', MAX_SHORTNAME),
          '1' => __('Yes', MAX_SHORTNAME),
        ),
      ),

      'quality' => array(
        'type'    => 'select',
        'label'   => __('Default Video Quality', MAX_SHORTNAME),
        'desc'    => __('Choose the default video quality, when the video is loaded. If the quality is not available, the next lower quality is showing.', MAX_SHORTNAME),
        'options' => array(
          'auto' => __('Automatically by YouTube', MAX_SHORTNAME),
          'hd1080' => __('HD 1080', MAX_SHORTNAME),
          'hd720' => __('HD 720', MAX_SHORTNAME),
          'large' => __('SD 480', MAX_SHORTNAME),
          'medium' => __('SD 360', MAX_SHORTNAME),
          'small' => __('SD 240', MAX_SHORTNAME),
        ),
      ),

    ),

    'shortcode'   => '[youtube id="{{id}}" width="{{width}}" height="{{height}}" wmode="{{wmode}}" showinfo="{{showinfo}}" autohide="{{autohide}}" quality="{{quality}}]',
    'popup_title' => __('Insert YouTube Shortcode', MAX_SHORTNAME)

  );

/*-----------------------------------------------------------------------------------*/
/* Vimeo Embed shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {id} the vimeo video id
 * @param string {width} width of the video to show
 * @param string {height} height of the video to show
 * @param string {wmode} the wmode of the flash video
 * @param string {title} show the video title and info on top
 * @param string {byline} show the byline below the title
 * @param string {portrait} show the authors portrait
 * @param string {hd} choose the default quality on start
 *
 * @return array
 */

  $max_shortcodes['videovimeo'] = array(

    'params' => array(

      'id'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Vimeo video ID', MAX_SHORTNAME),
        'desc'    => __('Enter the Vimeo Video URL or ID.', MAX_SHORTNAME)
      ),

  		'width' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Video width in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px. Only needed to preserve aspect ration.', MAX_SHORTNAME),
  		),

  		'height' => array(
  			'std'     => '',
  			'type'    => 'text',
  			'label'   => __('Video height in px', MAX_SHORTNAME),
  			'desc'    => __('Set the width of the image in px. Only needed to preserve aspect ration.', MAX_SHORTNAME),
  		),

      'wmode' => array(
        'type'    => 'select',
        'label'   => __('wmode Attribute', MAX_SHORTNAME),
        'desc'    => __('Select the wmode attribute for the video. Best is "transparent"', MAX_SHORTNAME),
        'options' => array(
          'transparent' => __('Transparent', MAX_SHORTNAME),
          'opaque'      => __('Opaque', MAX_SHORTNAME),
        ),
      ),

      'title' => array(
        'type'    => 'select',
        'label'   => __('Show Video Title?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to show the video title or not.', MAX_SHORTNAME),
        'options' => array(
          '1' => __('Yes', MAX_SHORTNAME),
          '0' => __('No', MAX_SHORTNAME),
        ),
      ),

      'byline' => array(
        'type'    => 'select',
        'label'   => __('Show Author Byline?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to show the authors byline or not.', MAX_SHORTNAME),
        'options' => array(
          '0' => __('No', MAX_SHORTNAME),
          '1' => __('Yes', MAX_SHORTNAME),
        ),
      ),

      'portrait' => array(
        'type'    => 'select',
        'label'   => __('Show Author Portrait?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to show the authors portrait or not.', MAX_SHORTNAME),
        'options' => array(
          '1' => __('Yes', MAX_SHORTNAME),
          '0' => __('No', MAX_SHORTNAME),
        ),
      ),

      'hd' => array(
        'type'    => 'select',
        'label'   => __('Play HD Video?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to show the video in HD if possible.', MAX_SHORTNAME),
        'options' => array(
          '1' => __('Yes', MAX_SHORTNAME),
          '0' => __('No', MAX_SHORTNAME),
        ),
      ),

    ),

    'shortcode'   => '[vimeo id="{{id}}" width="{{width}}" height="{{height}}" wmode="{{wmode}}" title="{{title}}" byline="{{byline}}" portrait="{{portrait}}" hd="{{hd}}"]',
    'popup_title' => __('Insert Vimeo Shortcode', MAX_SHORTNAME)

  );

/*-----------------------------------------------------------------------------------*/
/* Recent Posts shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {title} headline for the recent posts
 * @param string {limit} number of posts to show
 * @param string {type} post type post / gallery
 * @param string {category} string of category or gallery id's to draw the posts from
 * @param string {img} Show the post image or not
 *
 * @return array
 */

  $max_shortcodes['recentposts'] = array(

    'params' => array(

      'title'   => array(
        'std'     => __( 'Recent Posts', MAX_SHORTNAME ),
        'type'    => 'text',
        'label'   => __('Title of Recent Posts List', MAX_SHORTNAME),
        'desc'    => __('Enter the title of the post list that is shown above the posts.', MAX_SHORTNAME)
      ),

      'limit'   => array(
        'std'     => '4',
        'type'    => 'text',
        'label'   => __('Number of posts', MAX_SHORTNAME),
        'desc'    => __('Enter the number of posts to show.', MAX_SHORTNAME)
      ),

      'type' => array(
        'type'    => 'select',
        'label'   => __('Post Type', MAX_SHORTNAME),
        'desc'    => __('Select the post type of the recent posts', MAX_SHORTNAME),
        'options' => array(
          'post'    => __('Blog Posts', MAX_SHORTNAME),
          'gallery' => __('Photo Posts', MAX_SHORTNAME),
        ),
      ),

      'category'   => array(
        'std'     => '',
        'type'    => 'text',
        'label'   => __('Category/Gallery IDs', MAX_SHORTNAME),
        'desc'    => __('Enter a comma separated list of category or gallery ids to draw the recent posts from. Leave blank ignore this filter.', MAX_SHORTNAME)
      ),

      'img' => array(
        'type'    => 'select',
        'label'   => __('Show image?', MAX_SHORTNAME),
        'desc'    => __('Select, if you want to show the image of a recent post or a plain list.', MAX_SHORTNAME),
        'options' => array(
          'true'  => __('Yes, show images', MAX_SHORTNAME),
          'false' => __('No, show list', MAX_SHORTNAME),
        ),
      ),

    ),

    'shortcode'   => '[recent_posts limit="{{limit}}" type="{{type}}" category="{{category}}" img="{{img}}" title="{{title}}"]',
    'popup_title' => __('Insert Recent Posts Shortcode', MAX_SHORTNAME)
 );


/*-----------------------------------------------------------------------------------*/
/* Columns Shortcode
/*-----------------------------------------------------------------------------------*/
/**
 * @since Invictus 3.0
 *
 * @param string {content} the content of the video

 * @return array
 */

// columns
$max_shortcodes['columns'] = array(

	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', MAX_SHORTNAME),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label'=> __('Column Type', MAX_SHORTNAME),
				'desc' => __('Select the type, ie width of the column.', MAX_SHORTNAME),
				'options' => array(
					'two_col'          => 'Two Col',
					'two_col_last'     => 'Two Col Last',
					'three_col'        => 'Three Col',
					'three_col_last'   => 'Three Col Last',
					'four_col'         => 'Four Col',
					'four_col_last'    => 'Four Col Last',
					'one_third'        => 'One Third',
					'one_third_last'   => 'One Third Last',
					'two_third'        => 'Two Third',
					'two_third_last'   => 'Two Third Last',
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', MAX_SHORTNAME),
				'desc' => __('Add the column content.', MAX_SHORTNAME),
			)
		),
		'shortcode' => '[{{column}}]{{content}}[/{{column}}] ',
		'clone_button' => __('Add Column', MAX_SHORTNAME)
	)
);

?>