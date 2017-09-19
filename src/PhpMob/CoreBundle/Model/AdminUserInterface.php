<?php

namespace PhpMob\CoreBundle\Model;

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
}
