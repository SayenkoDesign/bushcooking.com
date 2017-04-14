var wprm_admin = wprm_admin || {};
wprm_admin.prep_time_set = false;
wprm_admin.cook_time_set = false;
wprm_admin.total_time_set = false;

wprm_admin.editing_recipe = 0;
wprm_admin.set_recipe = function(args) {
	var recipe_id = args.recipe_id ? args.recipe_id : 0;

	wprm_admin.editing_recipe = recipe_id;
	wprm_admin.clear_recipe_fields();
	if(typeof wprmp_admin !== 'undefined') {
		wprmp_admin.clear_recipe_fields();
	}

	if (recipe_id == 0) {
		var button = jQuery('.wprm-button-action');

		jQuery('.wprm-router.active').find('.wprm-menu-item').each(function() {
			jQuery(this).data('button', wprm_modal.text.action_button_insert);
		});
		button.text(wprm_modal.text.action_button_insert);
	} else {
		var button = jQuery('.wprm-button-action');

		jQuery('.wprm-router.active').find('.wprm-menu-item').each(function() {
			jQuery(this).data('button', wprm_modal.text.action_button_update);
		});
		button.text(wprm_modal.text.action_button_update);

		wprm_admin.disable_menu();

		var data = {
			action: 'wprm_get_recipe',
			security: wprm_modal.nonce,
			recipe_id: recipe_id
		};

		wprm_admin.start_loader(button);

		jQuery.post(wprm_modal.ajax_url, data, function(out) {
			wprm_admin.stop_loader(button);

			if (out.success) {
				wprm_admin.set_recipe_fields(out.data.recipe);
				if(typeof wprmp_admin !== 'undefined') {
					wprmp_admin.set_recipe_fields(out.data.recipe);
				}
				jQuery('.wprm-frame-title').find('h1').text(wprm_modal.text.edit_recipe);
			}
		}, 'json');
	}
};

wprm_admin.edit_recipe = function() {
	var id = parseInt(jQuery('#wprm-edit-recipe-id').val());
	if(id != 0) {
		var editor = wprm_admin.active_editor_id;
		wprm_admin.close_modal();
		wprm_admin.open_modal(editor, {
			recipe_id: id
		});
	}
};

wprm_admin.insert_recipe = function() {
	var id = parseInt(jQuery('#wprm-insert-recipe-id').val());
	if(id != 0) {
		var shortcode = '[wprm-recipe id="' + id + '"]';

		wprm_admin.add_text_to_editor(shortcode);
		wprm_admin.close_modal();
	}
};

wprm_admin.clear_recipe_fields = function() {
		// Recipe Details
		wprm_admin.remove_media_image(jQuery('.wprm-recipe-image-container'));
		jQuery('#wprm-recipe-name').val('');
		wprm_admin.rich_editor.resetContent(''); // Recipe summary
		jQuery('#wprm-recipe-author-display').val('disabled').change();
		jQuery('#wprm-recipe-author-name').val('');
		jQuery('#wprm-recipe-servings').val('');
		jQuery('#wprm-recipe-servings-unit').val('');
		jQuery('#wprm-recipe-calories').val('');
		jQuery('#wprm-recipe-prep-time').val('');
		jQuery('#wprm-recipe-cook-time').val('');
		jQuery('#wprm-recipe-total-time').val('');

		wprm_admin.prep_time_set = false;
		wprm_admin.cook_time_set = false;
		wprm_admin.total_time_set = false;

		jQuery('.wprm-recipe-tags').val(null).trigger('change');

		// Ingredients & Instructions
		jQuery('.wprm-recipe-ingredients .wprm-recipe-ingredients-instructions-delete, .wprm-recipe-instructions .wprm-recipe-ingredients-instructions-delete').each(function() {
				jQuery(this).click();
		});
		jQuery('.wprm-recipe-ingredients-add').click();
		jQuery('.wprm-recipe-instructions-add').click();

		// Recipe Notes
		if (typeof tinyMCE !== 'undefined' && tinyMCE.get('wprm_recipe_notes') && !tinyMCE.get('wprm_recipe_notes').isHidden()) {
				tinyMCE.get('wprm_recipe_notes').focus(true);
				
				// Check for error caused by EasyRecipe.
				jQuery('.wprm-easyrecipe-warning').hide();
				try {
					tinyMCE.activeEditor.setContent('');
				} catch(err) {
					jQuery('.wprm-easyrecipe-warning').show();
				}
		} else {
				jQuery('#wprm_recipe_notes').val('');
		}
};

