<?php

namespace PhpMob\CoreBundle\Model;

use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface WebUserInterface extends BaseUserInterface
{
    /**
     * @return null|WebUserPictureInterface
     */
    public function getPicture(): ?WebUserPictureInterface;

    /**
     * @param null|WebUserPictureInterface $picture
     */
    public function setPicture(?WebUserPictureInterface $picture): void;
}
