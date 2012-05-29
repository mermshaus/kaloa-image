<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class SmoothFilter extends AbstractFilter
{
    protected $level;

    /**
     *
     * @param int $level
     */
    public function __construct($level)
    {
        $this->level = $level;
    }

    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_SMOOTH, $this->level);

        return $srcImage->getResource();
    }
}
