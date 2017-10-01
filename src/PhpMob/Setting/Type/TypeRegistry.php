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

namespace PhpMob\Setting\Type;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TypeRegistry
{
    /**
     * @var TypeInterface[]
     */
    private $types;

    public function __construct()
    {
        $this->add(new BooleanType());
        $this->add(new DefaultType());
        $this->add(new JsonType());
        $this->add(new StringType());
    }

    /**
     * @param TypeInterface $type
     */
    public function add(TypeInterface $type): void
    {
        $this->types[$type::getName()] = $type;
    }

    /**
     * @param $name
     *
     * @return TypeInterface
     */
    public function get($name): TypeInterface
    {
        return $this->types[$name];
    }
}
