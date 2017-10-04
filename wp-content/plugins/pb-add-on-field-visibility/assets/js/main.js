/**
 * Function that adds the visibility and user role visibility field properties to the global fields object
 * declared in assets/js/jquery-manage-fields-live-change.js
 *
 */
function updateFieldsVisibility() {
    if (typeof fields == "undefined") {
        return false;
    }

    //The fields we want the new properties to show - they must match the ones in index.php
    var updateFields = [ 'Checkbox', 'Checkbox (Terms and Conditions)', 'Radio', 'Datepicker', 'Timepicker', 'Colorpicker', 'Input', 'Number', 'Textarea', 'Phone', 'Select', 'Select (Multiple)', 'Select (Country)', 'Select (Timezone)', 'Select (Currency)', 'Select (User Role)', 'Upload', 'Avatar', 'WYSIWYG', 'Heading', 'HTML' ];

    for( var i = 0; i < updateFields.length; i++ ) {
        fields[ updateFields[i] ]['show_rows'].push( '.row-visibility' );
        fields[ updateFields[i] ]['show_rows'].push( '.row-user-role-visibility' );
        fields[ updateFields[i] ]['show_rows'].push( '.row-location-visibility' );
    }
}

function updateFieldsToShow() {
    fields_to_show.push('.row-visibility');
    fields_to_show.push('.row-user-role-visibility');
    fields_to_show.push('.row-location-visibility');
}

jQuery( function() {
    updateFieldsVisibility();
    updateFieldsToShow();

    wppb_hide_properties_for_already_added_fields( '#container_wppb_manage_fields' );
});