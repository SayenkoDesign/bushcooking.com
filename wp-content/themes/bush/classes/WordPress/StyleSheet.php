<?php
namespace Bush\WordPress;

class StyleSheet
{
    /**
     * @var string name for css file
     */
    protected $name;

    /**
     * @var string|bool location of stylesheet or bool if wordpress already knows the location
     */
    protected $source;

    /**
     * @var array list of dependencies
     */
    protected $deps;

    /**
     * @var float version
     */
    protected $version;

    /**
     * @var string|array media types to include the stylesheet with
     */
    protected $media;

    /**
     * StyleSheet constructor.
     * @param string $name
     * @param bool|string $source
     * @param array $deps
     * @param float $version
     * @param array|string $media
     */
    public function __construct($name, $source, array $deps = [], $version = false, $media = 'all', $register = true)
    {
        $this->setName($name);
        $this->setSource($source);
        $this->setDeps($deps);
        $this->setVersion($version);
        $this->setMedia($media);
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
            wp_enqueue_style($this->name, $this->source, $this->deps, $this->version, $this->media);
        });
    }

    public function unregister()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style($this->name);
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
     * @return StyleSheet
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
     * @return StyleSheet
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return array
     */
    public function getDeps()
    {
        return $this->deps;
    }

    /**
     * @param array $deps
     * @return StyleSheet
     */
    public function setDeps($deps)
    {
        $this->deps = $deps;
        return $this;
    }

    /**
     * @return float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param float $version
     * @return StyleSheet
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param array|string $media
     * @return StyleSheet
     */
    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }


}