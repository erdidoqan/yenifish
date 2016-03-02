<?php

/*-----------------------------------------------------------------------------------*/

/* = Custom function for query term posts
/*-----------------------------------------------------------------------------------*/

if (!function_exists('max_query_term_posts')):
    function max_query_term_posts($showposts = PER_PAGE_DEFAULT, $id_array, $type = 'gallery', $random = false, $taxonomy = GALLERY_TAXONOMY, $sorting = false, $filter_current = false) {

        global $post, $max_random_posts_query;

        $rand = !$random ? "" : $random;
        $sort = !$sorting ? "" : $sorting;

        $posts_to_query = get_objects_in_term($id_array, $taxonomy);

        if ($filter_current === true) {
            $_array_diff = array(0 => $post->ID);
            $posts_to_query = array_diff($posts_to_query, $_array_diff);
        }

        $seed = date('Ymdhi');

        // Use date('Ymdh') to get an hourly change
        $max_random_posts_query = " ORDER BY rand($seed) ";

        // set the query args
        $defaults = array('ignore_sticky_posts' => 1, 'showposts' => $showposts, 'post_type' => $type, 'post__in' => $posts_to_query, 'orderby' => $rand, 'order' => $sort);

        // query the posts
        $queried_posts = query_posts($defaults);

        $max_random_posts_query = '';

        return $queried_posts;
    }
endif;

/*-----------------------------------------------------------------------------------*/

/*	function to retrieve consistent random set of posts with pagination
/*-----------------------------------------------------------------------------------*/
function max_random_posts_query($query) {

    global $max_random_posts_query;

    if ($max_random_posts_query && strpos($query, 'ORDER BY RAND()') !== false) {
        $query = str_replace('ORDER BY RAND()', $max_random_posts_query, $query);
    }

    return $query;
}
add_filter('query', 'max_random_posts_query');

/*-----------------------------------------------------------------------------------*/

/* = set category to start with 0 key to prevent error warning when keys starting with 1
/*-----------------------------------------------------------------------------------*/

if (!function_exists('max_set_term_order')):

    function max_set_term_order($terms) {

        if (is_array($terms) && !empty($terms)):

            for ($a = 0; $a < 1000; ++$a) {
                $i = 0;
                $temp_cats = array();

                foreach (@$terms as $value) {
                    $temp_cats[$i] = $value;
                    $i++;
                }

                $terms = $temp_cats;
            }

            return $terms;
        endif;

        return false;
    }
endif;

/*-----------------------------------------------------------------------------------*/

/* = Get a image url from post id
/*-----------------------------------------------------------------------------------*/

function max_get_post_image_url($id, $size = 'full') {
    return wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
}

if (!function_exists('max_get_image_path')):
    function max_get_image_path($post_id = null, $size = 'full') {
        if ($post_id == null) {
            global $post;
            $post_id = $post->ID;
        }
        $theImageSrc = max_get_post_image_url($post_id, $size);

        global $blog_id;

        if (isset($blog_id) && $blog_id > 0) {
            $imageParts = explode('/files/', $theImageSrc[0]);
            if (isset($imageParts[1])) {
                $theImageSrc[0] = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
            }
        }

        return $theImageSrc[0];
    }
endif;

/*-----------------------------------------------------------------------------------*/

/* = New function wether to get the timbthumb image url or the standard url
/*-----------------------------------------------------------------------------------*/

