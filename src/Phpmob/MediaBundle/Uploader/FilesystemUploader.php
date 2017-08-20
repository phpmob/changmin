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

namespace Phpmob\MediaBundle\Uploader;

use Gaufrette\FilesystemInterface;
use Phpmob\MediaBundle\Model\FileInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FilesystemUploader implements FileUploaderInterface
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
        } while ($this->filesystem->has($path));

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
     * @param string $path
     *
     * @return bool
     */
    private function has($path)
    {
        return $this->filesystem->has($path);
    }
}
