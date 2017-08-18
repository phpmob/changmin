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

namespace Phpmob\FileBundle\Imagine\Cache;

use Liip\ImagineBundle\Controller\ImagineController;
use Liip\ImagineBundle\Imagine\Cache\CacheManager as BaseCacheManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CacheManager extends BaseCacheManager
{
    /**
     * @var ImagineController
     */
    private $controller;

    /**
     * @param ImagineController $controller
     */
    public function setController(ImagineController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Returns a web accessible URL.
     *
     * @param string $path The path where the resolved file is expected
     * @param string $filter The name of the imagine filter in effect
     * @param array $runtimeConfig
     * @param string $resolver
     *
     * @return string
     */
    public function generateUrl($path, $filter, array $runtimeConfig = array(), $resolver = null)
    {
        $params = array(
            'path' => ltrim($path, '/'),
            'filter' => $filter,
        );

        if ($resolver) {
            $params['resolver'] = $resolver;
        }

        if (empty($runtimeConfig)) {
            $filterUrl = $this->router->generate('liip_imagine_filter', $params, UrlGeneratorInterface::ABSOLUTE_URL);
        } else {
            $params['filters'] = $runtimeConfig;
            $hash = $this->signer->sign($path, $runtimeConfig);

            try {
                $filterUrl = $this->controller
                    ->filterRuntimeAction(new Request($params), $hash, $path, $filter)
                    ->getTargetUrl()
                ;
            } catch (NotFoundHttpException $e) {
                return null;
            }
        }

        return $filterUrl;
    }
}
