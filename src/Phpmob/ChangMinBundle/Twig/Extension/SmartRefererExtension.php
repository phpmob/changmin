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

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class SmartRefererExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

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
            new \Twig_Function('smart_referer', [$this, 'getReferer']),
        ];
    }

    /**
     * @param null $default
     *
     * @return null|string
     */
    public function getReferer($default = null)
    {
        if (!$current = $this->requestStack->getCurrentRequest()) {
            return $default;
        }

        $referer = $current->headers->get('referer');

        if ($referer === $current->getUri()) {
            return $default;
        }

        return $referer;
    }
}
