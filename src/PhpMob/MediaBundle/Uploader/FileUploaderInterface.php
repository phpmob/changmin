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

use PhpMob\MediaBundle\Model\FileInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface FileUploaderInterface
{
    /**
     * @param FileInterface $file
     */
    public function upload(FileInterface $file);

    /**
     * @param string|null $path
     *
     * @return boolean
     */
    public function remove($path = null);

    /**
     * @param string $path
     *
     * @return bool
     */
    public function has($path);
}
