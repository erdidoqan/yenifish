<?php

if ( !function_exists('max_options') ) {

	function max_options(){

		global $social_array, $order_array, $cropping_array, $nivo_effect_array, $slider_array, $easing_transitions_array, $max_options;

		/*-----------------------------------------------------------------------------------*/
		/*	Catch the Wordpress Categories
		/*-----------------------------------------------------------------------------------*/
		global $wp_cats;

		$wp_cats = array();
		$max_categories = get_categories('hide_empty=0');
		foreach ($max_categories as $category_list ) {
			 $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
		}

		/*-----------------------------------------------------------------------------------*/
		/*	Catch the Wordpress Pages
		/*-----------------------------------------------------------------------------------*/
		global $wp_pages;

		$max_pages = get_pages('sort_column=post_parent,menu_order');
		$wp_pages = array();
		foreach ($max_pages as $page_list) {
			$wp_pages[$page_list->ID] = $page_list->post_name;
		}
		$max_pages_temp = array_unshift($wp_pages, "Select a page:");

		/*-----------------------------------------------------------------------------------*/
		/*	Catch the Taxonomy Cats for Galleries
		/*-----------------------------------------------------------------------------------*/
		global $wp_gal_cats;

		$gallery_cats = get_terms(GALLERY_TAXONOMY, 'orderby=name&hide_empty=0&hierarchical=1');
		$wp_gal_cats = array();
		foreach ($gallery_cats as $term_list ) {
			 $wp_gal_cats[$term_list->term_id] = $term_list->name;
		}

		/*-----------------------------------------------------------------------------------*/
		/*	Make theme available for translation
		/*-----------------------------------------------------------------------------------*/

		load_theme_textdomain( 'invictus', get_template_directory()  . '/languages' );

		$locale = get_locale();

		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );


  		/*-----------------------------------------------------------------------------------*/
  		/*	 Creates the admin menu
  		/*-----------------------------------------------------------------------------------*/
  		// Option presets
  		$slider_array		  		= array('none'=>"Show Featured Image", 'slider-nivo' => "Nivo Slider", 'slider-slides' => 'Slides Slider', 'slider-kwicks' => "Accordion Slider", 'slider-stacked' => __("Stacked Images", MAX_SHORTNAME));
  		$social_array = array('500px'=>'500px',
    											'addthis'            => "AddThis",
    											'aboutme'            => "About.me",
    											'audioboo'           => "Audioboo",
    											'bebo'               => "bebo",
    											'behance'            => "Behance",
    											'blogger'            => "Blogger",
    											'bluecanvas'         => "Bluecanvas",
    											'creativecommons'    => "CreativeCommons",
    											'delicious'          => "Delicious",
    											'designfloat'        => "DesignFloat",
    											'deviantart'         => "Deviantart",
    											'digg'               => "Digg",
    											'dribbble'           => "Dribbble",
    											'easyart'            => "Easyart",
    											'email'              => "Email",
    											'ember'              => "Ember",
    											'etsy'               => "Etsy",
    											'evernote'           => "Evernote",
    											'facebook'           => "Facebook",
    											'flickr'             => "Flickr",
    											'forrst'             => "Forrst",
    											'foursquare'         => "Foursquare",
    											'friendfeed'         => "FriendFeed",
    											'github'             => "GitHub",
    											'google'             => "Google",
    											'googleplus'         => 'Google+',
    											'grooveshark'        => 'Grooveshark',
    											'icq'                => "ICQ",
    											'imdb'               => "IMDB",
    											'instagram'          => 'Instagram',
    											'lastfm'             => "Lastfm",
    											'linkedin'           => "LinkedIn",
    											'livejournal'        => 'LiveJournal',
    											'lockerz'            => 'Lockerz',
    											'meetup'             => 'Meetup',
                          'megavideo'          => 'Megavideo',
    											'msn'                => "MSN",
    											'myspace'            => "MySpace",
    											'mywed'              => "MyWed.ru",
    											'path'               => 'Path',
    											'paypal'             => 'PayPal',
    											'photorankr'         => 'Photorankr',
    											'piano'              => 'Piano',
    											'picasa'             => 'Picasa',
    											'pinterest'          => "Pinterest",
    											'playstation'        => 'Playstation',
    											'posterous'          => 'Posterous',
    											'reddit'             => "Reddit",
    											'rss'                => "RSS",
    											'sharethis'          => 'ShareThis',
    											'skype'              => "Skype",
    											'socialvibe'         => "SocialVibe",
    											'soundcloud'         => "SoundCloud",
    											'spotify'            => "Spotify",
    											'springme'           => "Spring.me",
    											'stumbleupon'        => "Stumbleupon",
    											'technorati'         => "Technorati",
    											'themeforest'        => "ThemeForest",
    											'tumblr'             => "Tumblr",
    											'twitpic'            => "TwitPic",
    											'twitter'            => "Twitter",
    											'typepad'            => "Typepad",
    											'viddler'            => "Viddler",
    											'vimeo'              => "Vimeo",
    											'virb'               => "Virb",
    											'vkontakt'           => "VK",
    											'xing'               => "Xing",
    											'windows'            => "Windows",
    											'wordpress'          => "WordPress",
    											'xing'               => "Xing",
    											'yahoo'              => "Yahoo",
    											'youtube'            => "YouTube",
    											'zerply'             => "Zerply");
		$theme_array                  = array("black"=>"Black Theme","white"=>"White Theme");
		$order_array                  = array("rand"=>"Random","id"=>"Post-ID","date"=>"Post Date","title"=>"Post Title","modified"=>"Last modified", 'menu_order'=>'Menu Order');
		$pretty_speed_array           = array('fast'=>'Fast',"normal"=>'Normal',"slow"=>'Slow');
		$pretty_theme_array           = array('dark_square'=>"Dark Square",'light_square'=>"Light Square",'dark_rounded'=>"Dark Rounded",'light_rounded'=>"Light Rounded",'facebook'=>"Facebook");
		$fullsize_speed_array         = array('slow'=>'Slow','normal'=>'Normal','fast'=>'Fast');
		$fullsize_transition_array    = array(0=>"None",1=>"Fade",2=>"Slide Down",3=>"Slide Left",4=>"Slide Top",5=>"Slide Right",6=>"Blind horizontal",7=>"Blind Vertiacl",90=>"Slide Right/Left",91=>"Slide Top/Down");
		$fullsize_overlay_array       = array("dotted"=> "Dots", "squared" => "Squares", "scanlines" => "Scanlines", "carbon" => "Carbon", "triangles" => "Triangles" );
		$cropping_array               = array( 'c' => 'Position in the Center (default)', 't' => 'Align top', 'b' => 'Align bottom', 'l' => 'Align left', 'r' => 'Align right' );
		$nivo_effect_array            = array("random"=>"Random","sliceDown"=>"Slice Down","sliceDownLeft"=>"Slice Down Left","sliceUp"=>"Slice Up","sliceUpLeft"=>"Slice Up Left","sliceUpDown"=>"Slice Up Down","sliceUpDownLeft"=>"Slice Up Down Left","fold"=>"Fold","fade"=>"Fade","slideInRight"=>"Slide in Right","slideInLeft"=>"Slide in Left", "boxRandom" => "Box Random", "boxRain" => "Box Rain", "boxRainReverse" => "Box Rain Reverse", "boxRainGrow" => "Box Rain Grow", "boxRainGrowReverse" => "Box Rain Grow Reverse");
		$easing_transitions_array     = array("linear"=>"Linear","easeInSine"=>"easeInSine","easeOutSine"=>"easeOutSine","easeInQuad"=>"easeInQuad","easeOutQuad"=>"easeOutQuad","easeInCubic"=>"easeInCubic","easeOutCubic"=>"easeOutCubic","easeInQuart"=>"easeInQuart","easeOutQuart"=>"easeOutQuart","easeInExpo"=>"easeInExpo","easeOutExpo"=>"easeOutExpo","easeInCirc"=>"easeInCirc","easeOutCirc"=>"easeOutCirc","easeInElastic"=>"easeInElastic","easeOutElastic"=>"easeOutElastic","easeInOutElastic"=>"easeInOutElastic","easeInBack"=>"easeInBack","easeOutBack"=>"easeOutBack","easeInBounce"=>"easeInBounce","easeOutBounce"=>"easeOutBounce");


		// The Options
		$options = array();

		/*-----------------------------------------------------------------------------------*/
		/*	Create the General Tab
		/*-----------------------------------------------------------------------------------*/
		$options[] = array(
      "name" => __('General', MAX_SHORTNAME),
      "id"   => "general",
      "type" => "section"
    );

		$options[] = array( "type" => "open");

      /** The general settings for all Full Size Galleries */
  		$options[] = array(
        "name" => __('General theme settings', MAX_SHORTNAME),
        "id"   => "subhead_fullsize_general",
        "desc" => __('Control and configure the general setup of your theme. Upload your preferred logo, insert your analytics tracking code and add some custom CSS code to change the default stylesheet easily.', MAX_SHORTNAME),
        "type" => "subhead"
      );

      $options[] = array(
        "id"    => MAX_SHORTNAME."_general_tab_nav",
        "type"  => "tab_nav",
        "tabs"  => array(
          MAX_SHORTNAME."_general_tab_logos"   => __('Logos &amp; Icons', MAX_SHORTNAME),
          MAX_SHORTNAME."_general_tab_posts"   => __('Posts &amp; Pages', MAX_SHORTNAME),
          MAX_SHORTNAME."_general_tab_others"  => __('Others', MAX_SHORTNAME)
        )
      );

      $options[] = array(
        "id"      => MAX_SHORTNAME."_general_tab_logos",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"  => __('Custom logo', MAX_SHORTNAME),
          "desc"  => __('Upload your own logo to use as site logo. (Should not be larger than 235x100px)', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_logo",
          "std"   => "",
          "type"  => "upload"
        );

        $options[] = array(
          "name"  => __('Logo Retina @2x', MAX_SHORTNAME),
          "desc"  => __('Please choose an image file for the retina version of the logo. This logo must be twice as large as the original. <strong>Important:</strong> The filename has to be the same as the original Logo but with @2x at the end, e.g. logo@2x.png', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_logo_2x",
          "std"   => "",
          "type"  => "upload"
        );

        $options[]   = array(
          "name"  => __('Logo Width (px)', MAX_SHORTNAME),
          "desc"  => __('Enter the width of your logo without px. This is needed to show the retina logo in right dimensions.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_logo_width",
          "type"  => "text",
          "std"   => ""
        );

        $options[] = array(
          "name" => __('Logo Height (px)', MAX_SHORTNAME),
          "desc" => __('Enter the height of your logo without px. This is needed to show the retina logo in right dimensions.', MAX_SHORTNAME),
          "id" => MAX_SHORTNAME."_custom_logo_height",
          "type" => "text",
          "std" => ""
        );

        $options[] = array(
          "name" => __('Blank logo', MAX_SHORTNAME),
          "desc"  => __('Turn on, if you want to show a blank logo without background and borders. Recommend if you have a transparent logo or a one with a colored background.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_logo_blank",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array(
          "name" => __('Custom Favicon', MAX_SHORTNAME),
          "desc"  => __('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_favicon",
          "std"   => "",
          "type"  => "upload"
        );

        $options[] = array(
          "name" => __('Apple iPhone Icon',MAX_SHORTNAME),
          "desc"  => __('Upload an icon for Apple iPhone (57px x 57px)', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_favicon_iphone",
          "type"  => "upload",
          "std"   => ""
        );

        $options[] = array(
          "name" => __('Apple iPhone Retina Icon',MAX_SHORTNAME),
          "desc"  => __('Upload a Retina Icon for Apple iPhone (114px x 114px)', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_favicon_iphone_2x",
          "type"  => "upload",
          "std"   => ""
        );

        $options[] = array(
          "name" => __('Apple iPad Icon',MAX_SHORTNAME),
          "desc"  => __('Upload an Icon for Apple iPad (72px x 72px)', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_favicon_ipad",
          "type"  => "upload",
          "std"   => ""
        );

        $options[] = array(
          "name" => __('Apple iPad Retina Icon',MAX_SHORTNAME),
          "desc"  => __('Upload a Retina Icon for Apple iPad (144px x 144px)', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_custom_favicon_ipad_2x",
          "type"  => "upload",
          "std"   => ""
        );

      $options[] = array( "type" => "tab_close" ); // close logo & icons tab


      // posts & pages tab
      $options[] = array(
        "id"      => MAX_SHORTNAME."_general_tab_posts",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"    => __('Portfolio posts per page', MAX_SHORTNAME),
          "desc"    => __('Enter the default number of post, that will be displayed on a portfolio and portfolio archive pages. This option can be overridden by portfolio templates settings.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_posts_per_page",
          "type"    => "slider",
          "step"    => "1",
          "max"     => "300",
          "min"     => "1",
          "std"     => "24"
        );

        $options[] = array(
          "name"    => __('Disable Comments on posts', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to disable comments for all posts (includes Blog and Photo posts. Overwrites the default WordPress discussion Settings).', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_disable_post_comments",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Disable Comments on pages', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to disable comments for all pages (Overwrites the default WordPress discussion Settings).', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_disable_page_comments",
          "type"    => "checkbox",
          "std"     => "true"
        );

      $options[] = array( "type" => "tab_close" );


      // others tabs
      $options[] = array(
        "id"      => MAX_SHORTNAME."_general_tab_others",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"    => __('Google Analytics ID', MAX_SHORTNAME),
          "desc"    => __('Enter your Google Analytic ID to track your page visitors.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_google_analytics_id",
          "type"    => "text",
          "std"     => ""
        );

        $options[] = array(
          "name"    => __('Custom CSS',MAX_SHORTNAME),
          "desc"    => __('Enter some CSS to your theme by adding it to this block.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_custom_css",
          "std"     => "",
          "type"    => "textarea",
          "rows"    => 10
        );

        $options[] = array(
          "name"    => __('Password protected text', MAX_SHORTNAME),
          "desc"    => __('Enter the text wich is shown if a page or post is password protected.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_protected_login_text",
          "std"     => "Whoops, this page is password protected. To view it please enter the password below:",
          "type"    => "textarea",
          "rows"    => 10
        );

      $options[] = array( "type" => "tab_close" ); // close others tab

    $options[] = array( "type" => "close"); // close general optionset


		/*-----------------------------------------------------------------------------------*/
		/*	Create the Layout Tab
		/*-----------------------------------------------------------------------------------*/
    $options[]  = array(
      "name"      => __('Layout', MAX_SHORTNAME),
      "id"        => MAX_SHORTNAME."_header_layout",
      "type"      => "section"
    );

    $options[]  = array( "type" => "open");

      $options[] = array(
        "name"    => __('Layout settings', MAX_SHORTNAME),
        "id"      => "subhead_layouts_main",
        "desc"    => __('Change the appearance of your theme with these option sets. Those changes are more general settings like position of some elements .', MAX_SHORTNAME),
        "type"    => "subhead"
      );

      $options[] = array(
        "name"      => __('Fill up content area, when there is no sidebar', MAX_SHORTNAME),
        "desc"      => __("If you don't have set a sidebar on a page or post at the 'Appearance > Widget' section you can set the content to fill the available free space. This only works for 'Full Width' navigation from above 'Header & Navigation' option.", MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_layout_fill_content",
        "type"      => "checkbox",
        "std"       => "false"
      );


      $options[] = array(
        "name"    => __('Show fullsize overlay', MAX_SHORTNAME),
        "desc"    => __('Check, if you want to show the overlay pattern on all posts &amp; pages. This options has no effect at the full size gallery overlay.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_general_show_fullsize_overlay",
        "type"    => "checkbox",
        "std"     => "true"
      );

      $options[] = array(
        "name"      => __('Fullsize overlay pattern', MAX_SHORTNAME),
        "desc"      => __('Select the type of overlay pattern for your full size overlay in the back.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_fullsize_overlay_pattern",
        "type"      => "radio",
        "options"   => $fullsize_overlay_array,
        "std"       => "dotted",
        "addtype"   => "overlay"
      );

    $options[]  = array( "type" => "close");

    /*-----------------------------------------------------------------------------------*/
    /*  Create the Menu & Navigation tab
    /*-----------------------------------------------------------------------------------*/
    $options[]  = array(
      "name"      => __('Menu', MAX_SHORTNAME),
      "id"        => MAX_SHORTNAME."_header_menu",
      "type"      => "section"
    );

    $options[]  = array( "type" => "open");

      $options[] = array(
        "name"    => __('Menu settings', MAX_SHORTNAME),
        "id"      => "subhead_menu_main",
        "desc"    => __('Control the layout of your main navigation menu or activate the Mega Menu option to create stunning navigation menus.', MAX_SHORTNAME),
        "type"    => "subhead"
      );

      $options[]  = array(
        "name"      => __('Header & Menu type', MAX_SHORTNAME),
        "desc"      => __('Select the type of header and navigation your want to use.<br /><br /><strong>Important note:</strong> If you change the header and navigation you have to change your logo in some cases too to get the best result.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_header_type",
        "type"      => "select",
        "options"   => array('default' => __('Default', MAX_SHORTNAME), 'full-width' => __('Full width', MAX_SHORTNAME), 'full-height' => __('Full height', MAX_SHORTNAME)),
        "std"       => "default"
      );

      $options[] = array(
        "name"    => __('Scroll Logo and Menu', MAX_SHORTNAME),
        "desc"    => __('Check, if you want scroll the logo and menu and not use the fixed logo and menu.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_custom_fixed_logo",
        "type"    => "checkbox",
        "std"     => "false"
      );

      $options[] = array(
        "name"    => __('Enable Mega Menu', MAX_SHORTNAME),
        "desc"    => __('Check, if you want to enable the Mega Menu options for your navigation menus.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_menu_mega_menu",
        "type"    => "checkbox",
        "std"     => "false"
      );

      $options[] = array(
        "name"    => __('Deactivate Primary Menu', MAX_SHORTNAME),
        "desc"    => __('Switch this option to "On", if you want to hide the primary menu.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_custom_hide_menu",
        "type"    => "checkbox",
        "std"     => "false"
      );

    $options[]  = array( "type" => "close");

    /*-----------------------------------------------------------------------------------*/
    /*  Create the Colors Tab
    /*-----------------------------------------------------------------------------------*/
    $options[]  = array(
      "name"      => __('Colors', MAX_SHORTNAME),
      "id"        => MAX_SHORTNAME."_header_colors",
      "type"      => "section"
    );

    $options[]  = array( "type" => "open");

      $options[] = array(
        "name"    => __('Color settings', MAX_SHORTNAME),
        "id"      => "subhead_colors_main",
        "desc"    => __('Change the main colors, the color sheme and link colors of your theme with these options. You can also create your own main color sheme, instead of using "black" or "white".', MAX_SHORTNAME),
        "type"    => "subhead"
      );

      $options[]  = array(
        "name"      => __('Color Scheme', MAX_SHORTNAME),
        "desc"      => __('Select the color scheme for the theme.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_main",
        "type"      => "select",
        "options"   => $theme_array,
        "std"       => "black"
      );

      $options[]  = array(
        "name"      => __('Custom Color Scheme', MAX_SHORTNAME),
        "desc"      => __('Select your own custom color scheme for the theme. Leave it blank to use the default color scheme from the above dropdown.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_main_custom_bg",
        "type"      => "colorpicker",
        "std"       => "#"
      );

      $options[]  = array(
        "name"      => __('Custom Color Alpha (Opacity)', MAX_SHORTNAME),
        "desc"      => __('Set the alpha channel of your custom color scheme. The lower the value, the lower the opacity. 1 means full opacity.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_main_custom_alpha",
        "type"      => "slider",
        "step"      => "0.01",
        "max"       => "1",
        "min"       => "0",
        "std"       => "0.9"
      );

      $options[]  = array(
        "name"      => __('Main Color', MAX_SHORTNAME),
        "desc"      => __('This is the main color for your theme (borders, link colors, current nav marker etc.)', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_main_typo",
        "type"      => "colorpicker",
        "std"       => "#c73a3a"
      );

      $options[]  = array(
        "name"      => __('Link Color', MAX_SHORTNAME),
        "desc"      => __('This is the link color for your theme.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_main_link",
        "type"      => "colorpicker",
        "std"       => "#c73a3a"
      );

      $options[]  = array(
        "name"      => __('Navigation Pulldown Background', MAX_SHORTNAME),
        "desc"      => __('This is the background color for your navigation pulldown menus.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_pulldown_background",
        "type"      => "colorpicker",
        "std"       => ''
      );

      $options[]  = array(
        "name"      => __('Navigation Link Hover', MAX_SHORTNAME),
        "desc"      => __('This is the hover color for your navigation links (hover and active).', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_nav_link_hover",
        "type"      => "colorpicker",
        "std"       => "#FFFFFF"
      );

      $options[]  = array(
        "name"      => __('Navigation Pulldown Link Hover', MAX_SHORTNAME),
        "desc"      => __('This is the hover color for your pulldown links (hover and active).', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_color_pulldown_link_hover",
        "type"      => "colorpicker",
        "std"       => "#212121"
      );

    $options[]  = array( "type" => "close");

		/*-----------------------------------------------------------------------------------*/
		/*	Font Tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name" => __('Fonts', MAX_SHORTNAME),
      "id"=> MAX_SHORTNAME."_header_font",
      "type" => "section"
    );

    $options[] = array( "type" => "open");

      $options[] = array(
        "name"  => __('Font settings', MAX_SHORTNAME),
        "id"    => "subhead_font_main",
        "type"  => "subhead",
        "desc"  => __("Setup the fonts for your theme with the options below. Change the color, the font-family and more. Use the Google Font API to choose from nearly over 650 fonts.", MAX_SHORTNAME )
      );

      $options[] = array(
        "name"    => __('Google Font API Key', MAX_SHORTNAME),
        "desc"    => __('Enter your Google Font API Key to ensure updates of the google font library.', MAX_SHORTNAME) . ' <a href="https://developers.google.com/console/help/new/#generatingdevkeys" target="_blank">' .__('More about the API keys', MAX_SHORTNAME) . '</a>',
        "id"      => MAX_SHORTNAME."_google_fontapi_key",
        "type"    => "text",
        "std"     => ""
      );

      $options[] = array(
        "name"    => __('Use Subsets', MAX_SHORTNAME),
        "desc"    => __('Choose the subsets of Google Fonts to use. ( Greek and Cyrillic )', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_subsets",
        "type"    => "select",
        "options" => array('none' => __('None (Default)', MAX_SHORTNAME), 'greek' => __('Greek', MAX_SHORTNAME), 'cyrillic' => __('Cyrillic', MAX_SHORTNAME)),
        "std"     => "none"
      );

      $options[] = array(
        "name"    => __('Deactivate Google Fonts', MAX_SHORTNAME),
        "desc"    => __('Set this option to "On" if you want to completely deactivate Google Fonts including. For example, to improve loading times if you use @font-face or default fonts.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_google_deactivate",
        "type"  => "checkbox",
        "std"   => "false"
      );

      $options[] = array(
        "name"    => __('Main Body font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_body",
        "std"     => array('font_family' => "PT Sans", 'font_size' => 12, 'line_height' => 20, 'font_weight' => 300, 'font_color' => '#BBBBBB'),
        "type"    => "font",
        "min"     => 1,
        "max"     => 60
      );

      $options[] = array(
        "name"    => __('H1 font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_h1",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 42, 'line_height' => 60, 'font_weight' => 300, 'font_color' => '#EEEEEE'),
        "type"    => "font",
        "min"     => 12,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('H2 font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_h2",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 36, 'line_height' => 50, 'font_weight' => 300, 'font_color' => '#c73a3a'),
        "type"    => "font",
        "min"     => 12,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('H3 font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_h3",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 30, 'line_height' => 40, 'font_weight' => 300, 'font_color' => '#CCCCCC'),
        "type"    => "font",
        "min"     => 12,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('H4 font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_h4",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 24, 'line_height' => 30, 'font_weight' => 300, 'font_color' => '#CCCCCC'),
        "type"    => "font",
        "min"     => 12,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('H5 font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_h5",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 18, 'line_height' => 20, 'font_weight' => 300, 'font_color' => '#CCCCCC'),
        "type"    => "font",
        "min"     => 12,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('H6 font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_h6",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 16, 'line_height' => 15, 'font_weight' => 300, 'font_color' => '#CCCCCC'),
        "type"    => "font",
        "min"     => 12,
        "max"     => 80
      );

      $options[] = array(
      "name"    => __('Widget headline font style', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_font_widget",
      "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 24, 'line_height' => 28, 'font_weight' => 300, 'font_color' => '#c73a3a'),
      "type"    => "font",
      "min"     => 12,
      "max"     => 80
      );

      $options[] = array(
        "name"    => __('Navigation font style', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_navigation",
        "std"     => array('font_family' => "PT Sans", 'font_size' => 13, 'line_height' => 18, 'font_weight' => 100, 'font_color' => '#AAAAAA'),
        "type"    => "font",
        "min"     => 10,
        "max"     => 80
      );

      $options[] = array(
      "name"    => __('Navigation pulldown font style', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_font_navigation_pulldown",
      "std"     => array('font_family' => "PT Sans", 'font_size' => 12, 'line_height' => 18, 'font_weight' => 100, 'font_color' => '#cccccc'),
      "type"    => "font",
      "min"     => 10,
      "max"     => 80
      );

      $options[] = array(
        "name"    => __('Full size gallery post title', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_fullsize_title",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 38, 'line_height' => 38, 'font_weight' => 500, 'font_color' => '#FFFFFF'),
        "type"    => "font",
        "min"     => 10,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('Full size gallery post excerpt', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_fullsize_excerpt",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 18, 'line_height' => 18, 'font_weight' => 500, 'font_color' => '#FFFFFF'),
        "type"    => "font",
        "min"     => 10,
        "max"     => 80
      );

      $options[] = array(
        "name"    => __('Blog header', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_font_blog_header",
        "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 28, 'line_height' => 30, 'font_weight' => 300, 'font_color' => '#FFFFFF'),
        "type"    => "font",
        "min"     => 10,
        "max"     => 80
      );

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Fullsize Gallery Tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"  => "Full Size Gallery",
      "id"    => "header_fullsize",
      "type"  => "section"
    );
    $options[] = array( "type" => "open");

      /** The general settings for all Full Size Galleries */
      $options[] = array(
        "name"    => __('General settings for full size galleries', MAX_SHORTNAME),
        "id"      => "subhead_fullsize_general",
        "desc"    => __('These are the default settings for all full size galleries within the theme. No matter if this is the default theme front page gallery or a page template with the "Portfolio Full Size Gallery" template attached.', MAX_SHORTNAME),
        "type"    => "subhead"
      );

      $options[] = array(
        "id"      => MAX_SHORTNAME."_fullsize_tab_nav",
        "type"    => "tab_nav",
        "tabs"    => array(
          MAX_SHORTNAME."_fullsize_tab_general"   => 'Main Settings',
          MAX_SHORTNAME."_fullsize_tab_thumbnail" => 'Thumbnail Scroller Settings',
          MAX_SHORTNAME."_fullsize_tab_video"     => 'Video Settings'
        )
      );

      $options[] = array(
        "id"         => MAX_SHORTNAME."_fullsize_tab_general",
        "type"       => "tab_open",
        "display"    => true
      );

        /** The general settings for all Full Size Galleries */
        $options[] = array(
          "name"  => "",
          "id"    => "subhead_fullsize_tab_general",
          "desc"  => __('With the main settings you can change the main behavior of the full size gallery images and slideshow elements with these options. These settings affect all full size galleries within your theme.', MAX_SHORTNAME),
          "type"  => "subhead"
        );

        $options[] = array(
          "name"  => __('Preload images', MAX_SHORTNAME),
          "desc"  => __('Activate this option, if you want to preload all full size gallery images on page load. It is not recommend to use this option, if you have more than 15 images attached to your fullsize galleries in order to avoid an increase in loading time of your full size gallery.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_preload",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array(
          "name"  => __('Show password protected posts', MAX_SHORTNAME),
          "desc"  => __('Do you want to show password protected posts on the full size gallery scroller?.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_exclude_protected",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Remove link on image title', MAX_SHORTNAME),
          "desc"  => __('Do you want to remove the link on the full size gallery image title? This is a global setting and switching on will overwrite individual post settings.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_remove_title_link",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array(
          "name"  => __('Show large prev/next arrows', MAX_SHORTNAME),
          "desc"  => __('Do you want to show large buttons for the previous and next action? These buttons are overlay buttons for the full size gallery.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_show_arrows",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Hide default controls', MAX_SHORTNAME),
          "desc"  => __('Do you want to hide the controls at top of thumbnail scroller? This is recommend if you have activated the large prev/next arrows.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_hide_controls",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array(
          "name"    => __('Animation speed', MAX_SHORTNAME),
          "desc"    => __('The speed of the animation between two images in a full size background gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_speed",
          "type"    => "select",
          "options" => $fullsize_speed_array,
          "std"     => "normal"
        );

        $options[] = array(
          "name"    => __('Transition', MAX_SHORTNAME),
          "desc"    => __('Type of slide transition.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_transition",
          "type"    => "select",
          "options" => $fullsize_transition_array,
          "std"     => 1
        );

      $options[] = array("type" => "tab_close");

      /** The general thumbnail scroller settings for all Full Size Galleries */
      $options[] = array(
        "id"   => MAX_SHORTNAME."_fullsize_tab_thumbnail",
        "type" => "tab_open"
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_fullsize_tab_thumbnail",
          "type"    => "subhead",
          "desc"    => __('The thumbnails settings control the behavior and look of the thumbnail scroller for all your full size galleries in your theme. These settings affect all full size galleries within your theme.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"  => __('Lazy Load thumbnails', MAX_SHORTNAME),
          "desc"  => __("Activate this option, if you don't want to load all thumbnails on page load. Only the first visible thumbnails are loaded on page load. All other thumnails are loaded when scrolling the thumbnail scroller.", MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_lazyload_thumbnails",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"    => __('Keep Thumbnail Scroller in Fullscreen mode', MAX_SHORTNAME),
          "desc"    => __('Do you want to show the thumbnails if you expand the gallery in fullscreen mode or a video is playing? By default the thumbnails are hidden.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_toggle_thumbnails",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Use mouse move scrolling', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to use the new mouse move scrolling on the thumbnails. Off will keep the old style scrolling.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_mouse_scrub",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide thumbnails on mouseout', MAX_SHORTNAME),
          "desc"    => __('Switch this option on, if you want to hide the thumbnail scroller when you leave it with the mouse cursor.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_mouse_leave",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Use key navigation', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to use the key navigation for your fullsize galleries (left = prev slide, right = next slide, up = show thumbnails, down = hidethumbnails)', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_key_nav",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Blank slideshow title background', MAX_SHORTNAME),
          "desc"    => __('Activate this option to not show any background on the slideshow title. The slideshow title is showing with a blank background on the current full size gallery image.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_title_blank",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Blank slideshow excerpt background', MAX_SHORTNAME),
          "desc"    => __('Activate this option to not show any background on the slideshow excerpt. The slideshow excerpt is showing with a blank background on the current full size gallery image.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_excerpt_blank",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Show more link beside slideshow title', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show a "more" arrow beside the slideshow title.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_show_title_more",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Position of thumbnail controls', MAX_SHORTNAME),
          "desc"    => __('Choose where to show the thumbnail controls of your full size gallery scroller.', MAX_SHORTNAME),
          "id"      => __(MAX_SHORTNAME.'_fullsize_controls_position'),
          "type"    => "select",
          "options" => array('right' => __('Right', MAX_SHORTNAME), 'centered' => __('Centered', MAX_SHORTNAME)),
          "std"     => "right"
        );

        $options[] = array(
          "name"    => __('Greyscale images', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show greyscaled thumbnails in your slider. Colored images will be shown on hover.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_use_greyscale",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Crop thumbnails', MAX_SHORTNAME),
          "desc"    => __('Choose whether you want to show cropped thumbnails in your slider. All images are appearing in the same format.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_use_square",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Thumbnail height', MAX_SHORTNAME),
          "desc"    => __('Set the height of the thumbnails in the scroller. The width is set proportional.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_thumb_height",
          "type"    => "slider",
          "step"    => "1",
          "max"     => "200",
          "min"     => "1",
          "std"     => "100"
        );

      $options[] = array("type" => "tab_close");


      /** The general settings for the videos for the default theme frontpage full size gallery */
      $options[] = array(
      "id"   => MAX_SHORTNAME."_fullsize_tab_video",
      "type" => "tab_open"
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_fullsize_tab_video",
          "desc"  => __('These video settings conrol the video you have added to a photo post within a full size gallery. These settings affect all full size galleries within your theme.', MAX_SHORTNAME),
          "type"  => "subhead"
        );

        $options[] = array(
          "name"  => __('Show page elements when a video is playing', MAX_SHORTNAME),
          "desc"  => __('Check, if you want to show the page elements when a video is playing. This will not show the thumbnail slider, but the navigation and logo.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_video_show_elements",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Force to play YouTube videos in HD', MAX_SHORTNAME),
          "desc"  => __('Check, if you want to play your YouTube fullsize videos always in HD.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_fullsize_yt_hd",
          "type"  => "checkbox",
          "std"   => "true"
        );

      $options[] = array("type" => "tab_close");

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Front page Fullsize Gallery Tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"  => "Front Page Full Size Gallery",
      "id"    => "header_homepage_fullsize",
      "type"  => "section"
    );
    $options[] = array( "type" => "open");

      /** The settings for the front full size gallery */
      $options[] = array(
        "name"  => __('Front page full size gallery settings', MAX_SHORTNAME),
        "id"    => "subhead_fullsize_homepage",
        "desc"  => __('These are the settings for the default front page full size gallery of the theme. This full size gallery is only showing if you have not set a "Static Front page" at the WordPress "Settings > Readings" options.', MAX_SHORTNAME),
        "type"  => "subhead"
      );

      $options[] = array(
        "id"     => MAX_SHORTNAME."_fullsize_front_tab_nav",
        "type"   => "tab_nav",
        "tabs"   => array(
          MAX_SHORTNAME."_fullsize_front_tab_general"   => 'Main Settings',
          MAX_SHORTNAME."_fullsize_front_tab_teaser"    => 'Welcome Teaser',
          MAX_SHORTNAME."_fullsize_front_tab_thumbnail" => 'Thumbnail Scroller Settings',
          MAX_SHORTNAME."_fullsize_front_tab_video"     => 'Video Settings'
        )
      );

      $options[] = array(
        "id"      => MAX_SHORTNAME."_fullsize_front_tab_general",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_fullsize_front_tab_general",
          "desc"  => __('With the main settings you can change the main behavior of the full size gallery images and slideshow elements with these options. These settings only affect the front page full size gallery of your theme.', MAX_SHORTNAME),
          "type"  => "subhead"
        );

        $options[] = array(
          "name"    => __('Featured galleries', MAX_SHORTNAME),
          "desc"    => __('Choose the galleries from which featured images for the full size gallery are drawn.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_cat",
          "type"    => "multicheck",
          "options" => $wp_gal_cats,
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Number of images', MAX_SHORTNAME),
          "desc"    => __('Enter the number of images you want to show in the full size gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_count",
          "type"    => "slider",
          "step"    => "1",
          "max"     => "350",
          "min"     => "1",
          "std"     => "18"
        );

        $options[] = array(
          "name"    => __('Autoplay slideshow', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to autoplay the slideshow for your full size gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_autoplay_slideshow",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Slideshow interval', MAX_SHORTNAME),
          "desc"    => __('The interval betweeen background slides in ms.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_interval",
          "type"    => "slider",
          "step"    => "100",
          "max"     => "50000",
          "min"     => "1000",
          "std"     => "8000"
        );

        $options[] = array(
          "name"    => __('Image order', MAX_SHORTNAME),
          "desc"    => __('Choose the order of images displayed in the full size gallery on homepage.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_order",
          "type"    => "select",
          "options" => $order_array,
          "std"     => "normal"
        );

        $options[] = array(
          "name"    => __('Image sorting direction', MAX_SHORTNAME),
          "desc"    => __('Choose the sorting direction of the images in a full size gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_sorting",
          "type"    => "select",
          "options" => array('desc' => __('Descending', MAX_SHORTNAME), 'asc' => __('Ascending', MAX_SHORTNAME)),
          "std"     => "desc"
        );

        $options[] = array(
          "name"    => __('Show fullsize overlay', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show the overlay pattern on your fullsize galleries.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_homepage_show_fullsize_overlay",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Always fit images', MAX_SHORTNAME),
          "desc"    => __('Check, if you want the images never exceed browser width or height and always remain their original proportions.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_fit_always",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Show overlay text', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show a title and a small text as overlay on the full size gallery (remember that text might not be readable on light fullsize backgrounds).', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_title_show",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Overlay title', MAX_SHORTNAME),
          "desc"    => __('Enter the text you want to show as title text on your homepage full size gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_title",
          "type"    => "text",
          "std"     => ""
        );

        $options[] = array(
          "name"    => __('Overlay text', MAX_SHORTNAME),
          "desc"    => __('Enter the text you want to show as description text on your homepage full size gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_featured_text",
          "std"     => "",
          "type"    => "textarea",
          "rows"    => 10
        );

      $options[] = array("type" => "tab_close");

      /** The thumbnail scroller settings only for the default theme frontpage Full Size Gallery */
      $options[] = array(
        "id"      => MAX_SHORTNAME."_fullsize_front_tab_thumbnail",
        "type"    => "tab_open",
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_fullsize_front_tab_thumbnail",
          "type"    => "subhead",
          "desc"    => __('The thumbnails settings control the behavior and look of the thumbnail scroller for all your full size galleries in your theme. These settings only affect the front page full size gallery of your theme.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"    => __('Show thumbnail scroller', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show the thumbnails on the homepage or not. By default the thumbnails are displayed.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_homepage_show_thumbnails",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Show slideshow title', MAX_SHORTNAME),
          "desc"    => __('Choose, if you want to show the large slideshow title above the thumbnail image scroller of a fullsize background gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_show_title",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Show slideshow excerpt', MAX_SHORTNAME),
          "desc"    => __('Choose, if you want to show the large excerpt title above the thumbnail image scroller of a fullsize background gallery. This excerpt is only shown, when "Show overlay slideshow title" is activated.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_show_title_excerpt",
          "type"    => "checkbox",
          "std"     => "true"
        );

      $options[] = array("type" => "tab_close");


      /** The video settings only for the default theme frontpage Full Size Gallery */
      $options[] = array(
        "id"    => MAX_SHORTNAME."_fullsize_front_tab_video",
        "type"  => "tab_open",
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_fullsize_front_tab_video",
          "desc"  => __('These video settings conrol the video you have added to a photo post within a full size gallery. These settings only affect the front page full size gallery of your theme.', MAX_SHORTNAME),
          "type"  => "subhead"
        );

        $options[] = array(
          "name"    => __('Autoplay slideshow videos', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to autoplay videos on your slideshow in a full size gallery.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_fullsize_autoplay_video",
          "type"    => "checkbox",
          "std"     => "true"
        );

      $options[] = array("type" => "tab_close");

      /** The welcome teaser settings for the front page full size gallery **/
      $options[] = array(
        "id"    => MAX_SHORTNAME."_fullsize_front_tab_teaser",
        "type"  => "tab_open",
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_fullsize_welcome_teaser",
          "type"    => "subhead",
          "desc"    => __("Setup the welcome teaser for your default front page full size gallery. If you are using a full size gallery page template you have to add the 'Welcome Teaser' widget to the sidebar of the page template.", MAX_SHORTNAME)
        );

        $options[] = array(
          "name"    => __('Show Welcome Teaser', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show your welcome teaser box on the homepage', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_homepage_show_welcome_teaser",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Welcome Teaser', MAX_SHORTNAME),
          "desc"    => __('Change your "Welcome Teaser on the Homepage.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_homepage_welcome_teaser",
          "type"    => "textarea",
          "std"     => "<strong>Hi! My name is Invictus</strong>. I am a highly versatile  and powerful <strong>premium WordPress Theme</strong> for all Photographers or Creative Folks designed by doitmax. <strong>Wow,</strong> I'm  responsive too! You can <strong>buy me now</strong> exclusively over at <strong><a href='http://bit.ly/plVhlj' target='_blank'>ThemeForest.net</a></strong>",
          "rows"    => 8
        );

        $options[] = array(
          "name"    => __('Welcome Teaser font style', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_font_welcome_teaser",
          "std"     => array('font_family' => "Yanone Kaffeesatz", 'font_size' => 26, 'line_height' => 28, 'font_weight' => 300, 'font_color' => '#ddd'),
          "type"    => "font",
          "min"     => 12,
          "max"     => 80
        );

        $options[] = array(
          "name"    => __('Welcome Teaser Bold Font Size', MAX_SHORTNAME),
          "desc"    => __('Select the font-size for the bold text of your Welcome Teaser in %. The base font-size is set above for "Welcome Teaser font style".', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_homepage_teaser_font_size_bold",
          "type"    => "slider",
          "step"    => "1",
          "max"     => "300",
          "min"     => "50",
          "std"     => "110"
        );

        $options[] = array(
          "name"    => __('Show Sidebar', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to show a sidebar on the homepage in addition to the welcome teaser on your themes front page.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_homepage_show_homepage_sidebar",
          "type"    => "checkbox",
          "std"     => "false"
        );

      $options[] = array("type" => "tab_close");

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Blog Tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => __('Blog', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_header_blog",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      /** The settings for the front full size gallery */
      $options[] = array(
        "name"    => __('Blog Settings', MAX_SHORTNAME),
        "id"      => "subhead_blog_settings",
        "desc"    => __('With these options you can control the look and layout of your blog posts, the blog images and the text showing on a blog post.', MAX_SHORTNAME),
        "type"    => "subhead"
      );

      $options[] = array(
        "id"     => MAX_SHORTNAME."_blog_tab_nav",
        "type"   => "tab_nav",
        "tabs"   => array(
          MAX_SHORTNAME."_blog_tab_general" => 'General Settings',
          MAX_SHORTNAME."_blog_tab_meta "   => 'Meta Settings'
        )
      );

      /** General blog settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_blog_tab_general",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"    => __('Show full blog post in blogroll', MAX_SHORTNAME),
          "desc"    => __('Activate this option, if you want to show the full blog post in the blogroll instead of a short excerpt.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_show_fullblog",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Do not crop featured images in the blogroll', MAX_SHORTNAME),
          "desc"    => __('Activate this option, if you want to use the original ratio without cropping for your featured images in the blogroll.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_image_blog_original_ratio",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Do not crop blog featured images', MAX_SHORTNAME),
          "desc"    => __('Activate this option, if you want to use the original ratio without cropping for your featured images on a blog post detail page.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_image_blog_detail_original_ratio",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array(
          "name"    => __('Do not show videos and sliders in blogroll', MAX_SHORTNAME),
          "desc"    => __('Activate this option, if you want to show the videos or sliders on blog post in the blogroll instead of the featured image.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_blog_show_compact",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Show full width blog details', MAX_SHORTNAME),
          "desc"    => __('Activate this option, if you want to show the full blog post detail page without sidebar but with full page width.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_show_fullblog_details",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
            "name"  => __('Show post author text', MAX_SHORTNAME),
            "desc"  => __('Activate this option, if you want to show the post author of a post on the blog post page below an article.', MAX_SHORTNAME),
            "id"    => MAX_SHORTNAME."_general_show_author",
            "type"  => "checkbox",
            "std"   => "true"
        );

        $options[] = array(
          "name"    => __('Selected option for background type', MAX_SHORTNAME),
          "desc"    => __('Choose an option, that is selected by default for the "Type of fullsize background" dropdown on your blog post edit page. This option is selected by default for all new created blog posts. You have to change it for existing posts.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_blog_background_default",
          "type"    => "select",
          "options" => array("single" => __("Single Image", MAX_SHORTNAME), "slideshow" => __("Slideshow Gallery", MAX_SHORTNAME), "default" => __("Default Theme Option", MAX_SHORTNAME)),
          "std"     => "single"
        );

        $options[] = array(
          "name"    => __('Default theme option background', MAX_SHORTNAME),
          "desc"    => __('The global background type for "Type of fullsize background" when selecting "Default Theme Option" at the blog post or as selected option above.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_blog_background",
          "type"    => "select",
          "options" => array("single" => __("Single Image", MAX_SHORTNAME), "slideshow" => __("Slideshow Gallery", MAX_SHORTNAME)),
          "std"     => "single"
        );

        $options[] = array(
          "name"    => __('Default single image background', MAX_SHORTNAME),
          "desc"    => __('Upload an image to show as default blog post background, if you have set "Default Blog Post Background" to "Single Image". Leave blank to show the featured image.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_general_blog_background_image",
          "type"    => "upload",
          "std"     => ""
        );

        $options[] = array(
        "name" => __('Default background slideshow gallery', MAX_SHORTNAME),
        "desc"      => __('Choose the galleries from which the default background images for the slideshow on blog posts are drawn from.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_general_blog_background_galleries",
        "type"      => "multicheck",
        "options"   => $wp_gal_cats,
        "std"       => "false"
        );

      $options[] = array("type" => "tab_close");


      /** Tab to setup blog post meta **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_blog_tab_meta",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_general_blog_meta",
          "type"    => "subhead",
          "desc"    => __('With these blog post meta settings you can hide part or the complete post meta information on a blog post and in the blog roll. Hide the author, the date or other information as well.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"    => __('Hide post meta', MAX_SHORTNAME),
          "desc"    => __('Do you want to completely hide the post meta information for a blog post (author, date, categories etc)?', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_blog_meta_show",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post categories', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post categories of a post on a blog post.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_blog_meta_show_category",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post author', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post author on blog post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_blog_meta_show_author",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post date', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post date on blog post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_blog_meta_show_date",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post comments count', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post comment count on blog post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_blog_meta_show_comment",
          "type"    => "checkbox",
          "std"     => "false"
        );

      $options[] = array("type" => "tab_close");

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Images tab
		/*-----------------------------------------------------------------------------------*/

    $options[] = array(
      "name"    => __('Photos &amp; Images', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_header_images",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      /** The settings for the Photos & Images tab */
      $options[] = array(
        "name"    => __('Photos &amp; Images', MAX_SHORTNAME),
        "id"      => "subhead_images_settings",
        "desc"    => __('On this tab you can control the settings for images and the photo posts.', MAX_SHORTNAME),
        "type"    => "subhead"
      );

      $options[] = array(
        "id"     => MAX_SHORTNAME."_image_tab_nav",
        "type"   => "tab_nav",
        "tabs"   => array(
          MAX_SHORTNAME."_images_tab_general"       => 'General Settings',
          MAX_SHORTNAME."_images_tab_project_page"  => 'Detail Pages',
          MAX_SHORTNAME."_images_tab_project_meta"  => 'Meta Settings'
        )
      );

      /** General images settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_images_tab_general",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"  => __('Use timthumb.php image cropping', MAX_SHORTNAME),
          "desc"  => __('Activate this option, if you want to use timthumb dynamic image resizing script. This is recommend, if your images and thumbnails are not showing properly, when this option is deactivated.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_image_use_timthumb",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array(
          "name"  => __('Photo Post Slug', MAX_SHORTNAME),
          "desc"  => __('Enter the URL Slug for your Photos Post-Type (Default: gallery). You have to reset your permalinks to default and save it to your wanted setting again after changing this.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_rewrite_posttype",
          "type"  => "text",
          "std"   => "gallery"
        );

        $options[] = array(
          "name"  => __('Gallery Taxonomy Slug', MAX_SHORTNAME),
          "desc"  => __('Enter the URL Slug for your Gallery Taxonomy (Default: gallery-categories) You have to reset your permalinks to default and save it to your wanted setting again after changing this.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_rewrite_taxonomy",
          "type"  => "text",
          "std"   => "gallery-categories"
        );

        $options[] = array(
          "name"      => __('Show image caption', MAX_SHORTNAME),
          "desc"      => __('Show the image caption and a small excerpt on mouseover, show always do not show it at all.', MAX_SHORTNAME),
          "id"        => MAX_SHORTNAME."_image_show_caption",
          "type"      => "select",
          "options"   => array("true" => __('On hover', MAX_SHORTNAME), "always" => __('Show always', MAX_SHORTNAME), "false" => __("Do not show", MAX_SHORTNAME)),
          "std"       => "true"
        );

        $options[] = array(
          "name"      => __('Hide image caption excerpt', MAX_SHORTNAME),
          "desc"      => __('Do you want to hide the image caption excerpt below the title on mouseover.', MAX_SHORTNAME),
          "id"        => MAX_SHORTNAME."_image_caption_excerpt",
          "type"      => "select",
          "options"   => array("false" => __('Show excerpt', MAX_SHORTNAME), "true" => __('Hide Excerpt', MAX_SHORTNAME)),
          "std"       => "false"
        );

        $options[] = array(
          "name"  => __('Show image fade', MAX_SHORTNAME),
          "desc"  => __('Show the image fade and background on mouseover.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_image_show_fade",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Always show lightbox and detail link', MAX_SHORTNAME),
          "desc"  => __('Always show the lightbox and detail link on photo posts, no matter what is set on photo options page.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_image_always_lightbox",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array(
          "name"    => __('Photo archive sorting direction', MAX_SHORTNAME),
          "desc"    => __('Choose the sorting direction of posts within photo post archives &amp; tags pages.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_photo_post_archive_sorting",
          "type"    => "select",
          "options" => array('desc' => __('Descending', MAX_SHORTNAME), 'asc' => __('Ascending', MAX_SHORTNAME)),
          "std"     => "desc"
        );

      $options[] = array("type" => "tab_close");

      /** General blog settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_images_tab_project_page",
        "type"    => "tab_open",
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_images_project_page",
          "type"  => "subhead",
          "desc"  => __('These settings change how you photo post detail pages look like. You can activate additional features or hide parts of the detail page.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"  => __('Do not crop photos featured image', MAX_SHORTNAME),
          "desc"  => __('Check, if you want to use the original ratio without cropping for your featured images on a photos post page.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_image_project_original_ratio",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Show "More from this gallery" images on photo project page', MAX_SHORTNAME),
          "desc"  => __('Check, if you want to show images from the current gallery where the photo is drawn from. These images are showing below the photo post details.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_image_show_gallery_images",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Number of "More from this gallery" images', MAX_SHORTNAME),
          "desc"  => __('Set the number of gallery images to show at "More from this gallery" on a photos post page. These images are drawn from the gallery the current photo is attached to.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_image_count_gallery_images",
          "type"  => "slider",
          "step"  => "1",
          "max"   => "100",
          "min"   => "1",
          "std"   => "20"
        );

        $options[] = array(
          "name"  => __('Show photo post author', MAX_SHORTNAME),
          "desc"  => __('Check, if you want to show the author information on the photo post page below the post details.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_general_show_photo_author",
          "type"  => "checkbox",
          "std"   => "true"
        );

      $options[] = array("type" => "tab_close");

      /** Tab to setup photo post meta **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_images_tab_project_meta",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_images_post_meta",
          "type"    => "subhead",
          "desc"    => __('With these photo post meta settings you can hide part or the complete post meta information on a photo post. You can hide the author, the date and other information as well or completely hide the meta information.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"    => __('Hide post meta', MAX_SHORTNAME),
          "desc"    => __('Do you want to completely hide the post meta information for a photo post (author, date, categories etc)?', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_images_meta_show",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide gallery categories', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post gallery categories on photo post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_images_meta_show_category",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post author', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post author on photo post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_images_meta_show_author",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post date', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post date on photo post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_images_meta_show_date",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post comments count', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the post comment count on photo post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_images_meta_show_comment",
          "type"    => "checkbox",
          "std"     => "false"
        );

        $options[] = array(
          "name"    => __('Hide post nav arrows', MAX_SHORTNAME),
          "desc"    => __('Check, if you want to hide the prev/next arrows on photo post meta.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_images_post_nav_show",
          "type"    => "checkbox",
          "std"     => "false"
        );

      $options[] = array("type" => "tab_close");

    $options[] = array( "type" => "close");



		/*-----------------------------------------------------------------------------------*/
		/*	Flickr template management
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => __('Full Size Flickr', MAX_SHORTNAME),
      "id"      => "header_fullsize_flickr",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      $options[] = array(
        "name"  => __('Full Size Flickr Settings', MAX_SHORTNAME),
        "id"    => "subhead_flickr_general",
        "type"  => "subhead",
        "desc"  => __('Control the layout and behavior of your full size Flickr portfolio templates. These options affect all your Flickr page templates.', MAX_SHORTNAME )
      );

      $options[] = array(
        "id"     => MAX_SHORTNAME."_flickr_tab_nav",
        "type"   => "tab_nav",
        "tabs"   => array(
          MAX_SHORTNAME."_flickr_tab_general"       => 'General',
          MAX_SHORTNAME."_flickr_tab_slideshow"     => 'Slideshow',
          MAX_SHORTNAME."_flickr_tab_controlbar"    => 'Control bar'
        )
      );

      /** General flickr settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_flickr_tab_general",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_flickr_general",
          "type"  => "subhead",
          "desc"  => __('These are the general settings for all your Flickr full size gallery page templates. You have to add a valid Flickr API key in order to make the templates work properly.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"  => __('Flickr API Key', MAX_SHORTNAME),
          "desc"  => __('Your Flickr API Key. Please create your own here: <a href="http://bit.ly/phYq8o">http://bit.ly/phYq8o</a>',MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_api_key",
          "type"  => "text",
          "std"   => ""
        );

        $options[] = array(
          "name" => __("Always fit images", MAX_SHORTNAME),
          "desc"  => __('Image will never exceed browser width or height.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_always_fit",
          "type"  => "checkbox",
          "std"   => "false"
        );

        $options[] = array( "name" => __("Show overlay", MAX_SHORTNAME),
          "desc"  => __('Enable or disable the fullsize overlay.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_scanlines",
          "type"  => "checkbox",
          "std"   => "true"
        );

      $options[] = array( "type" => "tab_close");

      /** slideshow flickr settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_flickr_tab_slideshow",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_flickr_slideshow",
          "type"  => "subhead",
          "desc"  => __('Change the settings for the slideshow. This controls the autoplay, interval and type of transition.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"  => __("Autoplay", MAX_SHORTNAME),
          "desc"  => __('Check, slideshow starts playing automatically.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_autoplay",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __('Slideshow interval', MAX_SHORTNAME),
          "desc"  => __('The interval betweeen each slides in ms.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_slideshow_interval",
          "type"  => "slider",
          "step"  => "10",
          "max"   => "20000",
          "min"   => "100",
          "std"   => "5000"
        );

        $options[] = array(
          "name"      => __('Transition', MAX_SHORTNAME),
          "desc"      => __('Type of transition for each slide', MAX_SHORTNAME),
          "id"        => MAX_SHORTNAME."_flickr_transition",
          "type"      => "select",
          "options"   => array(
            '0'         => __('None', MAX_SHORTNAME),
            '1'         => __('Fade', MAX_SHORTNAME),
            '2'         => __('Slide Top', MAX_SHORTNAME),
            '3'         => __('Slide Right', MAX_SHORTNAME),
            '4'         => __('Slide Bottom', MAX_SHORTNAME),
            '5'         => __('Slide Left', MAX_SHORTNAME),
          ),
          "std"       => "1"
        );

        $options[] = array(
          "name"  => __('Transition speed', MAX_SHORTNAME),
          "desc"  => __('The speed of transition in ms.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_transition_speed",
          "type"  => "slider",
          "step"  => "10",
          "max"   => "5000",
          "min"   => "10",
          "std"   => "750"
        );

      $options[] = array( "type" => "tab_close");

      /** slideshow flickr settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_flickr_tab_controlbar",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"  => '',
          "id"    => "subhead_flickr_controlbar",
          "type"  => "subhead",
          "desc"  => __('Change the settings for the Flickr control bar at the bottom of your full size Flickr template. For example you can hide each element separately or hide them all.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"  => __("Show navigation", MAX_SHORTNAME),
          "desc"  => __('Show slideshow controls or hide (play, pause, next, prev).', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_navigation",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __("Show thumbnails", MAX_SHORTNAME),
          "desc"  => __('Show thumbnail navigation for prev and next images.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_thumbnail_navigation",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __("Show slide numbers", MAX_SHORTNAME),
          "desc"  => __('Display actual and allover slide numbers on control bar.', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_slide_counter",
          "type"  => "checkbox",
          "std"   => "true"
        );

        $options[] = array(
          "name"  => __("Show slide captions", MAX_SHORTNAME),
          "desc"  => __('Display the slide caption for each image. (Pull from "title" in slides array of flickr images).', MAX_SHORTNAME),
          "id"    => MAX_SHORTNAME."_flickr_slide_captions",
          "type"  => "checkbox",
          "std"   => "true"
        );

      $options[] = array( "type" => "tab_close");

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Sidebar tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => __('Custom Sidebars', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_header_sidebars",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      $options[] = array(
        "name"  => __('Custom Sidebar', MAX_SHORTNAME),
        "id"    => "subhead_sidebar",
        "type"  => "subhead",
        "desc"  => __('Create custom sidebars and use them in your pages. You can choose created sidebars for every page you create with WordPress.', MAX_SHORTNAME )
      );

      $options[] = array(
        "name"  => __("Added Sidebars", MAX_SHORTNAME),
        "desc"  => __('Add your custom Sidebars on the right side. You can reorder these sidebars by drag and drop and delete them with a click on "x".', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_sidebar_array",
        "type"  => "sidebar",
        "std"   => "true"
      );

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Lightbox tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => __('Lightbox Options', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_header_prettyPhoto",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

       $options[] = array(
        "name"  => __('Lightbox Options', MAX_SHORTNAME),
        "id"    => "subhead_lightbox",
        "type"  => "subhead",
        "desc"  => __('With these options you can control the display of the lightbox that shows up, when you click on a blog post image or a photo with the respective link type set.', MAX_SHORTNAME )
      );

      $options[] = array(
        "name"    => __('Disable Lightbox ', MAX_SHORTNAME),
        "desc"    => __('Check, if you want to disable the PrettyPhoto lightbox on images completely. <strong>Important Note:</strong> Only activate this option, if you are using a different lightbox script instead!', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_pretty_enable_lightbox",
        "type"    => "checkbox",
        "std"     => "false"
      );

      $options[] = array(
        "name"      => __('Theme', MAX_SHORTNAME),
        "desc"      => __('Choose from one of the five supplied themes.', MAX_SHORTNAME),
        "id"        => MAX_SHORTNAME."_pretty_theme",
        "type"      => "select",
        "options"   => $pretty_theme_array,
        "std"       => "dark_square"
      );

      $options[] = array(
        "name"  => __('Enable Image Resize', MAX_SHORTNAME),
        "desc"  => __('Allow the user to expand a resized image.', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_pretty_allow_expand",
        "type"  => "checkbox",
        "std"   => "false"
      );

      $options[] = array(
        "name"  => __('Show social tools', MAX_SHORTNAME),
        "desc"  => __('Check, if you want to show the social tools of Twitter &amp; Facebook in the lightbox.', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_pretty_social_tools",
        "type"  => "checkbox",
        "std"   => "false"
      );

      $options[] = array(
        "name"  => __('Image Title/Description from Media Library', MAX_SHORTNAME),
        "desc"  => __('Check, if you want to use the title and description in lightbox of a featured image instead of the post/page title and excerpt.', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_general_use_image_meta",
        "type"  => "checkbox",
        "std"   => "false"
      );

      $options[] = array(
        "name"  => __('Show Lightbox Gallery', MAX_SHORTNAME),
        "desc"  => __('Check, if you want to show the lightbox gallery of prettyPhoto.', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_pretty_gallery_show",
        "type"  => "checkbox",
        "std"   => "true"
      );

      $options[] = array(
        "name"  => __('Show Lightbox Title &amp; Description', MAX_SHORTNAME),
        "desc"  => __('Check, if you want to show the title and description of a image open in prettyPhoto.', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_pretty_title_show",
        "type"  => "checkbox",
        "std"   => "true"
      );

      $options[] = array(
        "name"  => __('Slideshow Interval', MAX_SHORTNAME),
        "desc"  => __('Interval time of images in ms. Value "false" will disable the slideshow."', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_pretty_interval",
        "type"  => "slider",
        "step"  => "100",
        "max"   => "50000",
        "min"   => "1000",
        "std"   => "8000"
      );

      $options[] = array(
        "name"    => __('Animation Speed', MAX_SHORTNAME),
        "desc"    => __('The Speed of the popup animation to open an image.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_pretty_speed",
        "type"    => "select",
        "options" => $pretty_speed_array,
        "std"     => "350"
      );

      $options[] = array(
        "name"  => __('Thumbnail gallery limit', MAX_SHORTNAME),
        "desc"  => __('Set the limit of thumbnails within a lightbox gallery. If there are more thumbnails than this limit the thumbnails are hidden to speed up loading time.', MAX_SHORTNAME),
        "id"    => MAX_SHORTNAME."_pretty_thumbnail_limit",
        "type"  => "slider",
        "step"  => "1",
        "max"   => "200",
        "min"   => "6",
        "std"   => "30"
      );

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Contact tab
		/*-----------------------------------------------------------------------------------*/

		$options[] = array(
      "name"    => __('Contact Pages', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_header_contact",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      $options[] = array(
        "name"  => __('Contact pages options', MAX_SHORTNAME),
        "id"    => "subhead_contact",
        "desc"  => __('These are the settings for your contact pages. Add your contact details or company information. These settings affect all contact pages within your theme.', MAX_SHORTNAME),
        "type"  => "subhead"
      );

      $options[] = array(
        "name"    => __('Contact Form eMail', MAX_SHORTNAME),
        "desc"    => __('Enter the eMail thats used to send a you a contact request via contact formular.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_email",
        "type"    => "text",
        "std"     => "mail@example.com"
      );

      $options[] = array(
        "name"    => __('Show contact information text', MAX_SHORTNAME),
        "desc"    => __('Show the contact information text on the right hand side of your contact pages.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_show_text",
        "type"    => "checkbox",
        "std"     => "true"
      );

      $options[] = array(
        "name"    => __('Sidebar info headline', MAX_SHORTNAME),
        "desc"    => __('Enter the headline of your contact information text.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_sidebar_header",
        "type"    => "text",
        "std"     => "Company Info"
      );

      $options[] = array(
        "name"    => __('Sidebar info text', MAX_SHORTNAME),
        "desc"    => __('Enter the info text for your contact information text on the left.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_info",
        "type"    => "textarea",
        "std"     => "Aenean nisl orci, condimentum ultrices consequat eu, vehicula ac mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nisl orci, condimentum ultrices consequat eu, vehicula ac mauris. Ut adipiscing, leo nec. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        "rows"    => 6
      );

      $options[] = array(
        "name"    => __('Show company info', MAX_SHORTNAME),
        "desc"    => __('Show the company info text on the left of your contact page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_show_info",
        "type"    => "checkbox",
        "std"     => "true"
      );

      $options[] = array(
        "name"    => __('Company headline', MAX_SHORTNAME),
        "desc"    => __('Enter the headline of your company contact information.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_info_header",
        "type"    => "text",
        "std"     => "Awesome Company Name"
      );

      $options[] = array(
        "name"    => __('Adress line 1', MAX_SHORTNAME),
        "desc"    => __('Enter the first adress line.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_adress_1",
        "type"    => "text",
        "std"     => "121 King Street, Melbourne"
      );

      $options[] = array(
        "name"    => __('Adress line 2', MAX_SHORTNAME),
        "desc"    => __('Enter the second adress Line.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_adress_2",
        "type"    => "text",
        "std"     => "Victoria 3000 Australia"
      );

      $options[] = array(
        "name"    => __('Phone', MAX_SHORTNAME),
        "desc"    => __('Enter your phone number. Leave blank to hide.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_phone",
        "type"    => "text",
        "std"     => "+61 3 8376 6284"
      );

      $options[] = array(
        "name"    => __('Fax', MAX_SHORTNAME),
        "desc"    => __('Enter your Fax Number. Leave this field blank to hide it.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_fax",
        "type"    => "text",
        "std"     => "+61 3 8376 6285"
      );

      $options[] = array(
        "name"    => __('Contact eMail', MAX_SHORTNAME),
        "desc"    => __('Enter your company eMail address. Leave this field blank to hide it.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_contact_info_email",
        "type"    => "text",
        "std"     => "support@example.com"
      );

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Footer Tab
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => __('Footer', MAX_SHORTNAME),
      "id"      => MAX_SHORTNAME."_header_footer",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      $options[] = array(
        "name"  => __('Footer settings', MAX_SHORTNAME),
        "id"    => "subhead_footer",
        "desc"  => __('These are the settings for your website footer. Add some copyright or information text and control the social icons. You can also choose to show or hide the social links within the footer.', MAX_SHORTNAME),
        "type"  => "subhead"
      );

      $options[] = array(
        "id"     => MAX_SHORTNAME."_footer_tab_nav",
        "type"   => "tab_nav",
        "tabs"   => array(
          MAX_SHORTNAME."_footer_tab_general"  => 'General',
          MAX_SHORTNAME."_footer_tab_icons"    => 'Social Icons'
        )
      );

      /** Social icon settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_footer_tab_general",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"    => __('Copyright', MAX_SHORTNAME),
          "desc"    => __('Enter your copyright text for the footer.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_copyright",
          "type"    => "textarea",
          "std"     => '&copy; Copyright 2014 <a href="http://themes.doitmax.de/wordpress/invictus/">Invicus</a> / Powered by <a href="http://wordpress.org/">WordPress</a> / <a href="http://themes.doitmax.de/wordpress/invictus/">Invictus Theme</a> by <a href="http://www.doitmax.com/">doitmax</a>',
          "rows"    => 6
        );

        $options[] = array(
          "name"    => __("Hide Footer", MAX_SHORTNAME),
          "desc"    => __('Do you want to hide the footer completely?', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_footer_hide",
          "type"    => "checkbox",
          "std"     => "true"
        );

      $options[] = array( "type" => "tab_close");

      /** Social icon settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_footer_tab_icons",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"    => __("Show Social links", MAX_SHORTNAME),
          "desc"    => __('Do you want to show social links in your websites footer?', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_social_use",
          "type"    => "checkbox",
          "std"     => "true"
        );

        $options[] = array( "name" => __('Social Icons', MAX_SHORTNAME),
          "desc"    => __('Choose the social icons that will be displayed in your footer.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_social_show",
          "type"    => "socialinput",
          "options" => $social_array,
          "std"     => array('true')
        );

        $options[] = array( "name" => __("Open Blank", MAX_SHORTNAME),
          "desc" => __('Do you want to open social links in a blank Browser window?', MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_social_show_blank",
          "type" => "checkbox",
          "std"  => "true"
        );

      $options[] = array( "type" => "tab_close");

    $options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Social Management tab
		/*-----------------------------------------------------------------------------------*/

    $options[] = array(
      "name" => __('Social Sharing', MAX_SHORTNAME),
      "id"   =>"header_social",
      "type" => "section"
    );
    $options[] = array( "type" => "open");

      $options[] = array(
        "name"  => __('Social sharing settings ', MAX_SHORTNAME),
        "id"    => "subhead_social_sharing",
        "type"  => "subhead",
        "desc"  => __('Setup social sharing on your theme. Control the behavior of social links and likes within the blog and photo posts.', MAX_SHORTNAME )
      );

      $options[] = array(
        "id"     => MAX_SHORTNAME."_social_tab_nav",
        "type"   => "tab_nav",
        "tabs"   => array(
          MAX_SHORTNAME."_social_tab_general"  => 'Post sharing',
          MAX_SHORTNAME."_social_tab_facebook" => 'Facebook settings'
        )
      );

      /** Social icon settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_social_tab_general",
        "type"    => "tab_open",
        "display" => true
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_posts_socials",
          "type"    => "subhead",
          "desc"    => __('These settings control the social sharing in a single blog or photo post. You can turn on single options, or deactivate them all.', MAX_SHORTNAME)
        );

        $options[] = array( "name" => __("Activate Social Sharing", MAX_SHORTNAME),
          "desc" => __('Do you want to show social sharing buttons for each blog or photo post?', MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_post_social",
          "type" => "checkbox",
          "std"  => "true"
        );

        $options[] = array( "name" => __("Facebook", MAX_SHORTNAME),
          "desc" => __('Show the Facebook "Like" Button?', MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_post_social_facebook",
          "type" => "checkbox",
          "std"  => "true"
        );

        $options[] = array( "name" => __("Twitter", MAX_SHORTNAME),
          "desc" => __('Show the tweet Button?', MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_post_social_twitter",
          "type" => "checkbox",
          "std"  => "true"
        );

        $options[] = array( "name" => __("Google+", MAX_SHORTNAME),
          "desc" => __('Show the Google+ Button?', MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_post_social_google",
          "type" => "checkbox",
          "std"  => "true"
        );

        $options[] = array( "name" => __("Pinterest", MAX_SHORTNAME),
          "desc" => __('Show the Pinterest Button?', MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_post_social_pinterest",
          "type" => "checkbox",
          "std"  => "true"
        );

        $options[] = array( "name" => __('Social Share Caption', MAX_SHORTNAME),
          "desc" => __('Enter the text which is shown near the share buttons of your posts.',MAX_SHORTNAME),
          "id"   => MAX_SHORTNAME."_post_social_text",
          "type" => "text",
          "std"  => "<strong>Share my work!</strong>"
        );

      $options[] = array( "type" => "tab_close");

      /** Facebook settings **/
      $options[] = array(
        "id"      => MAX_SHORTNAME."_social_tab_facebook",
        "type"    => "tab_open"
      );

        $options[] = array(
          "name"    => '',
          "id"      => "subhead_facebook_options",
          "type"    => "subhead",
          "desc"    => __('Setup your Facebook social sharing options like app:id or og:meta information.', MAX_SHORTNAME)
        );

        $options[] = array(
          "name"    => __('Facebook language', MAX_SHORTNAME),
          "desc"    => __('Enter your language string for the like facebook button e.g. en_US, en_GB, de_DE, it_IT.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_post_social_language",
          "type"    => "text",
          "std"     => "en_US"
        );

        $options[] = array(
          "name"    => __('fb:admins', MAX_SHORTNAME),
          "desc"    => __('The Facebook admin id (<a href="https://developers.facebook.com/docs/insights/">More Info</a>)', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_social_fb_admins",
          "type"    => "text",
          "std"     => ""
        );

        $options[] = array(
          "name"    => __('fb:app_id', MAX_SHORTNAME),
          "desc"    => __('The Facebook app_id (<a href="https://developers.facebook.com/docs/insights/">More Info</a>)', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_social_fb_appid",
          "type"    => "text",
          "std"     => ""
        );

        $options[] = array(
          "name"    => __('og:image', MAX_SHORTNAME),
          "desc"    => __('Upload your image to show on facebook when someone likes your website. Only for homepage and pages without a featured image.', MAX_SHORTNAME),
          "id"      => MAX_SHORTNAME."_social_og_image",
          "std"     => "",
          "type"    => "upload"
        );

      $options[] = array( "type" => "tab_close");

    $options[] = array( "type" => "close");

		/*-----------------------------------------------------------------------------------*/
		/*	Splash Screen
		/*-----------------------------------------------------------------------------------*/
		$options[] = array(
      "name" => __('Splash Screen', MAX_SHORTNAME),
      "id"     => "splash",
      "type"   => "section"
    );
		$options[] = array( "type" => "open");

  		$options[]    = array(
        "name" => __('Splash Screen', MAX_SHORTNAME),
        "id"   => "subhead_splash_screen",
        "type" => "subhead",
        "desc" => __('Setup a splash screen that is showing once or multiple times for any user visiting your website. This splash screen can be a single image, a welcome text or even both. ', MAX_SHORTNAME)
      );

			$options[] = array(
        "name" => __('Show Splash Screen', MAX_SHORTNAME),
        "desc" => __('Do you want to show a custom "Splash Screen" as your homepage?', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_show",
        "type" => "checkbox",
        "std"  => "false")
      ;

      $options[] = array(
        "name" => __('Only show Splash Screen once per Visitor', MAX_SHORTNAME),
        "desc" => __('Once the visitor has entered your website, the splash screen is not showing anymore. A cookie is set which expires after 10 days. Then the splash screen is showing again. If you deactivate this option, the splash screen is always showing, when visiting the "Frontpage".', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_cookie_set",
        "type" => "checkbox",
        "std"  => "true"
      );

			$options[] = array(
        "name" => __('Splash Screen Cookie Expire', MAX_SHORTNAME),
        "desc" => __('Set the expire time of the splash screen cookie in days. After that time the splash screen is shown again for the same user. Set it to 0 to create a cookie for the current session.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_cookie_expires",
        "type" => "slider",
        "step" => "1",
        "max"  => "365",
        "min"  => "0",
        "std"  => "0"
      );

			$options[] = array(
        "name" => __('Splash Screen Logo', MAX_SHORTNAME),
        "desc" => __('Upload your own logo to show on the splash screen. If you want to show the same logo as your page, leave this page blank.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_logo",
        "std"  => "",
        "type" => "upload"
      );

			$options[] = array(
        "name" => __('Splash Screen Logo Retina @2x', MAX_SHORTNAME),
        "desc" => __('Please choose an image file for the retina version of the splash screen logo. This logo must be twice as large as the original. <strong>Important:</strong> The filename has to be the same as the original Logo but with @2x at the end, e.g. logo@2x.png', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_logo_2x",
        "std"  => "",
        "type" => "upload"
      );

			$options[]   = array(
        "name" => __('Splash Screen Logo Width (px)', MAX_SHORTNAME),
        "desc" => __('Enter the width of your splash screen logo without px. This is needed to show the retina logo in right dimensions.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_logo_width",
        "type" => "text",
        "std"  => "235"
      );

      $options[] = array(
        "name" => __('Splash Screen Logo Height (px)', MAX_SHORTNAME),
        "desc" => __('Enter the height of your splash screen logo without px. This is needed to show the retina logo in right dimensions.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_logo_height",
        "type" => "text",
        "std"  => "100"
      );

      $options[] = array(
        "name" => __('Splash Screen Font Color', MAX_SHORTNAME),
        "desc" => __('This is the font color for your splash text.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_font_color",
        "type" => "colorpicker",
        "std"  => "#bbb"
      );

      $options[] = array(
        "name" => __('Show "Enter Site" button', MAX_SHORTNAME),
        "desc" => __('Do you want to show the "enter" button on your splash screen?', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_show_enter",
        "type" => "checkbox",
        "std"  => "true"
      );

      $options[] = array(
        "name" => __('Enter Button Text',MAX_SHORTNAME),
        "desc" => __('Enter the text to show on the "Enter" button.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_enter_text",
        "std"  => "Enter Site",
        "type" => "text"
      );

      $options[] = array(
        "name" => __('Custom Text',MAX_SHORTNAME),
        "desc" => __('Enter some custom text to show on your Splash Screen. You can use HTML here.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_custom_text",
        "std"  => "",
        "type" => "textarea",
        "rows" => 10
      );


      $options[] = array(
        "name" => __('Animation', MAX_SHORTNAME),
        "id"   =>"subhead_splash_animation",
        "type" => "subhead"
      );

      $options[] = array(
        "name" => __('Automatically hide Splash Screen', MAX_SHORTNAME),
        "desc" => __('Do you want to hide the "Splash Screen" automatically? Set the timer below.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_hide",
        "type" => "checkbox",
        "std"  => "false"
      );

      $options[] = array(
        "name" => __('Timeout', MAX_SHORTNAME),
        "desc" => __('Set the timeout to hide the splash screen in ms.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_timeout",
        "type" => "slider",
        "step" => "50",
        "max"  => "20000",
        "min"  => "1000",
        "std"  => "5000"
      );

      $options[] = array(
        "name" => __('Animation Time', MAX_SHORTNAME),
        "desc" => __('Set the animation time to hide the splash screen in ms.', MAX_SHORTNAME),
        "id"   => MAX_SHORTNAME."_splash_fade",
        "type" => "slider",
        "step" => "50",
        "max"  => "5000",
        "min"  => "100",
        "std"  => "500"
      );

		$options[] = array( "type" => "close");


		/*-----------------------------------------------------------------------------------*/
		/*	Page Backgrounds
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => __('Page Backgrounds', MAX_SHORTNAME),
      "id"      => "page_backgrounds",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

		$options[]    = array( "name" => __('Page backgrounds', MAX_SHORTNAME),
							"id"     => "subhead_page_backgrounds",
							"type"   => "subhead",
							"desc"   => __('With these settings you can control the page backgrounds on pages that are automatically generated by WordPress, like archive and image attachment pages.', MAX_SHORTNAME));

      $options[] = array(
        "name"    => __('404 Background', MAX_SHORTNAME),
        "desc"    => __('Upload your background for the 404 Page not found page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_404",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Tags Page', MAX_SHORTNAME),
        "desc"    => __('Upload your background for the Tags page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_tag",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Archive', MAX_SHORTNAME),
        "desc"    => __('Upload your background for the Archive page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_archive",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Search Results', MAX_SHORTNAME),
        "desc"    => __('Upload your background for the Search results page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_search",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Category', MAX_SHORTNAME),
        "desc"    => __('Upload your background for a single category page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_category",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Taxonomy/Gallery Archive', MAX_SHORTNAME),
        "desc"    => __('Upload your background for a taxonomy/gallery archive page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_taxonomy",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Attachment Page Background', MAX_SHORTNAME),
        "desc"    => __('Upload your background for a single attachment page. This option is ignored, if checkbox for "Attachment Image as Background" is activated.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_attachment_url",
        "std"     => "",
        "type"    => "upload"
      );

      $options[] = array(
        "name"    => __('Attachment Image as Background', MAX_SHORTNAME),
        "desc"    => __('Turn on, if you want to show the attachment image as background on the attachment detail page.', MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_page_background_attachment",
        "type"    => "checkbox",
        "std"     => "true"
      );

    $options[] = array( "type" => "close");

    /*-----------------------------------------------------------------------------------*/
    /*  Admin login
    /*-----------------------------------------------------------------------------------*/

    $options[] = array(
      "name" => __( 'Admin Login', MAX_SHORTNAME ),
      "id"   => "admin_login",
      "type" => "section"
    );
    $options[] = array( "type" => "open");

      $options[]    = array(
        "id"   => "subhead_admin_login",
        "name" => __('WordPress Admin Login', MAX_SHORTNAME),
        "desc" => __('Control the layout of your WordPress admin login page. You can change the login logo, the background and some general styling properties.', MAX_SHORTNAME),
        "type" => "subhead",
      );

      $options[] = array(
        "id"   => MAX_SHORTNAME."_custom_login_logo",
        "name" => __( 'Custom Login Screen', MAX_SHORTNAME ),
        "desc" => __( 'Toggle the custom login screen design on or off. If you want to disable it, remove the default images below to save on loading time for your theme panel.', MAX_SHORTNAME ),
        "type" => "checkbox",
        "std"  => "false"
      );

      $options[] = array(
        "id"   => MAX_SHORTNAME."_admin_login_logo",
        "name" => __( 'Login Logo', MAX_SHORTNAME ),
        "desc" => __( 'Upload a custom logo for your login screen .', MAX_SHORTNAME ),
        "std"  => "",
        "type" => "upload"
      );

      $options[]   = array(
        "id"   => MAX_SHORTNAME."_admin_login_logo_height",
        "name" => __( 'Logo Height', MAX_SHORTNAME ),
        "desc" => __( 'Enter a height in pixels for your login logo (required).', MAX_SHORTNAME ),
        "type" => "text",
        "std"  => ""
      );

      $options[]   = array(
        "id"   => MAX_SHORTNAME."_admin_login_logo_url",
        "name" => __( 'Logo Link URL', MAX_SHORTNAME ),
        "desc" => __( 'By default the login screen logo goes to WordPress.org, enter a custom URL here to override it.', MAX_SHORTNAME ),
        "type" => "text",
        "std"  => home_url()
      );

      $options[]  = array(
        "id"        => MAX_SHORTNAME."_admin_login_background_color",
        "name"      => __('Body Background Color', MAX_SHORTNAME),
        "desc"      => __('Select your custom hex color.', MAX_SHORTNAME),
        "type"      => "colorpicker",
        "std"       => "#"
      );

      $options[] = array(
        "id"   => MAX_SHORTNAME."_admin_login_background_img",
        "name" => __( 'Background Image', MAX_SHORTNAME ),
        "desc" => __( 'Upload a custom background image for your admin login screen.', MAX_SHORTNAME ),
        "std"  => "",
        "type" => "upload"
      );

      $options[]  = array(
        "id"        => MAX_SHORTNAME."_admin_login_background_style",
        "name"      => __('Background Image Style', MAX_SHORTNAME),
        "desc"      => __('Select your preferred background style.', MAX_SHORTNAME),
        "type"      => "select",
        "options"   => array(
          'stretched' => __( 'Stretched',MAX_SHORTNAME ),
          'repeat'    => __( 'Repeat',MAX_SHORTNAME ),
          'fixed'     => __( 'Center Fixed',MAX_SHORTNAME )
        ),
        "std"       => "streched"
      );

      $options[]  = array(
        "id"        => MAX_SHORTNAME."_admin_login_form_background_color",
        "name"      => __('Form Background Color', MAX_SHORTNAME),
        "desc"      => __('Select your custom hex color.', MAX_SHORTNAME),
        "type"      => "colorpicker",
        "std"       => "#"
      );

      $options[] = array(
        "id"      => MAX_SHORTNAME."_admin_login_form_background_opacity",
        "name"    => __('Form Background Opacity', MAX_SHORTNAME),
        "desc"    => __('Select your opacity value for the login background color. This option only works, if a "Form Background Color" is set above.', MAX_SHORTNAME),
        "type"    => "slider",
        "step"    => .05,
        "max"     => 1,
        "min"     => 0,
        "std"     => 1
      );

      $options[]  = array(
        "id"        => MAX_SHORTNAME."_admin_login_form_text_color",
        "name"      => __('Form Text Color', MAX_SHORTNAME),
        "desc"      => __('Select your custom hex color for the text within the formular.', MAX_SHORTNAME),
        "type"      => "colorpicker",
        "std"       => "#"
      );

      $options[]   = array(
        "id"   => MAX_SHORTNAME."_admin_login_form_top",
        "name" => __( 'Form Top Margin', MAX_SHORTNAME ),
        "desc" => __( 'Enter a top margin for your login form in pixels.', MAX_SHORTNAME ),
        "type" => "text",
        "std"  => 150
      );

    $options[] = array( "type" => "close");

		/*-----------------------------------------------------------------------------------*/
		/*	Mobile Settings
		/*-----------------------------------------------------------------------------------*/
    $options[] = array(
      "name"    => "Mobile Settings",
      "id"      => "header_mobile",
      "type"    => "section"
    );
    $options[] = array( "type" => "open");

      $options[] = array(
        "name"    => __('Mobile Settings', MAX_SHORTNAME),
        "id"      => "subhead_mobile_settings",
        "type"    => "subhead",
        "desc"    => "These settings only affect the layout on mobile devices like tablets and smartphones."
      );

      $options[] = array(
        "name"    => __('Hide Welcome Teaser', MAX_SHORTNAME),
        "desc"    => __("Turn on if you want to show the welcome teaser on smaller mobile devices.", MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_mobile_show_welcome_teaser",
        "type"    => "checkbox",
        "std"     => "false"
      );

      $options[] = array(
        "name"    => __('Always show Footer', MAX_SHORTNAME),
        "desc"    => __("Turn on if you always want to show the footer on smaller mobile devices.", MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_mobile_show_footer",
        "type"    => "checkbox",
        "std"     => "false"
      );

      $options[] = array(
        "name"    => __('Show Footer Navigation', MAX_SHORTNAME),
        "desc"    => __("Turn on if you always want to show the footer navigation on smaller mobile devices.", MAX_SHORTNAME),
        "id"      => MAX_SHORTNAME."_mobile_show_footer_nav",
        "type"    => "checkbox",
        "std"     => "false"
      );


    $options[] = array( "type" => "close");

		// update the option template
		update_option('max_template', $options);

	}

}

add_action('init','max_options');

?>