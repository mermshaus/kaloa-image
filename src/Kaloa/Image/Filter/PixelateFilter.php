<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class PixelateFilter extends AbstractFilter
{
    protected $blockSize;
    protected $useAdvancedMode;

    public function __construct($blockSize, $useAdvancedMode = false)
    {
        $this->blockSize = $blockSize;
        $this->useAdvancedMode = $useAdvancedMode;
    }

    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_PIXELATE, $this->blockSize, $this->useAdvancedMode);

        return $srcImage->getResource();
    }
}
