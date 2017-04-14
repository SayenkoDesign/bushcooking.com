var wprm_admin = wprm_admin || {};

wprm_admin.insert_jump_to_recipe = function(button) {
		var id = parseInt(jQuery('#wprm-recipe-jump-id').val()),
				text = wprm_admin.shortcode_escape(jQuery('#wprm-recipe-jump-text').val()),
				shortcode = '[wprm-recipe-jump';

		if (id > 0) {
				shortcode += ' id="' + id + '"';
		}

		if (text) {
				shortcode += ' text="' + text + '"';
		}

		shortcode += ']';

		wprm_admin.add_text_to_editor(shortcode);
		wprm_admin.close_modal();
};

wprm_admin.insert_print_recipe = function(button) {
		var id = parseInt(jQuery('#wprm-recipe-print-id').val()),
				text = wprm_admin.shortcode_escape(jQuery('#wprm-recipe-print-text').val()),
				shortcode = '[wprm-recipe-print';

		if (id > 0) {
				shortcode += ' id="' + id + '"';
		}

		if (text) {
				shortcode += ' text="' + text + '"';
		}

		shortcode += ']';

		wprm_admin.add_text_to_editor(shortcode);
		wprm_admin.close_modal();
};

wprm_admin.reset_snippets = function(args) {
		jQuery('#wprm-recipe-jump-id').val('0').trigger('change');
		jQuery('#wprm-recipe-jump-text').val('');

		jQuery('#wprm-recipe-print-id').val('0').trigger('change');
		jQuery('#wprm-recipe-print-text').val('');
};