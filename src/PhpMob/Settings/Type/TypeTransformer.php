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

use PhpMob\Settings\Model\SettingInterface;
use PhpMob\Settings\Schema\SettingSchemaRegistryInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TypeTransformer implements TypeTransformerInterface
{
    /**
     * @var SettingSchemaRegistryInterface
     */
    private $schemaRegistry;

    /**
     * @var TypeRegistry
     */
    private $typeRegistry;

    /**
     * @param SettingSchemaRegistryInterface $schemaRegistry
     * @param TypeRegistryInterface $typeRegistry
     */
    public function __construct(SettingSchemaRegistryInterface $schemaRegistry, TypeRegistryInterface $typeRegistry)
    {
        $this->schemaRegistry = $schemaRegistry;
        $this->typeRegistry = $typeRegistry;
    }

    /**
     * @param string $section
     * @param string $key
     *
     * @return TypeInterface
     */
    private function resolverType(string $section, string $key)
    {
        return $this->typeRegistry->get(
            $this->schemaRegistry->get($section, $key)->getType()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function transform(string $section, string $key, $value)
    {
        return $this->resolverType($section, $key)->setter($value);
    }

    /**
     * {@inheritdoc}
     */
    public function reverse(string $section, string $key, $value)
    {
        return $this->resolverType($section, $key)->getter($value);
    }
}
