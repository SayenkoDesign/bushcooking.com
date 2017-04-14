<?php
/**
 * Open up recipes in the WordPress REST API.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.4.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Open up recipes in the WordPress REST API.
 *
 * @since      1.4.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Api {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.4.0
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'api_register_recipe_data' ) );
		add_filter( 'wprm_recipe_post_type_arguments', array( __CLASS__, 'recipe_post_type_arguments' ) );
	}

	/**
	 * Register recipe data for the REST API.
	 *
	 * @since    1.4.0
	 */
	public static function api_register_recipe_data() {
		if ( function_exists( 'register_rest_field' ) ) { // Prevent issue with Jetpack.
			register_rest_field( WPRM_POST_TYPE, 'recipe', array(
				'get_callback'    => array( __CLASS__, 'api_get_recipe_data' ),
				'update_callback' => null,
				'schema'          => null,
			));
		}
	}

	/**
	 * Get recipe data for the REST API.
	 *
	 * @since    1.4.0
	 * @param		 array           $object		 Details of current post.
	 * @param		 mixed           $field_name Name of field.
	 * @param		 WP_REST_Request $request 	 Current request.
	 */
	public static function api_get_recipe_data( $object, $field_name, $request ) {
		$recipe = WPRM_Recipe_Manager::get_recipe( $object['id'] );
		return $recipe->get_data();
	}

	/**
	 * Add REST API options to the recipe post type arguments.
	 *
	 * @since    1.4.0
	 * @param	 	 array $args Post type arguments.
	 */
	public static function recipe_post_type_arguments( $args ) {
		$args['show_in_rest'] = true;
		$args['rest_base'] = WPRM_POST_TYPE;
		$args['rest_controller_class'] = 'WP_REST_Posts_Controller';

		return $args;
	}
}

WPRM_Api::init();
