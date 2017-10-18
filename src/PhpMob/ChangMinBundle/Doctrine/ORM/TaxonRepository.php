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

namespace PhpMob\ChangMinBundle\Doctrine\ORM;

use Sylius\Bundle\TaxonomyBundle\Doctrine\ORM\TaxonRepository as BaseTaxonRepository;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TaxonRepository extends BaseTaxonRepository implements TaxonRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findNodesTreeSorted($rootCode = null)
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->addOrderBy('o.root')
            ->addOrderBy('o.left')
        ;

        if (null !== $rootCode) {
            $queryBuilder
                ->join('o.root', 'root')
                ->andWhere('root.code = :rootCode')
                ->setParameter('rootCode', $rootCode)
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
