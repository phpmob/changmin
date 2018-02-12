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

namespace PhpMob\CoreBundle\Context;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ParameterContext
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $parameter
     * @param null $default
     *
     * @return mixed|null
     */
    public function get(string $parameter, $default = null)
    {
        if (false === $this->container->hasParameter($parameter)) {
            return $default;
        }

        if (null === $value = $this->container->getParameter($parameter)) {
            return $default;
        }

        return $value;
    }
}