wprm_admin.set_recipe_fields = function(recipe) {
		// Recipe Details
		if (parseInt(recipe.image_id) > 0) {
				wprm_admin.set_media_image(jQuery('.wprm-recipe-details-form .wprm-recipe-image-container'), recipe.image_id, recipe.image_url);
		}

		jQuery('#wprm-recipe-name').val(recipe.name);
		wprm_admin.rich_editor.setContent(recipe.summary);
		jQuery('#wprm-recipe-servings-unit').val(recipe.servings_unit);

		jQuery('#wprm-recipe-author-display').val(recipe.author_display).change();
		jQuery('#wprm-recipe-author-name').val(recipe.author_name);

		var servings = parseInt(recipe.servings) > 0 ? parseInt(recipe.servings) : '',
				calories = recipe.nutrition.calories ? parseFloat(recipe.nutrition.calories) : '',
				prep_time = parseInt(recipe.prep_time) > 0 ? parseInt(recipe.prep_time) : '',
				cook_time = parseInt(recipe.cook_time) > 0 ? parseInt(recipe.cook_time) : '',
				total_time = parseInt(recipe.total_time) > 0 ? parseInt(recipe.total_time) : '';

		jQuery('#wprm-recipe-servings').val(servings);
		jQuery('#wprm-recipe-calories').val(calories);
		jQuery('#wprm-recipe-prep-time').val(prep_time);
		jQuery('#wprm-recipe-cook-time').val(cook_time);
		jQuery('#wprm-recipe-total-time').val(total_time);

		if (prep_time) wprm_admin.prep_time_set = true;
		if (cook_time) wprm_admin.cook_time_set = true;
		if (total_time) wprm_admin.total_time_set = true;

		for (var tag in recipe.tags) {
			if (recipe.tags.hasOwnProperty(tag)) {
				wprm_admin.set_recipe_tags(recipe, tag);
			}
		}
		
		// Ingredients & Instructions
		wprm_admin.set_recipe_ingredient_fields(recipe.ingredients);
		wprm_admin.set_recipe_instruction_fields(recipe.instructions);

		// Recipe Notes
		if (typeof tinyMCE !== 'undefined' && tinyMCE.get('wprm_recipe_notes') && !tinyMCE.get('wprm_recipe_notes').isHidden()) {
			tinyMCE.get('wprm_recipe_notes').focus(true);
			tinyMCE.activeEditor.setContent(recipe.notes);
		} else {
			jQuery('#wprm_recipe_notes').val(recipe.notes);
		}
};

wprm_admin.set_recipe_ingredient_fields = function(ingredients) {
	jQuery('.wprm-recipe-ingredients .wprm-recipe-ingredients-instructions-delete').each(function() {
		jQuery(this).click();
	});

	var i, l, group, j, m;

	for (i = 0, l = ingredients.length; i < l; i++) {
		group = ingredients[i];

		if (i > 0 || group.name !== '') {
			wprm_admin.add_ingredient_group(group.name);
		}

		for (j = 0, m = group.ingredients.length; j < m; j++) {
			var ingredient = group.ingredients[j];
			wprm_admin.add_ingredient(ingredient.amount, ingredient.unit, ingredient.name, ingredient.notes);
		}
	}
};

wprm_admin.set_recipe_instruction_fields = function(instructions) {
	jQuery('.wprm-recipe-instructions .wprm-recipe-ingredients-instructions-delete').each(function() {
		jQuery(this).click();
	});

	var i, l, group, j, m;

	for (i = 0, l = instructions.length; i < l; i++) {
		group = instructions[i];

		if (i > 0 || group.name !== '') {
			wprm_admin.add_instruction_group(group.name);
		}

		for (j = 0, m = group.instructions.length; j < m; j++) {
			var instruction = group.instructions[j];
			wprm_admin.add_instruction(instruction.text, instruction.image);
		}
	}
};

wprm_admin.set_recipe_tags = function(recipe, tag) {
		var term_ids = [],
				select = jQuery('#wprm-recipe-tag-' + tag);

		for (var i = 0, l = recipe.tags[tag].length; i < l; i++) {
				var term = recipe.tags[tag][i];
				term_ids.push(term.term_id);

				// Add term to options if not in there
				if (select.find('option[value=' + term.term_id + ']').length === 0) {
						select.append('<option value="' + term.term_id + '">' + term.name + '</option>');
				}
		}
		select.val(term_ids).trigger('change');
};

