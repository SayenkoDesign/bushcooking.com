<?php
namespace Bush;

use Bush\Twig\WordPressExtension;
use Pimple\Container;
use Symfony\Component\Yaml\Parser;

class App extends Container
{
    public function __construct(array $values)
    {
        parent::__construct($values);
    }

    /**
     * @return $this
     */
    public function enableTwig()
    {
        $this['twig.options'] = [
            'cache' => false,
            'auto_reload' => true,
            'strict_variables' => true,
        ];

        $this['twig.loader'] = function($c) {
            return new \Twig_Loader_Filesystem($c['twig.path']);
        };

        $this['twig'] = function($c) {
            $twig = new \Twig_Environment($c['twig.loader'], $c['twig.options']);
            $twig->addExtension(new WordPressExtension());
            return $twig;
        };

        return $this;
    }

    /**
     * @return $this
     */
    public function enableYaml()
    {
        $this['yaml.parser'] = function($c) {
            return new Parser();
        };

        return $this;
    }

    /**
     * Renders a template.
     *
     * @param string $name    The template name
     * @param array  $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     *
     * @throws \Twig_Error_Loader  When the template cannot be found
     * @throws \Twig_Error_Syntax  When an error occurred during compilation
     * @throws \Twig_Error_Runtime When an error occurred during rendering
     * @throws \Exception          If twig has not been registered
     */
    public function render($name, $context = [])
    {
        if(!$this->offsetExists('twig'))
        {
            throw new \Exception("Twig must be registered before you can render templates");
        }

        return $this['twig']->render($name, $context);
    }
}