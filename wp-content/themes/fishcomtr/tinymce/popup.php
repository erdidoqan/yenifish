<?php

global $wp_content_path;

$wp_content_path = $_REQUEST['wpcontentdir'];

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

define('MAX_TINYMCE_PATH', get_template_directory() . '/tinymce');
define('MAX_TINYMCE_URI', get_template_directory_uri() . '/tinymce');

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new max_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="max-popup">

	<div id="max-shortcode-wrap">

		<div id="max-sc-form-wrap">

			<div id="max-sc-form-head">

				<?php echo $shortcode->popup_title; ?>

			</div>
			<!-- /#max-sc-form-head -->

			<form method="post" id="max-sc-form">

				<table id="max-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary max-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#max-sc-form-table -->

			</form>
			<!-- /#max-sc-form -->

		</div>
		<!-- /#max-sc-form-wrap -->

		<div id="max-sc-preview-wrap">

			<div id="max-sc-preview-head">

				Shortcode Preview

			</div>
			<!-- /#max-sc-preview-head -->

			<?php if( $shortcode->no_preview ) : ?>
			<div id="max-sc-nopreview">Shortcode has no preview</div>
			<?php else : ?>
			<iframe src="<?php echo MAX_TINYMCE_URI; ?>/preview.php?wpcontentdir=<?php echo $wp_content_path ?>&amp;sc=" width="100%" frameborder="0" id="max-sc-preview" style="float: left;"></iframe>
			<?php endif; ?>

		</div>
		<!-- /#max-sc-preview-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#max-shortcode-wrap -->

</div>
<!-- /#max-popup -->

</body>
</html>