wprm_admin.select_media_image = function(container) {
		// Create a new media frame (don't reuse because we have multiple different inputs)
		var frame = wp.media({
				title: wprm_modal.text.media_title,
				button: {
						text: wprm_modal.text.media_button
				},
				multiple: false
		});


		// When an image is selected in the media frame...
		frame.on('select', function() {
				var attachment = frame.state().get('selection').first().toJSON();
				wprm_admin.set_media_image(container, attachment.id, attachment.url);
		});

		// Finally, open the modal on click
		frame.open();
};
wprm_admin.set_media_image = function(container, image_id, image_url) {
	container.find('.wprm-recipe-image-preview').html('');
	container.find('.wprm-recipe-image-preview').append('<img src="' + image_url + '" />');
	container.find('input').val(image_id);

	container.find('.wprm-recipe-image-add').addClass('hidden');
	container.find('.wprm-recipe-image-remove').removeClass('hidden');
};
wprm_admin.remove_media_image = function(container) {
	container.find('.wprm-recipe-image-preview').html('');
	container.find('input').val('');

	container.find('.wprm-recipe-image-add').removeClass('hidden');
	container.find('.wprm-recipe-image-remove').addClass('hidden');
};

wprm_admin.start_loader = function(button) {
		button
				.prop('disabled', true)
				.css('width', button.outerWidth())
				.data('text', button.html())
				.html('...');
};

wprm_admin.stop_loader = function(button) {
		button
				.prop('disabled', false)
				.css('width', '')
				.html(button.data('text'));
};

wprm_admin.add_ingredient = function(amount, unit, name, notes) {
		amount = amount || '';
		unit = unit || '';
		name = name || '';
		notes = notes || '';

		var clone = jQuery('.wprm-recipe-ingredients-placeholder').find('.wprm-recipe-ingredient').clone();
		jQuery('.wprm-recipe-ingredients').append(clone);

		clone.find('.wprm-recipe-ingredient-amount').val(amount).focus();
		clone.find('.wprm-recipe-ingredient-unit').val(unit);
		clone.find('.wprm-recipe-ingredient-name').val(name);
		clone.find('.wprm-recipe-ingredient-notes').val(notes);
};

wprm_admin.add_ingredient_group = function(name) {
		name = name || '';

		var clone = jQuery('.wprm-recipe-ingredients-placeholder').find('.wprm-recipe-ingredient-group').clone();
		jQuery('.wprm-recipe-ingredients').append(clone);
		clone.find('input:first').val(name).focus();
};

wprm_admin.add_instruction = function(text, image_id) {
		text = text || '';
		image_id = image_id || 0;

		var clone = jQuery('.wprm-recipe-instructions-placeholder').find('.wprm-recipe-instruction').clone();
		clone.find('.wprm-recipe-instruction-text').addClass('wprm-rich-editor');
		jQuery('.wprm-recipe-instructions').append(clone);
		clone.find('.wprm-recipe-instruction-text').val(text);
		wprm_admin.init_rich_editor();
		clone.find('.wprm-recipe-instruction-text').focus();

		// Get image thumbnail if there is an instruction image.
		if (parseInt(image_id) > 0) {
				var image_container = clone.find('.wprm-recipe-image-container'),
						button = image_container.find('.wprm-recipe-image-add');

				var data = {
						action: 'wprm_get_thumbnail',
						security: wprm_modal.nonce,
						image_id: image_id
				};

				wprm_admin.start_loader(button);

				jQuery.post(wprm_modal.ajax_url, data, function(out) {
						wprm_admin.stop_loader(button);

						if (out.success) {
								wprm_admin.set_media_image(image_container, image_id, out.data.image_url);
						}
				}, 'json');
		}
};

wprm_admin.add_instruction_group = function(name) {
		name = name || '';

		var clone = jQuery('.wprm-recipe-instructions-placeholder').find('.wprm-recipe-instruction-group').clone();
		jQuery('.wprm-recipe-instructions').append(clone);
		clone.find('input:first').val(name).focus();
};

