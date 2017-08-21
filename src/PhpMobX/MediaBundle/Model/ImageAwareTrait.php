<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
trait ImageAwareTrait
{
    /**
     * @var ImageInterface
     */
    private $image;

    /**
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage(ImageInterface $image = null)
    {
        $this->image = $image ? ($image->getFile() ? $image : null) : null;

        if ($this->image) {
            $image->setOwner($this);
        }
    }
}
