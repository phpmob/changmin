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

namespace PhpMob\MediaBundle\DependencyInjection\Compiler;

use PhpMob\MediaBundle\Form\Type\ImageType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class RegisterImageTypesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('phpmob.registry.image_types');

        foreach ($container->findTaggedServiceIds('form.type') as $id => $attributes) {
            if (is_subclass_of($this->getClass($id, $container), ImageType::class)) {
                $container->getDefinition($id)->addMethodCall('setImageTypeRegistry', [$registry]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    private function getClass($id, ContainerBuilder $container)
    {
        $className = $container->findDefinition($id)->getClass();

        if (false !== strpos($className, '%')) {
            $className = $container->getParameter(str_replace('%', '', $className));
        }

        return $className;
    }
}
