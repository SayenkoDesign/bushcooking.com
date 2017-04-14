<?php
/**
 * Responsible for saving recipes.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 */

/**
 * Responsible for saving recipes.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Recipe_Saver {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'wp_ajax_wprm_save_recipe', array( __CLASS__, 'ajax_save_recipe' ) );
		add_action( 'save_post', array( __CLASS__, 'update_post' ), 10, 2 );

		add_filter( 'wp_insert_post_data', array( __CLASS__, 'post_type_switcher_fix' ), 20, 2 );
	}

	/**
	 * Save recipe submitted through AJAX.
	 *
	 * @since    1.0.0
	 */
	public static function ajax_save_recipe() {
		if ( check_ajax_referer( 'wprm', 'security', false ) ) {
			$recipe = isset( $_POST['recipe'] ) ? WPRM_Recipe_Sanitizer::sanitize( wp_unslash( $_POST['recipe'] ) ) : array(); // Input var okay.
			$recipe_id = isset( $_POST['recipe_id'] ) ? intval( $_POST['recipe_id'] ) : 0; // Input var okay.

			if ( 0 !== $recipe_id && WPRM_POST_TYPE === get_post_type( $recipe_id ) ) {
				if ( current_user_can( 'edit_post', $recipe_id ) ) {
					WPRM_Recipe_Saver::update_recipe( $recipe_id, $recipe );
				}
			} else {
				if ( current_user_can( 'edit_posts' ) ) {
					$recipe_id = WPRM_Recipe_Saver::create_recipe( $recipe );
				}
			}

			wp_send_json_success( array(
				'id' => $recipe_id,
			) );
		}

		wp_die();
	}

	/**
	 * Create a new recipe.
	 *
	 * @since    1.0.0
	 * @param		 array $recipe Recipe fields to save.
	 */
	public static function create_recipe( $recipe ) {
		$post = array(
			'post_type' => WPRM_POST_TYPE,
			'post_status' => 'draft',
		);

		$recipe_id = wp_insert_post( $post );
		WPRM_Recipe_Saver::update_recipe( $recipe_id, $recipe );

		return $recipe_id;
	}

	/**
	 * Save recipe fields.
	 *
	 * @since    1.0.0
	 * @param		 int   $id Post ID of the recipe.
	 * @param		 array $recipe Recipe fields to save.
	 */
	public static function update_recipe( $id, $recipe ) {
		// Post Fields.
		$post = array(
			'ID'           => $id,
			'post_title'   => $recipe['name'],
			'post_name'	   => 'wprm-' . sanitize_title( $recipe['name'] ),
			'post_content' => $recipe['summary'],
		);
		wp_update_post( $post );

		// Featured Image.
		if ( $recipe['image_id'] ) {
			set_post_thumbnail( $id, $recipe['image_id'] );
		} else {
			delete_post_thumbnail( $id );
		}

		// Recipe Taxonomies.
		$taxonomies = WPRM_Taxonomies::get_taxonomies();
		foreach ( $taxonomies as $taxonomy => $options ) {
			$key = substr( $taxonomy, 5 ); // Get rid of wprm_.
			wp_set_object_terms( $id, $recipe['tags'][ $key ], $taxonomy, false );
		}

		// Recipe Ingredients.
		$ingredient_ids = array();
		foreach ( $recipe['ingredients'] as $ingredient_group ) {
			foreach ( $ingredient_group['ingredients'] as $ingredient ) {
				$ingredient_ids[] = intval( $ingredient['id'] );
			}
		}
		$ingredient_ids = array_unique( $ingredient_ids );

		wp_set_object_terms( $id, $ingredient_ids, 'wprm_ingredient', false );

		// Meta Fields.
		update_post_meta( $id, 'wprm_author_display', $recipe['author_display'] );
		update_post_meta( $id, 'wprm_author_name', $recipe['author_name'] );
		update_post_meta( $id, 'wprm_servings', $recipe['servings'] );
		update_post_meta( $id, 'wprm_servings_unit', $recipe['servings_unit'] );
		update_post_meta( $id, 'wprm_prep_time', $recipe['prep_time'] );
		update_post_meta( $id, 'wprm_cook_time', $recipe['cook_time'] );
		update_post_meta( $id, 'wprm_total_time', $recipe['total_time'] );
		update_post_meta( $id, 'wprm_ingredients', $recipe['ingredients'] );
		update_post_meta( $id, 'wprm_instructions', $recipe['instructions'] );
		update_post_meta( $id, 'wprm_notes', $recipe['notes'] );
		update_post_meta( $id, 'wprm_nutrition', $recipe['nutrition'] );
		update_post_meta( $id, 'wprm_ingredient_links_type', $recipe['ingredient_links_type'] );

		// Prevent import information from being overwritten.
		if ( $recipe['import_source'] ) {
			update_post_meta( $id, 'wprm_import_source', $recipe['import_source'] );
		}
		if ( count( $recipe['import_backup'] ) > 0 ) {
			update_post_meta( $id, 'wprm_import_backup', $recipe['import_backup'] );
		}

		WPRM_Recipe_Manager::invalidate_recipe( $id );
	}

	/**
	 * Check if post being saved contains recipes we need to update.
	 *
	 * @since    1.0.0
	 * @param		 int    $id Post ID being saved.
	 * @param		 object $post Post being saved.
	 */
	public static function update_post( $id, $post ) {
		// Use parent post if we're currently updating a revision.
		$revision_parent = wp_is_post_revision( $post );
		if ( $revision_parent ) {
			$post = get_post( $revision_parent );
		}

		$recipe_ids = WPRM_Recipe_Manager::get_recipe_ids_from_content( $post->post_content );

		// Prevent issue with automatically created redirections.
		if ( count( $recipe_ids ) > 0 ) {
			// Redirection plugin.
			if ( isset( $_POST['redirection_slug'] ) ) { // Input var okay.
				$_POST['redirection_slug'] = '/';
			}

			// Yoast SEO Premium plugin.
			add_filter( 'wpseo_premium_post_redirect_slug_change', '__return_true' );
		}

		foreach ( $recipe_ids as $recipe_id ) {
			$recipe = array(
				'ID'          	=> $recipe_id,
				'post_status' 	=> $post->post_status,
				'post_author' 	=> $post->post_author,
				'post_date' 	=> $post->post_date,
				'post_modified' => $post->post_modified,
			);
			wp_update_post( $recipe );

			update_post_meta( $recipe_id, 'wprm_parent_post_id', $post->ID );
		}
	}

	/**
	 * Prevent post type switcher bug from changing our recipe's post type.
	 *
	 * @since    1.4.0
	 * @param		 array $data    Data that might have been modified by Post Type Switcher.
	 * @param	   array $postarr Unmodified post data.
	 */
	public static function post_type_switcher_fix( $data, $postarr ) {
		if ( WPRM_POST_TYPE === $postarr['post_type'] ) {
			$data['post_type'] = WPRM_POST_TYPE;
		}
		return $data;
	}
}

WPRM_Recipe_Saver::init();
