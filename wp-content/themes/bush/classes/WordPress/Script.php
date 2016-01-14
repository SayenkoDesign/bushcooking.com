<?php
namespace Bush\WordPress;

class Script
{
    /**
     * @var string name of resource
     */
    protected $name;

    /**
     * @var string|bool location of resource or bool if it is already known to wordpress
     */
    protected $source;

    /**
     * @var string|array script dependencies
     */
    protected $deps;

    /**
     * @var float|bool version of script
     */
    protected $version;

    /**
     * @var bool include script in footer
     */
    protected $in_footer;

    /**
     * Script constructor.
     * @param string $name
     * @param bool|string $source
     * @param array|string $deps
     * @param bool|float $version
     * @param bool $in_footer
     */
    public function __construct($name, $source, $deps = [], $version = false, $in_footer = true, $register = true)
    {
        $this->setName($name);
        $this->setSource($source);
        $this->setDeps($deps);
        $this->setVersion($version);
        $this->setInFooter($in_footer);
        if($register) {
            $this->register();
        }
    }

    public static function getThemeURL()
    {
        return get_stylesheet_directory_uri();
    }

    public static function getParentURL()
    {
        return get_template_directory_uri();
    }

    public function register()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script($this->name, $this->source, $this->deps, $this->version, $this->in_footer);
        });
    }

    public function unregister()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_script($this->name);
        });
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Script
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param bool|string $source
     * @return Script
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getDeps()
    {
        return $this->deps;
    }

    /**
     * @param array|string $deps
     * @return Script
     */
    public function setDeps($deps)
    {
        $this->deps = $deps;
        return $this;
    }

    /**
     * @return bool|float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param bool|float $version
     * @return Script
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isInFooter()
    {
        return $this->in_footer;
    }

    /**
     * @param boolean $in_footer
     * @return Script
     */
    public function setInFooter($in_footer)
    {
        $this->in_footer = $in_footer;
        return $this;
    }


}