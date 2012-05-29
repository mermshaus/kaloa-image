<?php

namespace Kaloa\Tests;

use PHPUnit_Framework_TestCase;
use Kaloa\Image\Image;
use Kaloa\Image\ImageFactory;
use Kaloa\Image\Filter\ContrastFilter;

class ImageTest extends PHPUnit_Framework_TestCase
{
    public function testDummy()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath(__DIR__ . '/../../../../demos/Image/assets/autumn-still-life.jpg')
                 ->filter(new ContrastFilter(100));
    }
}
