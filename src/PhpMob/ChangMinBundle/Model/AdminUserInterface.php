<?php

namespace PhpMob\ChangMinBundle\Model;

use PhpMob\MediaBundle\Model\FileAwareInterface;
use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

interface AdminUserInterface extends BaseUserInterface, FileAwareInterface
{
    /**
     * @return null|AdminUserPictureInterface
     */
    public function getPicture(): ?AdminUserPictureInterface;

    /**
     * @param null|AdminUserPictureInterface $picture
     */
    public function setPicture(?AdminUserPictureInterface $picture): void;

    /**
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * @param string $displayName
     */
    public function setDisplayName(?string $displayName): void;
}
