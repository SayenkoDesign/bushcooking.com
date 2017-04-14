<?php
/**
 * Responsible for the plugin settings.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Responsible for the plugin settings.
 *
 * @since      1.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Settings {
	/**
	 * Cached version of the plugin settings.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      array    $settings    Array containing the plugin settings.
	 */
	private static $settings = array();

	/**
	 * Defaults for the plugin settings.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      array    $defaults    Default values for unset settings.
	 */
	private static $defaults = array(
		// Appearance.
		'recipe_image_use_featured' => false,
		'recipe_author_display_default' => 'disabled',
		'show_nutrition_label' => false,
		'template_font_size' => '',
		'template_font_header' => '',
		'template_font_regular' => '',
		'template_recipe_image' => '',
		'template_instruction_image' => '',
		'template_color_border' => '#aaaaaa',
		'template_color_background' => '#ffffff',
		'template_color_text' => '#333333',
		'template_color_link' => '#000000',
		'template_color_header' => '#000000',
		'template_color_icon' => '#343434',
		'template_color_comment_rating' => '#343434',
		'template_color_accent' => '#2c3e50',
		'template_color_accent_text' => '#ffffff',
		'template_color_accent2' => '#3498db',
		'template_color_accent2_text' => '#ffffff',
		'comment_rating_position' => 'above',
		'default_recipe_template' => 'simple',
		'default_print_template' => 'clean-print',
		'print_credit' => '',
		// Features.
		'features_manage_access' => 'manage_options',
		'features_import_access' => 'manage_options',
		'features_comment_ratings' => true,
		'features_custom_style' => true,
		// Features Premium.
		'features_adjustable_servings' => true,
	);

	/**
	 * Register actions and filters.
	 *
	 * @since    1.2.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_submenu_page' ), 20 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_post_wprm_settings_appearance', array( __CLASS__, 'form_save_settings_appearance' ) );
		add_action( 'admin_post_wprm_settings_labels', array( __CLASS__, 'form_save_settings_labels' ) );
		add_action( 'admin_post_wprm_settings_features', array( __CLASS__, 'form_save_settings_features' ) );

		add_action( 'wprm_settings_page', array( __CLASS__, 'settings_page' ) );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.2.0
	 */
	public static function enqueue() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wprm-settings', WPRM_URL . 'assets/css/admin/settings.min.css', array(), WPRM_VERSION, 'all' );

		wp_enqueue_script( 'wprm-settings', WPRM_URL . 'assets/js/admin/settings.js', array( 'jquery', 'wp-color-picker' ), WPRM_VERSION, true );
	}

	/**
	 * Add the settings submenu to the WPRM menu.
	 *
	 * @since    1.2.0
	 */
	public static function add_submenu_page() {
		add_submenu_page( 'wprecipemaker', __( 'WPRM Settings', 'wp-recipe-maker' ), __( 'Settings', 'wp-recipe-maker' ), 'manage_options', 'wprm_settings', array( __CLASS__, 'settings_page_template' ) );
	}

	/**
	 * Settings page to output.
	 *
	 * @since    1.5.0
	 * @param		 mixed $sub Sub settings page to display.
	 */
	public static function settings_page( $sub ) {
		if ( 'appearance' === $sub ) {
			require_once( WPRM_DIR . 'templates/admin/settings/appearance.php' );
		} elseif ( 'labels' === $sub ) {
			require_once( WPRM_DIR . 'templates/admin/settings/labels.php' );
		} elseif ( 'features' === $sub ) {
			require_once( WPRM_DIR . 'templates/admin/settings/features.php' );
		}
	}

	/**
	 * Get the template for the settings page.
	 *
	 * @since    1.2.0
	 */
	public static function settings_page_template() {
		require_once( WPRM_DIR . 'templates/admin/settings.php' );
	}

	/**
	 * Get the value for a specific setting.
	 *
	 * @since    1.2.0
	 * @param		 mixed $setting Setting to get the value for.
	 */
	public static function get( $setting ) {
		$settings = self::get_settings();

		if ( isset( $settings[ $setting ] ) ) {
			return $settings[ $setting ];
		} else {
			return self::get_default( $setting );
		}
	}

	/**
	 * Get the default for a specific setting.
	 *
	 * @since    1.7.0
	 * @param	 mixed $setting Setting to get the default for.
	 */
	public static function get_default( $setting ) {
		$defaults = self::get_defaults();
		if ( isset( $defaults[ $setting ] ) ) {
			return $defaults[ $setting ];
		} else {
			return false;
		}
	}

	/**
	 * Get the default settings.
	 *
	 * @since    1.5.0
	 */
	public static function get_defaults() {
		return apply_filters( 'wprm_settings_defaults', self::$defaults );
	}

	/**
	 * Get all the settings.
	 *
	 * @since    1.2.0
	 */
	public static function get_settings() {
		// Lazy load settings.
		if ( empty( self::$settings ) ) {
			self::load_settings();
		}

		return self::$settings;
	}

	/**
	 * Load all the plugin settings.
	 *
	 * @since    1.2.0
	 */
	private static function load_settings() {
		self::$settings = get_option( 'wprm_settings', array() );
	}

	/**
	 * Update the plugin settings.
	 *
	 * @since    1.5.0
	 * @param		 array $settings_to_update Settings to update.
	 */
	public static function update_settings( $settings_to_update ) {
		$settings = self::get_settings();

		if ( is_array( $settings_to_update ) ) {
				$settings = array_merge( $settings, $settings_to_update );
		}

		update_option( 'wprm_settings', $settings );
		self::$settings = $settings;
	}

	/**
	 * Save the appearance settings.
	 *
	 * @since    1.7.0
	 */
	public static function form_save_settings_appearance() {
		if ( isset( $_POST['wprm_settings'] ) && wp_verify_nonce( sanitize_key( $_POST['wprm_settings'] ), 'wprm_settings' ) ) { // Input var okay.
			$recipe_image_use_featured = isset( $_POST['recipe_image_use_featured'] ) && sanitize_key( $_POST['recipe_image_use_featured'] ) ? true : false; // Input var okay.
			$recipe_author_display_default = isset( $_POST['recipe_author_display_default'] ) ? sanitize_text_field( wp_unslash( $_POST['recipe_author_display_default'] ) ) : ''; // Input var okay.
			$show_nutrition_label = isset( $_POST['show_nutrition_label'] ) && sanitize_key( $_POST['show_nutrition_label'] ) ? true : false; // Input var okay.

			$template_font_size = isset( $_POST['template_font_size'] ) ? sanitize_text_field( wp_unslash( $_POST['template_font_size'] ) ) : ''; // Input var okay.
			$template_font_header = isset( $_POST['template_font_header'] ) ? sanitize_text_field( wp_unslash( $_POST['template_font_header'] ) ) : ''; // Input var okay.
			$template_font_regular = isset( $_POST['template_font_regular'] ) ? sanitize_text_field( wp_unslash( $_POST['template_font_regular'] ) ) : ''; // Input var okay.
			$template_recipe_image = isset( $_POST['template_recipe_image'] ) ? sanitize_text_field( wp_unslash( $_POST['template_recipe_image'] ) ) : ''; // Input var okay.
			$template_instruction_image = isset( $_POST['template_instruction_image'] ) ? sanitize_text_field( wp_unslash( $_POST['template_instruction_image'] ) ) : ''; // Input var okay.

			$template_color_border = isset( $_POST['template_color_border'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_border'] ) ) : ''; // Input var okay.
			$template_color_background = isset( $_POST['template_color_background'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_background'] ) ) : ''; // Input var okay.
			$template_color_text = isset( $_POST['template_color_text'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_text'] ) ) : ''; // Input var okay.
			$template_color_link = isset( $_POST['template_color_link'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_link'] ) ) : ''; // Input var okay.
			$template_color_header = isset( $_POST['template_color_header'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_header'] ) ) : ''; // Input var okay.
			$template_color_icon = isset( $_POST['template_color_icon'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_icon'] ) ) : ''; // Input var okay.
			$template_color_accent = isset( $_POST['template_color_accent'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_accent'] ) ) : ''; // Input var okay.
			$template_color_accent_text = isset( $_POST['template_color_accent_text'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_accent_text'] ) ) : ''; // Input var okay.
			$template_color_accent2 = isset( $_POST['template_color_accent2'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_accent2'] ) ) : ''; // Input var okay.
			$template_color_accent2_text = isset( $_POST['template_color_accent2_text'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_accent2_text'] ) ) : ''; // Input var okay.

			$template_color_comment_rating = isset( $_POST['template_color_comment_rating'] ) ? sanitize_text_field( wp_unslash( $_POST['template_color_comment_rating'] ) ) : ''; // Input var okay.
			$comment_rating_position = isset( $_POST['comment_rating_position'] ) ? sanitize_key( $_POST['comment_rating_position'] ) : ''; // Input var okay.

			$default_recipe_template = isset( $_POST['default_recipe_template'] ) ? sanitize_text_field( wp_unslash( $_POST['default_recipe_template'] ) ) : ''; // Input var okay.
			$default_print_template = isset( $_POST['default_print_template'] ) ? sanitize_text_field( wp_unslash( $_POST['default_print_template'] ) ) : ''; // Input var okay.
			$print_credit = isset( $_POST['print_credit'] ) ? wp_kses_post( wp_unslash( $_POST['print_credit'] ) ) : ''; // Input var okay.

			$settings = array();

			$settings['recipe_image_use_featured'] = $recipe_image_use_featured;
			$settings['show_nutrition_label'] = $show_nutrition_label;

			if ( in_array( $recipe_author_display_default, array( 'disabled', 'post_author', 'custom' ) ) ) {
				$settings['recipe_author_display_default'] = $recipe_author_display_default;
			}

			$settings['template_font_size'] = $template_font_size;
			$settings['template_font_header'] = $template_font_header;
			$settings['template_font_regular'] = $template_font_regular;
			$settings['template_recipe_image'] = $template_recipe_image;
			$settings['template_instruction_image'] = $template_instruction_image;

			if ( $template_color_border ) { $settings['template_color_border'] = $template_color_border; }
			if ( $template_color_background ) { $settings['template_color_background'] = $template_color_background; }
			if ( $template_color_text ) { $settings['template_color_text'] = $template_color_text; }
			if ( $template_color_link ) { $settings['template_color_link'] = $template_color_link; }
			if ( $template_color_header ) { $settings['template_color_header'] = $template_color_header; }
			if ( $template_color_icon ) { $settings['template_color_icon'] = $template_color_icon; }
			if ( $template_color_accent ) { $settings['template_color_accent'] = $template_color_accent; }
			if ( $template_color_accent_text ) { $settings['template_color_accent_text'] = $template_color_accent_text; }
			if ( $template_color_accent2 ) { $settings['template_color_accent2'] = $template_color_accent2; }
			if ( $template_color_accent2_text ) { $settings['template_color_accent2_text'] = $template_color_accent2_text; }

			if ( $template_color_comment_rating ) { $settings['template_color_comment_rating'] = $template_color_comment_rating; }
			if ( $comment_rating_position ) { $settings['comment_rating_position'] = $comment_rating_position; }

			if ( $default_recipe_template ) { $settings['default_recipe_template'] = $default_recipe_template; }
			if ( $default_print_template ) { $settings['default_print_template'] = $default_print_template; }
			$settings['print_credit'] = $print_credit;

			self::update_settings( $settings );
		}
		wp_safe_redirect( admin_url( 'admin.php?page=wprm_settings&sub=appearance' ) );
		exit();
	}

	/**
	 * Save the labels settings.
	 *
	 * @since    1.10.0
	 */
	public static function form_save_settings_labels() {
		if ( isset( $_POST['wprm_settings'] ) && wp_verify_nonce( sanitize_key( $_POST['wprm_settings'] ), 'wprm_settings' ) ) { // Input var okay.
			$labels = array();

			foreach ( $_POST as $id => $value ) { // Input var okay.
				if ( 'wprm_label_' === substr( $id, 0, 11 ) ) {
					$uid = sanitize_key( substr( $id, 11 ) );
					$labels[ $uid ] = sanitize_text_field( wp_unslash( $value ) );
				}
			}

			WPRM_Template_Helper::update_labels( $labels );
		}
		wp_safe_redirect( admin_url( 'admin.php?page=wprm_settings&sub=labels' ) );
		exit();
	}

	/**
	 * Save the features settings.
	 *
	 * @since    1.7.0
	 */
	public static function form_save_settings_features() {
		if ( isset( $_POST['wprm_settings'] ) && wp_verify_nonce( sanitize_key( $_POST['wprm_settings'] ), 'wprm_settings' ) ) { // Input var okay.
			$features_manage_access = isset( $_POST['features_manage_access'] ) ? sanitize_text_field( wp_unslash( $_POST['features_manage_access'] ) ) : ''; // Input var okay.
			$features_import_access = isset( $_POST['features_import_access'] ) ? sanitize_text_field( wp_unslash( $_POST['features_import_access'] ) ) : ''; // Input var okay.
			$features_comment_ratings = isset( $_POST['features_comment_ratings'] ) && sanitize_key( $_POST['features_comment_ratings'] ) ? true : false; // Input var okay.
			$features_custom_style = isset( $_POST['features_custom_style'] ) && sanitize_key( $_POST['features_custom_style'] ) ? true : false; // Input var okay.
			$features_adjustable_servings = isset( $_POST['features_adjustable_servings'] ) && sanitize_key( $_POST['features_adjustable_servings'] ) ? true : false; // Input var okay.

			$settings = array();

			if ( $features_manage_access ) { $settings['features_manage_access'] = $features_manage_access; }
			if ( $features_import_access ) { $settings['features_import_access'] = $features_import_access; }
			$settings['features_comment_ratings'] = $features_comment_ratings;
			$settings['features_custom_style'] = $features_custom_style;
			$settings['features_adjustable_servings'] = $features_adjustable_servings;

			self::update_settings( $settings );
		}
		wp_safe_redirect( admin_url( 'admin.php?page=wprm_settings&sub=features' ) );
		exit();
	}
}

WPRM_Settings::init();
