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
use PhpMob\Settings\Model\Setting;
use PhpMob\Settings\Model\SettingInterface;
use PhpMob\Settings\Schema\SettingSchema;
use PhpMob\Settings\Schema\SettingSchemaRegistryInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class LocalSettingProvider implements SettingProviderInterface
{
    /**
     * @var SettingSchemaRegistryInterface
     */
    private $schemaRegistry;

    /**
     * @param SettingSchemaRegistryInterface $schemaRegistry
     */
    public function __construct(SettingSchemaRegistryInterface $schemaRegistry)
    {
        $this->schemaRegistry = $schemaRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserSettings(string $owner)
    {
        $settings = [];

        foreach ($this->schemaRegistry->getOwners() as $section) {
            $settings = array_merge($settings, $section->getSettings());
        }

        return new ArrayCollection($this->populateSettings($settings, $owner));
    }

    /**
     * {@inheritdoc}
     */
    public function findGlobalSettings()
    {
        $settings = [];

        foreach ($this->schemaRegistry->getGlobals() as $section) {
            $settings = array_merge($settings, $section->getSettings());
        }

        return new ArrayCollection($this->populateSettings($settings));
    }

    /**
     * @param SettingSchema[] $settings
     * @param null|string $owner
     *
     * @return SettingInterface[]
     */
    private function populateSettings(array $settings, ?string $owner = null)
    {
        $objects = [];

        foreach ($settings as $setting) {
            $objects[] = $object = new Setting();
            $object->setOwner($owner);
            $object->setSection($setting->getSection()->getName());
            $object->setKey($setting->getKey());
            $object->setValue($setting->getValue());
        }

        return $objects;
    }
}
