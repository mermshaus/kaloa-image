<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class RotateFilter extends AbstractFilter
{
    protected $angle;
    protected $backgroundColor;
    protected $ignoreTransparent;

    public function __construct($angle, $backgroundColor, $ignoreTransparent = 0)
    {
        $this->angle             = $angle;
        $this->backgroundColor   = $backgroundColor;
        $this->ignoreTransparent = $ignoreTransparent;
    }

    public function render(Image $srcImage)
    {
        $newResource = imagerotate($srcImage->getResource(), $this->angle, $this->backgroundColor, $this->ignoreTransparent);

        return $newResource;
    }
}
