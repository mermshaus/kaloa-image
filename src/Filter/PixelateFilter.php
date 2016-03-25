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

class PixelateFilter extends AbstractFilter
{
    private $blockSize;
    private $useAdvancedMode;

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
