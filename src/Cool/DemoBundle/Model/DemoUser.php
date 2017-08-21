<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cool\DemoBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PhpMob\MediaBundle\Model\ImageAwareTrait;
use Sylius\Component\User\Model\User as BaseUser;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DemoUser extends BaseUser implements DemoUserInterface
{
    use ImageAwareTrait;

    /**
     * @var Collection|DemoUserPictureInterface[]
     */
    private $images;

    public function __construct()
    {
        parent::__construct();

        $this->images = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return '/profiles';
    }

    public function getImages()
    {
        return $this->images;
    }

    public function hasImage(DemoUserPictureInterface $picture)
    {
        return $this->images->contains($picture);
    }

    public function addImage(DemoUserPictureInterface $picture)
    {
        if (!$this->hasImage($picture)) {
            $picture->setUser($this);
            $picture->setBasePath($this->getFileBasePath());
            $this->images->add($picture);
        }
    }

    public function removeImage(DemoUserPictureInterface $picture)
    {
        if ($this->hasImage($picture)) {
            $picture->setUser(null);
            $this->images->removeElement($picture);
        }
    }
}
