<?php

declare(strict_types=1);

namespace PhpMob\ChangMinBundle\Fixture;

use PhpMob\ChangMinBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class AdminUserFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'admin_user';
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
            ->scalarNode('displayName')->cannotBeEmpty()->end()
            ->booleanNode('enabled')->end()
            ->scalarNode('password')->cannotBeEmpty()->end()
        ;
    }
}
