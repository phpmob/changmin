<?php

namespace PhpMob\ChangMinBundle\Model;

use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

interface AdminUserInterface extends BaseUserInterface
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
