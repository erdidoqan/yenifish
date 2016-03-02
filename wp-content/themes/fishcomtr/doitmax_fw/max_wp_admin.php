<?php
/*-----------------------------------------------------------------------------------*/
/*	Load needed JS for admin head
/*-----------------------------------------------------------------------------------*/
function max_admin_head() {

?>
			<script type="text/javascript" language="javascript">

				jQuery(document).ready(function(){

					// Race condition to make sure js files are loaded
					if (typeof AjaxUpload != 'function') {
						return ++counter < 6 && window.setTimeout(init, counter * 500);
					}

					//AJAX Upload
					jQuery('.image_upload_button').each(function(){

						var obj_clicked = jQuery(this);
						var obj_id = jQuery(this).attr('id');
						new AjaxUpload(obj_id, {
						  action: '<?php echo admin_url("admin-ajax.php"); ?>',
						  name: obj_id, // File upload name
						  data: { // Additional data to send
								action: 'max_ajax_post_action',
								type: 'upload',
								data: obj_id },
						  autoSubmit: true, // Submit file after selection
						  responseType: false,
						  onChange: function(file, extension){},
						  onSubmit: function(file, extension){
								obj_clicked.text('Uploading'); // change button text, when user selects file
								this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
								interval = window.setInterval(function(){
									var text = obj_clicked.text();
									if (text.length < 13){	obj_clicked.text(text + '.'); }
									else { obj_clicked.text('Uploading'); }
								}, 200);
						  },
						  onComplete: function(file, response) {

						  	window.clearInterval(interval);
							obj_clicked.text('Upload Image');
							this.enable(); // enable upload button

							// If there was an error
							if(response.search('Upload Error') > -1){
								var buildReturn = '<span class="upload-error">' + response + '</span>';
								jQuery(".upload-error").remove();
								obj_clicked.parent().after(buildReturn);
							}
							else{

								var buildReturn = '<img class="hide max-option-image" id="image_'+obj_id+'" src="'+response+'" alt="" />';

								jQuery(".upload-error").remove();
								jQuery("#image_" + obj_id).remove();
								obj_clicked.parent().after(buildReturn);
								jQuery('img#image_'+obj_id).fadeIn();
								obj_clicked.next('span').fadeIn();
								jQuery('#'+obj_clicked.attr('data-rel')).val(response);

							}
						  }
						});

					});

					//AJAX Remove (clear option value)
					jQuery('.image_reset_button').click(function(){

							var obj_clicked = jQuery(this);
							var obj_id = jQuery(this).attr('id');
							var theID = jQuery(this).attr('title');

							var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

							var data = {
								action: 'max_ajax_post_action',
								type: 'image_reset',
								data: theID
							};

							jQuery.post(ajax_url, data, function(response) {
								var image_to_remove = jQuery('#image_' + theID);
								var button_to_hide = jQuery('#reset_' + theID);
								image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
								button_to_hide.fadeOut();
								jQuery('#'+obj_clicked.attr('data-rel')).val('');
							});

							return false;

						});


					//AJAX Remove (clear option value)
					jQuery('.option-reset-button').click(function(){

							var obj_clicked = jQuery(this);
							var obj_id      = jQuery(this).attr('id');
							var theID       = jQuery(this).attr('title');

							var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

							var data = {
								action: 'max_ajax_post_action',
								type: 'reset',
								data: theID
							};

							var r = confirm("Do you really want to reset your options to default? All your custom theme settings are lost when click on 'OK'!");
							if ( r == true) {

								jQuery.post(ajax_url, data, function(response) {

									var success = jQuery('#max-popup-reset');
									var fail    = jQuery('#max-popup-fail');

									if ( response == 1 )
									{
										success.fadeIn();
										window.setTimeout(function(){
											location.reload();
										}, 1000);
									}
									else
									{
										fail.fadeIn();
										window.setTimeout(function(){
											fail.fadeOut();
										}, 5000);
									}

								});

							}

							return false;

						});


					//Update Message popup
					jQuery.fn.center = function () {
						this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2 + jQuery(window).scrollTop() + "px"}, 100);
						this.css({ left: "50%", marginLeft: - this.width() / 2 });
						return this;
					}

					//Save the form
					jQuery('#max-option-form').on('click', 'button.save-options', function(event){

						event.preventDefault();

						function newValues() {
						  var serializedValues = jQuery("#max-option-form").serialize();
						  return serializedValues;
						}

						jQuery(":checkbox, :radio").click(newValues);
						jQuery("select").change(newValues);
						jQuery('.ajax-loading').css({ visibility: 'visible', diplay: 'none' }).fadeIn();

						var serializedReturn = newValues();
						var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

						//var data = {data : serializedReturn};

						var data = {
							<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'maxframe'){ ?>
							type: 'options',
							<?php } ?>
							action: 'max_ajax_post_action',
							data: serializedReturn
						};

						jQuery.post(ajax_url, data, function(response) {

							var success = jQuery('#max-popup-save');
							var loading = jQuery('.ajax-loading');
								loading.fadeOut(250, function(){
									jQuery(this).css({ visibility: 'hidden', display: 'block' })
								});
							success.fadeIn();
							window.setTimeout(function(){ success.fadeOut() }, 2000);

						});

						return false;

					});

				});

			</script>
		<?php
		}

/*-----------------------------------------------------------------------------------*/
/* Migrate existing options
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'max_migrate_options' ) ) :

	function max_migrate_options() {

		global $wpdb, $max_options;

		if( is_admin() ) :

			$db_results = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."options WHERE option_name LIKE 'invictus_%'", OBJECT );

			$migrate_trigger = get_option( MAX_SHORTNAME.'_migrate_option_checker' );

			// Options are not translated to the new option set
			if( empty($migrate_trigger) || $migrate_trigger === false ) :

				$max_migrate_option_set = array();

				foreach ( $db_results as $index => $option ) {

					if( $option->option_name == 'invictus_splash_logo_value' ) {
						$option->option_name = 'splash_logo';
					}

					if( $option->option_name == 'invictus_custom_logo_value' ) {
						$option->option_name = 'custom_logo';
					}

					if( $option->option_name == 'invictus_custom_footer_logo_value' ) {
						$option->option_name = 'custom_footer_logo';
					}

					if( $option->option_name == 'invictus_custom_favicon_value' ) {
						$option->option_name = 'custom_favicon';
					}

					$max_migrate_option_set[ $option->option_name ] = $option->option_value;

				}

				// lets migrate the options to the new max_options array
				update_option( MAX_SHORTNAME.'_migrate_option_checker', true );
				update_option( 'max_options', $max_migrate_option_set );

			endif;

		endif;

	}

endif;

add_action('admin_head', 'max_migrate_options', 10);

/*-----------------------------------------------------------------------------------*/
/* Load required javascripts for Options Page in admin head
/*-----------------------------------------------------------------------------------*/

function max_load_only() {

	add_action('admin_head', 'max_admin_head');

}

