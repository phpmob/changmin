<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\TwigModifyBundle\Cache;

use Doctrine\Common\Cache\Cache;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class LocalFile implements Cache
{
    /**
     * @var string Cache dir
     */
    private $cacheDir;

    /**
     * @param $cacheDir
     */
    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        return file_get_contents($this->cacheDir.DIRECTORY_SEPARATOR.$id);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($id)
    {
        return file_exists($this->cacheDir.DIRECTORY_SEPARATOR.$id);
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = 0)
    {
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir);
        }

        return file_put_contents($this->cacheDir.DIRECTORY_SEPARATOR.$id, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return @unlink($this->cacheDir.DIRECTORY_SEPARATOR.$id);
    }

    /**
     * {@inheritdoc}
     */
    public function getStats()
    {
        return null;
    }
}
