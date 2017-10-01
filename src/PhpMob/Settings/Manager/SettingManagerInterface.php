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

namespace PhpMob\Settings\Manager;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface SettingManagerInterface
{
    /**
     * @param $section
     * @param $key
     * @param $value
     * @param null|string $owner
     * @param boolean $autoFlush
     */
    public function setSetting($section, $key, $value, ?string $owner, $autoFlush = false): void;

    /**
     * @param $section
     * @param $key
     * @param null|string $owner
     *
     * @return mixed
     */
    public function getSetting($section, $key, ?string $owner);

    /**
     * @param string $path
     * @param null|string $owner
     *
     * @return mixed
     */
    public function get(string $path, ?string $owner);

    /**
     * @param string $path
     * @param $value
     * @param null|string $owner
     */
    public function set(string $path, $value, ?string $owner): void;

    /**
     * Flush
     */
    public function flush(): void;
}
