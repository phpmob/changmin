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
use PhpMob\Settings\Schema\SettingSchemaRegistryInterface;
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
     * @var SettingSchemaRegistryInterface
     */
    private $schemaRegistry;

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
        SettingSchemaRegistryInterface $schemaRegistry,
        TypeTransformerInterface $transformer
    ) {
        $this->manager = $managerRegistry->getManagerForClass(Setting::class);
        $this->provider = $provider;
        $this->schemaRegistry = $schemaRegistry;
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
     * @param $section
     * @param null|string $owner
     */
    private function assertSectionScope($section, ?string $owner)
    {
        try {
            $section = $this->schemaRegistry->getSection($section);
        } catch (\InvalidArgumentException $e) {
            throw new \LogicException($e->getMessage());
        }

        if (($owner && !$section->isOwnerAware()) || (!$owner && $section->isOwnerAware())) {
            throw new \LogicException("Wrong section accessing.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setSetting(string $section, string $key, $value, ?string $owner, $autoFlush = false): void
    {
        $this->assertSectionScope($section, $owner);

        $setting = $this->findSetting($section, $key, $owner) ?: new Setting();
        $setting->setOwner($owner);
        $setting->setSection($section);
        $setting->setKey($key);
        $setting->setValue($this->transformer->transform($section, $key, $value));
        $setting->setUpdatedAt(new \DateTime());

        if ($autoFlush) {
            $this->manager->persist($setting);
            $this->manager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSetting(string $section, string $key, ?string $owner)
    {
        $this->assertSectionScope($section, $owner);

        $setting = $this->findSetting($section, $key, $owner);

        return $this->transformer->reverse($section, $key, $setting->getValue());
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
        @list($section, $key) = explode('.', $path);

        if (empty($key)) {
            throw new \InvalidArgumentException("The $path should be something like: `section.key`.");
        }

        return $this->getSetting($section, $key, $owner);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value, ?string $owner): void
    {
        @list($section, $key) = explode('.', $path);

        if (empty($key)) {
            throw new \InvalidArgumentException("The $path should be something like: `section.key`.");
        }

        $this->setSetting($section, $key, $value, $owner, true);
    }
}
