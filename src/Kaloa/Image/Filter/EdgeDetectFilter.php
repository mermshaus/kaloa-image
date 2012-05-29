<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class EdgeDetectFilter extends AbstractFilter
{
    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_EDGEDETECT);

        return $srcImage->getResource();
    }
}
