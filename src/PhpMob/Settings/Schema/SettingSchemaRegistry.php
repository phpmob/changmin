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
class SettingSchemaRegistry implements SettingSchemaRegistryInterface
{
    /**
     * @var Section[]
     */
    private $schemas = [];

    /**
     * @var array
     */
    private $types = [
        'globals' => [],
        'owners' => [],
    ];

    /**
     * {@inheritdoc}
     */
    public function add($section, array $data): void
    {
        if (!$data['enabled']) {
            return;
        }

        $this->schemas[$section] = new Section($data);

        if ($data['ownered']) {
            $this->types['owners'][$section] = $this->schemas[$section];
        } else {
            $this->types['globals'][$section] = $this->schemas[$section];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($section, $key)
    {
        if ($section = $this->getSection($section)) {
            return $section->get($key);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSection($section)
    {
        if (!array_key_exists($section, $this->schemas)) {
            return null;
        }

        return $this->schemas[$section];
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return $this->types['globals'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOwners()
    {
        return $this->types['owners'];
    }
}
