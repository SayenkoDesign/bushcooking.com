<?php
/**
 * Created by PhpStorm.
 * User: rpark
 * Date: 1/8/2016
 * Time: 1:48 AM
 */

namespace Bush\WordPress;


class Menu
{
    /**
     * @var string Menu location identifier, like a slug.
     */
    protected $location;

    /**
     * @var string Menu description - for identifying the menu in the dashboard.
     */
    protected $description;

    /**
     * MenuRegistration constructor.
     * @param string $location
     * @param string $description
     * @param bool $register register menu on init
     */
    public function __construct($location, $description, $register = true)
    {
        $this->setLocation($location);
        $this->setDescription($description);

        if ($register) {
            $this->register();
        }
    }

    public function register()
    {
        add_action('after_setup_theme', function () {
            register_nav_menu($this->location, __($this->description, 'bush'));
        });
        return $this;
    }

    public function unregister()
    {
        add_action('after_setup_theme', function () {
            unregister_nav_menu($this->location);
        });
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}