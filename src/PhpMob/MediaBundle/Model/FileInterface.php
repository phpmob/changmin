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

namespace PhpMob\MediaBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface FileInterface extends ResourceInterface, TimestampableInterface
{
    /**
     * @return null|\SplFileInfo
     */
    public function getFile();

    /**
     * @param \SplFileInfo $file
     */
    public function setFile(\SplFileInfo $file);

    /**
     * @return bool
     */
    public function hasFile();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path
     */
    public function setPath($path);

    /**
     * @return string
     */
    public function getCaption();

    /**
     * @param string $caption
     */
    public function setCaption($caption);

    public function getOwner(): FileAwareInterface;

    public function setOwner(FileAwareInterface $owner);

    /**
     * @return string
     */
    public function getBasePath();

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath);

    /**
     * @return bool
     */
    public function isShouldRemove();

    /**
     * @param bool $shouldRemove
     */
    public function setShouldRemove($shouldRemove);
}
