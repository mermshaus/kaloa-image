<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class BrightnessFilter extends AbstractFilter
{
    protected $level;

    /**
     *
     * @param int $level [-255, 255]
     */
    public function __construct($level)
    {
        $this->level = $level;
    }

    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_BRIGHTNESS, $this->level);

        return $srcImage->getResource();
    }
}
