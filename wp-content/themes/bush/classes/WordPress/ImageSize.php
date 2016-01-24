<?php
/**
 * Created by PhpStorm.
 * User: rpark
 * Date: 1/23/2016
 * Time: 4:45 PM
 */

namespace Bush\WordPress;


class ImageSize
{
    /**
     * @var string name
     */
    protected $name;

    /**
     * @var int width
     */
    protected $width;

    /**
     * @var int height
     */
    protected $height;

    /**
     * @var bool|array crop
     */
    protected $crop;

    /**
     * ImageSize constructor.
     * @param string $name
     * @param int $width
     * @param int $height
     * @param array|bool $crop
     */
    public function __construct($name, $width, $height, $crop, $register = true)
    {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;
        if($register) {
            $this->register();
        }
    }

    public function register()
    {
        add_image_size( $this->name, $this->width, $this->height, $this->crop);
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
     * @return ImageSize
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return ImageSize
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return ImageSize
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return array|bool
     */
    public function getCrop()
    {
        return $this->crop;
    }

    /**
     * @param array|bool $crop
     * @return ImageSize
     */
    public function setCrop($crop)
    {
        $this->crop = $crop;
        return $this;
    }


}