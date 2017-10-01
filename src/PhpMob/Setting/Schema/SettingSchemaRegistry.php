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

namespace PhpMob\Setting\Schema;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class SettingSchemaRegistry implements SettingSchemaRegistryInterface
{
    /**
     * @var array
     */
    private $schemas = [];

    /**
     * {@inheritdoc}
     */
    public function add($section, $key, array $schema): void
    {
        if (!array_key_exists($section, $this->schemas)) {
            $this->schemas[$section] = [];
        }

        $this->schemas[$section][$key] = new SettingSchema($schema);
    }

    /**
     * {@inheritdoc}
     */
    public function get($section, $key)
    {
        $sections = $this->getSection($section);

        if (empty($sections)) {
            return null;
        }

        return $sections[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getSection($section)
    {
        if (!array_key_exists($section, $this->schemas)) {
            return [];
        }

        return $this->schemas[$section];
    }
}
