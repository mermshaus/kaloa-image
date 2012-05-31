<?php

namespace Kaloa\Tests;

use PHPUnit_Framework_TestCase;
use Kaloa\Image\Image;
use Kaloa\Image\ImageFactory;
use Kaloa\Image\Filter\ContrastFilter;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected $jpegImage;

    public function setUp()
    {
        $this->jpegImage = __DIR__ .
                '/../../../../demos/Image/assets/autumn-still-life.jpg';
    }

    public function testDummy()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath($this->jpegImage)
                 ->filter(new ContrastFilter(100));
    }

    public function testMimeTypeHandling()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath($this->jpegImage);

        $this->assertEquals(Image::TYPE_JPEG, $im->getMimeType());

        // Use second Image instance to assert that $im is written as a JPEG
        // file
        $im2 = $if->createNewImage()->createFromString($im->outputRaw());
        $this->assertEquals(Image::TYPE_JPEG, $im2->getMimeType());
    }
}