/*-----------------------------------------------------------------------------------*/
/* Generate the admin menu
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'max_admin_add_admin' ) ) :

	function max_admin_add_admin() {

		$max_page = add_menu_page( MAX_THEMENAME, MAX_THEMENAME, 'administrator', 'maxframe', 'max_theme_admin', MAX_FW_DIR."admin/images/menu_icon.png");

		add_action("admin_print_scripts-$max_page", 'max_load_only');
		add_action("admin_print_styles-$max_page",'max_load_only');

	  add_submenu_page( 'themes.php', __( 'Theme Support', MAX_SHORTNAME), __('Theme Support', MAX_SHORTNAME), 'update_core', 'max-theme-support', 'max_support_page_redirect');

		//add_submenu_page( basename(__FILE__), 'Invictus', 'Settings', 'manage_options', 'maxframe', 'max_theme_admin');
	}

endif;

add_action('admin_menu', 'max_admin_add_admin');

/*-----------------------------------------------------------------------------------*/
/* Redirect from Support link to Support board
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'max_support_page_redirect' ) ) :

  function max_support_page_redirect() { ?>
    <script type="text/javascript">
    //<![CDATA[
    window.location.replace("http://support.doitmax.de/forum");
    //]]>
    </script>
  <?php }

endif;

/*-----------------------------------------------------------------------------------*/
/* Ajax option save callback
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_ajax_max_ajax_post_action', 'max_ajax_callback' );
add_action( 'max_option_reset', 'max_option_setup' );

function max_ajax_callback() {

	global $wpdb, $social_array;

	$type_to_save = $_POST['type'];

	$max_saved_option = get_option( MAX_OPTION_SET );

	if ($type_to_save == 'reset')
	{
		// reset options like on theme activation
		do_action('max_option_reset');

        die('1'); //options reset

	} else {

		//Uploads
		if( $type_to_save == 'upload' ){

			$clicked_id = $_POST['data']; // Acts as the name
			$filename = $_FILES[ $clicked_id ];

			$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';
			$uploaded_file = wp_handle_upload($filename, $override);

			// store new value top the option array
			$max_saved_option[ $clicked_id ] = $uploaded_file['url'];


			if(!empty($uploaded_file['error'])) {
				echo 'Upload Error: ' . $uploaded_file['error'];
			} else {
				echo $uploaded_file['url'];
			} // Is the Response

		} elseif ($type_to_save == 'image_reset') {

			$id = $_POST['data']; // Acts as the name
			$max_saved_option[ $id ] = "";

		} elseif ($type_to_save == 'options') {

			$data = $_POST['data'];
			wp_parse_str( $data, $output );

			$options = get_option( 'max_template' );

			foreach ( $options as $value ) {

				$type = $value['type'];
				$id = $value['id'];
				$new_value = '';

				$nonsave_types = array('section', 'subhead', 'open', 'close', 'tab_nav', 'tab_open', 'tab_close');

				if( @!in_array($type, $nonsave_types) ){

					if( $type == 'socialinput' ){
						foreach($social_array as $s_index => $s_value){
							$max_saved_option[ MAX_SHORTNAME . '_social_' . $s_index ] = $output[ MAX_SHORTNAME . '_social_' . $s_index ];
						}
					}

					if( isset( $output[$id] ) ){
						$new_value = $output[$id];
					}

					if( $new_value == '' && $type == 'checkbox' ){ // Checkbox Save
						$new_value = 'false';
					}
					elseif ( $new_value == 'true' && $type == 'checkbox' ){ // Checkbox Save
						$new_value = 'true';
					}

					// store new value top the option array
					$max_saved_option[ $id ] = $new_value;

				}
			}

		}

		// update the new option set
		update_option( 'max_options' . MAX_OPTION_LANGUAGE, $max_saved_option );

		die();

	}

}

/*-----------------------------------------------------------------------------------*/
/*	Get Admin Options Scripts and CSS
/*-----------------------------------------------------------------------------------*/

add_action('admin_enqueue_scripts', 'max_admin_add_init');

function max_admin_add_init($hook) {

	if ( $hook == 'post.php' ||
		$hook == 'media-upload-popup' ||
		$hook == 'post-new.php' ||
		@$_REQUEST['page'] == 'max_options' ||
		@$_REQUEST['page'] == 'maxframe' ||
		@$_REQUEST['page'] == "photos_mass_posting"
	){

		wp_enqueue_style('functions', MAX_FW_DIR."admin/css/admin.css", false, "1.0", "all");
		wp_enqueue_style('checkbox', MAX_FW_DIR."admin/css/checkbox.css", false, "1.0", "all");
		wp_enqueue_style('thickbox');

		wp_deregister_script('jquery-ui');
		wp_register_script('jquery-ui', get_template_directory_uri() .'/js/jquery-ui.min.js', 'jquery', '1.10.3'); // register the local file
		wp_enqueue_script('jquery-ui');

		wp_enqueue_script('jquery-live-query', MAX_FW_DIR.'admin/js/jquery.livequery.min.js', array('jquery'), '1.0' );
		wp_enqueue_script('jquery-color-picker', MAX_FW_DIR.'admin/js/colorpicker.js', array('jquery'));
		wp_enqueue_script('jquery-checkbox', MAX_FW_DIR.'admin/js/jquery.iphone.checkbox.js', array('jquery'));
		wp_enqueue_script('jquery-ajaxupload',MAX_FW_DIR.'/admin/js/ajaxupload.js', array('jquery'));
		wp_enqueue_script('jquery-appendo', MAX_FW_DIR.'admin/js/jquery.appendo.js', false, '1.0', false);

		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');

		wp_enqueue_script('max_script', MAX_FW_DIR.'admin/js/scripts.js', array('jquery','jquery-ui', 'media-upload','thickbox'), '1.0' );

	}

	if ( $hook == 'edit.php') {
		wp_enqueue_style('admin-css', MAX_FW_DIR."/admin/css/admin.css", false, "1.0", "all");
	}

	// get script for mega menu in backend
	if( is_admin() && $hook == 'nav-menus.php' ) {
		wp_enqueue_media();

    	wp_register_script('max_megamenu', esc_url( get_template_directory_uri() ) . '/js/megamenu.js');
    	wp_enqueue_script('max_megamenu');
	}

	// get the wp-content folder
	$wp_content_dir = explode('/', WP_CONTENT_DIR);

	/* create localized JS array */
	$localized_array = array(
		'nonce'                 => wp_create_nonce( 'max_script_vars' ),
		'wp_content_dir'        => end($wp_content_dir),
		'wp_theme_dir'          => get_template_directory_uri(),
		'ajax'                  => admin_url( 'admin-ajax.php' ),
		'upload_text'           => __( 'Send to Gallery field', MAX_SHORTNAME),
		'remove_media_text'     => __( 'Remove Media', MAX_SHORTNAME ),
		'reset_agree'           => __( 'Are you sure you want to reset back to the defaults?', MAX_SHORTNAME ),
		'remove_no'             => __( 'You can\'t remove this! But you can edit the values.', MAX_SHORTNAME ),
		'remove_agree'          => __( 'Are you sure you want to remove this?', MAX_SHORTNAME ),
		'activate_layout_agree' => __( 'Are you sure you want to activate this layout?', MAX_SHORTNAME ),
		'setting_limit'         => __( 'Sorry, you can\'t have settings three levels deep.', MAX_SHORTNAME )
	);

	// write content folder to js to make it accessible via JS
	wp_localize_script( 'jquery', 'max_script_vars', $localized_array);

}

/*-----------------------------------------------------------------------------------*/
/* Add default options after activation
/*-----------------------------------------------------------------------------------*/

