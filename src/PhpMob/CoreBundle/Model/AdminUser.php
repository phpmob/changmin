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
     * @var string
     */
    protected $displayName;

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

    /**
     * {@inheritdoc}
     */
    public function getDisplayName(): string
    {
        return (string) ($this->displayName ? $this->displayName : $this->email);
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }
}
