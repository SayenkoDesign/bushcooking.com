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

        $funcs[] = new Twig_SimpleFunction('blog_info', function($show, $filter = 'raw'){
            return get_bloginfo($show, $filter);
        }, $html_safe);

        $funcs[] = new Twig_SimpleFunction('wp_title', function($sep = '&raquo;', $dir = '') {
            return wp_title($sep, false, $dir);
        }, $html_safe);

        $funcs[] = new Twig_SimpleFunction('wp_head', function() {
            ob_start();
            wp_head();
            $content = ob_get_clean();
            return $content;
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