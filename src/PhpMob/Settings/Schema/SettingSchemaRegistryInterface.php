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
interface SettingSchemaRegistryInterface
{
    /**
     * @param $section
     * @param array $data
     */
    public function add($section, array $data): void;

    /**
     * @param $section
     * @param $key
     *
     * @return SettingSchema
     * @throws \InvalidArgumentException
     */
    public function get($section, $key);

    /**
     * @param $section
     *
     * @return Section
     * @throws \InvalidArgumentException
     */
    public function getSection($section);

    /**
     * @return Section[]
     */
    public function getGlobals();

    /**
     * @return Section[]
     */
    public function getOwners();

    /**
     * @return Section[]
     */
    public function getAll();
}