wprm_admin.insert_update_recipe = function(button) {
	// Recipe Details
	var recipe = {
			image_id: jQuery('#wprm-recipe-image-id').val(),
			name: jQuery('#wprm-recipe-name').val(),
			summary: jQuery('#wprm-recipe-summary').val(),
			author_display: jQuery('#wprm-recipe-author-display').val(),
			author_name: jQuery('#wprm-recipe-author-name').val(),
			servings: jQuery('#wprm-recipe-servings').val(),
			servings_unit: jQuery('#wprm-recipe-servings-unit').val(),
			prep_time: jQuery('#wprm-recipe-prep-time').val(),
			cook_time: jQuery('#wprm-recipe-cook-time').val(),
			total_time: jQuery('#wprm-recipe-total-time').val(),
			nutrition: {
				calories: jQuery('#wprm-recipe-calories').val()
			},
			tags: {
					course: jQuery('#wprm-recipe-tag-course').val(),
					cuisine: jQuery('#wprm-recipe-tag-cuisine').val()
			}
	};

	// Recipe Tags
	recipe.tags = {};
	jQuery('.wprm-recipe-tags').each(function() {
		recipe.tags[jQuery(this).data('key')] = jQuery(this).val();
	});

	// Recipe Ingredients
	recipe.ingredients = wprm_admin.get_ingredients();

	// Recipe Instructions
	var instructions = [];
	var instruction_group = {
			name: '',
			instructions: []
	};
	jQuery('.wprm-recipe-instructions').find('tr').each(function() {
			var row = jQuery(this);
			if (row.hasClass('wprm-recipe-instruction-group')) {
					// Add current instruction group to instructions
					instructions.push(instruction_group);

					instruction_group = {
							name: row.find('.wprm-recipe-instruction-group-name').val(),
							instructions: []
					};
			} else {
					instruction_group.instructions.push({
							text: row.find('textarea.wprm-recipe-instruction-text').val(),
							image: row.find('.wprm-recipe-instruction-image').val()
					});
			}
	});
	// Add remaining instruction group
	instructions.push(instruction_group);

	recipe.instructions = instructions;

	// Recipe Notes
	if (typeof tinyMCE !== 'undefined' && tinyMCE.get('wprm_recipe_notes') && !tinyMCE.get('wprm_recipe_notes').isHidden()) {
		recipe.notes = tinyMCE.get('wprm_recipe_notes').getContent();
	} else {
		recipe.notes = jQuery('#wprm_recipe_notes').val();
	}

	// Add any Premium fields
	if(typeof wprmp_admin !== 'undefined') {
		recipe = wprmp_admin.insert_update_recipe(recipe);
	}

	// Ajax call to recipe saver
	var data = {
			action: 'wprm_save_recipe',
			security: wprm_modal.nonce,
			recipe_id: wprm_admin.editing_recipe,
			recipe: recipe
	};

	wprm_admin.start_loader(button);

	jQuery.post(wprm_modal.ajax_url, data, function(out) {
			wprm_admin.stop_loader(button);

			if (out.success) {
					if (wprm_admin.editing_recipe === 0) {
							wprm_admin.add_text_to_editor('[wprm-recipe id="' + out.data.id + '"]');
					} else if(wprm_admin.active_editor_id) {
							// Refresh content in editor to reload recipe preview
							if (typeof tinyMCE !== 'undefined' && tinyMCE.get(wprm_admin.active_editor_id) && !tinyMCE.get(wprm_admin.active_editor_id).isHidden()) {
									tinyMCE.get(wprm_admin.active_editor_id).focus(true);
									tinyMCE.activeEditor.setContent(tinyMCE.activeEditor.getContent());
							}
					}

					if(jQuery('.wprm-manage-datatable').length > 0) {
						jQuery('.wprm-manage-datatable').DataTable().ajax.reload(null, false);
					}

					wprm_admin.close_modal();
			}
	}, 'json');
};

wprm_admin.get_ingredients = function() {
	var ingredients = [];
	var ingredient_group = {
		name: '',
		ingredients: []
	};
	jQuery('.wprm-recipe-ingredients').find('tr').each(function() {
		var row = jQuery(this);
		if (row.hasClass('wprm-recipe-ingredient-group')) {
			// Add current ingredient group to ingredients
			ingredients.push(ingredient_group);

			ingredient_group = {
				name: row.find('.wprm-recipe-ingredient-group-name').val(),
				ingredients: []
			};
		} else {
			ingredient_group.ingredients.push({
				amount: row.find('.wprm-recipe-ingredient-amount').val(),
				unit: row.find('.wprm-recipe-ingredient-unit').val(),
				name: row.find('.wprm-recipe-ingredient-name').val(),
				notes: row.find('.wprm-recipe-ingredient-notes').val()
			});
		}
	});

	// Add remaining ingredient group
	ingredients.push(ingredient_group);

	return ingredients;
};

