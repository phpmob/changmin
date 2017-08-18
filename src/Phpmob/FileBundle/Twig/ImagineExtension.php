<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phpmob\FileBundle\Twig;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Phpmob\FileBundle\Model\ImageInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ImagineExtension extends \Twig_Extension
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var string
     */
    private $filter;

    /**
     * Constructor.
     *
     * @param CacheManager $cacheManager
     * @param string $filter
     */
    public function __construct(CacheManager $cacheManager, $filter = 'phpmob_imagine')
    {
        $this->cacheManager = $cacheManager;
        $this->filter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_Filter('phpmob_imagine', array($this, 'filter')),
        );
    }

    /**
     * @param string|ImageInterface $path
     * @param $sizing
     * @param bool $inset
     * @param string $default = null
     *
     * @return string
     */
    public function filter($path, $sizing, $inset = true, $default = null)
    {
        if ($path instanceof ImageInterface) {
            $path = $path->getPath();
        }

        if (empty($path)) {
            return $default;
        }

        $runtimeConfig = [
            'thumbnail' => [
                'size' => explode('x', strtolower($sizing)),
                'mode' => $inset ? 'inset' : 'outbound',
            ],
        ];

        return $this->cacheManager->getBrowserPath($path, $this->filter, $runtimeConfig);
    }
}
