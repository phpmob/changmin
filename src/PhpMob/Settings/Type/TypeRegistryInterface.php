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

namespace PhpMob\Settings\Type;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface TypeRegistryInterface
{
    /**
     * @param TypeInterface $type
     */
    public function add(TypeInterface $type): void;

    /**
     * @param $name
     *
     * @return TypeInterface
     */
    public function get($name): TypeInterface;
}
