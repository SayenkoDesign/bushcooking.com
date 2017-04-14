var wprm_admin = wprm_admin || {};

wprm_admin.update_term_metadata = function(term_id, field, value) {
	var data = {
			action: 'wprm_update_term_metadata',
			security: wprm_manage.nonce,
			term_id: term_id,
			field: field,
			value: value
	};

	jQuery.post(wprm_manage.ajax_url, data, function() {
		jQuery('.wprm-manage-datatable').DataTable().ajax.reload(null, false);
	});
};

wprm_admin.delete_or_merge_term = function(term_id, taxonomy, new_term_id) {
	var data = {
			action: 'wprm_delete_or_merge_term',
			security: wprm_manage.nonce,
			term_id: term_id,
			taxonomy: taxonomy,
			new_term_id: new_term_id
	};

	jQuery.post(wprm_manage.ajax_url, data, function() {
		jQuery('.wprm-manage-datatable').DataTable().ajax.reload(null, false);
	});
};

wprm_admin.delete_recipe = function(recipe_id) {
	var data = {
			action: 'wprm_delete_recipe',
			security: wprm_manage.nonce,
			recipe_id: recipe_id,
	};

	jQuery.post(wprm_manage.ajax_url, data, function() {
		jQuery('.wprm-manage-datatable').DataTable().ajax.reload(null, false);
	});
};

