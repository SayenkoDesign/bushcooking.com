var wprm_admin = wprm_admin || {};

wprm_admin.active_editor_id = false;

wprm_admin.disable_menu = function() {
		jQuery('.wprm-frame-menu').find('.wprm-menu-item').hide();
		jQuery('.wprm-menu-hidden').show();
};

wprm_admin.open_modal = function(editor_id, args) {
		args = args === undefined ? {} : args;

		// Enable menu items
		jQuery('.wprm-menu-item').show();
		jQuery('.wprm-menu-hidden').hide();

		wprm_admin.active_editor_id = editor_id;
		jQuery('.wprm-modal-container').show();

		// Init tabs
		var tabs = jQuery('.wprm-router').find('.wprm-menu-item');
		jQuery(tabs).each(function() {
				init_callback = jQuery(this).data('init');

				if (init_callback && typeof wprm_admin[init_callback] == 'function') {
						wprm_admin[init_callback](args);
				}
		});

		// Default to first menu item
		jQuery('.wprm-menu').find('.wprm-menu-item').first().click();
};

wprm_admin.close_modal = function() {
		wprm_admin.active_editor_id = false;
		jQuery('.wprm-menu').removeClass('visible');
		jQuery('.wprm-modal-container').hide();
};

wprm_admin.shortcode_escape_map = {
		'"': "'"
};

wprm_admin.shortcode_escape = function(text) {
		return String(text).replace(/["]/g, function(s) {
				return wprm_admin.shortcode_escape_map[s];
		});
};

wprm_admin.add_text_to_editor = function(text) {
		text = ' ' + text + ' ';

		if (wprm_admin.active_editor_id) {
				if (typeof tinyMCE == 'undefined' || !tinyMCE.get(wprm_admin.active_editor_id) || tinyMCE.get(wprm_admin.active_editor_id).isHidden()) {
						var current = jQuery('textarea#' + wprm_admin.active_editor_id).val();
						jQuery('textarea#' + wprm_admin.active_editor_id).val(current + text);
				} else {
						tinyMCE.get(wprm_admin.active_editor_id).focus(true);
						tinyMCE.activeEditor.selection.collapse(false);
						tinyMCE.activeEditor.execCommand('mceInsertContent', false, text);
				}
		}
};

jQuery(document).ready(function($) {
		// Opening Modal
		jQuery(document).on('click', '.wprm-modal-button', function() {
				var editor_id = jQuery(this).data('editor');
				wprm_admin.open_modal(editor_id);
		});

		// Edit Recipe button
		jQuery(document).on('click', '.wprm-modal-edit-button', function() {
			var editor_id = jQuery(this).data('editor');
			var recipe_id = jQuery(this).data('recipe');

			wprm_admin.open_modal(editor_id, {
				recipe_id: recipe_id
			});
		});

		// Closing Modal
		jQuery('.wprm-modal-container').on('click', '.wprm-modal-close, .wprm-modal-backdrop', function() {
			if(confirm(wprm_modal.text.modal_close_confirm)) {
				wprm_admin.close_modal();
			}
		});

		// Modal Menu
		jQuery('.wprm-menu').on('click', '.wprm-menu-item', function() {
				var menu_item = jQuery(this),
						menu_target = menu_item.data('menu'),
						menu_tab = menu_item.data('tab');

				// Hide Menu if on Mobile
				jQuery('.wprm-menu').removeClass('visible');

				// Set clicked on tab as the active one
				jQuery('.wprm-menu').find('.wprm-menu-item').removeClass('active');
				menu_item.addClass('active');

				// Show correct menu
				jQuery('.wprm-frame-router').find('.wprm-router').removeClass('active');
				jQuery('.wprm-frame-router').find('#wprm-menu-' + menu_target).addClass('active');

				// Show the first tab as active or whichever tab was passed along
				var active_tab = false;
				jQuery('.wprm-router').find('.wprm-menu-item').removeClass('active');
				jQuery('.wprm-frame-router').find('#wprm-menu-' + menu_target).find('.wprm-menu-item').each(function(index) {
						if (index === 0 || jQuery(this).data('tab') == menu_tab) {
								active_tab = jQuery(this);
						}
				});

				if (active_tab) {
						active_tab.click();
				}

				// Change main title
				jQuery('.wprm-frame-title').find('h1').text(menu_item.text());
		});

		// Modal Menu on Mobile
		jQuery('.wprm-modal-container').on('click', '.wprm-frame-title', function() {
				jQuery('.wprm-menu').toggleClass('visible');
		});

		// Modal Tabs
		jQuery('.wprm-router').on('click', '.wprm-menu-item', function() {
				var menu_item = jQuery(this),
					tab_target = menu_item.data('tab'),
					tab_button = menu_item.data('button');

				// Set clicked on tab as the active one
				jQuery('.wprm-router').find('.wprm-menu-item').removeClass('active');
				menu_item.addClass('active');

				// Hide action button if no callback is set
				if (menu_item.data('callback')) {
						jQuery('.wprm-button-action').text(tab_button).show();
				} else {
						jQuery('.wprm-button-action').hide();
				}

				// Show correct tab
				jQuery('.wprm-frame-content').find('.wprm-frame-content-tab').removeClass('active');
				jQuery('.wprm-frame-content').find('#wprm-tab-' + tab_target).addClass('active');
		});

		// Select Recipes Dropdown
		jQuery('.wprm-recipes-dropdown').select2_wprm({
				width: '250px',
				ajax: {
					type: 'POST',
					url: wprm_modal.ajax_url,
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							action: 'wprm_search_recipes',
							security: wprm_modal.nonce,
							search: params.term
						};
					},
					processResults: function (out, params) {
						return {
							results: out.data.recipes_with_id,
						};
					},
					cache: true
				},
				minimumInputLength: 1,
		});

		jQuery('.wprm-recipes-dropdown-with-first').select2_wprm({
				width: '250px',
				ajax: {
					type: 'POST',
					url: wprm_modal.ajax_url,
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							action: 'wprm_search_recipes',
							security: wprm_modal.nonce,
							search: params.term
						};
					},
					processResults: function (out, params) {
						var default_options = [{
							id: '0',
							text: wprm_modal.text.first_recipe_on_page,
						}];
						return {
							results: default_options.concat(out.data.recipes_with_id),
						};
					},
					cache: true
				},
				minimumInputLength: 1,
		});

		// Insert or Update Button
		jQuery('.wprm-button-action').on('click', function() {
				var active_tab = jQuery('.wprm-router.active').find('.wprm-menu-item.active'),
						callback = active_tab.data('callback');

				if (typeof wprm_admin[callback] == 'function') {
						wprm_admin[callback](jQuery(this));
				}
		});

		// Prevent Divi Builder bug.
		jQuery('.wprm-modal-container').keydown( function(e) {
			e.stopPropagation();
		});
});
