<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\ChangMinBundle\Model;

use PhpMob\MediaBundle\Model\FileAwareInterface;
use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface AdminUserInterface extends BaseUserInterface, FileAwareInterface
{
    /**
     * @return null|string
     */
    public function getLocaleCode(): ?string;

    /**
     * @param null|string $localeCode
     */
    public function setLocaleCode(?string $localeCode): void;

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
