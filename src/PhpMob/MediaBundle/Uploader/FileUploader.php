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

namespace PhpMob\MediaBundle\Uploader;

use League\Flysystem\FilesystemInterface;
use PhpMob\MediaBundle\Model\FileInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FileUploader implements FileUploaderInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

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
    public function upload(FileInterface $file)
    {
        if (!$file->hasFile()) {
            return;
        }

        if (null !== $file->getPath() && $this->has($file->getPath())) {
            $this->remove($file->getPath());
        }

        do {
            $hash = md5(uniqid((string)mt_rand(), true));
            $path = preg_replace('|/+|', '/', $file->getBasePath().'/'.$hash.'.'.$file->getFile()->guessExtension());
        } while ($this->has($path));

        $file->setPath($path);

        $this->filesystem->write(
            $file->getPath(),
            file_get_contents($file->getFile()->getPathname())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove($path = null)
    {
        if ($path) {
            return $this->filesystem->delete($path);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function has($path)
    {
        return $this->filesystem->has($path);
    }
}
