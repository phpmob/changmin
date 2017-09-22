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

use PhpMob\CmsBundle\Model\TemplateInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface TemplateRepositoryInterface
{
    /**
     * @param string $name
     *
     * @return null|object|TemplateInterface
     */
    public function findTemplate(string $name): ?TemplateInterface;

    /**
     * @return TemplateInterface[]
     */
    public function findNoneAbstractTemplates();
}