function max_get_custom_image_url($imgID = null, $postID = null, $width = false, $height = false, $cropping = false, $greyscale = false, $isSlider = false, $url = false, $retina = false) {

    global $blog_id;

    // check to wether to choose timthumb or not
    $use_timthumb = get_option_max('image_use_timthumb');

    if ($isSlider) {
        $tmp_img = wp_get_attachment_image_src($imgID, 'full');
        $img_src = $tmp_img[0];
    } else {
        $img_src = max_get_image_path($postID, 'full');
    }

    // get the right path for multisite installation
    if (isset($blog_id) && $blog_id > 0) {
        $imageParts = explode('/files/', $img_src);
        if (isset($imageParts[1])) {
            $img_src = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }

    if (!empty($use_timthumb) && $use_timthumb == 'true'):
        $imgUrl = get_template_directory_uri() . '/timthumb.php?src=' . $img_src . '&amp;h=' . $height . '&amp;w=' . $width . '&amp;a=' . $cropping . '&amp;q=100';
    else:
        $imgUrl = theme_thumb($img_src, $width, $height, $cropping, $retina);
    endif;

    return $imgUrl;
}

/*-----------------------------------------------------------------------------------*/

/* = New function to get a dummy image if no post image is set
/*-----------------------------------------------------------------------------------*/

function max_get_dummy_image($link = false) {

    global $post;

    $output = "";

    if ($link) $output.= '<a href="' . get_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '">';
    $output.= '<img src="' . get_template_directory_uri() . '/images/dummy-image.jpg" alt="' . __('No featured image specified', MAX_SHORTNAME) . '">';
    if ($link) $output.= '</a>';

    return $output;
}

/*-----------------------------------------------------------------------------------*/

/* = New function wether to choose the timthumb script or the standard cropping
/*-----------------------------------------------------------------------------------*/

function max_get_post_custom_image($imgID, $p_id = false, $return = false, $img_size = 'full') {

    // get the image
    $output = max_get_timthumb_image($return, $p_id, $img_size);

    // return the created image
    if ($return === true) {
        return $output;
    } else {
        echo $output;
    }
}

/*-----------------------------------------------------------------------------------*/

/* = Check for a mobile device
/*-----------------------------------------------------------------------------------*/

function max_get_image_string() {

    global $is_retina;

    // get the image we need for the different devices
    $max_mobile_detect = new Mobile_Detect();
    $_img_string = 'full';

    if ( $max_mobile_detect->isMobile() ) {

        // its a mobile device
        $_img_string = $is_retina ? 'large' : 'mobile';
    }

    if ( $max_mobile_detect->isTablet() ) {

        // its a tablet
        $_img_string = $is_retina ? 'full' : 'tablet';
    }

    if ( $is_retina && !$max_mobile_detect->isTablet() && !$max_mobile_detect->isMobile() ) {
        $_img_string = 'large';
    }

    return $_img_string;
}

/*-----------------------------------------------------------------------------------*/

/* = New function to calculate the image dimensions
/*-----------------------------------------------------------------------------------*/

function max_calculate_image($dimensions, $url) {

    $return = array();

    // We have a height but no width
    if (!isset($dimensions['width']) && isset($dimensions['height']) && $url[2] != 0) {

        // calculate the width depending on its height if the height is set
        $perc_height = $dimensions['height'] * 100 / $url[2];
        $calc_Width = floor($url[1] * ($perc_height / 100));

        $result['width'] = $calc_Width;
        $result['imgWidth'] = ' width="' . $calc_Width . '"';
    } elseif (isset($dimensions['width'])) {

        // the width is set by a template or users input, so use it
        $result['width'] = $dimensions['width'];
        $result['imgWidth'] = ' width="' . $dimensions['width'] . '"';
    } else {

        // there is no image width, so leave it blank
        $result['width'] = "";
        $result['imgWidth'] = '';
    }

    // We have a width but no height
    if (!isset($dimensions['height']) && isset($dimensions['width']) && $url[1] != 0) {

        // calculate the height depending on its height if the height is set
        $perc_width = $dimensions['width'] * 100 / $url[1];
        $calc_height = floor($url[2] * ($perc_width / 100));

        $result['height'] = $calc_height;
        $result['imgHeight'] = ' height="' . $calc_height . '"';
    } elseif (isset($dimensions['height'])) {

        // the height is set by a template or users input, so use it
        $result['height'] = $dimensions['height'];
        $result['imgHeight'] = ' height="' . $dimensions['height'] . '"';
    } else {

        // there is no image height, so leave it blank
        $result['height'] = "";
        $result['imgHeight'] = '';
    }

    return $result;
}

/*-----------------------------------------------------------------------------------*/

/* = Get a Post Image depending on Options set in Options Panel
/*-----------------------------------------------------------------------------------*/
function max_get_timthumb_image($return = false, $p_id = false, $img_size = 'full') {

    global $post, $imgDimensions, $imgDimensions1x, $p_tpl, $resize_images, $is_retina;

    $max_mobile_detect = new Mobile_Detect();

    // get the sting we need for the different devices
    $size = $img_size;

    // set the attachment image size
    $post_id = !$p_id ? $post->ID : $p_id;

    // check if its a lightbox or a project page link
    $photo_item_type = get_post_meta($post_id, MAX_SHORTNAME . '_photo_item_type_value', true);

    // get the item type
    $imgUrl = max_get_post_image_url($post_id, $size);

    // Get the post image url
    $tpl_show_lightbox = get_post_meta(get_query_var('page_id'), MAX_SHORTNAME . '_disable_post_lightbox', true);

    // check to show the lightbox on this page template
    $use_timthumb   = get_option_max('image_use_timthumb');
    $pretty_rel     = get_option_max('pretty_enable_lightbox', 'false') == 'false' ? ' data-rel="prettyPhoto"' : '';
    $pretty_rel_gal = get_option_max('pretty_enable_lightbox', 'false') == 'false' ? ' data-rel="prettyPhoto[gal]"' : '';

    // calculate the image dimensions
    if (($max_mobile_detect->isMobile() && !$max_mobile_detect->isTablet()) && !empty($imgDimensions1x) && is_array($imgDimensions1x)) {

        // its a mobile phone device so we need other images to display properly
        $_dimensions = max_calculate_image($imgDimensions1x, $imgUrl);
    } else {
        $_dimensions = max_calculate_image($imgDimensions, $imgUrl);

        // desktop images are larger

    }

    // Build the image link
    if (has_post_thumbnail($post_id)) {

        // Get Image URL
        $imgSrc = max_get_image_path($post_id);
        $imgFull = max_get_post_image_url($post_id);

        // get the title
        $title = !get_the_excerpt() ? '' : ' title="' . strip_tags(htmlspecialchars(get_the_excerpt())) . '"';
        $alt = ' alt="' . strip_tags(get_the_title()) . '"';

        $cat_list = array();

        foreach (get_the_category() as $category) {
            $cat_list[] = $category->cat_ID;
        }

        $output = "";

        // check if we have to show a link or links are disabled
        if ($photo_item_type != "Disable Link" && $photo_item_type != 'disable_link'):

            // check if option to show lightbox on this page template is enabled
            if (empty($tpl_show_lightbox) || $tpl_show_lightbox == 'false'):

                if ($photo_item_type == "Lightbox" || $photo_item_type == 'lightbox' || $p_tpl == "template-lightbox.php" || get_option_max('image_always_lightbox') == 'true') {

                    $lightbox_type = get_post_meta($post_id, MAX_SHORTNAME . '_photo_lightbox_type_value', true);
                    $lightbox_link = get_post_meta($post_id, MAX_SHORTNAME . '_photo_item_custom_lightbox', true);

                    if ($p_tpl == "template-lightbox.php") {

                        // check for youtube or vimeo id
                        if ($photo_item_type == 'youtube_embed') {
                            $output.= '<a href="http://www.youtube.com/watch?v=' . get_post_meta($post_id, MAX_SHORTNAME . '_video_embeded_url_value', true) . '"' . $pretty_rel_gal . ' data-link="' . get_permalink($post_id) . '"' . $title . '>';
                        } else if ($photo_item_type == 'vimeo_embed') {
                            $output.= '<a href="http://www.vimeo.com/' . get_post_meta($post_id, MAX_SHORTNAME . '_video_embeded_url_value', true) . '"' . $pretty_rel_gal . ' data-link="' . get_permalink($post_id) . '"' . $title . '>';
                        } else if ($photo_item_type == 'selfhosted_embed' || $photo_item_type == 'selfhosted') {
                            $output.= '<a href="' . get_post_meta($post_id, MAX_SHORTNAME . '_video_url_m4v_value', true) . '?iframe=true" ' . $pretty_rel_gal . ' data-link="' . get_permalink($post_id) . '"' . $title . '>';

                            // check for lightbox videos


                        } else if ($photo_item_type == 'lightbox' && $lightbox_type == 'vimeo') {
                            $output.= '<a href="' . get_post_meta($post_id, MAX_SHORTNAME . '_photo_video_vimeo_value', true) . '"' . $pretty_rel . $title . ' data-link="' . get_permalink($post_id) . '">';
                        } else if ($photo_item_type == 'lightbox' && $lightbox_type == 'youtube') {
                            $output.= '<a href="' . get_post_meta($post_id, MAX_SHORTNAME . '_photo_video_youtube_value', true) . '"' . $pretty_rel . $title . ' data-link="' . get_permalink($post_id) . '">';

                            // by default get the featured image


                        } else {
                            $output.= '<a href="' . $imgFull[0] . '"' . $pretty_rel_gal . ' data-link="' . get_permalink($post_id) . '"' . $title . '>';
                        }
                    } else {

                        // Display Lightbox custom link
                        if (!empty($lightbox_link) && $lightbox_type == 'custom') {
                            $output.= '<a href="' . $lightbox_link . '?iframe=true&amp;width=800&amp;height=600" ' . $pretty_rel . ' data-link="' . get_permalink($post_id) . '"' . $title . '>';
                        }

                        // Display Lightbox Photo
                        if ($lightbox_type == "Photo" || $lightbox_type == "photo") {
                            $output.= '<a href="' . $imgFull[0] . '"' . $pretty_rel_gal . ' data-link="' . get_permalink($post_id) . '"' . $title . '>';
                        }

                        // Display Lightbox YouTube Video
                        if ($lightbox_type == "YouTube-Video" || $lightbox_type == "youtube") {
                            $output.= '<a href="' . get_post_meta($post_id, MAX_SHORTNAME . '_photo_video_youtube_value', true) . '"' . $pretty_rel . $title . ' data-link="' . get_permalink($post_id) . '">';
                        }

                        // Display Lightbox Vimeo Video
                        if ($lightbox_type == "Vimeo-Video" || $lightbox_type == "vimeo") {
                            $output.= '<a href="' . get_post_meta($post_id, MAX_SHORTNAME . '_photo_video_vimeo_value', true) . '"' . $pretty_rel . $title . ' data-link="' . get_permalink($post_id) . '">';
                        }
                    }
                } else if ($photo_item_type == "Project Page" || $photo_item_type == 'projectpage' || $photo_item_type == 'selfhosted_embed' || $photo_item_type == 'selfhosted' || $photo_item_type == 'youtube_embed' || $photo_item_type == 'vimeo_embed') {

                    // Photo Type is a Project Page
                    $output.= '<a href="' . get_permalink($post_id) . '"' . $title . '>';
                } else if ($photo_item_type == "External Link" || $photo_item_type == 'external') {

                    $target = get_post_meta($post_id, MAX_SHORTNAME . '_external_link_target_value', true);
                    $str_target = isset($target) && $target != "" ? $target : "_blank";

                    // Photo Type is an external Link
                    $output.= '<a href="' . get_post_meta($post_id, MAX_SHORTNAME . '_photo_external_link_value', true) . '" target="' . get_post_meta($post_id, MAX_SHORTNAME . '_external_link_target_value', true) . '"' . $title . '">';
                } else {

                    // Get the image link
                    $output.= '<a href="' . $imgFull[0] . '"' . $pretty_rel . $title . ' data-link="' . get_permalink($post_id) . '">';
                }
            endif;
        endif;

        // fallback to lightbox if something is wrong to not break the image link


    } else {

        if (empty($tpl_show_lightbox) || $tpl_show_lightbox == 'false'):

            // check if option to show lightbox on this page template is enabled
            // Get the image link
            $output.= '<a href="' . $imgFull[0] . '"' . $pretty_rel . $title . ' data-link="' . get_permalink($post_id) . '">';
        endif;
    }

    // get the new image width calculation if no height or width is set
    if ($_dimensions['height'] == 0) $_dimensions['height'] = "";
    if ($_dimensions['width'] == 0) $_dimensions['width'] = "";

    // resize the image if needed otherwise get the cropped WP version
    if ($resize_images === true):

        // change to retina image size
        if (!empty($is_retina) && true === $is_retina) {
            $_dimensions['height'] = $_dimensions['height'] * 2;
            $_dimensions['width'] = $_dimensions['width'] * 2;
        }

        $data1x_img = max_get_custom_image_url(get_post_thumbnail_id($post_id), false, $_dimensions['width'], $_dimensions['height'], get_cropping_direction(get_post_meta($post_id, MAX_SHORTNAME . '_photo_cropping_direction_value', true)), false, true);
    else:

        // lets get the cropped WP version

        // retina size array
        $size_array = array('mobile' => 'large', 'large' => 'full', 'tablet' => 'full', 'full' => 'full');

        // change to retina image size
        if (!empty($is_retina) && true === $is_retina) {
            $size = $size_array[$size];
        }

        $_wp_image = max_get_post_image_url($post_id, $size);
        $data1x_img = $_wp_image[0];
    endif;

    // get the image tag, it's always the same
    $output.= '<img src="' . $data1x_img . '" ' . $alt . ' data-src="' . $data1x_img . '" class="the-post-image" />';

    // Close Link if its not a disabled link
    if ($photo_item_type != "Disable Link" && $photo_item_type != 'disable_link') {

        if (empty($tpl_show_lightbox) || $tpl_show_lightbox == 'false'):

            // check if option to show lightbox on this page template is enabled
            $output.= '</a>';
        endif;
    }

    if ($return === true) {
        return $output;
    } else {
        echo $output;
    }
}

/*-----------------------------------------------------------------------------------*/

/* = Get a Post Image depending on Options set in Options Panel
/*-----------------------------------------------------------------------------------*/

if (!function_exists('max_get_slider_image')):

    function max_get_slider_image($_meta, $img_slug = 'full', $sort = 0, $return = false, $greyscale = false, $crop = false, $_height = 400) {

        // Get Image URL
        $theImageSrc = wp_get_attachment_image_src($_meta['imgID'], $img_slug);

        global $blog_id, $meta;

        $output = "";

        $cat_list = array();

        $imgWidth = '';
        $width = MAX_CONTENT_WIDTH;

        // get the new proportional image height
        if ($theImageSrc[1] >= MAX_CONTENT_WIDTH):
            $newHeight = $theImageSrc[2] * (MAX_CONTENT_WIDTH / $theImageSrc[1]);
        else:
            $newHeight = $theImageSrc[2];
        endif;
        $height = $_height === false ? $newHeight : $_height;

        if ($img_slug == 'slides-slider'):
            $width = $theImageSrc[1];
            $height = $theImageSrc[2];
        endif;

        foreach (get_the_category() as $category) {
            $cat_list[] = $category->cat_ID;
        }

        // check greyscale images
        $greyscale = $greyscale == "true" ? "&f=2" : "";

        // output the link and the image
        $_link = wp_get_attachment_url($_meta['imgID']);
        $_add = ' data-rel="prettyPhoto[gal-' . get_the_ID() . ']"';

        // check title
        $title = isset($_meta['showtitle']) && $_meta['showtitle'] == 'true' ? ' title="' . get_the_title() . '"' : $title = "";
        $_cropping = !empty($_meta['cropping']) ? $_meta['cropping'] : "c";

        $img_url = max_get_custom_image_url($_meta['imgID'], false, $width, $height, $_cropping, false, true);

        // check if lightbox should be shown
        if (@$meta[MAX_SHORTNAME . '_photo_lightbox'] != 'true') {
            $output.= '<a href="' . $_link . '" ' . $title . $_add . ' data-link="' . get_permalink() . '">';
        }

        $output.= '<img src="' . $img_url . '" alt="' . htmlspecialchars(get_the_excerpt()) . '"' . $imgWidth . ' />';

        // check if lightbox should be shown
        if (@$meta[MAX_SHORTNAME . '_photo_lightbox'] != 'true') {
            $output.= '</a>';
        }

        if ($return === true) {
            return $output;
        } else {
            echo $output;
        }
    }
endif;

/*-----------------------------------------------------------------------------------*/

/* = Get a Post Lightbox CSS Class
/*-----------------------------------------------------------------------------------*/

function max_get_post_lightbox_class() {

    global $post, $imgDimensions, $p_tpl;

    $link_type = get_post_meta($post->ID, MAX_SHORTNAME . '_photo_item_type_value', true);
    $lightbox_type = get_post_meta($post->ID, MAX_SHORTNAME . '_photo_lightbox_type_value', true);

    $class = "";
    $class2 = "";

    if ($p_tpl == "template-lightbox.php") {

        $class = "lightbox";
    } else {

        switch ($link_type) {
            case 'lightbox':
            case "Lightbox":

                $class = "lightbox";

                switch ($lightbox_type) {
                    case "Photo":
                    case "photo":
                        $class2 = " photo";
                        break;

                    case "YouTube-Video":
                    case "youtube":
                        $class2 = " youtube-video";
                        break;

                    case "Vimeo-Video":
                    case "vimeo":
                        $class2 = " vimeo-video";
                        break;

                    default:
                        $class2 = "";
                        break;
                }

                break;

            case 'projectpage':
            case 'Project Page':

                $class = "link";

                break;

            case 'external':
            case 'External Link':

                $class = "external";

                break;

            case 'selfhosted':
            case 'youtube_embed':
            case 'vimeo_embed':

                $class = "video";

                break;

            default:
                $class = "photo";
                break;
        }

        return $class . $class2;
    }
}

/*-----------------------------------------------------------------------------------*/

/* = Custom excerpt function
/*-----------------------------------------------------------------------------------*/

if (!function_exists('max_get_the_excerpt')):

    function max_get_the_excerpt($echo = false) {

        global $post;

        if ($post->post_excerpt != "") {
            if ($echo === true) {
                the_excerpt();
            } else {
                get_the_excerpt();
            }
        } else {
            return false;
        }

        return true;
    }
endif;

/*-----------------------------------------------------------------------------------*/

/* = Get all the meta fields for a page or post and store it in an array
/*-----------------------------------------------------------------------------------*/

if (!function_exists('max_get_cutom_meta_array')):

    function max_get_cutom_meta_array($id = 0) {

        //if we want to run this function on a page of our choosing them the next section is skipped.
        //if not it grabs the ID of the current page and uses it from now on.
        if ($id == 0):
            global $wp_query;
            $content_array = $wp_query->get_queried_object();
            @$id = $content_array->ID;
        endif;

        //knocks the first 3 elements off the array as they are WP entries and i dont want them.
        $first_array = @get_post_custom_keys($id);

        if (count($first_array)) {

            //first loop puts everything into an array, but its badly composed
            foreach ($first_array as $key => $value):
                $second_array[$value] = get_post_meta($id, $value, FALSE);

                //so the second loop puts the data into a associative array
                foreach ($second_array as $second_key => $second_value):
                    $result[$second_key] = $second_value[0];
                endforeach;
            endforeach;
        } else {
            return false;
        }

        //and returns the array.
        return $result;
    }
endif;

/*-----------------------------------------------------------------------------------*/

/* = Get custom prev and next links for custom taxonomy
/*-----------------------------------------------------------------------------------*/

if (!function_exists('max_get_custom_prev_next')):

    function max_get_custom_prev_next($term_ids, $order_by = 'date', $order = 'DESC', $post_type = "gallery", $taxonomy = GALLERY_TAXONOMY) {

        global $post;

        // query all other posts from the current post categories
        $_nav_posts = max_query_term_posts(9999, $term_ids, $post_type, $order_by, $taxonomy, $order);

        foreach ($_nav_posts as $_index => $_value) {
            $_id_array[] = $_value->ID;
        }

        // prepare some values
        $_search_id = $post->ID;
        $_first_id = current($_id_array);
        $_last_id = $_id_array[sizeof($_id_array) - 1];

        $_current_key = array_search($_search_id, $_id_array);
        $_current_value = $_id_array[$_current_key];

        $_prev_id = "";
        $_next_id = "";

        // get next post_id
        if ($_search_id != $_last_id) {
            $_next_id = $_current_key + 1;
            $_next_value = $_id_array[$_next_id];
        }

        // get prev post_id
        if ($_search_id != $_first_id && !empty($_prev_id)) {
            $_prev_id = $_current_key - 1;
            $_prev_value = $_id_array[$_prev_id];
        }

        $_return_values = array('prev_id' => @$_prev_value, 'next_id' => @$_next_value);

        return $_return_values;
    }
endif;
?>