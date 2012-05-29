<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class ContrastFilter extends AbstractFilter
{
    protected $level;

    /**
     *
     * @param int $level [-100, 100] -100 = min contrast, 0 = no change,
     *                   +100 = max contrast
     */
    public function __construct($level)
    {
        $this->level = -1 * $level;
    }

    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_CONTRAST, $this->level);

        return $srcImage->getResource();
    }
}
