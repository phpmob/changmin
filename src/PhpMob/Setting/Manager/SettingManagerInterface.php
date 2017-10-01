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

namespace PhpMob\Setting\Manager;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface SettingManagerInterface
{
    /**
     * @param $section
     * @param $key
     * @param $value
     * @param null|UserInterface $user
     * @param boolean $autoFlush
     */
    public function setSetting($section, $key, $value, ?UserInterface $user, $autoFlush = false): void;

    /**
     * @param $section
     * @param $key
     * @param null|UserInterface $user
     *
     * @return mixed
     */
    public function getSetting($section, $key, ?UserInterface $user);

    /**
     * @param string $path
     * @param null|UserInterface $user
     *
     * @return mixed
     */
    public function get(string $path, ?UserInterface $user);

    /**
     * @param string $path
     * @param $value
     * @param null|UserInterface $user
     */
    public function set(string $path, $value, ?UserInterface $user): void;

    /**
     * Flush
     */
    public function flush(): void;
}
