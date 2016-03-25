<?php

/*
 * This file is part of the kaloa/image package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Image\Filter;

use Kaloa\Image\Image;

final class ContrastFilter extends AbstractFilter
{
    private $level;

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
