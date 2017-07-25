<?php
add_action( 'add_meta_boxes' , 'sfbap1_add_meta_boxes');

/* META BOXES */

function sfbap1_add_meta_boxes(){
// Shortcode meta box
	add_meta_box( 'sfbap1_shortcode_meta_box' , 'Shortcode' , 'sfbap1_shortcode_meta_box_UI' , 'sfbap1_social_feed','side');

}
function sfbap1_shortcode_meta_box_UI( $post ){
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

	?>
	<p id="sfbap1_shortcode_label">Use this shortcode to add Social Feed in your Posts, Pages & Text Widgets: </p>
	<input style="width: 100%;
    text-align: center;
    font-weight: bold;
    font-size: 20px;" type="text" readonly id="sfbap1_shortcode_value" name="sfbap1_shortcode_value" value="[arrow_sf id='<?php echo $post->ID; ?>']" />
	<?php
}