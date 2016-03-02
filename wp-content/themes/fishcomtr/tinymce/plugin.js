(function ()
{

	// create maxshortcodes plugin
	tinymce.create("tinymce.plugins.maxshortcodes", {

		init : function(ed, url) {

            ed.addCommand("maxPopup", function ( a, params ){

				var popup = params.identifier;

				var w = window.innerWidth;        // Get the inner window width
				var h = window.innerHeight;       // Get the inner window height

				w = (w * 90) / 100;               // Calculate the dialog width
				h = (h * 85) / 100;               // Calculate the dialog height

				// load thickbox
				tb_show("Insert Shortcode", url + "/popup.php?popup=" + popup + "&width="+w+"&wpcontentdir="+max_script_vars.wp_content_dir );

			});

            ed.addButton( 'max_button', {
                type: 'splitbutton',
                text: 'Shortcodes',
                icon: false,
                image: max_script_vars.wp_theme_dir + "/tinymce/images/icon.png",
                onselect: function(e) {

                },
                onclick: function() {

                },
				menu: [
					{ text: 'Columns', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Columns', identifier: 'columns' }) }},
					{ text: 'Typography', menu: [
						{ text: 'Highlight', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Highlight', identifier: 'highlight' }) }},
						{ text: 'Blockquote', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Blockquote', identifier: 'blockquote' }) }},
						{ text: 'Dropcap', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Dropcap', identifier: 'dropcap' }) }},
						{ text: 'Tooltip', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Tooltip', identifier: 'tooltip' }) }},
						{ text: 'Horizontal Line', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Horizontal Line', identifier: 'horizontalline' }) }}
					]},
					{ text: 'Box, Toggles and Tabs', menu: [
						{ text: 'Info Box', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Info Box', identifier: 'boxinfo' }) }},
						{ text: 'Toggle Box', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Toggle Box', identifier: 'boxtoggle' }) }},
						{ text: 'Tab Box', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Tab Box', identifier: 'boxtabs' }) }}
					]},
					{ text: 'Media', menu: [
						{ text: 'Image Float', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Image Float', identifier: 'imagefloat' }) }},
						{ text: 'Lightbox Image', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Toggle Box', identifier: 'prettyimage' }) }},
						{ text: 'Lightbox Gallery', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Lightbox Gallery', identifier: 'prettygallery' }) }},
						{ text: 'Caption Image', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Caption Image', identifier: 'captionimage' }) }},
						{ text: 'YouTube Video', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'YouTube Video', identifier: 'videoyoutube' }) }},
						{ text: 'Vimeo Video', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Vimeo Video', identifier: 'videovimeo' }) }}
					]},
					{ text: 'Recent Posts', onclick: function() { tinyMCE.activeEditor.execCommand("maxPopup", false, { title: 'Recent Posts', identifier: 'recentposts' }) }}
				]

            });

        },


		addWithPopup: function ( ed, title, id ) {

			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("maxPopup", false, {
						title: title,
						identifier: id
					})
				}
			})

		},

		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},

		getInfo: function () {
			return {
				longname: 'max Shortcodes',
				author: 'Dennis Osterkamp',
				authorurl: 'http://themeforest.net/user/doitmax/',
				infourl: 'http://',
				version: "1.0"
			}
		}

	});

	// add maxshortcodes plugin
	tinymce.PluginManager.add("maxshortcodes", tinymce.plugins.maxshortcodes);

})();