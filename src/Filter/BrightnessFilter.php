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

final class BrightnessFilter extends AbstractFilter
{
    private $level;

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
