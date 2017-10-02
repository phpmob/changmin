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
class SettingSchema
{
    /**
     * @var array
     */
    private $data = [];

    public function __construct(Section $section, $key, array $schema)
    {
        $this->data['section'] = $section;
        $this->data['key'] = $key;

        foreach ($schema as $key => $value) {
            $this->data[$key] = 'blueprint' === $key ? new Blueprint($value) : $value;
        }
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
    public function getKey()
    {
        return $this->data['key'];
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->data['value'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * @return Blueprint
     */
    public function getBlueprint()
    {
        return $this->data['blueprint'];
    }

    /**
     * @return Section
     */
    public function getSection()
    {
        return $this->data['section'];
    }
}
