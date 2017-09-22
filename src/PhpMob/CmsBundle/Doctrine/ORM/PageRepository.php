<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Doctrine\ORM;

use PhpMob\CmsBundle\Repository\SlugableRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Model\SlugAwareInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PageRepository extends EntityRepository implements SlugableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findBySlug(string $slug, ?string $locale): ?SlugAwareInterface
    {
        $queryBuilder = $this->createQueryBuilder('o');

        return $queryBuilder
            ->join('o.translations', 'translation', 'WITH', 'translation.locale = :locale')
            ->leftJoin('o.template', 'tpl')
            ->addSelect('translation')
            ->addSelect('tpl')
            ->where($queryBuilder->expr()->eq('translation.slug', ':slug'))
            ->andWhere($queryBuilder->expr()->eq('o.enabled', ':enabled'))
            ->setParameter(':slug', $slug)
            ->setParameter(':locale', $locale)
            ->setParameter(':enabled', true)
            ->getQuery()->getOneOrNullResult();
    }
}
