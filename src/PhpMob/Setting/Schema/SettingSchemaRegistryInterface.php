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
interface SettingSchemaRegistryInterface
{
    /**
     * @param $section
     * @param $key
     * @param array $schema
     */
    public function add($section, $key, array $schema): void;

    /**
     * @param $section
     * @param $key
     *
     * @return null|SettingSchema
     */
    public function get($section, $key);

    /**
     * @param $section
     *
     * @return SettingSchema[]
     */
    public function getSection($section);
}
