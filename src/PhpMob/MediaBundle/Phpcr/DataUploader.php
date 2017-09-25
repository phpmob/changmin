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

use League\Flysystem\Config;
use League\Flysystem\Phpcr\PhpcrAdapter;
use PhpMob\MediaBundle\Model\FileInterface;
use PhpMob\MediaBundle\Uploader\FileUploaderInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DataUploader implements FileUploaderInterface
{
    /**
     * @var PhpcrAdapter
     */
    private $adapter;

    public function __construct(PhpcrAdapter $adapter)
    {
        $this->adapter = $adapter;
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

        $this->adapter->writeStream(
            $file->getPath(),
            fopen($file->getFile()->getPathname(), 'rb'),
            new Config()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove($path = null)
    {
        if ($path) {
            return $this->adapter->delete($path);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function has($path = null)
    {
        return $this->adapter->has($path);
    }
}
