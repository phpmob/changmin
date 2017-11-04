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

use Sylius\Component\User\Model\User as BaseUser;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
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
     * @var string
     */
    protected $localeCode;

    /**
     * {@inheritdoc}
     */
    public function getLocaleCode(): ?string
    {
        return $this->localeCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocaleCode(?string $localeCode): void
    {
        $this->localeCode = $localeCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return '/private/admins';
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
