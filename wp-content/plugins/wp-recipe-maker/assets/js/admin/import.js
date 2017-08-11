var wprm_admin = wprm_admin || {};

wprm_admin.import_last_checked = false;

wprm_admin.importing_recipes = [];
wprm_admin.importing_recipes_total = 0;
wprm_admin.import_recipes = function() {
	var data = {
		action: 'wprm_import_recipes',
		security: wprm_modal.nonce,
		importer_uid: wprm_import.importer_uid,
		post_data: wprm_import.post_data,
		recipes: wprm_admin.importing_recipes
	};

	jQuery.post(wprm_modal.ajax_url, data, function(out) {
		if (out.success) {
			wprm_admin.importing_recipes = out.data.recipes_left;
			wprm_admin.update_progress_bar();

			if(wprm_admin.importing_recipes.length > 0) {
				wprm_admin.import_recipes();
			} else {
				jQuery('#wprm-import-finished').show();
			}
		} else {
			window.location = out.data.redirect;
		}
	}, 'json');
}

wprm_admin.update_progress_bar = function() {
	var percentage = ( 1.0 - ( wprm_admin.importing_recipes.length / wprm_admin.importing_recipes_total ) ) * 100;
	jQuery('#wprm-import-progress-bar').css('width', percentage + '%');
};

jQuery(document).ready(function($) {
	// Quick select functionality.
	jQuery('.wprm-import-recipes-select-all').on('click', function(e) {
		e.preventDefault();
		jQuery('.wprm-import-recipes').find(':checkbox').each(function() {
			jQuery(this).prop('checked', true);
		});
	});
	jQuery('.wprm-import-recipes-select-none').on('click', function(e) {
		e.preventDefault();
		jQuery('.wprm-import-recipes').find(':checkbox').each(function() {
			jQuery(this).prop('checked', false);
		});
	});

	// Select multiple using SHIFT
	jQuery('.wprm-import-recipes').on('click', ':checkbox', function(e) {
		if(wprm_admin.import_last_checked && e.shiftKey) {
			var checkboxes = jQuery('.wprm-import-recipes').find(':checkbox'),
				start = checkboxes.index(this),  
				end = checkboxes.index(wprm_admin.import_last_checked);

			checkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', wprm_admin.import_last_checked.checked);
		}

		wprm_admin.import_last_checked = this;
	});

	// Go to next import page
	jQuery('.wprm-import-next-page').on('click', function() {
		var url = window.location.href,
			regex = /(&|\?)p=(\d+)/,
			match = regex.exec(url);

		if(match) {
			var page = parseInt(match[2]),
				search = 'p=' + page,
				replace = 'p=' + (page+1);
							
			url = url.replace('?' + search, '?' + replace);
			url = url.replace('&' + search, '&' + replace);
		}

		window.location = url;
	});

	// Go back to the first import page
	jQuery('.wprm-import-reset-page').on('click', function() {
		var url = window.location.href,
			regex = /(&|\?)p=(\d+)/,
			match = regex.exec(url);

		if(match) {
			var page = parseInt(match[2]),
				search = 'p=' + page,
				replace = 'p=0';
							
			url = url.replace('?' + search, '?' + replace);
			url = url.replace('&' + search, '&' + replace);
		}

		window.location = url;
	});

	// Edit imported recipe
	jQuery(document).on('click', '.wprm-import-recipes-actions-edit', function(e) {
		e.preventDefault();

		var id = jQuery(this).data('id');

		wprm_admin.open_modal(false, {
			recipe_id: id
		});
	});

	// Import Process
	if(window.wprm_import !== undefined) {
		wprm_admin.importing_recipes = wprm_import.recipes;
		wprm_admin.importing_recipes_total = wprm_import.recipes.length;
		wprm_admin.import_recipes();
	}
});
