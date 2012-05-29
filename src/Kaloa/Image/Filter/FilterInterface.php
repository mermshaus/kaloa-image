<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Image;

/**
 *
 */
interface FilterInterface
{
    public function render(Image $srcImage);
}
