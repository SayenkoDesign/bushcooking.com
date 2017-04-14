var wprm_admin = wprm_admin || {};

jQuery(document).ready(function($) {
	jQuery('.wprm-settings').find('select').select2_wprm();
	jQuery('.wprm-settings').find('.wprm-color').wpColorPicker();
});