if ( is_admin() && isset($_GET['activated'] ) ) {

	$opt_str = MAX_SHORTNAME.'_theme_activation';

	$theme_activation = get_option( $opt_str );

	// set theme activation to true
	update_option( $opt_str , 'true' );

	add_action( 'admin_head', 'max_option_setup', 11 );

	header( 'Location: '.admin_url().'admin.php?page=maxframe' ) ;

}

function max_option_setup(){

	$saved_options = get_option( 'max_options' );

	update_option( 'max_themename', MAX_THEMENAME );
	update_option( 'max_shortname', MAX_SHORTNAME );

	if( empty($saved_options) ) :

		$max_array = array();
		$template = get_option( 'max_template' );
		$nonsave_types = array('section', 'subhead', 'open', 'close', 'tab_nav', 'tab_open', 'tab_close');

		foreach( $template as $option ) {

			if( @!in_array( $option['type'], $nonsave_types ) ){

				$id        = $option['id'];
				$std       = $option['std'];

				if( is_array( $option['type'] ) ) {

					foreach($option['type'] as $child){
						$c_id = $child['id'];
						$c_std = $child['std'];
						//update_option($c_id,$c_std);
						$max_array[ $c_id ] = $c_std;
					}

				} else {
					$max_array[ $id ] = $std;
				}

			}
		}

		update_option('max_options', $max_array);

	endif;

}

