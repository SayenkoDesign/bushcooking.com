<?php
require_once 'vendor/autoload.php';

use Bush\App;
use Bush\WordPress\Menu;
use Bush\WordPress\StyleSheet;
use Bush\WordPress\Script;
use Bush\WordPress\PostType;
use Bush\WordPress\Taxonomy;
use Bush\WordPress\ImageSize;

add_theme_support( 'post-thumbnails' );

// stylesheets
$stylesheet_slick = new StyleSheet('slick', '//cdn.jsdelivr.net/g/jquery.slick@1.5.9(slick-theme.css+slick.css)');
$stylesheet_fontawesome = new StyleSheet('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
$stylesheet_fancybox = new StyleSheet('fancybox', StyleSheet::getThemeURL() . '/bower_components/fancybox/dist/jquery.fancybox.css');
$stylesheet_app = new StyleSheet('bush_app_css', StyleSheet::getThemeURL() . '/stylesheets/app.css', ['fontawesome', 'slick', 'fancybox']);

// scripts
add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
});
$script_jquery = new Script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
$script_slickjs = new Script('slick', '//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js', ['jquery']);
$script_fancybox = new Script('fancybox', Script::getThemeURL() . '/bower_components/fancybox/dist/jquery.fancybox.js');
$script_stickykit = new Script('sticky-kit', Script::getThemeURL() . '/bower_components/sticky-kit/jquery.sticky-kit.min.js');
$script_foundation = new Script('foundation', Script::getThemeURL() . '/bower_components/foundation-sites/dist/foundation.min.js');
$script_app = new Script('bush_app_js', Script::getThemeURL() . '/js/app.min.js', [
    'foundation',
    'fancybox',
    'sticky-kit',
    'slick',
], time());

// menus
$menu_primary = new Menu('primary', 'Primary menu used in header');
$menu_recipes = new Menu('recipes', 'Recipes menu for header and footer');
$menu_categories = new Menu('categories', 'Categories menu used in footer');

// post type
$recipes = new PostType(
    'recipes',
    'Recipe',
    'Recipe',
    'Food Recipes',
    true,
    true,
    true,
    false,
    ['title', 'author', 'comments', 'thumbnail'],
    true
);
$recipes->setMenuIcon('dashicons-carrot');
$recipes->register();

// add taxonomies
$Difficulty = new Taxonomy('difficulty', 'recipes');
$Food = new Taxonomy('food_category', 'recipes');
$Food->setLabel("Food Category");
$Country = new Taxonomy('country', 'recipes');
$CookMethod = new Taxonomy('cooking_method', 'recipes');
$CookMethod->setLabel("Cooking Method");
$Ingredient = new Taxonomy('ingredient', 'recipes');
$Equipment = new Taxonomy('equipment', 'recipes');
$RecipeType = new Taxonomy('recipe_type', 'recipes');
$RecipeType->setLabel("Recipe Type");

// move yoast down
add_filter( 'wpseo_metabox_prio', function() { return 'low';});
// gd is gdrts-metabox but I wont be able to move it without a bit of work so I am leaving it as is.

// add image sizes
$teaser = new ImageSize('teaser', 280, 280, true);
$slider = new ImageSize('slider', 380, 380, true);

// acf theme options page
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'bush-theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

add_shortcode( 'bush_tabbed_title', function ( $atts, $content = '' ) {
    static $tabbed_title_counter = 0;
    $tabbed_title_counter++;
    if($tabbed_title_counter == 1 ) {
        return <<<HTML
        <li class="tabs-title is-active"><a href="#panel-$tabbed_title_counter" aria-selected="true">$content</a></li>
HTML;
    } else {
        return <<<HTML
        <li class="tabs-title"><a href="#panel-$tabbed_title_counter">$content</a></li>
HTML;
    }
});

add_shortcode( 'bush_tabbed_contents', function ( $atts, $content = '' ){
    $inner_content = do_shortcode($content);
    return <<<HTML
<div class="tabs-content" data-tabs-content="example-tabs">$inner_content</div>
HTML;
});

add_shortcode( 'bush_tabbed_content', function ( $atts, $content = '' ) {
    static $tabbed_content_counter = 0;
    $tabbed_content_counter++;
    if($tabbed_content_counter == 1) {
        return <<<HTML
    <div class="tabs-panel is-active" id="panel-$tabbed_content_counter">
        $content
    </div>
HTML;
    } else {
        return <<<HTML
    <div class="tabs-panel" id="panel-$tabbed_content_counter">
        $content
    </div>
HTML;
    }
});

