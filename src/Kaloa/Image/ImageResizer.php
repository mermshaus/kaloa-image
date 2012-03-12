<?php

namespace Kaloa\Image;

use InvalidArgumentException;

/**
 * Helper class for resizing images (based on GD)
 *
 * @author Marc Ermshaus <http://www.ermshaus.org/>
 * @version 2011-Apr-20
 * @license GNU General Public License Version 3 (or later)
 *          <http://www.gnu.org/licenses/gpl.html>
 */
class ImageResizer
{
    /**
     *
     * @var int
     */
    protected $maxWidth = 300;

    /**
     *
     * @var int
     */
    protected $maxHeight = 300;

    /**
     *
     * @var bool
     */
    protected $enlargeSmallImages = false;

    /**
     *
     * @param resource $image
     * @return resource GD image resource
     */
    protected function resize($image)
    {
        $maxWidth  = $this->maxWidth;
        $maxHeight = $this->maxHeight;

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

    /**
     *
     * @param string $path
     * @return resource GD image resource
     */
    public function resizeFromPath($path)
    {
        return $this->resize(imagecreatefromstring(file_get_contents($path)));
    }

    /**
     *
     * @param resource $image
     * @return resource GD image resource
     */
    public function resizeFromGd($image)
    {
        return $this->resize($image);
    }

    /**
     *
     * @param string $imageData
     * @return resource GD image resource
     */
    public function resizeFromString($imageData)
    {
        return $this->resize(imagecreatefromstring($imageData));
    }

    /**
     *
     * @return int
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     *
     * @param int $maxWidth
     */
    public function setMaxWidth($maxWidth)
    {
        if (!is_int($maxWidth) || $maxWidth < 1) {
            throw new InvalidArgumentException(
                    'maxWidth must be an (int) greater than 0');
        }

        $this->maxWidth = $maxWidth;
    }

    /**
     *
     * @return int
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     *
     * @param int $maxHeight
     */
    public function setMaxHeight($maxHeight)
    {
        if (!is_int($maxHeight) || $maxHeight < 1) {
            throw new InvalidArgumentException(
                    'maxHeight must be an (int) greater than 0');
        }

        $this->maxHeight = $maxHeight;
    }

    /**
     *
     * @return bool
     */
    public function getEnlargeSmallImages()
    {
        return $this->enlargeSmallImages;
    }

    /**
     *
     * @param bool $enlargeSmallImages
     */
    public function setEnlargeSmallImages($enlargeSmallImages)
    {
        if (!is_bool($enlargeSmallImages)) {
            throw new InvalidArgumentException(
                    'enlargeSmallImages must be a (bool)');
        }

        $this->enlargeSmallImages = $enlargeSmallImages;
    }
}
