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

    public function __construct(array $sections = [])
    {
        foreach ($sections as $section => $data) {
            $this->add($section, $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($section, array $data): void
    {
        $this->schemas[$section] = new Section($section, $data);

        if ($data['owner_aware']) {
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
        return $this->getSection($section)->getSetting($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getSection($section)
    {
        if (!array_key_exists($section, $this->schemas)) {
            throw new \InvalidArgumentException("No section name `$section`.");
        }

        return $this->schemas[$section];
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array_values($this->types['globals']);
    }

    /**
     * {@inheritdoc}
     */
    public function getOwners()
    {
        return array_values($this->types['owners']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return array_values($this->schemas);
    }
}
