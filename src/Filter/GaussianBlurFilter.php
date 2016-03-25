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

final class GaussianBlurFilter extends AbstractFilter
{
    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_GAUSSIAN_BLUR);

        return $srcImage->getResource();
    }
}
