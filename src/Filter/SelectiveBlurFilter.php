<?php

/*
 * This file is part of the kaloa/image package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Image\Filter;

use Kaloa\Image\Image;

final class SelectiveBlurFilter extends AbstractFilter
{
    public function render(Image $srcImage)
    {
        imagefilter($srcImage->getResource(), IMG_FILTER_SELECTIVE_BLUR);

        return $srcImage->getResource();
    }
}
