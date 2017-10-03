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

namespace PhpMob\Settings\Schema;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Section implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var SettingSchema[]
     */
    private $settings = [];

    public function __construct($name, array $data)
    {
        $this->data['name'] = $name;

        foreach ($data as $key => $value) {
            if ('settings' === $key) {
                $this->initSettings($value);
            } else {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * @param array $settings
     */
    private function initSettings(array $settings)
    {
        foreach ($settings as $schemaKey => $schemaData) {
            $this->settings[$schemaKey] = new SettingSchema($this, $schemaKey, $schemaData);
        }
    }

    /**
     * @return boolean
     */
    public function isOwnerAware()
    {
        return $this->data['owner_aware'];
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->data['enabled'];
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->data['label'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @param string $key
     *
     * @return SettingSchema
     * @throws \InvalidArgumentException
     */
    public function getSetting($key)
    {
        if (!array_key_exists($key, $this->settings)) {
            throw new \InvalidArgumentException("No setting key `$key` in this section.`");
        }

        return $this->settings[$key];
    }

    /**
     * @return SettingSchema[]
     */
    public function getSettings()
    {
        return array_values($this->settings);
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        return array_merge($this->data, [
            'settings' => $this->settings,
        ]);
    }
}
