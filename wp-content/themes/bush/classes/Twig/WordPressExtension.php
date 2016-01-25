<?php
namespace Bush\Twig;

use Twig_Environment;
use Twig_SimpleFunction;

class WordPressExtension extends \Twig_Extension
{

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        $html_safe = ['is_safe' => array('html')];

        $funcs = [];

        // home_url
        $funcs[] = new Twig_SimpleFunction('home_url', function($blog_id = null, $path = '', $scheme = null){
            return get_home_url($blog_id, $path, $scheme);
        }, $html_safe);

        // blog_info
        $funcs[] = new Twig_SimpleFunction('blog_info', function($show, $filter = 'raw'){
            return get_bloginfo($show, $filter);
        }, $html_safe);

        // wp_title
        $funcs[] = new Twig_SimpleFunction('wp_title', function($sep = '&raquo;', $dir = '') {
            return wp_title($sep, false, $dir);
        }, $html_safe);

        // wp_head
        $funcs[] = new Twig_SimpleFunction('wp_head', function() {
            ob_start();
            wp_head();
            $content = ob_get_clean();
            return $content;
        }, $html_safe);

        // wp_footer
        $funcs[] = new Twig_SimpleFunction('wp_footer', function() {
            ob_start();
            wp_footer();
            $content = ob_get_clean();
            return $content;
        }, $html_safe);

        // language_attributes
        $funcs[] = new Twig_SimpleFunction('language_attributes', function($doctype = 'html') {
            return get_language_attributes($doctype);
        }, $html_safe);

        // body_class
        $funcs[] = new Twig_SimpleFunction('body_class', function($class = '') {
            return 'class="' . join( ' ', get_body_class( $class ) ) . '"';
        }, $html_safe);

        // post_class
        $funcs[] = new Twig_SimpleFunction('post_class', function($class = '') {
            return 'class="' . join( ' ', get_post_class( $class ) ) . '"';
        }, $html_safe);

        // header_image
        $funcs[] = new Twig_SimpleFunction('header_image', function() {
            return get_header_image();
        }, $html_safe);

        // wp_list_categories
        $funcs[] = new Twig_SimpleFunction('wp_list_categories', function($args = []) {
            $args['echo'] = false;
            return wp_list_categories($args);
        }, $html_safe);

        // wp_nav_menu
        $funcs[] = new Twig_SimpleFunction('wp_nav_menu', function($args = []) {
            $args['echo'] = false;
            return wp_nav_menu($args);
        }, $html_safe);

        // the_id
        $funcs[] = new Twig_SimpleFunction('the_id', function($args = []) {
            return get_the_ID();
        }, $html_safe);

        // the_permalink
        $funcs[] = new Twig_SimpleFunction('the_permalink', function() {
            ob_start();
            the_permalink();
            return ob_get_clean();
        }, $html_safe);

        // the_post_thumbnail
        $funcs[] = new Twig_SimpleFunction('the_post_thumbnail', function($id = null, $size = 'post-thumbnail', $attr = '') {
            return get_the_post_thumbnail($id, $size, $attr);
        }, $html_safe);

        // post_password_required
        $funcs[] = new Twig_SimpleFunction('post_password_required', function() {
            return post_password_required();
        }, $html_safe);

        // the_title
        $funcs[] = new Twig_SimpleFunction('the_title', function() {
            return get_the_title();
        }, $html_safe);

        // the_content
        $funcs[] = new Twig_SimpleFunction('the_content', function() {
            return get_the_content();
        }, $html_safe);

        // wp_link_pages
        $funcs[] = new Twig_SimpleFunction('wp_link_pages', function($args) {
            $args['echo'] = false;
            return wp_link_pages($args);
        }, $html_safe);

        // edit_post_link
        $funcs[] = new Twig_SimpleFunction('edit_post_link', function($text, $before, $after, $class) {
            ob_start();
            edit_post_link($text, $before, $after, 0, $class);
            return ob_get_clean();
        }, $html_safe);

        // the_field
        $funcs[] = new Twig_SimpleFunction('the_field', function($field) {
            return get_field($field);
        }, $html_safe);

        // the_author_avatar
        $funcs[] = new Twig_SimpleFunction('the_author_avatar', function($size = null) {
            return get_avatar( get_the_author_meta( 'ID' ) , $size );
        }, $html_safe);

        // the_author
        $funcs[] = new Twig_SimpleFunction('the_author', function($size = null) {
            return get_the_author();
        }, $html_safe);

        // the_author_link
        $funcs[] = new Twig_SimpleFunction('the_author_link', function($size = null) {
            return get_the_author_link();
        }, $html_safe);

        // do_shortcode
        $funcs[] = new Twig_SimpleFunction('do_shortcode', function($content) {
            return do_shortcode($content);
        }, $html_safe);

        // the_post_thumbnail
        $funcs[] = new Twig_SimpleFunction('the_post_thumbnail', function($size = 'post-thumbnail', $attr = []) {
            ob_start();
            the_post_thumbnail( $size, $attr );
            return ob_get_clean();
        }, $html_safe);

        // get_the_category
        $funcs[] = new Twig_SimpleFunction('the_category', function($id = false) {
            return get_the_category($id);
        }, $html_safe);

        // get_category_link
        $funcs[] = new Twig_SimpleFunction('category_link', function($id) {
            return get_category_link($id);
        }, $html_safe);

        return $funcs;
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_GlobalsInterface instead
     */
    public function getGlobals()
    {
        return [
            'template_directory_uri' => get_template_directory_uri(),
            'stylesheet_directory_uri' => get_stylesheet_directory_uri(),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'WordPress';
    }
}