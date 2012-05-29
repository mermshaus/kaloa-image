<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

class ResizeFilter extends AbstractFilter
{
    protected $newWidth;
    protected $newHeight;
    protected $enlargeSmallImages;

    /**
     *
     */
    public function __construct($newWidth, $newHeight)
    {
        $this->newWidth = $newWidth;
        $this->newHeight = $newHeight;

        $this->enlargeSmallImages = false;
    }

    /**
     *
     * @param resource $image
     * @return resource GD image resource
     */
    protected function resize($image)
    {
        $maxWidth  = $this->newWidth;
        $maxHeight = $this->newHeight;

        $width  = imagesx($image);
        $height = imagesy($image);

        // If both dimensions of the image are below specified maxima and no
        // enlargement of small images is wanted, there is nothing to do
        if ($this->enlargeSmallImages === false
                && $width < $maxWidth && $height < $maxHeight
        ) {
            return $image;
        }

        $ratioX = $width / $maxWidth;
        $ratioY = $height / $maxHeight;

        $newWidth  = 0;
        $newHeight = 0;

        if ($ratioX > $ratioY) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(imagesy($image) / $ratioX);
            if ($newHeight > $maxHeight) {
                $newHeight = $maxHeight;
            }
        } else {
            $newHeight = $maxHeight;
            $newWidth  = (int) round(imagesx($image) / $ratioY);
            if ($newWidth > $maxWidth) {
                $newWidth = $maxWidth;
            }
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0,
                $newWidth, $newHeight, $width, $height);

        imagedestroy($image);

        return $newImage;
    }

    public function render(Image $srcImage)
    {
        return $this->resize($srcImage->getResource());
    }
}
