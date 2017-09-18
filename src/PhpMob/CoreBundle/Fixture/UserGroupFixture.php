<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\Fixture;

use PhpMob\ChangMinBundle\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class UserGroupFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'user_group';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
    {
        $resourceNode
            ->children()
            ->scalarNode('code')->end()
            ->scalarNode('name')->cannotBeEmpty()->end()
        ;
    }
}
