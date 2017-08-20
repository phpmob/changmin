<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phpmob\ChangMinBundle\Twig\Extension;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FlagIconExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $options = array('is_safe' => array('html'));

        return [
            new \Twig_Filter('flag_icon', [$this, 'getFlagIcon'], $options),
            new \Twig_Filter('flag_icon_squared', [$this, 'getFlagIconSquared'], $options),
        ];
    }

    /**
     * @param string $locale
     * @param string $tpl
     *
     * @return string
     */
    public function getFlagIcon($locale, $tpl = '<span class="%s"></span>')
    {
        $locales = explode('_', $locale);
        $locale = array_pop($locales);

        return sprintf($tpl, 'flag-icon flag-icon-' . strtolower($locale));
    }

    /**
     * @param string $locale
     * @param string $tpl
     *
     * @return string
     */
    public function getFlagIconSquared($locale, $tpl = '<span class="%s"></span>')
    {
        $locales = explode('_', $locale);
        $locale = array_pop($locales);

        return sprintf($tpl, 'flag-icon flag-icon-' . strtolower($locale) . ' flag-icon-squared');
    }
}
