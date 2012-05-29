<?php

namespace Kaloa\Image\Filter;

use Kaloa\Image\Filter\AbstractFilter;
use Kaloa\Image\Image;

/**
 *
 *
 * The class is modeled after java.awt.image.RescaleOp
 * <http://docs.oracle.com/javase/7/docs/api/java/awt/image/RescaleOp.html>
 */
class RescaleOpFilter extends AbstractFilter
{
    /**
     *
     * @var array (float[3])
     */
    protected $scaleFactors;

    /**
     *
     * @var array (float[3])
     */
    protected $offsets;

    /**
     *
     * @param array $scaleFactors Scaling factors for (r, g, b) components
     * @param array $offsets      Offsets for (r, g, b) components
     */
    public function __construct(array $scaleFactors, array $offsets)
    {
        $this->scaleFactors = $scaleFactors;
        $this->offsets = $offsets;
    }

    /**
     * Apply scaling factors and offsets to each pixel
     *
     * The algorithm uses micro-optimization techniques. As it is written in
     * PHP, nevertheless expect runtimes in the range of a second per 200,000
     * pixels or so. That is really slow compared to non-PHP implementations.
     *
     * @param  resource $img GD image resource
     * @return resource GD image resource
     */
    protected function loop($img)
    {
        // Cache already computed pixels
        $cache = array();

        // Compute all 256 rescaled values for each color dimension (R, G, B)
        for ($dimension = 0; $dimension <= 2; ++$dimension) {
            $s = $this->scaleFactors[$dimension];
            $o = $this->offsets[$dimension];

            $table[$dimension] = array_fill(0, 256, 0);
            for ($i = 0; $i <= 255; $i++) {
                $tmp = (int) round($i * $s + $o);
                if ($tmp > 255) $tmp = 255; else if ($tmp < 0) $tmp = 0;
                $table[$dimension][$i] = $tmp;
            }
        }

        // Dereferencing ($table[0]) would be slower
        list($table0, $table1, $table2) = $table;

        $width = imagesx($img);
        $y = imagesy($img);

        // Loops through the image row by row from bottom right to top left. The
        // idea here is to reduce the number of opcodes in the inner loop
        do {
            --$y;
            $x = $width;
            do
                if (isset($cache[$rgb = imagecolorat($img, --$x, $y)]))
                    imagesetpixel($img, $x, $y, $cache[$rgb]);
                else
                    imagesetpixel($img, $x, $y,
                            $cache[$rgb] = imagecolorallocate(
                                    $img,
                                    $table0[$rgb >> 16 & 0xFF],
                                    $table1[$rgb >>  8 & 0xFF],
                                    $table2[$rgb       & 0xFF]));
            while ($x);
        } while ($y);

        return $img;
    }

    /**
     *
     *
     * For each pixel do: pixelVector = pixelVector * scaleFactors + offsets
     *
     * @param  resource $img
     * @return resource
     */
    public function render(Image $srcImg)
    {
        $img = $srcImg->getResource();

        $img = $this->loop($img);

        return $img;
    }
}
