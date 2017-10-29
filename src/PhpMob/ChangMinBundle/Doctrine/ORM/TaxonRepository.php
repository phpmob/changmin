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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Sylius\Bundle\TaxonomyBundle\Doctrine\ORM\TaxonRepository as BaseTaxonRepository;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TaxonRepository extends BaseTaxonRepository implements TaxonRepositoryInterface
{
    /**
     * @var NestedTreeRepository
     */
    private $nestedTreeRepository;

    /**
     * @param EntityManager $em
     * @param ClassMetadata $metadata
     */
    public function __construct(EntityManager $em, ClassMetadata $metadata)
    {
        parent::__construct($em, $metadata);

        $this->nestedTreeRepository = new NestedTreeRepository($em, $metadata);
    }

    /**
     * {@inheritdoc}
     */
    public function moveDown($node, $number = 1)
    {
        $this->nestedTreeRepository->moveDown($node, $number);
    }

    /**
     * {@inheritdoc}
     */
    public function moveUp($node, $number = 1)
    {
        $this->nestedTreeRepository->moveUp($node, $number);
    }

    /**
     * {@inheritdoc}
     */
    public function findNodesTreeSorted($rootCode = null)
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->addOrderBy('o.root')
            ->addOrderBy('o.left')
        ;

        /** @var TaxonInterface $root */
        if (null !== $rootCode && $root = $this->findOneBy(['code' => $rootCode])) {
            $queryBuilder
                ->addSelect('root')
                ->addSelect('translation')
                ->innerJoin('o.root', 'root')
                ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
                //->andWhere('o.root = :root')
                ->andWhere($queryBuilder->expr()->between('o.left', $root->getLeft(), $root->getRight()))
                //->setParameter('root', $root)
                ->setParameter('locale', $root->getTranslation()->getLocale())
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function createFilterQueryBuilder(string $locale, ?string $parentCode): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->setParameter('locale', $locale)
        ;

        if ($parentCode) {
            if (!$parent = $this->findOneBy(['code' => $parentCode])) {
                return $queryBuilder;
            }

            return $queryBuilder
                ->andWhere($queryBuilder->expr()->between('o.left', $parent->getLeft(), $parent->getRight()))
                ->andWhere('o.root = :rootCode')
                ->setParameter('rootCode', $parent->getRoot())
                ->addOrderBy('o.left')
            ;
        }

        return $queryBuilder
            ->addSelect('parent')
            ->leftJoin('o.parent', 'parent')
            ->andWhere($queryBuilder->expr()->between('o.left', 'parent.left', 'parent.right'))
            ->addOrderBy('o.left')
        ;
    }
}
