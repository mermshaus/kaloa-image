<?php

/*
 * This file is part of the kaloa/image package.
 *
 * For full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Kaloa\Image;

use Kaloa\Image\Filter\FilterInterface;
use ReflectionClass;

/**
 *
 */
final class ImageFactory
{
    /**
     *
     * @var array Array of FilterInterface
     */
    private $filters = null;

    /**
     *
     * @return Image
     */
    public function createNewImage()
    {
        return new Image($this);
    }

    /**
     *
     */
    private function rebuildFilters()
    {
        $files = glob(__DIR__ . '/Filter/*Filter.php');

        $this->filters = array();

        foreach ($files as $file) {
            $basename = basename($file);

            if ($basename === 'AbstractFilter.php') {
                continue;
            }

            $className = 'Kaloa\\Image\\Filter\\' . substr($basename, 0, -4);
            $methodName = lcfirst(substr($basename, 0, -10));

            $this->filters[$methodName] = $className;
        }
    }

    /**
     *
     * @param  string $methodName
     * @return bool
     */
    public function _hasFilter($methodName)
    {
        // Lazy loading
        if (null === $this->filters) {
            $this->rebuildFilters();
        }

        return (isset($this->filters[$methodName]));
    }

    /**
     *
     * @param  string $methodName
     * @param  array  $arguments
     * @return FilterInterface
     * @throws ImageException
     */
    public function _getFilterInstance($methodName, $arguments)
    {
        // Lazy loading
        if (null === $this->filters) {
            $this->rebuildFilters();
        }

        $instance = null;

        if (!$this->_hasFilter($methodName)) {
            throw new ImageException('Unknown filter: ' . $methodName);
        } else {
            $reflection = new ReflectionClass($this->filters[$methodName]);
            $instance = $reflection->newInstanceArgs($arguments);
        }

        return $instance;
    }
}
