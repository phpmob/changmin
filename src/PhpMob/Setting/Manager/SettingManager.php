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

namespace PhpMob\Setting\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use PhpMob\Setting\Model\Setting;
use PhpMob\Setting\Model\SettingInterface;
use PhpMob\Setting\Provider\SettingProviderInterface;
use PhpMob\Setting\Type\TypeTransformerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    public function __construct()
    {
        $this->globalSettings = new ArrayCollection();
        $this->userSettings = new ArrayCollection();
    }

    /**
     * @param UserInterface $user
     *
     * @return mixed|null
     */
    private function getUserSettings(UserInterface $user)
    {
        if (!$this->userSettings->get($user->getUsername())) {
            $this->userSettings->set($user->getUsername(), $this->provider->findUserSettings($user));
        }

        return $this->userSettings->get($user->getUsername());
    }

    /**
     * @param null|UserInterface $user
     */
    private function loadSettings(?UserInterface $user)
    {
        $user && $this->getUserSettings($user);

        if (!$user && $this->globalSettings->isEmpty()) {
            $this->globalSettings = $this->provider->findGlobalSettings();
        }
    }

    /**
     * @param Collection $settings
     * @param string $section
     * @param string $key
     * @param null|UserInterface $user
     *
     * @return Collection
     */
    private function filter(Collection $settings, string $section, string $key, ?UserInterface $user)
    {
        return $settings->filter(function (SettingInterface $setting) use ($section, $key, $user) {
            return $section === $setting->getSection()
                && $key === $setting->getKey()
                && $user === $setting->getUser();
        });
    }

    /**
     * @param $section
     * @param $key
     * @param null|UserInterface $user
     *
     * @return SettingInterface|null
     */
    private function findSetting($section, $key, ?UserInterface $user)
    {
        $this->loadSettings($user);

        return $user
            ? $this->filter($this->getUserSettings($user), $section, $key, $user)->first()
            : $this->filter($this->globalSettings, $section, $key, null)->first()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setSetting($section, $key, $value, ?UserInterface $user, $autoFlush = false): void
    {
        $setting = $this->findSetting($section, $key, $user) ?: new Setting();
        $setting->setUser($user);
        $setting->setSection($section);
        $setting->setKey($key);
        $setting->setValue($value);

        $this->transformer->transform($setting);

        if ($autoFlush) {
            $this->manager->persist($setting);
            $this->manager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSetting($section, $key, ?UserInterface $user)
    {
        if ($setting = $this->findSetting($section, $key, $user)) {
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
    public function get(string $path, ?UserInterface $user)
    {
        list($section, $key) = explode('.', $path);

        return $this->getSetting($section, $key, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value, ?UserInterface $user): void
    {
        list($section, $key) = explode('.', $path);

        $this->setSetting($section, $key, $value, $user, true);
    }
}
