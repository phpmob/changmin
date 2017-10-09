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

namespace PhpMob\WidgetBundle\Twig;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface WidgetInterface
{
    /**
     * Widget name
     *
     * @return string
     */
    public static function getName();

    /**
     * @param \Twig_Environment $env
     * @param array $userOptions
     *
     * @return string
     */
    public function render(\Twig_Environment $env, array $userOptions = []);
}
