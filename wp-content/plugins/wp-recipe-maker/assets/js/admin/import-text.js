var wprm_admin = wprm_admin || {};

wprm_admin.text_import_step = '';
wprm_admin.text_import_highlighter;
wprm_admin.text_import = {};
wprm_admin.text_import_waiting = false;

wprm_admin.start_text_import = function() {
    jQuery('.wprm-button-import-text-reset').removeAttr('disabled');
    jQuery('.wprm-button-import-text-clear').removeAttr('disabled');
    jQuery('.wprm-button-import-text-next').removeAttr('disabled');

    wprm_admin.text_import_step = 'input';
    jQuery('#import-text-highlight-sandbox').textHighlighter();
    wprm_admin.text_import_highlighter = jQuery('#import-text-highlight-sandbox').getHighlighter()
};

wprm_admin.btn_text_import_reset = function() {
    wprm_admin.btn_text_import_clear(true);
    jQuery('#import-text-highlight-sandbox').text('');
    wprm_admin.text_import = {};
    wprm_admin.text_import_waiting = false;
    
    jQuery('.wprm-button-import-text-reset').attr('disabled', 'disabled');
    jQuery('.wprm-button-import-text-clear').attr('disabled', 'disabled');
    jQuery('.wprm-button-import-text-next').attr('disabled', 'disabled');

    jQuery('.import-text-step').hide();
    jQuery('#import-text-step-input').show();
    jQuery('#import-text-highlight-sandbox').hide();
};

wprm_admin.btn_text_import_clear = function(all) {
    if(all || wprm_admin.text_import_step == 'input') {
        jQuery('#import-text-input-recipe').val('');
    }

    if(all || wprm_admin.text_import_step == 'ingredient-groups') {
        jQuery('#import-text-ingredient-groups').find('input').attr('checked', false);
    }

    if(all || wprm_admin.text_import_step == 'instruction-groups') {
        jQuery('#import-text-instruction-groups').find('input').attr('checked', false);
    }

    wprm_admin.text_import_highlighter.removeHighlights();
};

wprm_admin.btn_text_import_next = function() {
    if(wprm_admin.text_import_step == 'input') {
        wprm_admin.text_import.raw = jQuery('#import-text-input-recipe').val();
        jQuery('#import-text-highlight-sandbox').html(wprm_admin.text_import.raw.replace(/\r?\n/g,'<br/>')).show();

        wprm_admin.text_import_step = 'name';
    } else if(wprm_admin.text_import_step == 'name') {
        wprm_admin.text_import.name = wprm_admin.get_highlighted_text();

        wprm_admin.text_import_step = 'summary';
    } else if(wprm_admin.text_import_step == 'summary') {
        wprm_admin.text_import.summary = wprm_admin.get_highlighted_text();

        jQuery('#import-text-highlight-sandbox').show();

        wprm_admin.text_import_step = 'ingredients';
    } else if(wprm_admin.text_import_step == 'ingredients') {
        var ingredients = wprm_admin.text_import_highlighter.getHighlights();
        wprm_admin.text_import.ingredients_raw = ingredients;
        
        jQuery('#import-text-ingredient-groups').html('');
        for(var i = 0, l = ingredients.length; i<l; i++) {
            var text = jQuery(ingredients[i]).text().trim();
            text = text.replace(/^(\d\.\s+|[a-z]\)\s+|•\s+|[A-Z]\.\s+|[IVX]+\.\s+)/g, "");
            var ingredient = '<div class="import-text-ingredient"><input type="checkbox" id="ingredient-' + i + '"> ' + '<label for="ingredient-' + i + '">' + text + '</label></div>';
            jQuery('#import-text-ingredient-groups').append(ingredient);
        }
        jQuery('.import-text-group-warning').hide();
        
        if(ingredients.length == 0) {
            jQuery('#import-text-highlight-sandbox').show();
            wprm_admin.text_import.ingredients = [];
            wprm_admin.text_import_step = 'instructions';
        } else {
            jQuery('#import-text-highlight-sandbox').hide();
            wprm_admin.text_import_step = 'ingredient-groups';
        }
    } else if(wprm_admin.text_import_step == 'ingredient-groups') {
        var ingredients = [],
            ingredient_group = {
                name: '',
                ingredients: []
        };

        jQuery('#import-text-ingredient-groups').find('.import-text-ingredient').each(function() {
            var is_ingredient_group = jQuery(this).find('input').is(':checked'),
                ingredient = jQuery(this).find('label').text();

            if(is_ingredient_group) {
                ingredients.push(ingredient_group);

                ingredient_group = {
                    name: ingredient,
                    ingredients: []
                }
            } else {
                ingredient_group.ingredients.push({raw: ingredient});
            }
        });
        ingredients.push(ingredient_group);

        wprm_admin.text_import.ingredients = [];

        // Parse ingredients
        var data = {
            action: 'wprm_parse_ingredients',
            security: wprm_modal.nonce,
            ingredients: ingredients
        };

        wprm_admin.text_import_waiting = true;
        jQuery.post(wprm_modal.ajax_url, data, function(out) {
            wprm_admin.text_import_waiting = false;
            if (out.success) {
                wprm_admin.text_import.ingredients = out.data.ingredients;
            }
        }, 'json');

        jQuery('#import-text-highlight-sandbox').show();

        wprm_admin.text_import_step = 'instructions';
    } else if(wprm_admin.text_import_step == 'instructions') {
        var instructions = wprm_admin.text_import_highlighter.getHighlights();
        wprm_admin.text_import.instructions_raw = instructions;
        
        jQuery('#import-text-instruction-groups').html('');
        for(var i = 0, l = instructions.length; i<l; i++) {
            var text = jQuery(instructions[i]).text().trim();
            text = text.replace(/^(\d\.\s+|[a-z]\)\s+|•\s+|[A-Z]\.\s+|[IVX]+\.\s+)/g, "");
            var instruction = '<div class="import-text-instruction"><input type="checkbox" id="instruction-' + i + '"> ' + '<label for="instruction-' + i + '">' + text + '</label></div>';
            jQuery('#import-text-instruction-groups').append(instruction);
        }
        jQuery('.import-text-group-warning').hide();

        if(instructions.length == 0) {
            jQuery('#import-text-highlight-sandbox').show();
            wprm_admin.text_import.instructions = [];
            wprm_admin.text_import_step = 'notes';
        } else {
            jQuery('#import-text-highlight-sandbox').hide();
            wprm_admin.text_import_step = 'instruction-groups';
        }
    } else if(wprm_admin.text_import_step == 'instruction-groups') {
        var instructions = [],
            instruction_group = {
                name: '',
                instructions: []
        };

        jQuery('#import-text-instruction-groups').find('.import-text-instruction').each(function() {
            var is_instruction_group = jQuery(this).find('input').is(':checked'),
                instruction = jQuery(this).find('label').text();

            if(is_instruction_group) {
                instructions.push(instruction_group);

                instruction_group = {
                    name: instruction,
                    instructions: []
                }
            } else {
                instruction_group.instructions.push({text: instruction});
            }
        });
        instructions.push(instruction_group);

        wprm_admin.text_import.instructions = instructions;

        jQuery('#import-text-highlight-sandbox').show();

        wprm_admin.text_import_step = 'notes';
    } else if(wprm_admin.text_import_step == 'notes') {
        wprm_admin.text_import.notes = wprm_admin.get_highlighted_text();

        jQuery('#import-text-highlight-sandbox').hide();
        jQuery('.wprm-button-import-text-reset').attr('disabled', 'disabled');
        jQuery('.wprm-button-import-text-clear').attr('disabled', 'disabled');
        jQuery('.wprm-button-import-text-next').attr('disabled', 'disabled');
        
        if(wprm_admin.text_import_waiting) {
            wprm_admin.text_import_step = 'waiting';
            wprm_admin.text_import_waiting_check();
        } else {
            jQuery('.wprm-button-import-text-reset').removeAttr('disabled');
            wprm_admin.import_recipe();
            wprm_admin.text_import_step = 'finished';
        }
    } else if(wprm_admin.text_import_step == 'waiting') {
        if(!wprm_admin.text_import_waiting) {
            jQuery('.wprm-button-import-text-reset').removeAttr('disabled');
            wprm_admin.import_recipe();
            wprm_admin.text_import_step = 'finished';
        }
    }

    jQuery('.import-text-step').hide();
    jQuery('#import-text-step-' + wprm_admin.text_import_step).show();
    wprm_admin.text_import_highlighter.removeHighlights();
};

