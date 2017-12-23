<?php

namespace PhpMob\CoreBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phpmob_core');

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                ->arrayNode('identicon')
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->booleanNode('size')->defaultValue(200)->end()
                        ->arrayNode('colors')
                            ->defaultValue(['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997', '#17a2b8'])
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('security')
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->scalarNode('firewall_context_name')->defaultValue('web')->end()
                        ->arrayNode('username')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('reserved_words')
                                    ->defaultValue(['root', 'roots'])
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('password')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('requirements')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->integerNode('min_length')
                                            ->info('Minimum length of the password, should be at least 6 (or 8 for better security)')
                                            ->defaultNull()
                                        ->end()
                                        ->booleanNode('letters')
                                            ->info('Require that the password should at least contain one letter (default true)')
                                            ->defaultNull()
                                        ->end()
                                        ->booleanNode('case_diff')
                                            ->info('Require that the password should at least contain one lowercase and one uppercase letter (default false)')
                                            ->defaultNull()
                                        ->end()
                                        ->booleanNode('numbers')
                                            ->info('Require that the password should at least contain one number (default false)')
                                            ->defaultNull()
                                        ->end()
                                        ->booleanNode('special_character')
                                            ->info('Require that the password should at least contain one non lateral or numerical character like @ (default false)')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('strengths')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->integerNode('min_length')
                                            ->info('Minimum length of the password, should be at least 6 (or 8 for better security)')
                                            ->defaultNull()
                                        ->end()
                                        ->enumNode('level')
                                            ->info('Minimum required strength of the password. (default: 3)')
                                            ->defaultNull()
                                            ->values([1, 2, 3, 4, 5])
                                        ->end()
                                        ->booleanNode('unicode_equality')
                                            ->info('Consider characters from other scripts (unicode) as equal (default: false).')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
