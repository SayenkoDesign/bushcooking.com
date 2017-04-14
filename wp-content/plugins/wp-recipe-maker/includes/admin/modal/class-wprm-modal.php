<?php
/**
 * Add the recipe modal to posts and pages.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin/modal
 */

/**
 * Add the recipe modal to posts and pages.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin/modal
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Modal {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'admin_footer', array( __CLASS__, 'add_modal_content' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue' ) );

		add_action( 'wp_ajax_wprm_get_thumbnail', array( __CLASS__, 'ajax_get_thumbnail' ) );
	}

	/**
	 * Enqueue stylesheets and scripts.
	 *
	 * @since    1.0.0
	 */
	public static function enqueue() {
		wp_enqueue_style( 'wprm-medium-editor', WPRM_URL . 'vendor/medium-editor/css/medium-editor.min.css', array(), WPRM_VERSION, 'all' );
		wp_enqueue_style( 'wprm-medium-editor-theme', WPRM_URL . 'vendor/medium-editor/css/themes/beagle.min.css', array(), WPRM_VERSION, 'all' );
		wp_enqueue_style( 'wprm-select2', WPRM_URL . 'vendor/select2/css/select2.min.css', array(), WPRM_VERSION, 'all' );
		wp_enqueue_style( 'wprm-modal', WPRM_URL . 'assets/css/admin/modal.min.css', array(), WPRM_VERSION, 'all' );

		wp_enqueue_script( 'medium-editor', WPRM_URL . 'vendor/medium-editor/js/medium-editor.min.js', array( 'jquery' ), WPRM_VERSION, true );
		wp_enqueue_script( 'rangy', WPRM_URL . 'vendor/rangy/rangy-core.js', array(), WPRM_VERSION, true );
		wp_enqueue_script( 'wprm-rich-editor', WPRM_URL . 'assets/js/admin/rich-editor.js', array( 'jquery', 'medium-editor', 'rangy' ), WPRM_VERSION, true );
		wp_enqueue_script( 'wprm-select2', WPRM_URL . 'vendor/select2/js/select2.min.js', array( 'jquery' ), WPRM_VERSION, true );
		wp_enqueue_script( 'texthighlighter', WPRM_URL . 'vendor/texthighlighter/TextHighlighter.min.js', array( 'jquery' ), WPRM_VERSION, true );

		wp_enqueue_script( 'wprm-modal', WPRM_URL . 'assets/js/admin/modal.js', array( 'jquery' ), WPRM_VERSION, true );
		wp_enqueue_script( 'wprm-import-text', WPRM_URL . 'assets/js/admin/import-text.js', array( 'jquery', 'wprm-modal', 'texthighlighter' ), WPRM_VERSION, true );
		wp_enqueue_script( 'wprm-recipe-form', WPRM_URL . 'assets/js/admin/recipe-form.js', array( 'jquery', 'jquery-ui-sortable', 'wprm-modal', 'medium-editor', 'wprm-select2' ), WPRM_VERSION, true );
		wp_enqueue_script( 'wprm-recipe-snippets', WPRM_URL . 'assets/js/admin/recipe-snippets.js', array( 'jquery', 'wprm-modal' ), WPRM_VERSION, true );

		wp_localize_script( 'wprm-modal', 'wprm_modal', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'wprm' ),
			'text' => array(
				'modal_close_confirm' => __( 'Are you sure? You will lose any unsaved changes.', 'wp-recipe-maker' ),
				'action_button_insert' => __( 'Insert', 'wp-recipe-maker' ),
				'action_button_update' => __( 'Update', 'wp-recipe-maker' ),
				'media_title' => __( 'Select or Upload Image', 'wp-recipe-maker' ),
				'media_button' => __( 'Use Image', 'wp-recipe-maker' ),
				'shortcode_remove' => __( 'Are you sure you want to remove this recipe?', 'wp-recipe-maker' ),
				'import_text_reset' => __( 'Are you sure you want to start over with importing from text?', 'wp-recipe-maker' ),
				'edit_recipe' => __( 'Edit Recipe', 'wp-recipe-maker' ),
				'first_recipe_on_page' => __( 'First recipe on page', 'wp-recipe-maker' ),
				'medium_editor_placeholder' => __( 'Type here (select text for advanced styling options)', 'wp-recipe-maker' ),
			),
			'addons' => array(
				'premium' => WPRM_Addons::is_active( 'premium' ),
			),
		));
	}

	/**
	 * Get the image thumbnail from its ID.
	 *
	 * @since    1.0.0
	 */
	public static function ajax_get_thumbnail() {
		if ( check_ajax_referer( 'wprm', 'security', false ) ) {
			$image_id = isset( $_POST['image_id'] ) ? intval( $_POST['image_id'] ) : 0; // Input var okay.

			$thumb = wp_get_attachment_image_src( $image_id, 'medium' );
			$image_url = $thumb && isset( $thumb[0] ) ? $thumb[0] : '';

			wp_send_json_success( array(
				'image_url' => $image_url,
			) );
		}

		wp_die();
	}

	/**
	 * Add modal template to edit screen.
	 *
	 * @since    1.0.0
	 */
	public static function add_modal_content() {
		$screen = get_current_screen();

		if ( in_array( $screen->base, array( 'post', 'page' ), true ) ) {
			$menu = WPRM_Modal::get_modal_menu();
			require_once( WPRM_DIR . 'templates/admin/modal/modal.php' );
		}
	}

	/**
	 * Get menu to show in modal.
	 *
	 * @since    1.0.0
	 */
	public static function get_modal_menu() {
		$menu = array(
			'recipe' => array(
				'order' => 100,
				'default' => true,
				'label' => __( 'New Recipe', 'wp-recipe-maker' ),
				'tabs' => array(
					'text-import' => array(
						'order' => 50,
						'label' => __( 'Import from Text', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/import-text.php',
						'callback' => '',
					),
					'recipe-details' => array(
						'order' => 100,
						'label' => __( 'Recipe Details', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/recipe-details.php',
						'callback' => 'insert_update_recipe',
						'init' => 'set_recipe',
					),
					'recipe-ingredients-instructions' => array(
						'order' => 200,
						'label' => __( 'Ingredients & Instructions', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/recipe-ingredients-instructions.php',
						'callback' => 'insert_update_recipe',
					),
					'recipe-notes' => array(
						'order' => 300,
						'label' => __( 'Recipe Notes', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/recipe-notes.php',
						'callback' => 'insert_update_recipe',
					),
				),
				'default_tab' => 'recipe-details',
			),
			'edit-recipe' => array(
				'order' => 110,
				'label' => __( 'Edit Recipe', 'wp-recipe-maker' ),
				'tabs' => array(
					'edit-recipe-select' => array(
						'order' => 100,
						'label' => __( 'Edit Recipe', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/edit-recipe.php',
						'callback' => 'edit_recipe',
						'button' => __( 'Edit', 'wp-recipe-maker' ),
					),
				),
				'default_tab' => 'edit-recipe-select',
			),
			'insert-recipe' => array(
				'order' => 120,
				'label' => __( 'Insert Recipe', 'wp-recipe-maker' ),
				'tabs' => array(
					'insert-recipe-select' => array(
						'order' => 100,
						'label' => __( 'Insert Recipe', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/insert-recipe.php',
						'callback' => 'insert_recipe',
						'button' => __( 'Insert', 'wp-recipe-maker' ),
					),
				),
				'default_tab' => 'insert-recipe-select',
			),
			'recipe-snippets' => array(
				'order' => 200,
				'label' => __( 'Recipe Snippets', 'wp-recipe-maker' ),
				'tabs' => array(
					'recipe-snippets-jump' => array(
						'order' => 100,
						'label' => __( 'Jump to Recipe', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/recipe-snippets-jump.php',
						'callback' => 'insert_jump_to_recipe',
						'init' => 'reset_snippets',
					),
					'recipe-snippets-print' => array(
						'order' => 200,
						'label' => __( 'Print Recipe', 'wp-recipe-maker' ),
						'template' => WPRM_DIR . 'templates/admin/modal/tabs/recipe-snippets-print.php',
						'callback' => 'insert_print_recipe',
					),
				),
				'default_tab' => 'recipe-snippets-jump',
			),
		);

		// Allow menu to be altered.
		$menu = apply_filters( 'wprm_admin_modal_menu', $menu );

		// Sort menu before returning.
		$sorted_menu = array();
		foreach ( $menu as $menu_item => $options ) {
			uasort( $options['tabs'], array( __CLASS__, 'sort_by_order' ) );

			$sorted_menu[ $menu_item ] = $options;
		}

		uasort( $sorted_menu, array( __CLASS__, 'sort_by_order' ) );

		return $sorted_menu;
	}

	/**
	 * Custom sorting function for menu array.
	 *
	 * @since    1.0.0
	 * @param    mixed $a First array to compare.
	 * @param    mixed $b Second array to compare.
	 */
	public static function sort_by_order( $a, $b ) {
		return $a['order'] - $b['order'];
	}
}

WPRM_Modal::init();
