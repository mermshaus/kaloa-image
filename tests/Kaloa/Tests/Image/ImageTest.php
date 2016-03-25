<?php

/*
 * This file is part of the kaloa/image package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Tests;

use Kaloa\Image\Filter\ContrastFilter;
use Kaloa\Image\Image;
use Kaloa\Image\ImageFactory;
use PHPUnit_Framework_TestCase;

/**
 *
 */
class ImageTest extends PHPUnit_Framework_TestCase
{
    private $jpegImage;

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

    public function testRunFilters()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath($this->jpegImage);

        $im
            ->brightness(200)
            ->colorize(100, 100, 100, 100)
            ->contrast(20)
            ->edgeDetect()
            ->emboss()
            ->gaussianBlur()
            ->grayscale()
            ->rescaleOp(array(1, 0, 0), array(0, 0, 0))
            ->rotate(180, 0)
            ->selectiveBlur()
            ->smooth(5)

            ->resize(128, 128)
            ->negate()
            ->meanRemoval()
            ->pixelate(8);
    }

    public function testSetGetFactory()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath($this->jpegImage);

        $this->assertEquals(true, $im->getFactory() instanceof ImageFactory);

        $im->setFactory($if);

        $this->assertEquals(true, $im->getFactory() instanceof ImageFactory);
    }

    public function testClone()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath($this->jpegImage);

        clone $im;
    }

    public function testOutputRaw()
    {
        $if = new ImageFactory();

        $im = $if->createNewImage()
                 ->createFromPath($this->jpegImage);

        $this->assertEquals(true, is_string($im->outputRaw()));
    }
}