// Source: http://stackoverflow.com/questions/647259/javascript-query-string
wprm_admin.get_query_args = function() {
  var result = {}, queryString = location.search.slice(1),
      re = /([^&=]+)=([^&]*)/g, m;

  while (m = re.exec(queryString)) {
    result[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
  }

  return result;
}

jQuery(document).ready(function($) {
	// Get ID of datatable that's active on this page
	var wprm_active_datatable = '';
	jQuery('.wprm-manage-datatable').each(function() {
		wprm_active_datatable = jQuery(this).attr('id');
	});

	// Datatable filters.
	var args = wprm_admin.get_query_args();
	jQuery('.wprm-manage-recipes-filter').on('change', function() {
		wprm_datatable.search('').draw();
	}).each(function() {
		var taxonomy = jQuery(this).data('taxonomy');

		if(args.hasOwnProperty(taxonomy)) {
			jQuery(this).val(args[taxonomy]);
		}
	}).select2_wprm();

	// Init datatable
	$.fn.dataTable.ext.errMode = 'throw';

	var wprm_datatable = jQuery('.wprm-manage-datatable').DataTable( {
		pageLength: 10,
		order: [ 0, 'desc' ],
		serverSide: true,
		ajax: {
			url: wprm_manage.ajax_url,
			type: 'POST',
			data: function ( d ) {
				d.action = 'wprm_manage_datatable';
				d.security = wprm_manage.nonce;
				d.table = wprm_active_datatable;

				// Check for advanced search filters.
				var search_filters = jQuery('.wprm-manage-recipes-filter');

				if(search_filters.length > 0) {
					var search = jQuery('#wprm-manage-recipes_wrapper').find('input[type="search"]').val();

					search_filters.each(function() {
						var taxonomy = jQuery(this).data('taxonomy');
						var value = parseInt(jQuery(this).val());

						if(value > 0) {
							search += '{{' + taxonomy + '=' + value +'}}';
						}
					});

					d.search.value = search;
				}
			}
		},
		drawCallback: function() {
			// Select2.
			jQuery('.wprm-manage-datatable').find('select').select2_wprm();

			// Add tooltips.
			jQuery('.wprm-manage-ingredients-actions').tooltipster({
				content: '<div class="wprm-manage-ingredients-actions-tooltip"><div class="tooltip-header">&nbsp;</div><a href="#" class="wprm-manage-ingredients-actions-link">Edit Ingredient Link</a><a href="#" class="wprm-manage-ingredients-actions-merge">Merge into Another Ingredient</a><a href="#" class="wprm-manage-ingredients-actions-delete">Delete Ingredient</a></div>',
				contentAsHTML: true,
				functionBefore: function() {
					var instances = jQuery.tooltipster.instances();
					jQuery.each(instances, function(i, instance){
						instance.close();
					});
				},
				functionReady: function(instance, helper) {
					var id = parseInt(jQuery(helper.origin).data('id')),
						count = parseInt(jQuery(helper.origin).data('count')),
						name = jQuery('#wprm-manage-ingredients-name-' + id).text();

					jQuery(helper.tooltip).find('a').data('id', id);
					jQuery(helper.tooltip).find('.tooltip-header').text('#' + id + ' - ' + name);

					if(count > 0) {
						jQuery(helper.tooltip)
							.find('.wprm-manage-ingredients-actions-delete')
							.remove();
					}
				},
				interactive: true,
				delay: 0,
				side: 'left',
				trigger: 'custom',
				triggerOpen: {
					mouseenter: true,
					touchstart: true
				},
				triggerClose: {
					click: true,
					tap: true
				},
			});

			jQuery('.wprm-manage-taxonomies-actions').tooltipster({
				content: '<div class="wprm-manage-taxonomies-actions-tooltip"><div class="tooltip-header">&nbsp;</div><a href="#" class="wprm-manage-taxonomies-actions-merge">Merge into Another Term</a><a href="#" class="wprm-manage-taxonomies-actions-delete">Delete Term</a></div>',
				contentAsHTML: true,
				functionBefore: function() {
					var instances = jQuery.tooltipster.instances();
					jQuery.each(instances, function(i, instance){
						instance.close();
					});
				},
				functionReady: function(instance, helper) {
					var id = parseInt(jQuery(helper.origin).data('id')),
						count = parseInt(jQuery(helper.origin).data('count')),
						name = jQuery('#wprm-manage-taxonomies-name-' + id).text();

					jQuery(helper.tooltip).find('a').data('id', id);
					jQuery(helper.tooltip).find('.tooltip-header').text('#' + id + ' - ' + name);
				},
				interactive: true,
				delay: 0,
				side: 'left',
				trigger: 'custom',
				triggerOpen: {
					mouseenter: true,
					touchstart: true
				},
				triggerClose: {
					click: true,
					tap: true
				},
			});

			jQuery('.wprm-manage-recipes-actions').tooltipster({
				content: '<div class="wprm-manage-recipes-actions-tooltip"><div class="tooltip-header">&nbsp;</div><a href="#" class="wprm-manage-recipes-actions-edit">Edit Recipe</a><a href="#" class="wprm-manage-recipes-actions-delete">Delete Recipe</a></div>',
				contentAsHTML: true,
				functionBefore: function() {
					var instances = jQuery.tooltipster.instances();
					jQuery.each(instances, function(i, instance){
						instance.close();
					});
				},
				functionReady: function(instance, helper) {
					var id = parseInt(jQuery(helper.origin).data('id')),
						name = jQuery('#wprm-manage-recipes-name-' + id).text();

					jQuery(helper.tooltip).find('.tooltip-header').text('#' + id + ' - ' + name);
					jQuery(helper.tooltip).find('a').data('id', id);
				},
				interactive: true,
				delay: 0,
				side: 'left',
				trigger: 'custom',
				triggerOpen: {
					mouseenter: true,
					touchstart: true
				},
				triggerClose: {
					click: true,
					tap: true
				},
			});
			
			jQuery('.wprm-manage-recipes-seo').tooltipster({
				delay: 0,
				side: 'left',
			});
		}
	} );

	jQuery(document).on('click', '.wprm-manage-recipes-seo', function() {
		var id = jQuery(this).data('id');

		wprm_admin.open_modal(false, {
			recipe_id: id
		});
	});

	jQuery(document).on('change', '.wprm-manage-ingredients-link-nofollow', function() {
		var id = jQuery(this).data('id'),
			nofollow = jQuery(this).val();
		
		wprm_admin.update_term_metadata(id, 'ingredient_link_nofollow', nofollow);
	});

	jQuery(document).on('click', '.wprm-manage-ingredients-actions-link', function() {
		var id = jQuery(this).data('id'),
			name = jQuery('#wprm-manage-ingredients-name-' + id).text(),
			link_container = jQuery('#wprm-manage-ingredients-link-' + id),
			link = link_container.text();
		
		var new_link = prompt('What do you want the link for "' + name + '" to be?', link).trim();
		wprm_admin.update_term_metadata(id, 'ingredient_link', new_link);
	});

	jQuery(document).on('click', '.wprm-manage-ingredients-actions-merge', function() {
		var id = jQuery(this).data('id'),
			name = jQuery('#wprm-manage-ingredients-name-' + id).text();
		
		var new_term = parseInt(prompt('What is the ID of the ingredient that you want to merge "' + name + '" into?', ''));
		if(new_term) {
			wprm_admin.delete_or_merge_term(id, 'ingredient', new_term);
		}
	});

	jQuery(document).on('click', '.wprm-manage-taxonomies-actions-merge', function() {
		var id = jQuery(this).data('id'),
			name = jQuery('#wprm-manage-taxonomies-name-' + id).text(),
			taxonomy = jQuery('.wprm-manage-taxonomies').data('taxonomy');
		
		var new_term = parseInt(prompt('What is the ID of the term that you want to merge "' + name + '" into?', ''));
		if(new_term) {
			wprm_admin.delete_or_merge_term(id, taxonomy, new_term);
		}
	});

	jQuery(document).on('click', '.wprm-manage-ingredients-actions-delete', function() {
		var id = jQuery(this).data('id');
		wprm_admin.delete_or_merge_term(id, 'ingredient', 0);
	});

	jQuery(document).on('click', '.wprm-manage-taxonomies-actions-delete', function() {
		var id = jQuery(this).data('id'),
			name = jQuery('#wprm-manage-taxonomies-name-' + id).text(),
			taxonomy = jQuery('.wprm-manage-taxonomies').data('taxonomy');

		if(confirm('Are you sure you want to delete "' + name + '"?')) {
			wprm_admin.delete_or_merge_term(id, taxonomy, 0);
		}
	});

	jQuery(document).on('click', '.wprm-manage-recipes-actions-edit', function() {
		var id = jQuery(this).data('id');

		wprm_admin.open_modal(false, {
			recipe_id: id
		});
	});

	jQuery(document).on('click', '.wprm-manage-recipes-actions-delete', function() {
		var id = jQuery(this).data('id'),
			name = jQuery('#wprm-manage-recipes-name-' + id).text();
		
		if(confirm('Are you sure you want to delete "' + name + '"?')) {
			wprm_admin.delete_recipe(id);
		}
	});
});
