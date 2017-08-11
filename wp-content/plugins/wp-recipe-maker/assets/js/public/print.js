var wprm = wprm || {};

wprm.print_recipe = function(recipe_id, servings, system) {
		var print_window = window.open(wprm_public.home_url + 'wprm_print/' + recipe_id, '_blank');
		print_window.onload = function() {
			print_window.focus();
			print_window.document.title = document.title;
			print_window.history.pushState('', 'Print Recipe', location.href.replace(location.hash,""));
			print_window.wprm.set_print_system(system);
			print_window.wprm.set_print_servings(servings);
			print_window.print();
		};
};

jQuery(document).ready(function($) {
		jQuery('.wprm-recipe-print').on('click', function(e) {
				e.preventDefault();

				var recipe = jQuery(this).parents('.wprm-recipe-container'),
					servings = parseInt(recipe.find('.wprm-recipe-servings').data('servings')),
					system = 1,
					recipe_id = recipe.data('recipe-id');

				if('undefined' !== typeof wprmpuc) {
					system = wprmpuc.get_active_system(recipe);
				}

				wprm.print_recipe(recipe_id, servings, system);
		});
		jQuery('.wprm-print-recipe-shortcode').on('click', function(e) {
				e.preventDefault();

				var recipe_id = jQuery(this).data('recipe-id');
				wprm.print_recipe(recipe_id, false, 1);
		});
});
