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

use Doctrine\ORM\QueryBuilder;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface as BaseTaxonRepositoryInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface TaxonRepositoryInterface extends BaseTaxonRepositoryInterface
{
    /**
     * @param $node
     * @param int $number
     */
    public function moveDown($node, $number = 1);

    /**
     * @param $node
     * @param int $number
     */
    public function moveUp($node, $number = 1);

    /**
     * @param null|string $rootCode
     *
     * @return TaxonInterface[]
     */
    public function findNodesTreeSorted($rootCode = null);

    /**
     * @param string $locale
     * @param null|string $parentCode
     *
     * @return QueryBuilder
     */
    public function createFilterQueryBuilder(string $locale, ?string $parentCode): QueryBuilder;
}
