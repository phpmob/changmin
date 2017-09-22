<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Translation;

use PhpMob\CmsBundle\Model\DefinedTranslationInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface AddDefinedTranslationInterface
{
    /**
     * @param DefinedTranslationInterface $definedTranslation
     */
    public function addTranslations(DefinedTranslationInterface $definedTranslation);
}
