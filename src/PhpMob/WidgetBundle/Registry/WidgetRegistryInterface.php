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

namespace PhpMob\WidgetBundle\Registry;

use PhpMob\WidgetBundle\Twig\WidgetInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface WidgetRegistryInterface
{
    /**
     * @param string|WidgetInterface $class
     */
    public function addWidget($class);

    /**
     * @param $name
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getWidgetClass($name);
}
