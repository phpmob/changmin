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

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WidgetRegistry implements WidgetRegistryInterface
{
    /**
     * @var array
     */
    private $widgets = [];

    /**
     * {@inheritdoc}
     */
    public function addWidget($class)
    {
        $this->widgets[$class::getName()] = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidgetClass($name)
    {
        if (!array_key_exists($name, $this->widgets)) {
            throw new \InvalidArgumentException("Not found widget by name `$name`.");
        }

        return $this->widgets[$name];
    }
}