// control field order and remove uri field
add_filter( 'comment_form_fields', function ( $fields ) {
    $commenter = wp_get_current_commenter();

	$comment_field = '<div class="row column"><textarea placeholder="Your Comment" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>';
    $fields['author'] = '<div class="row">'
        . '<div class="medium-6 columns">'
        . '<input placeholder="Name" name="author" type="text" aria-required="true" required="required" value="'.esc_attr( $commenter['comment_author'] ).'"/>'
        . '</div>';
    $fields['email'] = '<div class="medium-6 columns">'
        . '<input name="email" placeholder="Email" type="text" aria-required="true" required="required" value="'.esc_attr( $commenter['comment_author_email'] ).'"/>'
        . '</div>'
        . '</div>';

    unset($fields['url']);
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
});

// Add fields after default fields above the comment box, always visible
add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );
function additional_fields () {
?>
    <div class="row column">
        <label for="rating">Your Rating</label>
        <div class="hide">
            <input type="radio" name="rating" id="rating-1" value="1" />
            <input type="radio" name="rating" id="rating-2" value="2" />
            <input type="radio" name="rating" id="rating-3" value="3" />
            <input type="radio" name="rating" id="rating-4" value="4" />
            <input type="radio" name="rating" id="rating-5" value="5" checked="checked" />
        </div>
        <div class="star-container">
            <span class="stars">
                <label for="rating-1" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-2" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-3" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-4" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-5" class="star"><i class="fa fa-star"></i></label>
            </span>
        </div>
    </div>
<?php
}

// Save the comment meta data along with comment
add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') )
        $rating = wp_filter_nohtml_kses($_POST['rating']);
    add_comment_meta( $comment_id, 'rating', $rating );
}

// Add the filter to check whether the comment meta data has been filled
add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
    if ( ! isset( $_POST['rating'] ) )
        wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
    return $commentdata;
}

// Add the comment meta (saved earlier) to the comment text
// You can also output the comment meta values directly to the comments template
add_filter( 'comment_text', 'modify_comment');
function modify_comment( $text ){

    $plugin_url_path = WP_PLUGIN_URL;

    if( $commentrating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
        $commentrating = '<p class="comment-rating">  Rating: <strong>'. $commentrating .' / 5</strong></p>';
        $text = $text . $commentrating;
        return $text;
    } else {
        return $text;
    }
}

// Add an edit option to comment editing screen
add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Rating' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="rating"><?php _e( 'Rating: ' ); ?></label>
      <span class="commentratingbox">
      <?php for( $i=1; $i <= 5; $i++ ) {
          echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
          if ( $rating == $i ) echo ' checked="checked"';
          echo ' />'. $i .' </span>';
      }
      ?>
      </span>
    </p>
    <?php
}

// Update comment meta data from comment editing screen
add_action( 'edit_comment', 'extend_comment_edit_metafields' );
function extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
        $rating = wp_filter_nohtml_kses($_POST['rating']);
        update_comment_meta( $comment_id, 'rating', $rating );
    else :
        delete_comment_meta( $comment_id, 'rating');
    endif;

}

// author fields
add_filter('user_contactmethods', function ($profile_fields) {
    $profile_fields['linkedin'] = 'Linkedin';
    $profile_fields['pinterest'] = 'Pinterest';
    $profile_fields['instagram'] = 'Instagram';
    $profile_fields['twitter'] = 'Twitter';
    $profile_fields['facebook'] = 'Facebook';

    return $profile_fields;
});

// remove taxonomy boxes
add_action( 'admin_menu', function (){
    remove_meta_box('food_categorydiv', 'recipes', 'side');
    remove_meta_box('difficultydiv', 'recipes', 'side');
    remove_meta_box('countrydiv', 'recipes', 'side');
    remove_meta_box('cooking_methoddiv', 'recipes', 'side');
    remove_meta_box('ingredientdiv', 'recipes', 'side');
    remove_meta_box('equipmentdiv', 'recipes', 'side');
    remove_meta_box('recipe_typediv', 'recipes', 'side');
});