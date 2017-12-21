<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\Fixture;

use PhpMob\ChangMinBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class WebUserFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'web_user';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
    {
        $resourceNode
            ->children()
            ->scalarNode('email')->cannotBeEmpty()->end()
            ->scalarNode('username')->cannotBeEmpty()->end()
            ->scalarNode('displayName')->end()
            ->scalarNode('firstName')->cannotBeEmpty()->end()
            ->scalarNode('lastName')->cannotBeEmpty()->end()
            ->scalarNode('gender')->end()
            ->scalarNode('phoneNumber')->end()
            ->scalarNode('birthday')->end()
            ->scalarNode('countryCode')->end()
            ->scalarNode('localeCode')->end()
            ->booleanNode('enabled')->end()
            ->scalarNode('password')->cannotBeEmpty()->end()
        ;
    }
}
