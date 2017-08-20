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

namespace Phpmob\MediaBundle\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class File implements FileInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var \SplFileInfo
     */
    protected $file;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $caption;

    /**
     * @var ImageAwareInterface|FileAwareInterface
     */
    protected $owner;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var bool
     */
    protected $shouldRemove = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function setFile(\SplFileInfo $file)
    {
        $this->file = $file;
        $this->updatedAt = new \DateTime();

        if ($this->owner) {
            $this->basePath = $this->owner->getFileBasePath();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile()
    {
        return null !== $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPath()
    {
        return null !== $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * {@inheritdoc}
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * {@inheritdoc}
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * {@inheritdoc}
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * {@inheritdoc}
     */
    public function isShouldRemove()
    {
        return $this->shouldRemove;
    }

    /**
     * {@inheritdoc}
     */
    public function setShouldRemove($shouldRemove)
    {
        $this->shouldRemove = $shouldRemove;
        $this->updatedAt = new \DateTime();
    }
}