/*-----------------------------------------------------------------------------------*/
/*	Create the Admin options
/*-----------------------------------------------------------------------------------*/

  // sidebar option
  function max_get_option_sidebar($value){
		$std        = $value['std'];
		$option_key = $value['id'];
		$sidebars   = get_option_max( $option_key );

    ?>

		<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
  		<input class="max-input max_control_input" type="text" name="max_sidebar_add_<?php echo $value['type'] ?>" />
		</div>
		<p>
      <input type="button" class="button action" name="max_button_<?php echo $option_key ?>" value="<?php _e('Create Sidebar', MAX_SHORTNAME) ?>" />
		</p>

    <ul id="sb_list_<?php echo $option_key ?>" class="ui-sortable">
	  <?php
	  if( is_array($sidebars) ) : // we have some sidebars

	    foreach( $sidebars as $index => $sidebar ) : // loop through sidebars and display
        $sidebar = explode(',', $sidebar);
        // decode the json value from the sidebar array
        echo "<li id='sidebar_".$index."' class='ui-state-default'>".$sidebar[0]."<a href='#' class='remove'>Delete</a><input type='hidden' name='".$option_key."[".$index."]' value='".$sidebar[0].",".$sidebar[1]."' /></li>";
	    endforeach;

	  endif;
	  ?>
    </ul>

    <script type="text/javascript">
    	jQuery(document).ready(function($) {

        $ul = jQuery('#option_<?php echo $option_key; ?>'), // store the list

        // add the click event to the sidebar button
        jQuery('#option_<?php echo $option_key; ?>').on('click', 'input[name="max_button_<?php echo $option_key ?>"]', function(){

          var num = $ul.find('.ui-sortable li').length; // get the number of current sidebars

          $val = jQuery('input[name="max_sidebar_add_<?php echo $value['type'] ?>"]').val(); // store the value

          if($val != ""){

            $li = jQuery("<li id='sidebar_"+num+"' class='ui-state-default'><span></span>" + $val + "<a href='#' class='remove'>Delete</a>" + "<input type='hidden' name='<?php echo $option_key ?>["+num+"]' value='" + $val + "," +$val.toLowerCase().split(' ').join('-') +"' /></li>");

            jQuery('#sb_list_<?php echo $option_key ?>').append($li);

          }else{

            alert('<?php _e("Please add a sidebar name", MAX_SHORTNAME) ?>');

          }

          return false;
        })

        // add click event to the delete button of a certain sidebar list element
        $ul.on('click', 'a.remove', function(){

          jQuery(this).parent().stop(true).fadeOut(450, function(){
            jQuery(this).remove();
          });

          return false;

        });

        // add jQuery sortable
        $( "#sb_list_<?php echo $value['id'] ?>" ).sortable({ placeholder: "ui-state-hightlight" });

    	});
    </script>


		<?php
  }

  // subhead option
  function max_get_option_subhead($value){
  	?>
  	<div class="max-sub-header">
  		<h3><?php echo $value['name']; ?></h3>
  	</div>
  	<?php
  }

  // checkbox option
  function max_get_option_checkbox($value){

		$std        = $value['std'];
		$option_key = $value['id'];
		$saved      = get_option_max( $option_key );

		if( isset($saved) ){

			if( $saved == 'true' ){

				$checked = 'checked="checked"';

			}else{

				$checked = '';

			}

		} elseif ( $std == 'true' ) {

			$checked = 'checked="checked"';

		} else {

			$checked = '';

		}

		?>
		<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
			<input type="checkbox" class="max_control_<?php echo $value['type'] ?>" name="<?php echo $option_key; ?>" id="<?php echo $option_key; ?>" value="true" <?php echo $checked; ?> />
		</div>
		<?php
  }

  // multicheck option
  function max_get_option_multicheck($value){
		$std        = $value['std'];
		$option_key = $value['id'];
		$saved      = get_option_max( $option_key );

		?>
		<div class="max_style_<?php echo $value['type'] ?>">
			<ul class="cat-checklist gallery-categories-checklist">
			<?php
			foreach($value['options'] as $index => $option) {

				if(is_array($saved))
				{
					  if(in_array($index, $saved)){
						 $checked = 'checked="checked"';
					  }
					  else{
						  $checked = '';
					  }
				}
				elseif( @$std[$index] == "true" ) {
				   $checked = 'checked="checked"';
				}
				else {
					$checked = '';
				}
				?>
				<li>
				  <input type="checkbox" class="checkbox max_control_<?php echo $value['type'] ?>" name="<?php echo $option_key ?>[]" id="<?php echo $option_key ?>" value="<?php echo $index ?>" <?php echo $checked ?> />
				  <label for="<?php echo $option_key ?>[]"><?php echo $option ?></label>
				</li>
				<?php
			}
			?>
			</ul>
		</div>
		<?php
  }

  // text option
  function max_get_option_text($value){
	$std        = $value['std'];
	$option_key = $value['id'];
	$saved      = get_option_max( $option_key );
  	?>
  	<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
  		<input class="max_control_input" name="<?php echo $option_key; ?>" id="<?php echo $option_key; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( isset($saved) ) { echo stripslashes( $saved ); } else { echo $std; } ?>" <?php if(!empty($value['size'])) : ?>size="<?php echo $value['size']; ?>" <?php endif; ?> />
  	</div>
  	<?php
  }

  // textarea option
  function max_get_option_textarea($value){
	$std        = $value['std'];
	$option_key = $value['id'];
	$saved      = get_option_max( $option_key );
  	?>
  	<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
  		<textarea class="max_control_textarea" name="<?php echo $option_key; ?>" type="<?php echo $value['type']; ?>" cols="" rows="<?php echo $value['rows']; ?>"><?php if ( isset($saved) ) { echo stripslashes($saved); } else { echo $std; } ?></textarea>
  	</div>
  	<?php
  }

  // select option
  function max_get_option_select($value){
	$std        = $value['std'];
	$option_key = $value['id'];
	$saved      = get_option_max( $option_key );
  	?>
  	<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
  		<select class="max_control_select" name="<?php echo $option_key; ?>" id="<?php echo $option_key; ?>">
  		<?php foreach ( $value['options'] as $index => $option ) { ?>
  			<option value="<?php echo $index ?>" <?php if ( $saved == $index ) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
  		<?php } ?>
  		</select>
  	</div>
  	<?php
  }

  // slider option
  function max_get_option_slider($value){
	$std        = $value['std'];
	$option_key = $value['id'];
	$saved      = get_option_max( $option_key );

  	if(!$saved){
  		$saved = $std;
  	}

  	$show = $saved;
  	if(is_array($show)) $show = implode('-',$show);

  	?>
  	<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
  		<div style="width: 230px" id="<?php echo $option_key ?>_slider" class="ui-slider"></div>
  		<input type="text" id="<?php echo $option_key ?>_handle" class="slide-value ui-handle" value="<?php echo $show ?>">
  	</div>
  	<input type="hidden" name="<?php echo $option_key ?>" id="<?php echo $option_key ?>" value="<?php echo $show ?>" />
  	<script type="text/javascript">
  		jQuery("#<?php echo $option_key ?>_slider").slider({
  			<?php
  			if(!is_array($saved)) {
  				echo 'value: '.$saved.',';
  				echo 'range: "min",';
  			} else {
  				echo 'range: true,';
  				echo 'values: ['.implode(',',$saved).'],';
  			}
  			echo 'step:' .$value['step'].',';
  			echo 'max: '.$value['max'].',';
  			echo 'min: '.$value['min'].',';
  			if(!is_array($saved)) {
  				echo 'slide: function(e,ui) { jQuery("#'.$option_key.'_handle").val(ui.value); jQuery("#'.$option_key.'").val(ui.value); },';
  			} else {
  				echo 'slide: function(e,ui) { jQuery("#'.$option_key.'_handle").val(ui.values[0]+"-"+ui.values[1]); jQuery("#'.$option_key.'").val(ui.values[0]+"-"+ui.values[1]); },';
  			}
  			?>
  		});

  		jQuery( "#<?php echo $option_key ?>_handle" ).change(function() {
  			if( jQuery(this).val() > <?php echo $value['max'] ?> ){
  				var val = <?php echo $value['max'] ?>;
  				jQuery(this).val( val )
  				jQuery( "#<?php echo $option_key ?>" ).val( val );
  			}else{
  				var val = jQuery(this).val();
  				jQuery( "#<?php echo $option_key ?>" ).val( val );
  			}
  			jQuery("#<?php echo $option_key ?>_slider").slider( "value", val );
  		});

  	</script>
  	<?php
  }

  // colorpicker option
  function max_get_option_colorpicker($value){
	$std        = $value['std'];
	$option_key = $value['id'];
	$saved      = get_option_max( $option_key );

    ?>
    <script type="text/javascript">
    	jQuery(document).ready(function($) {

    		function colorPickerTrigger(val){
    			var add = "";
    			if(val.charAt(0) != '#') add = '#';

    			jQuery('#cp_<?php echo $value['id']; ?> div').css({'backgroundColor': add+val });
    			jQuery('#colorpicker_<?php echo $option_key; ?>').val(add+val);
    		}

    		$('#colorpicker_<?php echo $value['id']; ?>').ColorPicker({
    			onSubmit: function(hsb, hex, rgb, el) {
    				colorPickerTrigger(hex);
    				jQuery(el).ColorPickerHide();
    			},
    			onBeforeShow: function () {
    				$(this).ColorPickerSetColor(this.value);
    				return false;
    			},
    			onChange: function (hsb, hex, rgb) {
    				colorPickerTrigger(hex);
    			}
    		}).bind('keyup change', function(){
    			$(this).ColorPickerSetColor(this.value);
    			colorPickerTrigger(this.value);
    		});

    		$('#cp_<?php echo $option_key; ?>').next('input').change(function(){
    		   $('#cp_<?php echo $option_key; ?> div').css({'backgroundColor': $(this).val(), 'backgroundImage': 'none'});
    		})

    	});
    </script>

    <div id="cp_<?php echo $option_key; ?>" class="cp_box">
    <div class="color_display" style="background-color:<?php echo ( isset($saved) ? stripslashes($saved) : $std ) ?>;<?php if ( isset( $option_key ) ) { echo 'background-image:none;'; } ?>"></div>
    </div>
    <div class="max_style_holder max_style_<?php echo $value['type'] ?>">
    <input  maxlength="7" type="text" name="<?php echo $option_key; ?>" id="colorpicker_<?php echo $option_key; ?>" value=<?php if ( $saved != "") { echo stripslashes( $saved ); } else { echo $std; } ?> class="cp_input max_control_input" />
    </div>
    <?php
  }

  // radio option
  function max_get_option_radio($value){
		$std        = $value['std'];
		$option_key = $value['id'];
		$saved      = get_option_max( $option_key );
		?>
		<ul>
		<?php

		$i=0;

		foreach($value['options'] as $index => $option) {

			$checked = '';
				if($saved != '') {
					if ( $saved  == $index ) { $checked = ' checked'; }
				} else {
					if ( $std == $index) { $checked = ' checked'; }
			}

			?>
			<li>
			<input type="radio" class="radio overlay_pattern" name="<?php echo $option_key ?>" id="<?php echo $option_key."_".$index ?>" value="<?php echo $index ?>" <?php echo $checked ?> />
			<?php if ( $value['addtype'] != "" ){
			?>
			<img src="<?php echo MAX_FW_DIR ?>admin/images/overlay-<?php echo $index ?>.png" class="radio-overlay" width="20" height="20" />
			<?php
			}?>
			<label><?php echo $option ?></label>
			</li>
			<?php
			$i++;
		}
		?>
		</ul>
		<?php
  }

  // upload option
  function max_get_option_upload($value){
	$id              = $value['id'];
	$output          = '';
	$option_uploaded = get_option_max( $id );

  	if ( isset($option_uploaded) && $option_uploaded != "") {
  		$val = $option_uploaded;
  	}else{
  		$val = "";
  	}

  	$output .= '<div class="max_style_holder max_style_'.$value['type'].'">
  					<input class="max-input max_control_input" name="'. $value['id'] . '" id="'. $id .'_input" type="text" value="'. stripslashes($val) .'" />
  				</div>';

  	$output .= '<div class="clearfix upload_button_div">';
  	$output .= '<span class="button image_upload_button" id="'.$id.'" data-rel="'. $id .'_input">Upload Image</span>';

  	if(!empty($option_uploaded)) {$hide = '';} else { $hide = 'hide';}

  	$output .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '" data-rel="'. $id .'_input">Delete current</span>';
  	$output .='</div>' . "\n";

  	if(!empty($option_uploaded)){
  		$output .= '<a class="max-uploaded-image" href="'. $option_uploaded . '">';
  		$output .= '<img class="max-option-image" id="image_'.$id.'" src="'.$option_uploaded.'" alt="" />';
  		$output .= '</a>';
  		}

  	echo $output;
  }

  // social icon option
  function max_get_option_socialinput($value){
		$std        = $value['std'];
		$option_key = $value['id'];
		$saved      = get_option_max( $option_key );

		$i = 0;

		foreach($value['options'] as $index => $option) {

			if(is_array($saved))
			{
				  if(in_array($index, $saved)){
					 $checked = 'checked="checked"';
				  }
				  else{
					  $checked = '';
				  }
			}
			elseif(!empty($std[$i]) && $std[$i] == "true" ) {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';
			}
			?>
			<li class="clearfix">
				<div class="max_social_label">
					<input type="checkbox" class="checkbox" name="<?php echo $option_key ?>[]" id="<?php echo $option_key ?>" value="<?php echo $index ?>" <?php echo $checked ?> />
					<img src="<?php echo get_template_directory_uri() ?>/images/social/<?php echo $index ?>.png" />
					<label><?php echo $option ?></label>
				</div>
				<div class="max_style_holder max_style_<?php echo $value['type'] ?>">
					<input class="socialurl max_control_input" name="<?php echo MAX_SHORTNAME ?>_social_<?php echo $index  ?>" id="invictus_social_<?php echo $index ?>" type="text" value="<?php echo stripslashes( get_option_max( 'social_'.$index  )  ); ?>" />
				</div>
			</li>
			<?php
			$i++;
		}
		?>
		</ul>
		<?php
  }

  // font option
  function max_get_option_font($value){

	$std        = $value['std'];
	$option_key = $value['id'];
	$_font_array      = get_option_max( $option_key );

  	// set font size & line height range
  	$_font_sizes = range( $value['min'], $value['max'] );
  	$_line_height = range(1,80);

  	// get values
	$_val_font_size   = $_font_array['font_size'];
	$_val_line_height = $_font_array['line_height'];
	$_val_font_family = $_font_array['font_family'];
	$_val_font_weight = $_font_array['font_weight'];
	$_val_font_color  = $_font_array['font_color'];

  	// standard values is an array
  	if(is_array($value['std'])){
  		$_std = $value['std'];
  	}

	if(!$_val_font_size || $_val_font_size     == "") $_val_font_size = $_std['font_size'];
	if(!$_val_line_height || $_val_line_height == "") $_val_line_height = $_std['line_height'];
	if(!$_val_font_family || $_val_font_family == "") $_val_font_family = $_std['font_family'];
	if(!$_val_font_weight || $_val_font_weight == "") $_val_font_weight = $_std['font_weight'];
	if(!$_val_font_color || $_val_font_color   == "") $_val_font_color = $_std['font_color'];

  	// font size select ?>
  	<div id="<?php echo $value['id'] ?>_holder">
  		<div class="max_style_holder max_style_select">
  			<select class="max_control_select max_control_font_size" name="<?php echo $value['id'] ?>[font_size]" id="<?php echo $value['id'] ?>_font_size">
  				<?php
  				foreach($_font_sizes as $_sizes){
  					$_checked = false;
  					if($_sizes == $_val_font_size){
  						$_checked = ' selected="selected"';
  					}
  				?>
  				<option value="<?php echo $_sizes ?>" <?php echo $_checked ?>><?php echo $_sizes ?>px</option>
  				<?php } ?>
  			</select>
  			<span class="font-desc"><?php _e('Font-Size', MAX_SHORTNAME) ?></span>
  		</div>

  		<?php // line height select ?>
  		<div class="max_style_holder max_style_select">
  			<select class="max_control_select max_control_line_height" name="<?php echo $value['id'] ?>[line_height]" id="<?php echo $value['id'] ?>_line_height">
  				<?php
  				foreach($_line_height as $_sizes){
  					$_checked = false;
  					if($_sizes == $_val_line_height){
  						$_checked = ' selected="selected"';
  					}
  				?>
  				<option value="<?php echo $_sizes ?>" <?php echo $_checked ?>><?php echo $_sizes ?>px</option>
  				<?php } ?>
  			</select>
  			<span class="font-desc"><?php _e('Line-Height', MAX_SHORTNAME) ?></span>
  		</div>

  		<?php // font family select ?>
  		<div class="max_style_holder max_style_select">
  			<select class="max_control_select max_control_font_family" name="<?php echo $value['id'] ?>[font_family]" id="<?php echo $value['id']; ?>_font_family">
  				<option value="<?php echo $_val_font_family ?>" selected="selected"><?php echo $_val_font_family ?></option>
  				<option value="off">None (Turn off the Font)</option>
  				<?php max_google_font_select() ?>
  			</select>
  			<span class="font-desc"><?php _e('Font-Family', MAX_SHORTNAME) ?></span>
  		</div>

  		<?php // font weight select ?>
  		<div class="max_style_holder max_style_select">
  			<select class="max_control_select max_control_font_weight" name="<?php echo $value['id'] ?>[font_weight]" id="<?php echo $value['id'] ?>_font_weight">
  				<option value="100" <?php if( $_val_font_weight == '100') echo ' selected="selected"'; ?>>Ultra Thin (not all fonts)</option>
  				<option value="200" <?php if( $_val_font_weight == '200') echo ' selected="selected"'; ?>>Thin (not all fonts)</option>
  				<option value="300" <?php if( $_val_font_weight == '300') echo ' selected="selected"'; ?>>Light (not all fonts)</option>
  				<option value="normal" <?php if( $_val_font_weight == 'normal') echo ' selected="selected"'; ?>>Normal</option>
  				<option value="italic" <?php if( $_val_font_weight == 'italic') echo ' selected="selected"'; ?>>Italic</option>
  				<option value="bold" <?php if( $_val_font_weight == 'bold') echo ' selected="selected"'; ?>>Bold</option>
  				<option value="bold_italic" <?php if( $_val_font_weight == 'bold_italic') echo ' selected="selected"'; ?>>Bold Italic</option>
  			</select>
  			<span class="font-desc"><?php _e('Font-Weight', MAX_SHORTNAME) ?></span>
  		</div>

  		<div class="max_style_holder max_style_colorpicker">
  			<?php // font color input ?>
  			<div id="cp_<?php echo $value['id']; ?>_font_color" class="cp_box">
  				<div class="color_display" style="background-color:<?php echo $_val_font_color ?>"></div>
  			</div>
  			<input  maxlength="7" type="text" name="<?php echo $value['id']; ?>[font_color]" id="colorpicker_<?php echo $value['id']; ?>_color" value="<?php echo $_val_font_color ?>" class="cp_input max_control_input max_control_font_color" />
  			<span class="font-desc"><?php _e('Color', MAX_SHORTNAME) ?></span>
  		</div>
  		<script type="text/javascript">
  			jQuery(document).ready(function($) {

  				function colorPickerTrigger(val){
  					var add = "";
  					if(val.charAt(0) != '#') add = '#';

  					jQuery('#cp_<?php echo $value['id']; ?>_font_color div').css({'backgroundColor': add+val });
  					jQuery('#colorpicker_<?php echo $value['id']; ?>_color').val(add+val);
  					jQuery('#<?php echo $value['id']; ?>_preview .font-preview-text').css({ color: add+val });
  				}

  				$('#colorpicker_<?php echo $value['id']; ?>_color').ColorPicker({
  					onSubmit: function(hsb, hex, rgb, el) {
  						colorPickerTrigger(hex);
  						jQuery(el).ColorPickerHide();
  					},
  					onBeforeShow: function () {
  						$(this).ColorPickerSetColor(this.value);
  						return false;
  					},
  					onChange: function (hsb, hex, rgb) {
  						colorPickerTrigger(hex);
  					}
  				}).bind('keyup change', function(){
  					$(this).ColorPickerSetColor(this.value);
  					colorPickerTrigger(this.value);
  				});

  				$('#cp_<?php echo $value['id']; ?>_font_color').next('input').change(function(){
  					$('#cp_<?php echo $value['id']; ?>_font_color div').css({'backgroundColor': $(this).val(), 'backgroundImage': 'none'});
  				})

  			});
  		</script>
  	</div>

  	<?php // the preview ?>

  	<div id="<?php echo $value['id']; ?>_preview" class="font-preview preview_<?php echo get_option_max('color_main') ?>">
  		<div class="font-preview-text">
  			The quick brown fox jumps over the lazy dog
  		</div>
  	</div>

  	<?php max_get_google_font( array( $_val_font_family ) ); ?>

  	<style>
  		#<?php echo $value['id']; ?>_preview {
  			color: <?php echo $_val_font_color ?>;
  			font-family: "<?php echo $_val_font_family ?>";
  			font-size: <?php echo $_val_font_size ?>px !important;
  			line-height: <?php echo $_val_line_height?>px !important;
  			<?php if( $_val_font_weight != 'bold_italic'){ ?>
  			font-weight: <?php echo $_val_font_weight ?> !important;
  			<?php }else{
  			$_new_font_weight = explode("_", $_val_font_weight);
  			?>
  			font-weight: <?php echo $_new_font_weight[0] ?>;
  			font-style: <?php echo $_new_font_weight[1] ?>;
  			<?php } ?>
  			padding: 13px;
  			margin: 13px 0;
  			position: relative;
  			height: auto;
  		}

  		#<?php echo $value['id']; ?>_preview .font_preview_text { height: auto; }
  	</style>

  	<script type="text/javascript">
  		jQuery(document).ready(function() {

  			jQuery('#<?php echo $value['id']; ?>_holder select').change(function(){

  				var font 		= jQuery('#<?php echo $value['id']; ?>_font_family').val();
  				var font_size 	= jQuery('#<?php echo $value['id']; ?>_font_size').val();
  				var line_height = jQuery('#<?php echo $value['id']; ?>_line_height').val();
  				var font_weight = jQuery('#<?php echo $value['id']; ?>_font_weight').val();
  				var font_color 	= jQuery('#<?php echo $value['id']; ?>_font_color').val();
  				var cont_<?php echo $value['id']; ?>_font_family = jQuery('#<?php echo $value['id']; ?>_preview .font-preview-text');

  				cont_<?php echo $value['id']; ?>_font_family
  					.prepend('<img src="<?php echo MAX_FW_DIR ?>admin/images/icons/loading.gif" />')
  					.load("<?php echo MAX_FW_DIR ?>max_font_previewer.php?id=<?php echo $value['id']; ?>&font="+escape(font)+"&font_size="+escape(font_size)+"&line_height="+escape(line_height)+"&font_weight="+escape(font_weight)+"&font_color="+escape(font_color))
  			})

  		})
  	</script>
  	<?php
  }

