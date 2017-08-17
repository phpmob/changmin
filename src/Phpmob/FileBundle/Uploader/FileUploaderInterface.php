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

namespace Phpmob\FileBundle\Uploader;

use Phpmob\FileBundle\Model\FileInterface;

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
     * @param FileInterface|null $file
     *
     * @return boolean
     */
    public function remove(FileInterface $file = null);

    /**
     * @param string $path
     *
     * @return boolean|string
     */
    public function read($path);
}
