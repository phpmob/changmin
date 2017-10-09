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

namespace PhpMob\WidgetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PhpMobWidgetExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'phpmob_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('phpmob.widgets', $config['widgets']);

        // auto register
        // simple widget without register twig service
        // can set or not set the service, if set can with or without `twig.extension` tag
        foreach (array_keys($config['widgets']) as $class) {
            $def = new Definition();
            $hasDefinition = false;

            foreach ($container->getDefinitions() as $definition) {
                if ($definition->getClass() === $class) {
                    $def = $definition;
                    $hasDefinition = true;
                    break;
                }
            }

            if (!$hasDefinition) {
                $container->setDefinition($class, $def);
            }

            $def->setClass($class)->addTag('twig.extension');
        }
    }
}
