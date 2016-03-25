<?php

/*
 * This file is part of the kaloa/image package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Image\Filter;

use Kaloa\Image\Image;

final class RotateFilter extends AbstractFilter
{
    private $angle;
    private $backgroundColor;
    private $ignoreTransparent;

    public function __construct($angle, $backgroundColor, $ignoreTransparent = 0)
    {
        $this->angle             = $angle;
        $this->backgroundColor   = $backgroundColor;
        $this->ignoreTransparent = $ignoreTransparent;
    }

    public function render(Image $srcImage)
    {
        $newResource = imagerotate(
            $srcImage->getResource(),
            $this->angle,
            $this->backgroundColor,
            $this->ignoreTransparent
        );

        return $newResource;
    }
}
