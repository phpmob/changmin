<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Twig;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class PrintIfExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('print_if', [$this, 'printIf']),
        ];
    }

    /**
     * @param string $text
     * @param boolean $condition
     *
     * @return string
     */
    public function printIf($text, $condition)
    {
        return $condition ? $text : '';
    }
}
