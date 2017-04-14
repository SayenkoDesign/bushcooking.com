var wprm = wprm || {};

jQuery(document).ready(function($) {
		if (jQuery('.wprm-recipe-container').length > 0 || jQuery('body.wp-admin').length > 0) {
				jQuery('.comment-form-wprm-rating').show();

				var color = jQuery('.comment-form-wprm-rating').data('color');

				jQuery(document).on('mouseenter', '.comment-form-wprm-rating .wprm-rating-star', function() {
						jQuery(this).prevAll().andSelf().each(function() {
								jQuery(this).find('polygon').css('fill', color);
						});
						jQuery(this).nextAll().each(function() {
								jQuery(this).find('polygon').css('fill', 'none');
						});
				});
				jQuery(document).on('mouseleave', '.comment-form-wprm-rating .wprm-rating-star', function() {
						jQuery(this).siblings().andSelf().each(function() {
								jQuery(this).find('polygon').css('fill', '');
						});
				});
				jQuery(document).on('click', '.comment-form-wprm-rating .wprm-rating-star', function() {
						var star = jQuery(this),
								rating = star.data('rating'),
								input = star.parents('.comment-form-wprm-rating').find('#wprm-comment-rating'),
								current_rating = input.val();

						if (current_rating == rating) {
								input.val('');

								jQuery(this).siblings('').andSelf().each(function() {
										jQuery(this).removeClass('rated');
								});
						} else {
								input.val(rating);

								jQuery(this).prevAll().andSelf().each(function() {
										jQuery(this).addClass('rated');
								});
								jQuery(this).nextAll().each(function() {
										jQuery(this).removeClass('rated');
								});
						}
				});
		}
});
