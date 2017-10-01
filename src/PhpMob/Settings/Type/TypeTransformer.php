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
     * @param SettingInterface $setting
     *
     * @return TypeInterface
     */
    private function resolverType(SettingInterface $setting)
    {
        return $this->typeRegistry->get(
            $this->schemaRegistry->get($setting->getSection(), $setting->getKey())
        );
    }

    /**
     * @param SettingInterface $setting
     */
    public function transform(SettingInterface $setting)
    {
        $setting->setValue($this->resolverType($setting)->setter($setting->getValue()));
    }

    /**
     * @param SettingInterface $setting
     */
    public function reverse(SettingInterface $setting)
    {
        $setting->setValue($this->resolverType($setting)->getter($setting->getValue()));
    }
}
