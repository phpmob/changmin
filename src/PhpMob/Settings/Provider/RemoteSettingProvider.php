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

namespace PhpMob\Settings\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use PhpMob\Settings\Model\Setting;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class RemoteSettingProvider implements SettingProviderInterface
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->repository = $managerRegistry->getRepository(Setting::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserSettings(string $owner)
    {
        return new ArrayCollection($this->repository->findBy(['owner' => $owner]));
    }

    /**
     * {@inheritdoc}
     */
    public function findGlobalSettings()
    {
        return new ArrayCollection($this->repository->findBy(['owner' => null]));
    }
}
