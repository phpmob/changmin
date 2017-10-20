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

namespace PhpMob\ChangMinBundle\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TaxonFixture extends AbstractResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'taxon';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
    {
        $resourceNode
            ->children()
            ->scalarNode('code')->cannotBeEmpty()->end()
            ->variableNode('name')->cannotBeEmpty()->end()
            ->variableNode('slug')->cannotBeEmpty()->end()
            ->variableNode('description')->cannotBeEmpty()->end()
            ->variableNode('children')->end()
        ;
    }
}
