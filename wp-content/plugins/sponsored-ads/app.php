<?php
/*
Plugin Name: Sponsored Ads
Description: Display sponsored ads. If none is available default to google adsense ad.
Version: 1.0
License: MIT
Text Domain: aponsored-ads
*/
$sponsored_ad_version = 1.0;

if(!function_exists('acf_add_local_field_group')){
    // @TODO throw an error
    return;
}

// create tables
register_activation_hook(__file__, function() {
    global $wpdb;
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    $charset_collate = $wpdb->get_charset_collate();

    // country table countries
    $table_name = $wpdb->prefix . "ip2nationCountries";
    $sql = <<<SQL
CREATE TABLE $table_name (
  code varchar(4) NOT NULL default '',
  iso_code_2 varchar(2) NOT NULL default '',
  iso_code_3 varchar(3) default '',
  iso_country varchar(255) NOT NULL default '',
  country varchar(255) NOT NULL default '',
  lat float NOT NULL default '0',
  lon float NOT NULL default '0',  
  PRIMARY KEY  (code),
  KEY code (code)
) $charset_collate;
SQL;
    $result = dbDelta($sql);

    // ip table
    $table_name = $wpdb->prefix . "ip2nation";
    $sql = <<<SQL
CREATE TABLE $table_name (
  ip int(11) unsigned NOT NULL default '0',
  country char(2) NOT NULL default '',
  KEY ip (ip)
) $charset_collate;
SQL;
    $result = dbDelta($sql);
});

// install data
register_activation_hook(__file__, function() {
    return;
    global $wpdb;

    // country table
    $table_name = $wpdb->prefix . "ip2nationCountries";
    if (($handle = fopen(__DIR__."/data/ip2nationcountries.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $wpdb->insert(
                $table_name,
                array(
                    'code' => $data[0],
                    'iso_code_2' => $data[1],
                    'iso_code_3' => $data[2],
                    'iso_country' => $data[3],
                    'country' => $data[4],
                    'lat' => $data[5],
                    'lon' => $data[6],
                )
            );
        }
        fclose($handle);
    }

    // ip table
    $table_name = $wpdb->prefix . "ip2nation";
    if (($handle = fopen(__DIR__."/data/ip2nation.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $wpdb->insert(
                $table_name,
                array(
                    'ip' => $data[0],
                    'country' => $data[1],
                )
            );
        }
        fclose($handle);
    }
});

// include acf fields
require_once __DIR__.'/acf.php';

// register post type
add_action('init', function() {
    register_post_type('sponsored_ads', [
        'labels' => [
            'name' => 'Sponsored Ads',
            'singular_name' => 'Sponsored Ad'
        ],
        'description' => __('Sponsored Ads'),
        'public' => false,
        'has_archive' => false,
        'show_ui' => true,
        'hierarchical' => false,
        'supports' => ['title', 'author'],
        'map_meta_cap' => true,
        'menu_icon' => 'dashicons-format-image',
        'menu_position' => 58,
    ]);
});

// add settings page
acf_add_options_page([
    'parent_slug' => 'edit.php?post_type=sponsored_ads',
    'page_title' => 'settings',
    'capability' => 'manage_options',

]);

// add admin styles
add_action('admin_head', function(){
    wp_register_style('sponsored_ads_admin', plugin_dir_url(__FILE__).'sponsored-ads-admin.css', [], false);
    wp_enqueue_style('sponsored_ads_admin');
});

// add google adsense
$adsense_id = get_field('adsense_publisher_id', 'option');
if($adsense_id) {
    add_action('wp_enqueue_scripts', function () use($adsense_id) {
        wp_register_style('sponsored_ads', plugin_dir_url(__FILE__).'sponsored-ads.css', [], false);
        wp_register_script('adsense', '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', [], false, false);
        wp_register_script('sponsored_ads', plugin_dir_url(__FILE__).'sponsored-ads.js', ['adsense', 'jquery'], false, false);
        wp_localize_script('sponsored_ads', 'sponsored_ads', ['id' => $adsense_id]);
        wp_enqueue_script('sponsored_ads');
        wp_enqueue_style('sponsored_ads');
    });
}

// add image size
add_action( 'after_setup_theme', function (){
    add_image_size('sponsored-ad', get_field('ad_width', 'option'), get_field('ad_height', 'option'), true);
    add_image_size('mobile-sponsored-ad', get_field('mobile_ad_width', 'option'), get_field('mobile_ad_height', 'option'), true);
});

// shortcode
add_shortcode('sponsored_ad', function($atts){
    $id = null;
    if($country = sponsored_ad_get_country()) {
        $id = get_field('attached_ad_'.$country->code);
    }
    if(!$id) {
        $id = get_field('attached_ad');
    }

    $atts = shortcode_atts( array(
        'id' => $id ?: 0,
        'class' => '',
    ), $atts );

    if($atts['id']) {
        $post = get_post($atts['id']);
    }

    if(!$atts['id'] || !$post) {
        $ad_content = get_field('field_adsense_code', 'option');
        return '<div class="sponsored-ad default-ad">'.$ad_content.'</div>';
    }

    $largeImage = get_field('field_ad_image', $post->ID);
    $smallImage = get_field('field_mobile_ad_image', $post->ID);

    $url = get_field('field_ad_url', $post->ID);
    return '<div class="sponsored-ad ad '.$atts['class'].'">'
    .'<a href="'.$url.'" target="_blank">'
    .'<img src="'.$largeImage['sizes']['sponsored-ad'].'" alt="'.$largeImage['alt'].'" class="hide-for-small show-for-medium"/>'
    .'<img src="'.$smallImage['sizes']['mobile-sponsored-ad'].'" alt="'.$smallImage['alt'].'" class="hide-for-medium"/>'
    .'</a>'
    .'</div>';
});

function sponsored_ad_get_country() {
    global $wpdb;

    // not escaping REMOTE_ADDR because it is not controlled by a header
    // to be spoofed the attacker would need to control an ISP which is unheard of
    $SQL = <<<SQL
SELECT c.* 
FROM {$wpdb->prefix}ip2nationCountries AS c, {$wpdb->prefix}ip2nation i 
WHERE i.ip < INET_ATON("{$_SERVER['REMOTE_ADDR']}") 
AND c.code = i.country 
ORDER BY i.ip DESC 
LIMIT 0,1
SQL;
    $result = $wpdb->get_results($SQL);

    if(!$result) {
        return false;
    }

    return $result[0];
}