function max_theme_admin() {

    $options = get_option( 'max_template' );

	$i=0;

	// check for first launch or theme activation and show the welcome popup
	$theme_activation = get_option(MAX_SHORTNAME.'_theme_activation');
	$first_launch     = get_option(MAX_SHORTNAME.'_first_launch');

	if( $theme_activation == 'true' || ( $first_launch == 'false' || !$first_launch ) ){
		?>

		<script type="text/javascript">
		jQuery(document).ready(function($){

			tb_show('', '<?php echo MAX_FW_DIR ?>/includes/activation.inc.php?TB_iframe=true');
			$("#TB_window,#TB_overlay,#TB_HideSelect").one("unload",killTBUnload);

			function killTBUnload(e) {
				e.stopPropagation();
				e.stopImmediatePropagation();
				return false;
			}
		})
		</script>

		<?php

		// set options to false to not open the thickbox again
		update_option(MAX_SHORTNAME.'_theme_activation', 'false');
		update_option(MAX_SHORTNAME.'_first_launch', 'true');

	}
	?>

	<div id="maxFrame-wrapper">

		<div id="max-popup-save" class="max-save-popup">
			<div class="max-save-save">
			  <h3><?php _e('Options updated', MAX_SHORTNAME) ?></h3>
			  <p><?php _e('Your options were saved and are now used in the theme.', MAX_SHORTNAME) ?></p>
      		</div>
		</div>

		<div id="max-popup-reset" class="max-save-popup">
			<div class="max-save-reset">
			  <h3><?php _e('Options Resetted', MAX_SHORTNAME) ?></h3>
			  <p><?php _e('Your options were resetted to the default values.', MAX_SHORTNAME) ?></p>
			</div>
		</div>

		<div id="max-popup-fail" class="max-save-popup">
			<div class="max-save-fail">
			  <h3><?php _e('Option update failed', MAX_SHORTNAME) ?></h3>
			  <p><?php _e('Your options were not changed because of an error.', MAX_SHORTNAME) ?></p>
			</div>
		</div>

		<div id="maxFrame-admin" class="wrap">

		  <?php
      $theme  = wp_get_theme();
      $header = $theme->get( 'Name' ) . ' Theme Options'; //. sprintf( ' <small>v%s</small>', $theme->get( 'Version' ) );
      ?>

			<h2><?php echo $header ?></h2>

			<ul class="header-links">
				<li><a href="index.php?page=theme-update-notifier">Changelog</a></li>
				<li class="div">&nbsp;|&nbsp;</li>
				<li><a href="<?php echo MAX_LINK_SUPPORT ?>" title="Visit the help and support forum" target="_blank">Help &amp; Support Forum</a></li>
				<li class="div">&nbsp;|&nbsp;</li>
				<li class="icon facebook">
					<a href="http://www.facebook.com/pages/doitmax/120695808006003" title="Follow doitmax on Facebook" target="_blank">
						<span>Follow doitmax on Facebook and receive notifications about updates and new items.</span>
					</a>
				</li>
				<li class="icon twitter">
					<a href="http://www.twitter.com/doitmax" title="Follow doitmax on Twitter" target="_blank">
						<span>Follow doitmax on Twitter and receive notifications about updates and new items.</span>
					</a>
				</li>
				<li class="icon themeforest">
					<a href="http://themeforest.net/user/doitmax/follow" title="Visit doitmax's profile page on themeforest" target="_blank">
						<span>Visit doitmax's profile page on themeforest and receive notifications about updates and new items.</span>
					</a>
				</li>
			</ul>

				<form action="" enctype="multipart/form-data" id="max-option-form" method="post">

					<div class="clearfix info top-info">
						<button name="save" class="button-primary save-options">Save All Changes</button>
            <img src="<?php echo MAX_FW_DIR ?>admin/images/loading.gif" class="ajax-loading ajax-loading-bottom" alt="Saving..." />
				  </div>

          <div id="options_tabs" class="ui-tabs">

						<ul class="options_tabs ui-tabs-nav">

							<?php
							// loop through sections to create the navigation
							foreach ($options as $value) {
								switch ( $value['type'] ) {
									case "section":
										$i++;
									?>
									<li>
										<a href="#option_<?php echo $value['id']; ?>">
											<?php echo $value['name']; ?><span></span>
										</a>
									</li>
									<?php break;
								}
							}
							?>

						</ul>

            <div id="poststuff" class="metabox-holder">
              <div id="post-body">
                <div id="post-body-content">

    							<?php foreach ($options as $value) {

    								// check, if it is a grouped option
    								if( !isset($value['grouped']) || $value['grouped'] === false ){

    									if( $value['type'] != "open" && $value['type'] != "close" && $value['type'] != "section" && $value['type'] != "tab_open" && $value['type'] != "tab_close" && $value['type'] != "tab_nav"  ){
    									?>
    									<div id="option_<?php echo $value['id'] ?>" class="clearfix max-option max-<?php echo $value['type'] ?>">

    										<?php if( $value['name'] != '' ) { ?><h3><?php echo $value['name']; ?></h3><?php } // only show if a header was set ?>
    										<div class="section section_<?php echo $value['type'] ?>">
    											<div class="element">

    									<?php
    									}
    								}

    								switch ( $value['type'] ) {

    									// --> open the option section
    									case "open":

                      break;

                      case "tab_nav" :
                        $i = 0;
                      ?>
                        <h2 id="tabs_<?php echo $value['id'] ?>" class="nav-tab-wrapper">
                        <?php foreach ( $value['tabs'] as $id => $title ) {
                          // add active class to first tab
                          $add_class = $i == 0 ? " nav-tab-active" :"";
                        ?>
                        <a href="#<?php echo $id ?>" class="nav-tab<?php echo $add_class; ?>"><?php echo $title ?></a>
                        <?php
                          $i++;
                        }
                        ?>
                        </h2>
                      <?php
                      break;

                      case "tab_open": ?>
                        <div id="tab_<?php echo $value['id']; ?>" class="nav-pane<?php if( empty($value['display']) ) { ?> nav-pane-hide<?php } ?>">
                      <?php
                      break;

                      case "tab_close": ?>
                        </div>
                      <?php
                      break;

    									// --> create a subheadline
    									case "subhead":
    										//max_get_option_subhead($value);
    									break;

    									// --> close the option section
    									case "close":
    									?>
                      </div><!-- close .inside -->
    									</div><!-- close .postbox -->
    									<?php
    									break;

    									// --> Create a Sidebar Option
    									case "sidebar":
    									  max_get_option_sidebar($value);
    									break;

    									case 'slider':
    										max_get_option_slider($value);
    									break;

    									// --> Create a text input
    									case 'text':
    										max_get_option_text($value);
    									break;

    									// --> Create a textarea input
    									case 'textarea':
    										max_get_option_textarea($value);
    									break;

    									// --> Create a select input
    									case 'select':
    										max_get_option_select($value);
    									break;

    									// --> Create the font Select
    									case 'font':
    										max_get_option_font($value);
    									break;

    									// --> Create the Colorpicker
    									case "colorpicker" :
    									  max_get_option_colorpicker($value);
    									break;

    									// --> Create a checkbox
    									case "checkbox":
    									  max_get_option_checkbox($value);
    									break;

    									// --> Create a Multiplex input
    									case "multicheck":
    									  max_get_option_multicheck($value);
    									break;

    								  // --> Create a radio input
    									case "radio":
    									  max_get_option_radio($value);
    									break;

    									// --> Create an Upload input
    									case "upload":
    									  max_get_option_upload($value);
    									break;

    									// --> Create a Checkbox
    									case "socialinput":
    									  max_get_option_socialinput($value);
    									break;

    									// --> Create the option section
    									case "section":
    										$i++;
    									?>

    									<div id="option_<?php echo $value['id']; ?>" class="postbox ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
    									  <div class="inside">
    								  <?php break;

    								// End switch
    								}

    								// check, if it is a grouped option
    								if( !isset($value['group-close']) || $value['group-close'] === false ){
    									if($value['type'] != "open" && $value['type'] != "close" && $value['type'] != "section" && $value['type'] != "tab_open" && $value['type'] != "tab_close" && $value['type'] != "tab_nav"  ){
    									?>
    									</div>
    									</div>
    									<?php
    									}
    								}

    								// Description of each option
    								if(isset($value['desc']) && $value['desc'] != ""){
    								?>
    								<div class="description"><div class="max_description inner"><?php echo $value['desc']; ?></div></div>
    								<?php } ?>

    								<?php
    								// check, if it is a grouped option
    								if( !isset($value['group-close']) || $value['group-close'] === false ){
    									if( $value['type'] != "open" && $value['type'] != "close" && $value['type'] != "section" && $value['type'] != "tab_open" && $value['type'] != "tab_close" && $value['type'] != "tab_nav" ){
    									?>
    									</div>
    									<?php
    									}
    								}

    							// End foreach
    							}?>
    						</div>
              </div>
            </div>
            <div class="clear"></div>
          </div>

					<div class="info bottom">
						<input name="reset" type="submit" value="Reset" class="button-secondary reset option-reset-button" />
						<button name="save" class="button-primary save-options">Save All Changes</button>
						<img src="<?php echo MAX_FW_DIR ?>admin/images/loading.gif" class="ajax-loading ajax-loading-bottom" alt="Saving..." />
						<input type="hidden" name="action" value="save" />
					</div>
				</form>

		</div>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/*	Adds a hidden input field to control label of "Insert into post" button.
/*-----------------------------------------------------------------------------------*/

add_filter( 'media_upload_tabs', 'add_media_label_header');

function add_media_label_header($_default_tabs){

  if(!empty($_GET['max_label'])) echo("<input class='max_button_label' type='hidden' value='".html_entity_decode($_GET['max_label'])."' />");
	if(!empty($_GET['max_input'])) echo("<input class='max_saved_input' type='hidden' value='".html_entity_decode($_GET['max_input'])."' />");

	return $_default_tabs;
}

/*-----------------------------------------------------------------------------------*/
/*	Gets an attachment image (id based) and returns the image url to the javascript.
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_max_get_ajax_attachment', 'max_get_ajax_attachment');

if(!function_exists('max_get_ajax_attachment')){

	function max_get_ajax_attachment()
	{
		$attach_id = (int) $_POST['attachment_id'];

		$attachment = get_post($attach_id);
		$mime_type = $attachment->post_mime_type;

		if (substr($mime_type, 0, 5) == 'video'){
			$output = $attachment->guid;
		}else{
			$output = wp_get_attachment_image($attach_id, "mobile");
		}
		die($output);
	}

}

/*-----------------------------------------------------------------------------------*/
/*	Adds an Admin menu separator
/*-----------------------------------------------------------------------------------*/

function add_admin_menu_separator($position) {
  global $menu;
  $index = 0;
  foreach($menu as $offset => $section) {
    if (substr($section[2],0,9)=='separator')
      $index++;
    if ($offset>=$position) {
      $menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
      break;
    }
  }
}

/*-----------------------------------------------------------------------------------*/
/*	Define new table columns
/*-----------------------------------------------------------------------------------*/

function gallery_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"img_preview" => "Preview",
		"title" => "Image Title",
		"description" => "Description",
		"posted" => "Date added",
		"gallery-cat" => "Galleries",
		"menu_order" => "Menu Order"
	);
	return $columns;
}

