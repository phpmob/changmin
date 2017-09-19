<?php

namespace PhpMob\CoreBundle\Controller;

use Liip\ImagineBundle\Controller\ImagineController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    /**
     * @return ImagineController
     */
    private function getImagineController()
    {
        return $this->container->get('liip_imagine.controller');
    }

    public function testAction($path, $filter)
    {
        $runtimeConfig = [
            'thumbnail' => [
                'size' => explode('x', strtolower($filter)),
                'mode' => 'outbound',
            ],
        ];


        $params['filters'] = $runtimeConfig;

        $filterUrl = $this->getImagineController()
            ->filterRuntimeAction(new Request($params), $hash, $path, $filter)
            ->getTargetUrl();

        return new Response('OK');
    }
}
