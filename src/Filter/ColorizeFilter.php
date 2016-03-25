<?php

/*
 * This file is part of the kaloa/image package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

final class ColorizeFilter extends AbstractFilter
{
    private $red;
    private $green;
    private $blue;
    private $alpha;

    /**
     *
     * @param int $red   [-255,255]
     * @param int $green [-255,255]
     * @param int $blue  [-255,255]
     * @param int $alpha [0,127]
     */
    public function __construct($red, $green, $blue, $alpha)
    {
        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;
        $this->alpha = $alpha;
    }

    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_COLORIZE, $this->red, $this->green,
                $this->blue, $this->alpha);

        return $srcImage->getResource();
    }
}
