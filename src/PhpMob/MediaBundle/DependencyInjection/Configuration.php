<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('phpmob_media');

        $this->addImageFiltersSection($rootNode);
        $this->addImagineSection($rootNode);

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addImageFiltersSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('filters')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('code')->cannotBeEmpty()->end()
                                ->scalarNode('label')->cannotBeEmpty()->end()
                                ->scalarNode('filter')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addImagineSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('imagine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('driver')->defaultValue('gd')->end()
                        ->scalarNode('filter')->defaultValue('strip')->end()
                        ->scalarNode('quality')->defaultValue(100)->end()
                        ->scalarNode('data_loader')->defaultValue(null)->end()
                        ->scalarNode('default_image')->defaultValue('data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
