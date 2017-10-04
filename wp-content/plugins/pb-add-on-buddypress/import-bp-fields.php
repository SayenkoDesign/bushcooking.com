<?php

/**
 * Register Import page.
 *
 * Keep it hidden.
 *
 * @since 1.0.0
 *
 * @return null
 */
function wppb_bdp_register_import_page(){
    add_submenu_page(
        'WPPBHidden',
        'Import BuddyPress Fields',
        'WPPBHidden',
        'manage_options',
        'profile-builder-bp-import-fields',
        'wppb_bdp_import_page_content'
    );

}
add_action( 'admin_menu', 'wppb_bdp_register_import_page' );


/**
 * Import page content.
 *
 * @since 1.0.0
 *
 * @return null
 */
function wppb_bdp_import_page_content(){
    echo __('<h2>Import BuddyPress Fields to Profile Builder</h2>', 'profile-builder-buddypress-add-on' );

    /*
     *  Check if BuddyPress plugin is active before doing anything
     */
    if ( !( ( in_array( 'buddypress/bp-loader.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) || ( is_plugin_active_for_network('buddypress/bp-loader.php') ) ) ) {
        echo __( 'BuddyPress is not installed and active. Import aborted!', 'profile-builder-buddypress-add-on' );
        return ;
    }
    if ( ! isset( $_GET['wppb_bdp_import_fields'] ) ) {
        echo __('Importing BuddyPress Field Settings to Profile Builder...<br><br>', 'profile-builder-buddypress-add-on' );
        wppb_bdp_import_field_settings();
        $url = add_query_arg( array(
            'page'                      => 'profile-builder-bp-import-fields',
            'wppb_bdp_import_fields'    => 'yes',
        ), site_url('wp-admin/admin.php') );
        echo "<meta http-equiv='refresh' content='0; url={$url}' />";
        echo "<br> " . __( 'If the page does not redirect automatically', 'profile-builder-buddypress-add-on' ) . " <a href='$url' >" . __( 'click here', 'profile-builder-buddypress-add-on' ) . ".</a>";
    }else {
        echo __('Importing User entries BuddyPress Fields to Profile Builder...<br><br>', 'profile-builder-buddypress-add-on');
        wppb_bdp_iterate_over_users();
        echo __('Done.', 'profile-builder-buddypress-add-on' ) . '<br><br><a href="' . site_url('wp-admin/admin.php?page=profile-builder-buddypress') . '"> <input type="button" name="wppb_buddypress_page" value="' . __('Back to BuddyPress Settings page', 'profile-builder-buddypress-add-on') . '" class="button-primary"></a>';
    }
}


/**
 * Importing BuddyPress field settings
 *
 * @since 1.0.0
 *
 * @return null
 */
function wppb_bdp_import_field_settings(){
    if ( ! function_exists( 'bp_xprofile_get_groups' ) ) {
        return;
    }
    $args = array(
        'fetch_fields'          => true,
        'hide_empty_groups'     => true,
        );

    $groups = bp_xprofile_get_groups($args);
    $bp_group_ids_already_imported = wppb_bdp_get_imported_bp_field_ids( 'bp-imported-group-heading-id' );
    $bp_field_ids_already_imported = wppb_bdp_get_imported_bp_field_ids( 'bp-imported-field-id' );

    foreach( $groups as $group ){

        // insert heading field
        if ( ! in_array( $group->id, $bp_group_ids_already_imported ) ) {
            wppb_bdp_insert_field( array(
                'field' => 'Heading',
                'field-title' => $group->name,
                'heading-tag' => 'h4',
                'bp-imported-group-heading-id' => $group->id
            ));
            echo 'Imported group Heading "' . esc_attr( $group->name ) . '"<br><br>';
        }
        foreach ( $group->fields as $bp_field ) {
            if ( ! in_array( $bp_field->id, $bp_field_ids_already_imported ) ) {
                $field = wppb_bdp_convert_field( $bp_field );
                wppb_bdp_insert_field( $field );
                echo 'Imported field "' . esc_attr( $field['field-title'] ) . '"<br><br>';
            }
        }
    }
}


/**
 * Returns array of BuddyPress fields already imported
 *
 * @since 1.0.0
 *
 * @param $bp_imported_id_string
 *
 * @return array
 */
function wppb_bdp_get_imported_bp_field_ids( $bp_imported_id_string ){
    $manage_fields = get_option( 'wppb_manage_fields', 'not_set' );
    $bp_imported_field_ids = array();
    if ( $manage_fields == 'not_set' ){
        return $bp_imported_field_ids;
    }

    foreach ( $manage_fields as $field ) {
        if ( !empty ( $field[$bp_imported_id_string] ) ) {
            $bp_imported_field_ids[] = $field[$bp_imported_id_string];
        }
    }
    return $bp_imported_field_ids;
}


/**
 * Insert field with received settings
 *
 * @since 1.0.0
 *
 * @param $field_args
 *
 * @return null
 */
function wppb_bdp_insert_field($field_args){
    // Parse arguments
    $field = wp_parse_args( $field_args, array(
        'field'                     => '',
        'field-title'               => '',
        'meta-name'                 => wppb_get_meta_name(),
        'id'                        => wppb_get_unique_id(),
        'description'               => '',
        'default-value'             => '',
        'default-content'           => '',
        'min-number-value'          => '',
        'max-number-value'          => '',
        'labels'                    => '',
        'row-count'                 => '5',
        'date-format'               => 'mm/dd/yy',
        'required'                  => 'No',
        'overwrite-existing'        => 'No',
        'allowed-image-extensions'  => '.*',
        'allowed-upload-extensions' => '.*',
        'avatar-size'               => '100',
        'terms-of-agreement'        => '',
        'options'                   => '',
        'public-key'                => '',
        'private-key'               => '',
        'default-option'            => '',
        'default-options'           => '',
    ) );

    $manage_fields = get_option('wppb_manage_fields');
    $manage_fields[] = $field;

    update_option( 'wppb_manage_fields', $manage_fields );
}


/**
 * Convert BP field settings to PB field settings
 *
 * @since 1.0.0
 *
 * @param $bp_field
 *
 * @return array
 */
function wppb_bdp_convert_field( $bp_field ){
    $field = array();
    $field['bp-imported-field-id'] = $bp_field->id;
    $field['field-title'] = $bp_field->name;
    $field['description'] = $bp_field->description;
    $field['required'] = ( $bp_field->is_required == 1 ) ?  'Yes' : 'No';
    $field['bdp-default-visibility'] = $bp_field->default_visibility;
    $field['bdp-allow-custom-visibility'] = $bp_field->allow_custom_visibility;

    switch ( $bp_field->type ) {
        case 'checkbox':
            $field['field'] = 'Checkbox';
            $field['options'] = wppb_bdp_stringify_array_options( $bp_field->get_children() );
            $field['default-options'] = wppb_bdp_stringify_array_default_options( $bp_field->get_children() );
            break;

        case 'selectbox':
            $field['field'] = 'Select';
            $field['options'] = wppb_bdp_stringify_array_options( $bp_field->get_children() );
            $field['default-option'] = wppb_bdp_stringify_array_default_options( $bp_field->get_children() );
            break;

        case 'multiselectbox':
            $field['field'] = 'Select (Multiple)';
            $field['options'] = wppb_bdp_stringify_array_options( $bp_field->get_children() );
            $field['default-options'] = wppb_bdp_stringify_array_default_options( $bp_field->get_children() );
            break;

        case 'radio':
            $field['field'] = 'Radio';
            $field['options'] = wppb_bdp_stringify_array_options( $bp_field->get_children() );
            $field['default-option'] = wppb_bdp_stringify_array_default_options( $bp_field->get_children() );
            break;

        case 'datebox':
            $field['field'] = 'Datepicker';
            break;

        case 'textarea':
            $field['field'] = 'WYSIWYG';
            break;

        case 'number':
            $field['field'] = 'Number';
            break;

        case 'textbox':
            $field['field'] = 'Input';
            break;

        case 'url':
            $field['field'] = 'Input';
            break;
    }

    return $field;
}


/**
 * Transform field option labels from array to string
 *
 * @since 1.0.0
 *
 * @param $options_array
 *
 * @return string
 */
function wppb_bdp_stringify_array_options( $options_array ){
    $option_names = array();
    foreach ( $options_array as $option ){
        $option_names[] = $option->name;
    }
    return implode ( ',', $option_names );
}


/**
 * Transform field default options from array to string
 *
 * @since 1.0.0
 *
 * @param $options_array
 *
 * @return string
 */
function wppb_bdp_stringify_array_default_options( $options_array ){
    $default_options = array();
    foreach ( $options_array as $option ) {
        if ( $option->is_default_option ) {
            $default_options[] = $option->name;
        }
    }
    return implode ( ',', $default_options );
}


/**
 * Iterate over set of users
 *
 * @since 1.0.0
 *
 * @return null
 */
function wppb_bdp_iterate_over_users(){
    if ( !isset( $_GET['wppb_bdp_import_fields'] ) || $_GET['wppb_bdp_import_fields'] != 'yes' ) {
        return;
    }
    $step_size = apply_filters( 'wppb_bdp_user_field_import_step_size', 50 );
    $offset = 0;
    if ( ! empty( $_GET['offset'] ) && is_numeric ( $_GET['offset'] ) ) {
        $offset = $_GET['offset'];
    }

    if ( ! empty( $_GET['total_users_count'] ) && is_numeric ( $_GET['offset'] ) ) {
        $total_count = $_GET['total_users_count'];
    }else{
        $result = count_users();
        $total_count = $result['total_users'];
    }
    $args = array(
        'orderby'      => 'id',
        'offset'       => $offset,
        'number'       => $step_size,
        'fields'       => 'id',
    );
    $users = get_users( $args );

    if ( empty($users) ){
        return;
    }

    $interval_end = ( $total_count  > ($offset + $step_size + 1 ) ) ? $offset + $step_size + 1 : $total_count;
    echo '<strong> Users ' . ($offset + 1) . ' - ' . $interval_end . ' out of ' . $total_count . '</strong><br><br>';

    $manage_fields = get_option( 'wppb_manage_fields' );
    foreach( $users as $user_id ){
        wppb_bdp_import_user_field_entries( $user_id, $manage_fields );
    }

    $url = add_query_arg( array(
        'page'                      => 'profile-builder-bp-import-fields',
        'wppb_bdp_import_fields'    => 'yes',
        'total_users_count'         => $total_count,
        'offset'                    => ($offset + $step_size),
    ), site_url('wp-admin/admin.php') );
    echo "<meta http-equiv='refresh' content='0; url={$url}' />";
    echo "<br> " . __( 'If the page does not redirect automatically', 'profile-builder-buddypress-add-on' ) . " <a href='$url' >" . __( 'click here', 'profile-builder-buddypress-add-on' ) . ".</a>";
    exit;
}


/**
 * Import user field entries and visiblity options
 *
 * @since 1.0.0
 * @param $user_id
 * @param $manage_fields
 *
 * @return null
 */
function wppb_bdp_import_user_field_entries( $user_id, $manage_fields ){
    if ( ! function_exists( 'xprofile_get_field_data' ) ){
        return;
    }
    foreach ( $manage_fields as $field ){
        if ( empty ( $field['bp-imported-field-id'] ) ) {
            continue;
        }

        $bp_data = xprofile_get_field_data( $field['bp-imported-field-id'], $user_id );
        if ( empty( $bp_data ) ){
            continue;
        }
        $existing_user_meta = get_user_meta( $user_id, $field['meta-name'], true );
        if ( ! empty( $existing_user_meta ) ){
            // do not overwrite existing data
            continue;
        }

        switch ( $field['field'] ) {
            case 'Checkbox':
            case 'Select (Multiple)':
                $bp_data = implode(',', $bp_data);
                update_user_meta($user_id, esc_attr( $field['meta-name'] ), $bp_data);
                break;
            case 'Datepicker':
                $new_date_format = date('m/d/Y', strtotime($bp_data));
                $bp_data = ($new_date_format) ? $new_date_format : $bp_data;
                break;

            case 'Input':
                if ( function_exists( 'xprofile_get_field' ) ) {
                    $bp_field = xprofile_get_field($field['bp-imported-field-id']);
                    if ($bp_field->type == 'url') {


                        // get href from anchor if original field was an url
                        $html = wppb_bdp_str_get_html($bp_data);
                        if ( is_object( $html ) ) {
                            $anchors = $html->find('a');
                            foreach ($anchors as $anchor) {
                                if (isset($anchor->href)) {
                                    $bp_data = $anchor->href;
                                    break;
                                }
                            }
                        }
                    }
                }
                break;
        }

        update_user_meta($user_id, esc_attr( $field['meta-name'] ), $bp_data);

        // update visibility option for this field
        if ( function_exists( 'xprofile_get_field_visibility_level' ) ){
            $visibility_level = xprofile_get_field_visibility_level( $field['bp-imported-field-id'], $user_id );
            if ( ! empty( $visibility_level ) ) {
                $visibility_option = get_user_meta( $user_id, WPPB_BDP_VISIBILITY_OPTION_NAME, true );
                if ( empty ($visibility_option )) {
                    $visibility_option = array();
                }
                $visibility_option[$field['id']] = $visibility_level;

                update_user_meta( $user_id, WPPB_BDP_VISIBILITY_OPTION_NAME, $visibility_option );
            }
        }
    }

    if ( function_exists( 'bp_get_user_last_activity' ) ) {
        $last_activity = bp_get_user_last_activity($user_id);
        if (!empty($last_activity)) {
            update_user_meta($user_id, 'wppb_bdp_last_activity', $last_activity);
        }
    }
}