/*-----------------------------------------------------------------------------------*/
/*	Create the new table columns
/*-----------------------------------------------------------------------------------*/

function gallery_custom_columns($column){
	global $post;
	switch ($column) {
		case "img_preview":

			// get the post image
      $imgUrl = max_get_image_path($post->ID, 'thumbnail');

			echo '<img src="'.$imgUrl.'" height="60"  alt="'.get_the_title().'" />';
		break;
		case "description":
			the_excerpt();
		break;
		case "posted":
			echo get_the_date();
		break;
		case "gallery-cat":
			echo get_the_term_list($post->ID, GALLERY_TAXONOMY, '', ', ','');
		break;
		case 'menu_order':
			$order = $post->menu_order;
			echo $order;
		break;
	}
}

add_action("manage_posts_custom_column",  "gallery_custom_columns");
add_filter("manage_edit-gallery_columns", "gallery_edit_columns");

/*-----------------------------------------------------------------------------------*/
/*	Custom Login Logo Support
/*-----------------------------------------------------------------------------------*/

/**
 * Redesign the default WP login screen
 *
 * @package WordPress
 * @subpackage Invictus
 * @since Invictus 3.3
 */

// Hex to RGBA converter
if ( !function_exists( 'max_hex2rgba' ) ) :

	function max_hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if(empty($color)) return $default;

		//Sanitize $color if "#" is provided
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}
			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}

			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}

			//Return rgb(a) color string
			return $output;

	}  // End function