jQuery(document).ready(function($) {
		// Recipe and Instruction Image handler
		jQuery('.wprm-recipe-details-form, .wprm-recipe-instructions-form').on('click', '.wprm-recipe-image-add', function(e) {
				wprm_admin.select_media_image(jQuery(this).parents('.wprm-recipe-image-container'));
		});
		jQuery('.wprm-recipe-details-form, .wprm-recipe-instructions-form').on('click', '.wprm-recipe-image-remove', function(e) {
				wprm_admin.remove_media_image(jQuery(this).parents('.wprm-recipe-image-container'));
		});

		// Initialize rich editor
		wprm_admin.init_rich_editor();

		// Author
		jQuery('#wprm-recipe-author-display').select2_wprm({
			width: '95%'
		});

		jQuery(document).on('change', '#wprm-recipe-author-display', function() {
			var author_display = jQuery(this).val(),
				default_display = jQuery(this).find('option:first').data('default');

			if(author_display == 'custom' || (author_display == 'default' && default_display == 'custom')) {
				jQuery('#wprm-recipe-author-name-container').show();
			} else {
				jQuery('#wprm-recipe-author-name-container').hide();
			}
		});
		jQuery('#wprm-recipe-author-display').change();

		// Recipe Times
		jQuery('.wprm-recipe-time').on('keyup change', function() {
				var container = jQuery(this),
						prep_time_container = jQuery('#wprm-recipe-prep-time'),
						prep_time = prep_time_container.val(),
						cook_time_container = jQuery('#wprm-recipe-cook-time'),
						cook_time = cook_time_container.val(),
						total_time_container = jQuery('#wprm-recipe-total-time'),
						total_time = total_time_container.val();

				if (container.is('#wprm-recipe-prep-time')) wprm_admin.prep_time_set = true;
				if (container.is('#wprm-recipe-cook-time')) wprm_admin.cook_time_set = true;
				if (container.is('#wprm-recipe-total-time')) wprm_admin.total_time_set = true;

				if (prep_time && cook_time && !wprm_admin.total_time_set) total_time_container.val(parseInt(prep_time) + parseInt(cook_time));
				if (total_time && prep_time && !wprm_admin.cook_time_set) cook_time_container.val(parseInt(total_time) - parseInt(prep_time));
				if (total_time && cook_time && !wprm_admin.prep_time_set) prep_time_container.val(parseInt(total_time) - parseInt(cook_time));
		});

		// Recipe Tags
		jQuery('.wprm-recipe-tags').select2_wprm({
				width: '95%',
				tags: true
		});

		// Add Recipe Ingredients and Instructions
		jQuery('.wprm-recipe-ingredients-add').on('click', function() {
				wprm_admin.add_ingredient();
		});
		jQuery('.wprm-recipe-ingredients-add-group').on('click', function() {
				wprm_admin.add_ingredient_group();
		});
		jQuery('.wprm-recipe-instructions-add').on('click', function() {
				wprm_admin.add_instruction('');
		});
		jQuery('.wprm-recipe-instructions-add-group').on('click', function() {
				wprm_admin.add_instruction_group();
		});

		// Add new ingredient/instruction on TAB
		jQuery('.wprm-recipe-ingredients').on('keydown', '.wprm-recipe-ingredient-notes, .wprm-recipe-ingredient-group-name', function(e) {
				var keyCode = e.keyCode || e.which,
						input = jQuery(this);

				if (!e.shiftKey && keyCode == 9 && jQuery(this).parents('tr').is('tr:last-child')) {
						e.preventDefault();
						wprm_admin.add_ingredient();
				}
		});
		jQuery('.wprm-recipe-instructions').on('keydown', '.wprm-recipe-instruction-text, .wprm-recipe-instruction-group-name', function(e) {
				var keyCode = e.keyCode || e.which,
						input = jQuery(this);

				if (!e.shiftKey && keyCode == 9 && jQuery(this).parents('tr').is('tr:last-child')) {
						e.preventDefault();
						wprm_admin.add_instruction();
				}
		});

		// Remove Recipe Ingredients and Instructions
		jQuery('.wprm-recipe-ingredients-instructions-form').on('click', '.wprm-recipe-ingredients-instructions-delete', function() {
				jQuery(this).parents('tr').remove();
		});

		// Sort Recipe Ingredients and Instructions
		jQuery('.wprm-recipe-ingredients, .wprm-recipe-instructions').sortable({
				opacity: 0.6,
				revert: true,
				cursor: 'move',
				handle: '.wprm-recipe-ingredients-instructions-sort',
		});
});
