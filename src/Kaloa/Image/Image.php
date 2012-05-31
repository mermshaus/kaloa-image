<?php

namespace Kaloa\Image;

use Kaloa\Image\Filter\FilterInterface;
use Kaloa\Image\ImageException;
use Kaloa\Image\ImageFactory;

class Image
{
    protected $resource = null;

    const TYPE_UNKNOWN = 'application/octet-stream';
    const TYPE_JPEG    = 'image/jpeg';
    const TYPE_PNG     = 'image/png';
    const TYPE_GIF     = 'image/gif';
    const TYPE_BMP     = 'image/x-windows-bmp';
    const TYPE_TIFF    = 'image/tiff';

    protected $mimeType = null;

    protected $factory;

    /**
     *
     * @param ImageFactory $factory
     */
    public function __construct(ImageFactory $factory)
    {
        $this->mimeType = self::TYPE_UNKNOWN;
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

    /**
     *
     *
     * @param  string $binary
     * @return string TYPE_* constant
     */
    protected function getMimeTypeFromBinary($binary)
    {
        $type = self::TYPE_UNKNOWN;

        switch (true) {
            case (1 === preg_match('/\A\xff\xd8\xff/', $binary)):
                $type = self::TYPE_JPEG;
                break;
            case (1 === preg_match('/\AGIF8[79]a/', $binary)):
                $type = self::TYPE_GIF;
                break;
            case (1 === preg_match('/\A\x89PNG\x0d\x0a/', $binary)):
                $type = self::TYPE_PNG;
                break;
            case (1 === preg_match('/\ABM/', $binary)):
                $type = self::TYPE_BMP;
                break;
            case (1 === preg_match('/\A\x49\x49(?:\x2a\x00|\x00\x4a)/',
                        $binary)):
                $type = self::TYPE_TIFF;
                break;
            case (1 === preg_match('/\AFORM.{4}ILBM)/', $binary)):
                /** TODO Find out what this is */
                $type = self::TYPE_UNKNOWN;
                break;
            default:
                $type = self::TYPE_UNKNOWN;
                break;
        }

        return $type;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function createFromPath($path)
    {
        return $this->createFromString(file_get_contents($path));
    }

    public function createFromGd($resource)
    {
        $this->create($resource);

        return $this;
    }

    public function createFromString($imageData)
    {
        $this->mimeType = $this->getMimeTypeFromBinary($imageData);
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

    /**
     * Output image directly
     *
     * Appopriate MIME types will be set.
     */
    public function output()
    {
        switch ($this->mimeType) {
            case self::TYPE_JPEG:
                header('Content-Type: image/jpeg');
                imagejpeg($this->resource);
                break;
            case self::TYPE_PNG:
                header('Content-Type: image/png');
                imagepng($this->resource);
                break;
            case self::TYPE_GIF:
                header('Content-Type: image/gif');
                imagegif($this->resource);
                break;
            case self::TYPE_BMP:
                header('Content-Type: image/x-windows-bmp');
                imagewbmp($this->resource);
                break;
            case self::TYPE_TIFF:
                /** TODO */
                header('Content-Type: image/x-windows-bmp');
                imagewbmp($this->resource);
                break;
            case self::TYPE_UNKNOWN:
                /** TODO */
                header('Content-Type: image/png');
                imagepng($this->resource);
                break;
        }
    }

    /**
     *
     * @return string Binary string containing image data
     */
    public function outputRaw()
    {
        ob_start();

        switch ($this->mimeType) {
            case self::TYPE_JPEG:
                imagejpeg($this->resource);
                break;
            case self::TYPE_PNG:
                imagepng($this->resource);
                break;
            case self::TYPE_GIF:
                imagegif($this->resource);
                break;
            case self::TYPE_BMP:
                imagewbmp($this->resource);
                break;
            case self::TYPE_TIFF:
                /** TODO */
                imagewbmp($this->resource);
                break;
            case self::TYPE_UNKNOWN:
                /** TODO */
                imagepng($this->resource);
                break;
        }

        return ob_get_clean();
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
