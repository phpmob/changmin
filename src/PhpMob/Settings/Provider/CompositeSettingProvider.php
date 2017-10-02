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
use Doctrine\Common\Collections\Collection;
use PhpMob\Settings\Model\SettingInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class CompositeSettingProvider implements SettingProviderInterface
{
    /**
     * @var SettingProviderInterface
     */
    private $localProvider;

    /**
     * @var SettingProviderInterface
     */
    private $remoteProvider;

    /**
     * @param SettingProviderInterface $localProvider
     * @param SettingProviderInterface $remoteProvider
     */
    public function __construct(SettingProviderInterface $localProvider, SettingProviderInterface $remoteProvider)
    {
        $this->localProvider = $localProvider;
        $this->remoteProvider = $remoteProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserSettings(string $owner)
    {
        return $this->mergeSettings(
            $this->remoteProvider->findUserSettings($owner),
            $this->localProvider->findUserSettings($owner)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findGlobalSettings()
    {
        return $this->mergeSettings(
            $this->remoteProvider->findGlobalSettings(),
            $this->localProvider->findGlobalSettings()
        );
    }

    /**
     * @param Collection $remotes
     * @param Collection $locals
     *
     * @return ArrayCollection
     */
    private function mergeSettings(Collection $remotes, Collection $locals)
    {
        $settings = $remotes->toArray();

        /** @var SettingInterface $local */
        foreach ($locals->toArray() as $local) {
            if (!$this->exists($remotes, $local)) {
                $settings[] = $local;
            }
        }

        return new ArrayCollection($settings);
    }

    /**
     * @param Collection $remote
     * @param SettingInterface $object
     *
     * @return bool
     */
    private function exists(Collection $remote, SettingInterface $object)
    {
        return $remote->exists(function (int $key, SettingInterface $setting) use ($object) {
            return $setting->isEqual($object);
        });
    }
}
