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

        // language_attributes
        $funcs[] = new Twig_SimpleFunction('language_attributes', function($doctype = 'html') {
            return get_language_attributes($doctype);
        }, $html_safe);

        // body_class
        $funcs[] = new Twig_SimpleFunction('body_class', function($class = '') {
            return 'class="' . join( ' ', get_body_class( $class ) ) . '"';
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