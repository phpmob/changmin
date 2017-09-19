<?php

namespace PhpMob\CoreBundle\Model;

use Sylius\Component\User\Model\User as BaseUser;

class AdminUser extends BaseUser implements AdminUserInterface
{
    /**
     * @var AdminUserPictureInterface
     */
    protected $picture;

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
    public function getPicture(): ?AdminUserPictureInterface
    {
        return $this->picture;
    }

    /**
     * {@inheritdoc}
     */
    public function setPicture(?AdminUserPictureInterface $picture): void
    {
        $this->picture = $picture ? ($picture->getFile() ? $picture : null) : null;

        if ($this->picture) {
            $picture->setOwner($this);
        }
    }
}
