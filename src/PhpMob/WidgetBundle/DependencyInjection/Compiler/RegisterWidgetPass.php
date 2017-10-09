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

namespace PhpMob\WidgetBundle\DependencyInjection\Compiler;

use PhpMob\WidgetBundle\Twig\WidgetInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class RegisterWidgetPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $widgets = $container->getParameter('phpmob.widgets');

        foreach ($container->findTaggedServiceIds('twig.extension') as $key => $twigs) {
            $definition = $container->getDefinition($key);
            $class = $definition->getClass();

            if ($container->hasParameter($class)) {
                $class = $container->getParameterBag()->resolveValue($class);
            }

            if (!class_exists($class)) {
                continue;
            }

            $reflex = $container->getReflectionClass($class);

            if ($reflex->implementsInterface(WidgetInterface::class)) {
                if ($reflex->implementsInterface(ContainerAwareInterface::class)) {
                    $definition->addMethodCall('setContainer', [new Reference('service_container')]);
                }

                $definition->addMethodCall('setRouter', [new Reference('router')]);
                $definition->addMethodCall('setWidgetAssets', [new Reference('phpmob.widget.assets')]);
                $definition->addMethodCall('resolverDefaultOptions', [
                    array_key_exists($class, $widgets) ? $widgets[$class]['options'] : []
                ]);

                $container->getDefinition('phpmob.widget.registry')
                    ->addMethodCall('addWidget', [$class])
                ;
            }
        }
    }
}
