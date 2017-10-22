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

namespace PhpMob\ChangMinBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Taxonomy\Factory\TaxonFactoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class TaxonFactory implements TaxonFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return TaxonInterface|object
     */
    public function createNew(): TaxonInterface
    {
        return $this->factory->createNew();
    }

    /**
     * {@inheritdoc}
     */
    public function createForParent(TaxonInterface $parent): TaxonInterface
    {
        $taxon = $this->createNew();
        $taxon->setParent($parent);

        return $taxon;
    }

    /**
     * {@inheritdoc}
     */
    public function createWidthParent(?TaxonInterface $parent): TaxonInterface
    {
        $taxon = $this->createNew();
        $taxon->setParent($parent);

        return $taxon;
    }
}
