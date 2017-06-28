<?php
global $wpdb;

// ad settings page
$sql = "SELECT code, country FROM {$wpdb->prefix}ip2nationCountries ORDER BY country";
$countries = $wpdb->get_results($sql);
$country_choices = [];
foreach($countries as $country) {
    $country_choices[$country->code] = $country->country;
}
acf_add_local_field_group(array (
    'key' => 'group_ad_settings',
    'title' => 'Settings',
    'fields' => array (
        array (
            'key' => 'field_adsense_publisher_id',
            'label' => 'Adsense Publisher ID',
            'name' => 'adsense_publisher_id',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => 'ca-pub-0000000000000000',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_adsense_code',
            'label' => 'Adsense Code',
            'name' => 'adsense_code',
            'type' => 'textarea',
            'instructions' => 'Place the code for the adsense ad here',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '<p style="font-weight: bold;font-style: italic">'
                .'You have a missing id, invalid id, or you have not set a default ad in the sponsored_ad -> settings page'
                .'</p>',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => 'wpautop',
        ),
        array (
            'key' => 'field_ad_message',
            'label' => 'Sponsored ad image sizes',
            'name' => 'mobile_ad_message',
            'type' => 'message',
            'instructions' => 'Images will need to be <a href="/wp-admin/tools.php?page=regenerate-thumbnails">rebuilt</a> for changes to take effect.',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '100',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
        ),
        array (
            'key' => 'field_ad_size_width',
            'label' => 'Ad width',
            'name' => 'ad_width',
            'type' => 'number',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '25',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 355,
            'placeholder' => '',
        ),
        array (
            'key' => 'field_ad_size_height',
            'label' => 'Ad height',
            'name' => 'ad_height',
            'type' => 'number',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '25',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 310,
            'placeholder' => '',
        ),
        array (
            'key' => 'field_mobile_ad_size_width',
            'label' => 'Mobile ad width',
            'name' => 'mobile_ad_width',
            'type' => 'number',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '25',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 355,
            'placeholder' => '',
        ),
        array (
            'key' => 'field_mobile_ad_size_height',
            'label' => 'Mobile ad height',
            'name' => 'mobile_ad_height',
            'type' => 'number',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '25',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 130,
            'placeholder' => '',
        ),
        array (
            'key' => 'field_ad_countries',
            'label' => 'Countries',
            'name' => 'ad_countries',
            'type' => 'checkbox',
            'instructions' => 'Select countries you want to have enable targeted ads for',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => 'four-column-checklist',
                'id' => '',
            ),
            'layout' => 'horizontal',
            'choices' => $country_choices,
            'default_value' => '',
            'placeholder' => '',
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'acf-options-settings',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

// ad fields
acf_add_local_field_group(array (
    'key' => 'group_ad',
    'title' => 'Sponsored Ad Details',
    'fields' => array (
        array (
            'key' => 'field_ad_details',
            'label' => 'Sponsor',
            'name' => 'ad_sponsor',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_ad_url',
            'label' => 'URL',
            'name' => 'ad_url',
            'type' => 'url',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_ad_image',
            'label' => 'Image',
            'name' => 'ad_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        array (
            'key' => 'field_mobile_ad_image',
            'label' => 'Mobile Image',
            'name' => 'mobile_ad_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'sponsored_ads',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

// attach ad to post
acf_add_local_field_group(array (
    'key' => 'group_attached_ad',
    'title' => 'Sponsored Ad',
    'fields' => array (
        array (
            'key' => 'field_attached_ad',
            'label' => 'Global sponsored ad',
            'name' => 'attached_ad',
            'type' => 'post_object',
            'instructions' => 'Will display this ad if there isn\'t an ad for the users specific country',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array (
                0 => 'sponsored_ads',
            ),
            'taxonomy' => array (
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
            'ui' => 1,
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'recipes',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
$targeted_country_codes = get_field('ad_countries', 'option');
if($targeted_country_codes) {
    $targeted_country_list = '"' . implode($targeted_country_codes, '","') . '"';
    $sql = "SELECT code, country FROM {$wpdb->prefix}ip2nationCountries WHERE code IN($targeted_country_list) ORDER BY country";
    $targeted_countries = $wpdb->get_results($sql);
    foreach ($targeted_countries as $targeted_country) {
        acf_add_local_field([
            'key' => 'field_attached_ad_' . $targeted_country->code,
            'label' => 'Sponsored ad for ' . $targeted_country->country,
            'name' => 'attached_ad_' . $targeted_country->code,
            'parent' => 'group_attached_ad',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'sponsored_ads',
            ),
            'taxonomy' => array(),
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
            'ui' => 1,
        ]);
    }
}
