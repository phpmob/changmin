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

namespace PhpMob\WidgetBundle\Asset;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface WidgetAssetsInterface
{
    /**
     * @param $path
     */
    public function addScript($path): void;

    /**
     * @param $path
     */
    public function addStyle($path): void;

    /**
     * @return string
     */
    public function getScript(): string ;

    /**
     * @return string
     */
    public function getStyle(): string ;

    /**
     * Should render assets
     *
     * @return void
     */
    public function increaseCounter(): void;
}
