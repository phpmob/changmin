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

namespace PhpMob\ChangMinBundle\Twig\Extension;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @deprecated remove when https://github.com/twigphp/Twig-extensions/pull/195 merged!
 */
class RepeatExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_Filter('repeat', 'str_repeat'),
        ];
    }
}
