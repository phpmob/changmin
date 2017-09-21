<?php

namespace PhpMob\CoreBundle\Model;

use Sylius\Component\User\Model\User as BaseUser;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WebUser extends BaseUser implements WebUserInterface
{
    /**
     * @var WebUserPictureInterface
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
    public function getPicture(): ?WebUserPictureInterface
    {
        return $this->picture;
    }

    /**
     * {@inheritdoc}
     */
    public function setPicture(?WebUserPictureInterface $picture): void
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
