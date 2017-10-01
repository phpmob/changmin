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
 *
 * @property boolean $ownered
 * @property string $label
 */
class Section
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var SettingSchema[]
     */
    private $settings = [];

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if ('settings' === $key) {
                foreach ($value as $schemaKey => $schemaData) {
                    if ($schemaData['enabled']) {
                        $this->settings[$schemaKey] = new SettingSchema($schemaData);
                    }
                }
            } else {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param $key
     *
     * @return SettingSchema|null
     */
    public function get($key)
    {
        return array_key_exists($key, $this->settings) ? $this->settings[$key] : null;
    }

    /**
     * @return SettingSchema[]
     */
    public function getSettings()
    {
        return $this->settings;
    }
}
