<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Repository;

use PhpMob\CmsBundle\Model\PageInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface PageRepositoryInterface
{
    /**
     * @param string $slug
     * @param null|string $locale
     *
     * @return null|object|PageInterface
     */
    public function findPageBySlug(string $slug, ?string $locale): ?PageInterface;
}
