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

namespace PhpMob\Settings\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface SettingInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getSection(): string;

    /**
     * @param string $section
     */
    public function setSection(string $section): void;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param string $key
     */
    public function setKey(string $key): void;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     */
    public function setValue(?string $value): void;

    /**
     * @return string|null
     */
    public function getOwner(): ?string;

    /**
     * @param string $owner
     */
    public function setOwner(?string $owner): void;
}
