
// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {

    var max_shortcodes = {

    	loadVals: function()
    	{
    		var shortcode = $('#_max_shortcode').text(),
    			uShortcode = shortcode;

    		// fill in the gaps eg {{param}}
    		$('.max-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('max_', ''),		// gets rid of the max_ prefix
    				re = new RegExp("{{"+id+"}}","g");

    			uShortcode = uShortcode.replace(re, input.val());
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_max_ushortcode').remove();
    		$('#max-sc-form-table').prepend('<div id="_max_ushortcode" class="hidden">' + uShortcode + '</div>');

    		// updates preview
    		max_shortcodes.updatePreview();
    	},

    	cLoadVals: function()
    	{
    		var shortcode = $('#_max_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';

    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;

    			$('.max-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('max_', '')		// gets rid of the max_ prefix
    					re = new RegExp("{{"+id+"}}","g");

    				rShortcode = rShortcode.replace(re, input.val());
    			});

    			shortcodes = shortcodes + rShortcode + "\n";
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_max_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_max_cshortcodes" class="hidden">' + shortcodes + '</div>');

    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_max_ushortcode').text().replace('{{child_shortcode}}', shortcodes);

    		// add updated parent shortcode
    		$('#_max_ushortcode').remove();
    		$('#max-sc-form-table').prepend('<div id="_max_ushortcode" class="hidden">' + pShortcode + '</div>');

    		// updates preview
    		max_shortcodes.updatePreview();
    	},

    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});

    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();

    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}

    			return false;
    		});

    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'

			});
    	},

    	updatePreview: function()
    	{
    		if( $('#max-sc-preview').size() > 0 )
    		{
	    		var	shortcode = $('#_max_ushortcode').html(),
	    			iframe = $('#max-sc-preview'),
	    			iframeSrc = iframe.attr('src'),
	    			iframeSrc = iframeSrc.split('preview.php'),
	    			iframeSrc = iframeSrc[0] + 'preview.php';

	    		// updates the src value
	    		iframe.attr( 'src', iframeSrc + '?sc=' + base64_encode( shortcode ) + '&wpcontentdir=' + max_script_vars.wp_content_dir);

	    		// update the height
	    		$('#max-sc-preview').height( $('#max-popup').outerHeight()-42 );
    		}
    	},

    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				maxPopup = $('#max-popup'),
				no_preview = ($('#_max_preview').text() == 'false') ? true : false;

			if( no_preview )
			{
				ajaxCont.css({
					padding: 0,
          height: (tbWindow.outerHeight() - 47),
					overflow: 'scroll', // IMPORTANT,
					width: '100%'
				});

				$('#max-popup').addClass('no_preview');
			}
			else
			{
				ajaxCont.css({
					padding: 0,
					// height: (tbWindow.outerHeight()-47),
					height: maxPopup.outerHeight(),
					overflow: 'hidden', // IMPORTANT,
					width: '100%'
				});

				tbWindow.css({
					width: window.innerWidth * 70 / 100,
					height: ( ajaxCont.outerHeight() + 30 ),
					marginLeft: -( window.innerWidth * 70 / 100 / 2),
					marginTop: -( (ajaxCont.outerHeight() + 47) / 2 ),
					top: '50%'
				});

			}
    	},

    	load: function()
    	{
    		var	max_shortcodes = this,
    			popup = $('#max-popup'),
    			form = $('#max-sc-form', popup),
    			shortcode = $('#_max_shortcode', form).text(),
    			popupType = $('#_max_popup', form).text(),
    			uShortcode = '';

    		// resize TB
    		max_shortcodes.resizeTB();
    		$(window).resize(function() { max_shortcodes.resizeTB() });

    		// initialise
    		max_shortcodes.loadVals();
    		max_shortcodes.children();
    		max_shortcodes.cLoadVals();

    		// update on children value change
    		$('.max-cinput', form).live('change', function() {
    			max_shortcodes.cLoadVals();
    		});

    		// update on value change
    		$('.max-input', form).change(function() {
    			max_shortcodes.loadVals();
    		});

    		// when insert is clicked
    		$('.max-insert', form).click(function() {
    			if(window.tinyMCE)
				{
					window.tinyMCE.execCommand( 'mceInsertContent', false, $('#_max_ushortcode', form).html() );
					tb_remove();
				}
    		});
    	}
	}

    // run
    $('#max-popup').livequery( function() { max_shortcodes.load(); } );
});