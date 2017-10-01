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

namespace PhpMob\Setting\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class RemoteSettingProvider implements SettingProviderInterface
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function findUserSettings(UserInterface $user)
    {
        return new ArrayCollection($this->repository->findBy(['user' => $user]));
    }

    /**
     * {@inheritdoc}
     */
    public function findGlobalSettings()
    {
        return new ArrayCollection($this->repository->findBy(['user' => null]));
    }
}
