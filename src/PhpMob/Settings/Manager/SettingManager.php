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

namespace PhpMob\Settings\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use PhpMob\Settings\Model\Setting;
use PhpMob\Settings\Model\SettingInterface;
use PhpMob\Settings\Provider\SettingProviderInterface;
use PhpMob\Settings\Type\TypeTransformerInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class SettingManager implements SettingManagerInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var SettingProviderInterface
     */
    private $provider;

    /**
     * @var TypeTransformerInterface
     */
    private $transformer;

    /**
     * @var SettingInterface[]|Collection
     */
    private $globalSettings;

    /**
     * @var Collection
     */
    private $userSettings;

    public function __construct(
        ManagerRegistry $managerRegistry,
        SettingProviderInterface $provider,
        TypeTransformerInterface $transformer
    ) {
        $this->manager = $managerRegistry->getManagerForClass(Setting::class);
        $this->provider = $provider;
        $this->transformer = $transformer;

        $this->globalSettings = new ArrayCollection();
        $this->userSettings = new ArrayCollection();
    }

    /**
     * @param string $owner
     *
     * @return mixed|null
     */
    private function getUserSettings(string $owner)
    {
        if (!$this->userSettings->get($owner)) {
            $this->userSettings->set($owner, $this->provider->findUserSettings($owner));
        }

        return $this->userSettings->get($owner);
    }

    /**
     * @param null|string $owner
     */
    private function loadSettings(?string $owner)
    {
        $owner && $this->getUserSettings($owner);

        if (!$owner && $this->globalSettings->isEmpty()) {
            $this->globalSettings = $this->provider->findGlobalSettings();
        }
    }

    /**
     * @param Collection $settings
     * @param string $section
     * @param string $key
     * @param null|string $owner
     *
     * @return Collection
     */
    private function filter(Collection $settings, string $section, string $key, ?string $owner)
    {
        return $settings->filter(
            function (SettingInterface $setting) use ($section, $key, $owner) {
                return $section === $setting->getSection()
                    && $key === $setting->getKey()
                    && $owner === $setting->getOwner();
            }
        );
    }

    /**
     * @param $section
     * @param $key
     * @param null|string $owner
     *
     * @return SettingInterface|null
     */
    private function findSetting($section, $key, ?string $owner)
    {
        $this->loadSettings($owner);

        return $owner
            ? $this->filter($this->getUserSettings($owner), $section, $key, $owner)->first()
            : $this->filter($this->globalSettings, $section, $key, null)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function setSetting($section, $key, $value, ?string $owner, $autoFlush = false): void
    {
        $setting = $this->findSetting($section, $key, $owner) ?: new Setting();
        $setting->setOwner($owner);
        $setting->setSection($section);
        $setting->setKey($key);
        $setting->setValue($value);
        $setting->setUpdatedAt(new \DateTime());

        $this->transformer->transform($setting);

        if ($autoFlush) {
            $this->manager->persist($setting);
            $this->manager->flush($setting);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSetting($section, $key, ?string $owner)
    {
        if ($setting = $this->findSetting($section, $key, $owner)) {
            $this->transformer->reverse($setting);

            return $setting->getValue();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(): void
    {
        foreach ($this->globalSettings->toArray() as $setting) {
            $this->manager->persist($setting);
        }

        /** @var Collection $userSettings */
        foreach ($this->userSettings->toArray() as $userSettings) {
            foreach ($userSettings->toArray() as $setting) {
                $this->manager->persist($setting);
            }
        }

        $this->manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $path, ?string $owner)
    {
        list($section, $key) = explode('.', $path);

        return $this->getSetting($section, $key, $owner);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value, ?string $owner): void
    {
        list($section, $key) = explode('.', $path);

        $this->setSetting($section, $key, $value, $owner, true);
    }
}
