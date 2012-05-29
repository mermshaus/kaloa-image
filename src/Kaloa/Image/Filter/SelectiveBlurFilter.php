<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class SelectiveBlurFilter extends AbstractFilter
{
    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_SELECTIVE_BLUR);

        return $srcImage->getResource();
    }
}
