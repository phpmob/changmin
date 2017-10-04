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
class TypeRegistry implements TypeRegistryInterface
{
    /**
     * @var TypeInterface[]
     */
    private $types;

    /**
     * TypeRegistry constructor.
     */
    public function __construct()
    {
        $this->add(new BooleanType());
        $this->add(new DateTimeType());
        $this->add(new DateType());
        $this->add(new DefaultType());
        $this->add(new JsonType());
        $this->add(new StringType());
    }

    /**
     * {@inheritdoc}
     */
    public function add(TypeInterface $type): void
    {
        $this->types[$type::getName()] = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name): TypeInterface
    {
        return $this->types[$name];
    }
}