endif;  // End function_exists check


// Custom login design
if ( !function_exists( 'max_login_design' ) ) :

	function max_login_design() {

		// Custom login is disabled so lets bail
		if ( !get_option_max( 'custom_login_logo', 'true' ) || get_option_max( 'custom_login_logo' ) === 'false' ) return;

		$output = '';

		// Logo Vars
		$logo        = get_option_max( 'admin_login_logo', 'url' );
		$logo        = esc_url( $logo );
		$logo_height = get_option_max( 'admin_login_logo_height', '50' );
		$logo_height = intval( $logo_height );

		// Main BG Vars
		$bg_color = get_option_max( 'admin_login_background_color' );
		$bg_img   = get_option_max( 'admin_login_background_img', 'url' );
		$bg_img   = esc_url( $bg_img );
		$bg_style = get_option_max( 'admin_login_background_style', 'stretched' );

		// Form Vars
		$form_bg_color      = get_option_max( 'admin_login_form_background_color' );
		$form_bg_opacity    = get_option_max( 'admin_login_form_background_opacity', '0.7' );
		$form_bg_color_rgba = max_hex2rgba( $form_bg_color, $form_bg_opacity );
		$form_text_color    = get_option_max( 'admin_login_form_text_color' );
		$form_top           = get_option_max( 'admin_login_form_top', '150' );
		$form_top           = intval( $form_top );

		// Output Styles
		$output .= '<style type="text/css">';
			// Logo
			if ( $logo ) {
				$output .='body.login div#login h1 a {';
					$output .='background: url("'. $logo .'") center center no-repeat;';
					$output .='height: '. $logo_height .'px;';
					$output .='width: 100%;';
					$output .='display: block;';
					$output .='margin: 0 auto 30px;';
				$output .='}';
			}

			// Background image
			if ( $bg_img ) {
				if ( 'stretched' == $bg_style ) {
					$output .= 'body.login { background: url('. $bg_img .') no-repeat center center fixed; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; }';
				}
				if ( 'repeat' == $bg_style ) {
					$output .= 'body.login { background: url('. $bg_img .') repeat; }';
				}
				if ( 'fixed' == $bg_style ) {
					$output .= 'body.login { background: url('. $bg_img .') center top fixed no-repeat; }';
				}
			}

			// Background color
			if ( $bg_color ) {
				$output .='body.login { background-color: '. $bg_color .'; }';
			}

			// Form Background Color
			if ( $form_bg_color ) {
				$output .='.login form { background: none; -webkit-box-shadow: none; box-shadow: none; padding: 0 0 20px; } #backtoblog { display: none; } .login #nav { text-align: center; }';
				if ( $form_text_color ) {
					$output .='.login label, .login #nav a, .login #backtoblog a, .login #nav { color: '. $form_text_color .'; }';

				}
				$output .='body.login div#login { background: '. $form_bg_color .'; background: '. $form_bg_color_rgba .';height:auto;left:50%;margin: 0 0 0 -200px;padding:40px;position:absolute;top:'. $form_top .'px;width:320px; max-width:90%; border-radius: 5px; }';
			}


		$output .='</style>';

		echo $output;

	} // End function

