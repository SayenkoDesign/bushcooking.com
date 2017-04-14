<?php
/**
 * Handle the manage recipes page.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.9.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin/manage
 */

/**
 * Handle the manage recipes page.
 *
 * @since      1.9.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/admin/manage
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Manage_Recipes {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.9.0
	 */
	public static function init() {
	}

	/**
	 * Get the data to display in the datatable.
	 *
	 * @since    1.9.0
	 * @param		 array $datatable Datatable request values.
	 */
	public static function get_datatable( $datatable ) {
		$data = array();

		$orderby_options = array(
			0 => 'ID',
			1 => 'date',
			2 => 'title',
		);
		$orderby = isset( $orderby_options[ $datatable['orderby'] ] ) ? $orderby_options[ $datatable['orderby'] ] : $orderby_options[0];

		// Advanced Search.
		$search = $datatable['search'];
		$tax_query = array();

		preg_match_all( '/{{(.+?)=(\d*)}}/', $datatable['search'], $search_taxonomies );
		$search_taxonomies_length = count( $search_taxonomies[0] );
		if ( $search_taxonomies_length > 0 ) {
			for ( $i = 0; $i < $search_taxonomies_length; $i++ ) {
				// Remove advanced search.
				$search = str_replace( $search_taxonomies[0][ $i ], '', $search );

				// Add taxonomy query.
				$tax_query[] = array(
					'taxonomy' => $search_taxonomies[1][ $i ],
					'field' => 'term_id',
					'terms' => intval( $search_taxonomies[2][ $i ] ),
				);
			}

			$search = trim( $search );
		}

		$args = array(
				'post_type' => WPRM_POST_TYPE,
				'post_status' => 'any',
				'orderby' => $orderby,
				'order' => $datatable['order'],
				'posts_per_page' => $datatable['length'],
				'offset' => $datatable['start'],
				'tax_query' => $tax_query,
				's' => $search,
		);

		$query = new WP_Query( $args );

		$posts = $query->posts;
		foreach ( $posts as $post ) {
			$recipe = WPRM_Recipe_Manager::get_recipe( $post );

			// Parent Post Link.
			if ( $recipe->parent_post_id() ) {
				$parent_post_link = '<a href="' . esc_url( get_edit_post_link( $recipe->parent_post_id() ) ) . '" target="_blank">' . get_the_title( $recipe->parent_post_id() ) . '</a>';
			} else {
				$parent_post_link = '';
			}

			// Recipe SEO.
			$seo = WPRM_Seo_Checker::check_recipe( $recipe );

			$data[] = array(
				$recipe->id(),
				get_the_date( 'Y/m/d', $recipe->id() ),
				'<span id="wprm-manage-recipes-name-' . esc_attr( $recipe->id() ) . '">' . $recipe->name() . '</span>',
				$parent_post_link,
				'<div class="wprm-manage-recipes-seo wprm-manage-recipes-seo-' . esc_attr( $seo['type'] ) . '" data-tooltip-content="#wprm-manage-recipes-seo-' . esc_attr( $recipe->id() ) . '" data-id="' . esc_attr( $recipe->id() ) . '"></div><span class="wprm-manage-recipes-seo-tooltip" id="wprm-manage-recipes-seo-' . esc_attr( $recipe->id() ) . '">' . $seo['message'] . '</span>',
				'<span class="dashicons dashicons-admin-tools wprm-icon wprm-manage-recipes-actions" data-id="' . esc_attr( $recipe->id() ) . '"></span>',
			);
		}

		return array(
			'draw' => $datatable['draw'],
			'recordsTotal' => $query->found_posts,
			'recordsFiltered' => $query->found_posts,
			'data' => $data,
		);
	}
}

WPRM_Manage_Recipes::init();
