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

use PhpMob\CmsBundle\Model\TemplateInterface;
use PhpMob\CmsBundle\Repository\TemplateRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TemplateRepository extends EntityRepository implements TemplateRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findTemplate(string $name): ?TemplateInterface
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * {@inheritdoc}
     */
    public function findNoneAbstractTemplates()
    {
        $queryBuilder = $this->createQueryBuilder('o');

        return $queryBuilder
            ->where($queryBuilder->expr()->neq('o.type', ':type'))
            ->orderBy('o.name', 'ASC')
            ->setParameter(':type', TemplateInterface::TYPE_ABSTRACT)
            ->getQuery()->getResult();
    }
}
