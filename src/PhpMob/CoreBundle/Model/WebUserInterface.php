<?php

namespace PhpMob\CoreBundle\Model;

use PhpMob\MediaBundle\Model\FileAwareInterface;
use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface WebUserInterface extends BaseUserInterface, FileAwareInterface
{
    /**
     * @return null|WebUserPictureInterface
     */
    public function getPicture(): ?WebUserPictureInterface;

    /**
     * @param null|WebUserPictureInterface $picture
     */
    public function setPicture(?WebUserPictureInterface $picture): void;

    /**
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * @param string $displayName
     */
    public function setDisplayName(?string $displayName): void;
}