wprm_admin.text_import_waiting_check = function() {
    if(wprm_admin.text_import_waiting) {
        setTimeout(wprm_admin.text_import_waiting_check, 200);
    } else {
        wprm_admin.btn_text_import_next();
    }
};

wprm_admin.get_highlighted_text = function() {
    var highlight_parts = wprm_admin.text_import_highlighter.getHighlights();
    var highlight = '';

    for(var i = 0, l = highlight_parts.length; i<l; i++) {
        if(i > 0) {
            highlight += ' ';
        }
        highlight += jQuery(highlight_parts[i]).text().trim();
    }

    return highlight;
};

wprm_admin.import_recipe = function() {
    if(wprm_admin.text_import.name) {
        jQuery('#wprm-recipe-name').val(wprm_admin.text_import.name);
    }

    if(wprm_admin.text_import.summary) {
        wprm_admin.rich_editor.setContent(wprm_admin.text_import.summary);
    }

    if(wprm_admin.text_import.notes) {
        if (typeof tinyMCE !== 'undefined' && tinyMCE.get('wprm_recipe_notes') && !tinyMCE.get('wprm_recipe_notes').isHidden()) {
			tinyMCE.get('wprm_recipe_notes').focus(true);
			tinyMCE.activeEditor.setContent(wprm_admin.text_import.notes);
		} else {
			jQuery('#wprm_recipe_notes').val(wprm_admin.text_import.notes);
		}
    }

    if(wprm_admin.text_import.instructions.length > 0) {
        wprm_admin.set_recipe_instruction_fields(wprm_admin.text_import.instructions);
    }
    
    if(wprm_admin.text_import.ingredients.length > 0) {
        wprm_admin.set_recipe_ingredient_fields(wprm_admin.text_import.ingredients);
    }
};

jQuery(document).ready(function($) {
    jQuery('#import-text-input-recipe').on('keydown change', function() {
        wprm_admin.start_text_import();
    });

    jQuery('.wprm-button-import-text-reset').on('click', function() {
        if(confirm(wprm_modal.text.import_text_reset)) {
            wprm_admin.btn_text_import_reset();
        }
    });

    jQuery('.wprm-button-import-text-clear').on('click', function() {
        wprm_admin.btn_text_import_clear(false);
    });

    jQuery('.wprm-button-import-text-next').on('click', function() {
        wprm_admin.btn_text_import_next();
    });

    jQuery('.import-text-input-groups').on('change', 'input', function() {
        var groups = jQuery(this).parents('.import-text-input-groups');

        if(groups.find('input').length == groups.find('input:checked').length) {
            jQuery('.import-text-group-warning').show();
        }
    });
});