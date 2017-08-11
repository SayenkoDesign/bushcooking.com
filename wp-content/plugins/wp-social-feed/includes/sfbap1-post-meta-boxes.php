<?php
add_action( 'add_meta_boxes' , 'sfbap1_add_meta_boxes');

/* META BOXES */

function sfbap1_add_meta_boxes(){
// Shortcode meta box
	add_meta_box( 'sfbap1_shortcode_meta_box' , 'Shortcode' , 'sfbap1_shortcode_meta_box_UI' , 'sfbap1_social_feed','side');
		 add_meta_box( 'sfbap1_buy_premium_meta_box' , 'Buy Premium And:' , 'sfbap1_premium_version' , 'sfbap1_social_feed' , 'side' , 'high'); 
 add_meta_box( 'sfbap1_promotion_meta_box2' , 'You may also need:' , 'sfbap1_promotion2' , 'sfbap1_social_feed' , 'side'); 

}
function sfbap1_shortcode_meta_box_UI( $post ){
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

	?>
	<p id="sfbap1_shortcode_label">Use this shortcode to add Social Feed in your Posts or Pages: </p>
	<input style="width: 100%;
    text-align: center;
    font-weight: bold;
    font-size: 20px;" type="text" readonly id="sfbap1_shortcode_value" name="sfbap1_shortcode_value" value="[arrow_sf id='<?php echo $post->ID; ?>']" />
	<?php
}


function sfbap1_premium_version(){

 ?> <style type="text/css"> .sfbap1-action-button{ width: 93%; text-align: center; background: #e14d43; display: block; padding: 18px 8px; font-size: 16px; border-radius: 5px; color: white; text-decoration: none; border: 2px solid #e14d43;

 transition: all 0.2s; } .sfbap1-action-button:hover{ width: 93%; text-align: center; display: block; padding: 18px 8px; font-size: 16px; border-radius: 5px; color: white !important; text-decoration: none; background: #bb4138 !important; border: 2px solid #bb4138; }

 </style><strong> <ul> <li> - Unlock All Feed Templates</li> <li> - Unlock All Feed Styles</li> <li> - Unlock Twitter Hashtage Support</li><li> - Unlock Instagram Hashtage Support</li> <li> - Unlock Unlimited Creation of Feeds</li> <li> - Unlock Widget Support</li> <li> - Unlock All Customization Optisons</li> <li> - Create 3, 4, 5, 6 Columns Masonry Feed</li> <li> - Custom Size for Thumbnail View</li> <li> - Get 24/7 Premium Support</li> <li> - Unlimited Updates</li> </ul> </strong> <a href="https://www.arrowplugins.com/social-feed/" target="_blank" class="sfbap1-action-button">GET PREMIUM NOW</a> <?php }


 function sfbap1_promotion2(){ ?> <style type="text/css"> #sfbap1_promotion_meta_box2 .inside{ margin: 0 !important; padding:0; margin-top: 5px; } </style><p style="font-weight: bold; text-align: center;font-size: 20px;margin :0;padding: 0;"><a target="_blank" href="https://www.arrowplugins.com/subscribe-form">Subscribe Form</a></p> <a href="https://www.arrowplugins.com/subscribe-form" target="_blank"><img width="100%" src="<?php echo plugins_url('images/sub-product.png' , __FILE__); ?>" /></a> <p style="font-weight: bold; text-align: center;font-size: 20px;margin :0;padding: 0;"><a target="_blank" href="https://www.arrowplugins.com/popup-plugin">Popup</a></p><a href="https://www.arrowplugins.com/popup-plugin" target="_blank"><img width="100%" src="<?php echo plugins_url('images/p-product.png' , __FILE__); ?>" /></a>
<p style="font-weight: bold; text-align: center;font-size: 20px;margin :0;padding: 0;"><a target="_blank" href="https://www.arrowplugins.com/social-floating-icons">Social Floating Icons</a></p><a href="https://www.arrowplugins.com/social-floating-icons" target="_blank"><img width="100%" src="<?php echo plugins_url('images/fl-product.png' , __FILE__); ?>" /></a>
 <strong> <ul style="margin-left: 10px;">  </ul> </strong> <?php }  

