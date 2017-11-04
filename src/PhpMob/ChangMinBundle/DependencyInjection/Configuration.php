<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('changmin');

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                ->scalarNode('taxonomy')->defaultFalse()->end()
            ->end()
        ;

        $this->addTransitionConfig($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addTransitionConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('state_machine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('colors')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('negative')->defaultValue('red')->cannotBeEmpty()->end()
                                ->scalarNode('positive')->defaultValue('green')->cannotBeEmpty()->end()
                                ->scalarNode('na')->defaultValue('na')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('graphs')
                            ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->arrayNode('states')
                                            ->useAttributeAsKey('name')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('color')->end()
                                                    ->arrayNode('translation')
                                                        ->children()
                                                            ->scalarNode('key')->end()
                                                            ->scalarNode('domain')->defaultValue('messages')->cannotBeEmpty()->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->arrayNode('transitions')
                                            ->useAttributeAsKey('name')
                                            ->prototype('array')
                                                ->children()
                                                    ->scalarNode('color')->end()
                                                    ->arrayNode('translation')
                                                        ->children()
                                                            ->scalarNode('key')->end()
                                                            ->scalarNode('domain')->defaultValue('messages')->cannotBeEmpty()->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
