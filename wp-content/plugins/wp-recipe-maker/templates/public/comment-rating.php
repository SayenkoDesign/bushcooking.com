<?php
/**
 * Template to be used for the rating in comments.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/public
 */

?>
<div class="wprm-comment-rating">
	<span class="wprm-rating-stars"><?php
		for ( $i = 1; $i <= 5; $i++ ) {
			echo '<span class="wprm-rating-star">';
			if ( $i <= $rating ) {
					include( WPRM_DIR . 'assets/icons/star-full.svg' );
			} else {
					include( WPRM_DIR . 'assets/icons/star-empty.svg' );
			}
			echo '</span>';
		}
	?></span>
</div>
