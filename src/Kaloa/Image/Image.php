<?php

namespace Kaloa\Image;

use Kaloa\Image\Filter\FilterInterface;
use Kaloa\Image\ImageException;
use Kaloa\Image\ImageFactory;

class Image
{
    protected $resource = null;

    protected $factory;

    /**
     *
     * @param ImageFactory $factory
     */
    public function __construct(ImageFactory $factory)
    {
        $this->factory = $factory;
    }

    public function __call($name, $arguments)
    {
        if (!$this->factory->_hasFilter($name)) {
            throw new ImageException('Unknown filter or unknown method: '
                    . $name);
        }

        $this->filter($this->factory->_getFilterInstance($name, $arguments));

        return $this;
    }

    protected function create($resource)
    {
        $this->resource = $resource;
    }

    public function createFromPath($path)
    {
        $this->create(imagecreatefromstring(file_get_contents($path)));

        return $this;
    }

    public function createFromGd($resource)
    {
        $this->create($resource);

        return $this;
    }

    public function createFromString($imageData)
    {
        $this->create(imagecreatefromstring($imageData));

        return $this;
    }

    public function filter(FilterInterface $filter)
    {
        $this->resource = $filter->render($this);

        return $this;
    }

    public function isInitialized()
    {
        return ($this->resource !== null);
    }

    public function getResource()
    {
        if (!$this->isInitialized()) {
            throw new ImageException('Image is not initialized');
        }

        return $this->resource;
    }

    public function output()
    {
        header('Content-Type: image/jpeg');
        imagejpeg($this->resource);
    }

    /**
     *
     * @return ImageFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     *
     * @param ImageFactory $factory
     */
    public function setFactory(ImageFactory $factory)
    {
        $this->factory = $factory;
    }
}
