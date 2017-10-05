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

use PhpMob\CmsBundle\Model\TemplateInterface;
use PhpMob\CmsBundle\Repository\TemplateRepositoryInterface;
use PhpMob\CmsBundle\Translation\AddDefinedTranslationInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class RouteCheckerExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('is_route', [$this, 'isRouteName']),
            new \Twig_Function('is_route_name', [$this, 'isRouteName']),
        ];
    }

    /**
     * @param string $name #Route
     *
     * @return bool
     */
    public function isRouteName($name)
    {
        if (!$request = $this->requestStack->getMasterRequest()) {
            return false;
        }

        return $name === $request->get('_route');
    }
}