endif; // End function_exists check

add_action( 'login_enqueue_scripts', 'max_login_design' );


// Custom Login Logo URL
if ( !function_exists( 'max_login_logo_url' ) ) :

	function max_login_logo_url( $url ) {

		if ( get_option_max( 'admin_login_logo_url' ) ){
			return esc_url( get_option_max( 'admin_login_logo_url' ) );
		} else {
			return $url;
		}

	} // End function

	add_filter( 'login_headerurl', 'max_login_logo_url' );

endif;  // End function_exists check


  /**
   * Fake and dirty shortcode for stupid media uploader
   *
   * @since MaxFrame 1.0
   *
   * @return void
   */

  if( ! function_exists( 'max_media_view_settings' ) ) :

    function max_media_view_settings($settings, $post ) {

      if (!is_object($post)) return $settings;

      $shortcode    = '[gallery ';
      $ids          = get_post_meta($post->ID, MAX_SHORTNAME.'_post_gallery', TRUE);
      $ids          = explode(",", $ids);

      if (is_array($ids))
          $shortcode .= 'ids = "' . implode(',',$ids) . '"]';
      else
          $shortcode .= "id = \"{$post->ID}\"]";
      $settings['neviagallery'] = array('shortcode' => $shortcode);
      return $settings;

    }

  endif;

  add_filter( 'media_view_settings','max_media_view_settings', 10, 2 );

  if( ! function_exists( 'max_type_attachments_ajax_update' ) ) :

    function max_type_attachments_ajax_update() {

      if ( !empty( $_POST['ids'] ) )  {

        $args = array(
          'post_type' => 'attachment',
          'post_status' => 'inherit',
          'post__in' => $_POST['ids'],
          'post_mime_type' => 'image',
          'posts_per_page' => '-1',
          'orderby' => 'post__in'
        );
        $return = '';

        /* query posts array */
        $query = new WP_Query( $args  );
        $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );

        /* has posts */
        if ( $query->have_posts() ) {

          while ( $query->have_posts() ) {

            $query->the_post();

            /* Get Image Meta */
            $image_meta = get_post_meta($query->post->ID,'_wp_attachment_metadata',TRUE);

            /* Check Orientation ( Portrait / Landscape ) */
            $orientation = $image_meta['height'] > $image_meta['width'] ? 'portrait' : 'landscape';

            $return .= '<li class="attachment">';
            $return .= '<div class="attachment-preview '.$orientation.'">';
            $return .= '<div class="thumbnail">';
            $return .= '<div class="centered">';
            $return .= wp_get_attachment_image( $query->post->ID, 'medium');
            $return .= '</div></div></div>';
            $return .= '</li>';

          }

        } else {
          $return .=  '<p>' . __( 'No Posts Found', 'option-tree' ) . '</p>';
        }

        echo $return;
        exit();

      }

    }

  endif;

  add_action( 'wp_ajax_attachments_update', 'max_type_attachments_ajax_update' );


?>