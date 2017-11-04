<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle\Twig\Extension;

use Symfony\Component\Routing\RouterInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class RouteExistsExtension extends \Twig_Extension
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $requestStack
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('is_route_exists', [$this, 'isRouteExists']),
        ];
    }

    /**
     * @param string $name #Route
     *
     * @return bool
     */
    public function isRouteExists($name)
    {
        return !!$this->router->getRouteCollection()->get($name);
    }
}
