<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\Phpcr;

use League\Flysystem\FilesystemInterface;
use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class LiipDataLoader implements LoaderInterface
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function find($path)
    {
        return $this->filesystem->read($path);
    }
}
