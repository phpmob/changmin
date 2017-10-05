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
     * @var string
     */
    protected $statusMessage;

    /**
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return '/private/users';
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

    /**
     * {@inheritdoc}
     */
    public function getStatusMessage(): string
    {
        return (string) $this->statusMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusMessage(?string $statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }
}
