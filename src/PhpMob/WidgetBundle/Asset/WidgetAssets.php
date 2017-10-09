<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\WidgetBundle\Asset;

use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Config\FileLocatorInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WidgetAssets implements WidgetAssetsInterface
{
    /**
     * @var array
     */
    private $scripts = [
        '@PhpMobWidgetBundle/Resources/private/js/lib/waypoints.min.js',
        '@PhpMobWidgetBundle/Resources/private/js/lib/inview.min.js',
        '@PhpMobWidgetBundle/Resources/private/js/ext/*.js',
        '@PhpMobWidgetBundle/Resources/private/js/*.js',
    ];

    /**
     * @var array
     */
    private $styles = [
        '@PhpMobWidgetBundle/Resources/private/css/*.css',
    ];

    /**
     * @var FileLocatorInterface
     */
    private $fileLocator;

    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

    /**
     * @var bool
     */
    private $isDebug;

    /**
     * @var int
     */
    private $counter = 0;

    function __construct(FileLocatorInterface $fileLocator, CacheItemPoolInterface $cacheItemPool, $isDebug = true)
    {
        $this->fileLocator = $fileLocator;
        $this->cacheItemPool = $cacheItemPool;
        $this->isDebug = $isDebug;
    }

    /**
     * @param array $paths
     *
     * @return string
     */
    private function getHashKey(array $paths)
    {
        return md5(implode(',', $paths).($this->isDebug ? microtime() : ''));
    }

    /**
     * @param $path
     */
    public function addScript($path): void
    {
        $this->scripts[] = $path;
    }

    /**
     * @param $path
     */
    public function addStyle($path): void
    {
        $this->styles[] = $path;
    }

    /**
     * @param array $paths
     * @param string $type
     *
     * @return string
     */
    private function getContent(array $paths, $type)
    {
        $cacheKey = $this->getHashKey($paths);

        if ($this->cacheItemPool->hasItem($cacheKey)) {
            return $this->cacheItemPool->getItem($cacheKey)->get();
        }

        $minifier = 'js' === $type ? new JS() : new CSS();
        $content = '';

        foreach ($paths as $path) {
            foreach ($this->getFiles($path) as $file) {
                $file = $this->fileLocator->locate($file);

                if ($this->isDebug) {
                    $content .= file_get_contents($file);
                } else {
                    $minifier->add($file);
                }
            }
        }

        $content = $this->isDebug ? $content : $minifier->minify();

        $this->cacheItemPool->save($this->cacheItemPool->getItem($cacheKey)->set($content));

        return $content;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private function getFiles($path)
    {
        $files = [];

        if (false !== $pos = strpos($path, '*')) {
            list($before, $after) = explode('*', $path, 2);
            $input = $this->fileLocator->locate($before).'*'.$after;

            if (false !== $paths = glob($input)) {
                foreach ($paths as $path) {
                    $files[] = $path;
                }
            }
        } else {
            $files = [$this->fileLocator->locate($path)];
        }

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function getScript(): string
    {
        if (!$this->counter) {
            return '';
        }

        return $this->getContent($this->scripts, 'js');
    }

    /**
     * {@inheritdoc}
     */
    public function getStyle(): string
    {
        if (!$this->counter) {
            return '';
        }

        return $this->getContent($this->styles, 'css');
    }

    /**
     * {@inheritdoc}
     */
    public function increaseCounter(): void
    {
        $this->counter++;
    }
}
