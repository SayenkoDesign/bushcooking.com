<?php
    /*
    Plugin Name: Profile Builder - Field Visibility Add-On
    Plugin URI: http://www.cozmoslabs.com/wordpress-profile-builder/
    Description: Extends the functionality of Profile Builder by allowing you to change visibility options for the extra fields
    Version: 1.1.3
    Author: Cozmoslabs, Mihai Iova
    Author URI: http://www.cozmoslabs.com/
    License: GPL2

    == Copyright ==
    Copyright 2014 Cozmoslabs (www.cozmoslabs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
    */


    /*
     * Define plugin path and include dependencies
     *
     */
    define('WPPBFV_PLUGIN_DIR', plugin_dir_path(__FILE__));
    define('WPPBFV_PLUGIN_URL', plugin_dir_url(__FILE__));


    /*
     * Check for updates
     *
     */
    if (file_exists(WPPBFV_PLUGIN_DIR . '/update/update-checker.php')) {
        include_once(WPPBFV_PLUGIN_DIR . '/update/update-checker.php');

        //we don't know what version we have installed so we need to check both
        $localSerial = get_option('wppb_profile_builder_pro_serial');
        if( empty( $localSerial ) )
            $localSerial = get_option('wppb_profile_builder_hobbyist_serial');

        $wppb_fv_update = new wppb_PluginUpdateChecker('http://updatemetadata.cozmoslabs.com/?localSerialNumber=' . $localSerial . '&uniqueproduct=CLPBFV', __FILE__, 'wppb-fv-add-on');
    }


    /*
     * Function that adds the visibility properties to the extra fields when
     * activating the add-on/plugin
     *
     * @since v.1.0.0
     */
    function wppb_field_visibility_activation() {
        $manage_fields = get_option( 'wppb_manage_fields' );
        $filter_fields = wppb_field_visibility_get_extra_fields();

        foreach( $manage_fields as $key => $field ) {
            if( in_array( $field['field'], $filter_fields ) ) {
                if( !isset( $field['visibility'] ) ) {
                    $manage_fields[$key]['visibility'] = 'all';
                }

                if( !isset( $field['user-role-visibility'] ) ) {
                    $manage_fields[$key]['user-role-visibility'] = 'all';
                }

                if( !isset( $field['location-visibility'] ) ) {
                    $manage_fields[$key]['location-visibility'] = 'all';
                }
            }
        }

        update_option( 'wppb_manage_fields', $manage_fields);
    }
    register_activation_hook( __FILE__, 'wppb_field_visibility_activation' );

    /*
     * Function that enqueues the necessary scripts
     *
     * @since v.1.0.0
     */
    function wppb_field_visibility_scripts_and_styles() {
        wp_enqueue_script( 'wppb-field-visibility', plugin_dir_url(__FILE__) . 'assets/js/main.js', array( 'jquery', 'wppb-manage-fields-live-change' ) );
        wp_enqueue_style( 'wppb-field-visibility', plugin_dir_url(__FILE__) . 'assets/css/style.css' );
    }
    add_action( 'admin_enqueue_scripts', 'wppb_field_visibility_scripts_and_styles' );


    /*
     * Function that returns the fields that will have visibility properties
     * must match the ones in assets/main.js
     *
     * @since v.1.0.0
     *
     * @return array
     */
    function wppb_field_visibility_get_extra_fields() {
        return array(
            'checkbox' => 'Checkbox',
            'toa' => 'Checkbox (Terms and Conditions)',
            'radio' => 'Radio',
            'datepicker' => 'Datepicker',
            'timepicker' => 'Timepicker',
            'colorpicker' => 'Colorpicker',
            'input' => 'Input',
            'number' => 'Number',
            'textarea' => 'Textarea',
            'phone' => 'Phone',
            'select' => 'Select',
            'multiple_select' => 'Select (Multiple)',
            'country_select' => 'Select (Country)',
            'timezone_select' => 'Select (Timezone)',
            'currency_select' => 'Select (Currency)',
            'user_role' => 'Select (User Role)',
            'upload' => 'Upload',
            'avatar' => 'Avatar',
            'wysiwyg' => 'WYSIWYG',
            'heading' => 'Heading',
            'html' => 'HTML',
            'select2' => 'Select2',
            'select2_multiple' => 'Select2 (Multiple)',
        );
    }


    /*
     * Function adds the visibility and user role visibility radio and checkbox options in the field property from Manage Fields
     *
     * @since v.1.0.0
     *
     * @param array $fields - The current field properties
     *
     * @return array        - The field properties that now include the visibility and user role visibility properties
     */
    function wppb_field_visibility_properties_manage_field( $fields ) {
        global $wp_roles;

        $user_roles = array( '%All%all' );
        foreach( $wp_roles->roles as $user_role_slug => $user_role )
            array_push( $user_roles, '%' . $user_role['name'] . '%' . $user_role_slug );

        $visibility_properties = array(
            array( 'type' => 'select', 'slug' => 'visibility', 'title' => __( 'Visibility', 'profile-builder-field-visibility-add-on' ), 'options' => array( '%All%all', '%Admin Only%admin_only', '%User Locked%user_locked' ), 'default' => 'all', 'description' => __( "<strong>Admin Only</strong> field is visible only for administrators. <strong>User Locked</strong> field is visible for both administrators and users, but only administrators have the capability to edit it.", 'profile-builder-field-visibility-add-on' ) ),
            array( 'type' => 'checkbox', 'slug' => 'user-role-visibility', 'title' => __( 'User Role Visibility', 'profile-builder-field-visibility-add-on' ), 'options' => $user_roles, 'default' => 'all', 'description' => __( "Select which user roles see this field", 'profile-builder-field-visibility-add-on' ) ),
            array( 'type' => 'checkbox', 'slug' => 'location-visibility', 'title' => __( 'Location Visibility', 'profile-builder-field-visibility-add-on' ), 'options' => array( '%All%all', '%WordPress Edit Profile Form (back-end)%back_end', '%Register Forms Front-End%register', '%Edit Profile Forms Front-End%edit_profile'), 'default' => 'all', 'description' => __( "Select the locations you wish the field to appear", 'profile-builder-field-visibility-add-on' ) )
        );

        foreach( $visibility_properties as $field_property )
            array_push( $fields, $field_property );

        return $fields;
    }
    add_filter( 'wppb_manage_fields', 'wppb_field_visibility_properties_manage_field' );


    /*
     * Function that adds a column to the manage fields header for the visibility option
     *
     * @since v.1.0.0
     *
     */
    function wppb_manage_fields_header_add_visibility( $list_header ){
        return '<thead><tr><th class="wck-number">#</th><th class="wck-content">'. __( '<pre>Title</pre><pre>Type</pre><pre>Meta Name</pre><pre class="wppb-mb-head-required">Required</pre><pre class="wppb-mb-head-visibility"></pre>', 'profile-builder-field-visibility-add-on' ) .'</th><th class="wck-edit">'. __( 'Edit', 'profile-builder-field-visibility-add-on' ) .'</th><th class="wck-delete">'. __( 'Delete', 'profile-builder-field-visibility-add-on' ) .'</th></tr></thead>';
    }
    add_action( 'wck_metabox_content_header_wppb_manage_fields', 'wppb_manage_fields_header_add_visibility', 11 );


    /*
     * Function that changes the displayed value for the visibility property of the field
     * to a representative icon
     *
     * @since v.1.0.0
     *
     * @param string $display_value     - The saved value of the field in <pre> tag
     *
     */
    function wppb_change_display_value_to_icon_visibility( $display_value ) {
        $visibility = strtolower( str_replace( ' ', '_', str_replace( '<pre>', '', str_replace( '</pre>', '', $display_value ) )) );

        if( $visibility == 'all' )
            return;

        if( $visibility == 'admin_only' )
            return '<span title="' . __( 'This field is visible only for administrators.', 'profile-builder-field-visibility-add-on' ) . '" class="wppb-manage-fields-dashicon dashicons dashicons-visibility"></span>';

        if( $visibility == 'user_locked' )
            return '<span title="' . __( 'This field is visible for both administrators and users, but only administrators have the capability to edit it.', 'profile-builder-field-visibility-add-on' ) . '" class="wppb-manage-fields-dashicon dashicons dashicons-lock"></span>';

        return $display_value;
    }
    add_filter( 'wck_pre_displayed_value_wppb_manage_fields_element_visibility', 'wppb_change_display_value_to_icon_visibility' );


    /*
     * Function that changes the displayed value for the user role visibility property of the field
     * to a representative icon
     *
     * @since v.1.0.0
     *
     * @param string $display_value     - The saved value of the field in <pre> tag
     *
     */
    function wppb_change_display_value_to_icon_user_role_visibility( $display_value ) {
        $visibility_string = str_replace( '<pre>', '', str_replace( '</pre>', '', $display_value ) );
        $visibility = explode(', ', $visibility_string);

        if( in_array( 'all', $visibility ) )
            return;
        elseif( !empty( $visibility[0] ) )
            return '<span title="' . sprintf( __( 'This field is visible only for the following user roles: %1$s', 'profile-builder-field-visibility-add-on' ), $visibility_string ) . '" class="wppb-manage-fields-dashicon dashicons dashicons-admin-users"></span>';

        return $display_value;
    }
    add_filter( 'wck_pre_displayed_value_wppb_manage_fields_element_user-role-visibility', 'wppb_change_display_value_to_icon_user_role_visibility' );


    /*
     * Function that changes the displayed value for the location visibility property of the field
     * to a representative icon
     *
     * @since v.1.0.1
     *
     * @param string $display_value     - The saved value of the field in <pre> tag
     *
     */
    function wppb_change_display_value_to_icon_location_visibility( $display_value ) {
        $form_locations = array( 'register', 'edit_profile', 'back_end' );

        $is_visible_all_locations = true;

        $visibility_locations_string = str_replace( '<pre>', '', str_replace( '</pre>', '', $display_value ) );
        $visibility_locations = explode(', ', $visibility_locations_string);

        $form_locations_not_shown_in = array_diff( $form_locations, $visibility_locations );

        if( !empty($form_locations_not_shown_in) ) {
            $is_visible_all_locations = false;
        }

        foreach( $visibility_locations as $key => $visibility_location ) {

            if( $visibility_location == 'back_end' )
                $visibility_locations[$key] = 'WordPress Edit Profile Form (back-end)';

            if( $visibility_location == 'register' )
                $visibility_locations[$key] = 'Register Forms Front-End';

            if( $visibility_location == 'edit_profile' )
                $visibility_locations[$key] = 'Edit Profile Forms Front-End';
        }
        $visibility_locations_string = implode( ', ', $visibility_locations );

        if( in_array( 'all', $visibility_locations ) || $is_visible_all_locations == true )
            return;
        elseif( !empty( $visibility_locations[0] ) )
            return '<span title="' . sprintf( __( 'This field is visible only in the following locations: %1$s', 'profile-builder-field-visibility-add-on' ), $visibility_locations_string ) . '" class="wppb-manage-fields-dashicon dashicons dashicons-location"></span>';

        return $display_value;
    }
    add_filter( 'wck_pre_displayed_value_wppb_manage_fields_element_location-visibility', 'wppb_change_display_value_to_icon_location_visibility' );


    /*
     * Function that handles the visibility of the field
     *
     * @since v.1.0.0
     *
     * @param bool $display_field      - By default true, to continue displaying the field
     * @param array $field             - The current field
     * @param string $form_location    - The location of the form. It can be register, edit_profile and back_end
     * @param string $form_role        - The role that will be attributed by default to new users
     * @param int $user_id
     *
     * @return bool
     */
    function wppb_handle_output_display_state( $display_field, $field, $form_location, $form_role, $user_id ) {

        if( !in_array( $field['field'], wppb_field_visibility_get_extra_fields() ) )
            return $display_field;

        // Handle visibility by location
        if( isset( $field['location-visibility'] ) ) {
            $field_location_visibility = explode(', ', $field['location-visibility'] );

            if( !empty( $field['location-visibility'] ) && !in_array( 'all', $field_location_visibility ) && !in_array( $form_location, $field_location_visibility ) ) {
                return false;
            }
        }

        //Handle visibility for register form
        if( $form_location == 'register' ) {

            // Visibility for User Locked option
            if( !current_user_can( apply_filters( 'wppb_fv_capability_user_locked', 'manage_options' ) ) ) {
                if (isset($field['visibility']) && ($field['visibility'] == 'user_locked')) {
                    $display_field = false;
                }
            }

            if( isset( $field['user-role-visibility'] ) ) {
                $user_roles_visibility = explode(', ', $field['user-role-visibility']);

                if( !in_array( 'all', $user_roles_visibility ) && !empty($field['user-role-visibility']) ) {
                    if (!in_array($form_role, $user_roles_visibility)) {
                        $display_field = false;
                    }
                }
            }
        }

        //Handle visibility for edit profile form in front end
        if( $form_location == 'edit_profile' || $form_location == 'register' ) {

            // Visibility for Admin Only option
            if( !current_user_can( apply_filters( 'wppb_fv_capability_admin_only', 'manage_options' ) ) ) {
                if( isset( $field['visibility'] ) && ( $field['visibility'] == 'admin_only' ) ) {
                    $display_field = false;
                }
            }

        }

        //Handle visibility for edit profile form in back end
        if( $form_location == 'back_end' ) {

            // Visibility for Admin Only option
            if( !current_user_can( apply_filters( 'wppb_fv_capability_admin_only', 'manage_options' ) ) ) {
                if( isset( $field['visibility'] ) && ( $field['visibility'] == 'admin_only' ) ) {
                    $display_field = false;
                }
            }
        }

        //Handle visibility for edit profile form in front end and back end
        if( $form_location == 'edit_profile' || $form_location == 'back_end' ) {

            // Visibility for User Roles
            if( isset( $field['user-role-visibility'] ) ) {
                $user = get_user_by( 'id', $user_id );
                $user_user_roles = $user->roles;
                $user_roles_visibility = explode(', ', $field['user-role-visibility']);

                if( !in_array( 'all', $user_roles_visibility ) && !empty($field['user-role-visibility']) ) {
                    if( !array_intersect( $user_user_roles, $user_roles_visibility ) ) {
                        $display_field = false;
                    }
                }
            }

        }

        return $display_field;
    }

    /*
     * Function that modifies the default HTML of the field if the field is a user locked field
     *
     * @since v.1.0.0
     *
     * @param string $output            - The current HTML
     * @param string $form_location     - The location of the form
     * @param array $field              - The current field
     * @param int $user_id
     * @param $field_check_errors
     * @param $request_data
     * @param $input_value
     *
     * @return string
     */
    function wppb_handle_field_output( $output, $form_location, $field, $user_id, $field_check_errors, $request_data, $input_value = '' ) {

        // Heading fields
        if( strpos( strtolower($field['field']), 'heading' ) !== false )
            return $output;

        // Field output
        $field_output   = '';
        $initial_output = $output;

        // Fields display for User Locked feature
        if( !current_user_can( apply_filters( 'wppb_fv_capability_user_locked', 'manage_options' ) ) ) {
            if (isset($field['visibility']) && ($field['visibility'] == 'user_locked')) {

                // Upload field
                if( 'Upload' == $field['field'] ) {

                    if( !empty( $input_value ) ) {
                        if (is_numeric($input_value)) {
                            $input_value = wp_get_attachment_url($input_value);
                        }
                        $field_output = apply_filters('wppb_field_user_locked_' . $field['meta-name'], '<p><a target="_blank" href="' . esc_attr($input_value) . '">' . __('Get file', 'profile-builder-field-visibility-add-on') . '</a></p>', $input_value);
                    }

                // Textarea
                } elseif( 'WYSIWYG' == $field['field'] || 'Textarea' == $field['field'] ) {

                    $field_output = '<section>' . apply_filters('the_content', $input_value) . '</section>';

                // Select Currency
                } elseif( 'Select (Currency)' == $field['field'] && function_exists( 'wppb_get_currencies' ) ) {

                    $currencies = wppb_get_currencies();

                    if (!empty($currencies[$input_value]))
                        $field_output = '<p>' . esc_attr($currencies[$input_value]) . '</p>';

                // Select User Role
                } elseif( 'Select (User Role)' == $field['field'] ) {

                    global $wp_roles;

                    if( !empty( $wp_roles->roles[$input_value]['name'] ) )
                        $field_output = '<p>' . $wp_roles->roles[$input_value]['name'] . '</p>';

                // Avatar
                } elseif( 'Avatar' == $field['field'] ) {

                    if (!empty($input_value))
                        $field_output = get_avatar($user_id);

                // Checkboxes, multiple selects and radios
                } elseif( 'Checkbox' == $field['field'] || 'Select (Multiple)' == $field['field'] || 'Select2 (Multiple)' == $field['field'] || 'Radio' == $field['field'] ) {

                    // Set the options and labels as arrays
                    $field_options_arr = array_map( 'trim', explode( ',', $field['options'] ) );
                    $field_labels_arr  = array_map( 'trim', explode( ',', $field['labels'] ) );

                    // Radio has a string value, set is as array
                    if( !is_array( $input_value ) )
                        $input_value = array( $input_value );

                    // Check to see if there are labels for the option
                    // if not, use the option names
                    foreach( $input_value as $key => $single_value ) {
                        $indexes = array_keys( $field_options_arr, $single_value );

                        if( !empty( $field_labels_arr[$indexes[0]] ) )
                            $input_value[$key] = $field_labels_arr[$indexes[0]];
                    }

                    // Implode the array for output
                    $input_value = implode( ', ', $input_value );

                    $field_output = '<p>' . esc_attr($input_value) . '</p>';

                } else {

                    $field_output = '<p>' . esc_attr($input_value) . '</p>';

                }

                $initial_output = preg_replace( '/(for|name|id)="[^"]*"/', '', $initial_output );

                $field_output .= '<span style="display: none;">' . $initial_output . '</span>';

            }
        }

        //Handle visibility for edit profile form in front end
        if( $form_location == 'edit_profile' ) {

            // Visibility for User Locked option
            if( !current_user_can( apply_filters( 'wppb_fv_capability_user_locked', 'manage_options' ) ) ) {
                if (isset($field['visibility']) && ($field['visibility'] == 'user_locked')) {
                    $output  = '<label>' . $field['field-title'] . '</label>';
                    $output .= $field_output;
                }
            }

        }

        //Handle visibility for edit profile form in back end
        if( $form_location == 'back_end' ) {

            if( !current_user_can( apply_filters( 'wppb_fv_capability_user_locked', 'manage_options' ) ) ) {
                if (isset($field['visibility']) && ($field['visibility'] == 'user_locked')) {

                    $output = '
                        <table class="form-table">
                            <tr>
                                <th><label for="'.$field['meta-name'].'">'.$field['field-title'].'</label></th>
                                <td>
                                    ' . $field_output . '
                                </td>
                            </tr>
                        </table>';

                }
            }

        }

        return $output;
    }


    /**
     * Checks to see if a user_locked field has values set when saving the form. It should not, and
     * if it does an error is printed for that form, preventing the form values to be saved
     *
     */
    function wppb_fv_check_if_user_locked( $message, $field, $request_data, $form_location, $form_role = '', $user_id = 0 ) {
        if( empty( $field['visibility'] ) )
            return $message;

        if( $field['visibility'] != 'user_locked' )
            return $message;

        if( current_user_can( apply_filters( 'wppb_fv_capability_user_locked', 'manage_options' ) ) )
            return $message;

        if( ! empty( $request_data[ $field['meta-name'] ] ) )
            $message = __( 'You do not have the capabilities necessary to edit this field.', 'profile-builder-field-visibility-add-on' );

        return $message;

    }


    function wppb_fv_check_field_value( $message, $field, $request_data, $form_location, $form_role = '', $user_id = 0 ) {

        if( $field['required'] != 'Yes' )
            return $message;


        /*
         * Skip field validation if field is not in the form
         */
        if( isset( $field['location-visibility'] ) ) {
            $field_location_visibility = explode(', ', $field['location-visibility'] );

            if( !empty( $field['location-visibility'] ) && !in_array( 'all', $field_location_visibility ) && !in_array( $form_location, $field_location_visibility ) ) {
                $message = '';
            }
        }

        /*
         * Skip field validation if field is visible only by admins or is user locked
         */
        if( isset( $field['visibility'] ) ) {

            if( !current_user_can( apply_filters( 'wppb_fv_capability_user_locked', 'manage_options' ) ) && $field['visibility'] == 'user_locked' ) {
                $message = '';
            }

            if( !current_user_can( apply_filters( 'wppb_fv_capability_admin_only', 'manage_options' ) ) && $field['visibility'] == 'admin_only' ) {
                $message = '';
            }

        }


        /*
         * Skip field validation for user roles
         */
        if( $form_location == 'register' ) {

            if( isset( $field['user-role-visibility'] ) ) {
                $user_roles_visibility = explode(', ', $field['user-role-visibility']);

                if( !in_array( 'all', $user_roles_visibility ) && !empty($field['user-role-visibility']) ) {
                    if (!in_array($form_role, $user_roles_visibility)) {
                        $message = '';
                    }
                }
            }

        }

        if( $form_location == 'edit_profile' || $form_location == 'back_end' ) {

            if( isset( $field['user-role-visibility'] ) ) {
                $user = get_user_by( 'id', $user_id );

                if( $user ) {
                    $user_user_roles = $user->roles;
                    $user_roles_visibility = explode(', ', $field['user-role-visibility']);

                    if( !in_array( 'all', $user_roles_visibility ) && !empty($field['user-role-visibility']) ) {
                        if( !array_intersect( $user_user_roles, $user_roles_visibility ) ) {
                            $message = '';
                        }
                    }
                }
            }

        }

        return $message;
    }


    /*
     * Function that adds the necessary filters in order to change the output of the fields
     *
     * @since v.1.0.0
     *
     */
    function wppb_init_field_visibility() {
        $manage_fields = get_option( 'wppb_manage_fields' );
        $filter_fields = wppb_field_visibility_get_extra_fields();

        // add filters for the fields
        foreach( $manage_fields as $field ) {
            foreach( $filter_fields as $filter_field_slug => $filter_field ) {
                add_filter( 'wppb_register_' . $filter_field_slug . '_custom_field_' . $field['id'], 'wppb_handle_field_output', 10 , 6 );
                add_filter( 'wppb_edit_profile_' . $filter_field_slug . '_custom_field_' . $field['id'], 'wppb_handle_field_output', 10 , 7 );
                add_filter( 'wppb_back_end_' . $filter_field_slug . '_custom_field_' . $field['id'], 'wppb_handle_field_output', 10 , 7 );
            }
        }

        foreach( $filter_fields as $filter_field_slug => $filter_field ) {
            add_filter( 'wppb_check_form_field_' . $filter_field_slug, 'wppb_fv_check_field_value', 11, 6 );
            add_filter( 'wppb_check_form_field_' . $filter_field_slug, 'wppb_fv_check_if_user_locked', 11, 6 );
        }

        add_filter( 'wppb_output_display_form_field', 'wppb_handle_output_display_state', 10, 5 );

    }
    add_action( 'init', 'wppb_init_field_visibility' );

    /**
     * Initialize the translation for the Plugin.
     * @since v.1.0
     * @return null
     */
    function wppb_fv_init_translation(){
        $current_theme = wp_get_theme();
        if( !empty( $current_theme->stylesheet ) && file_exists( get_theme_root().'/'. $current_theme->stylesheet .'/local_pb_lang' ) )
            load_plugin_textdomain( 'profile-builder-field-visibility-add-on', false, basename( dirname( __FILE__ ) ).'/../../themes/'.$current_theme->stylesheet.'/local_pb_lang' );
        else
            load_plugin_textdomain( 'profile-builder-field-visibility-add-on', false, basename(dirname(__FILE__)) . '/translation/' );
    }
    add_action( 'init', 'wppb_fv_init_translation', 8 );