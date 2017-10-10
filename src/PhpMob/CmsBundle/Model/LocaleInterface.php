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

namespace PhpMob\CmsBundle\Model;

use Sylius\Component\Locale\Model\LocaleInterface as BaseLocaleInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface LocaleInterface extends BaseLocaleInterface
{
    /**
     * @return array
     */
    public function getTranslations(): array;

    /**
     * @param array $translations
     */
    public function setTranslations(array $translations);
}
