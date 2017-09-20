<?php

namespace PhpMob\MediaBundle\Controller;

use PhpMob\MediaBundle\Model\ImageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PhpMob\MediaBundle\Imagine\Cache\CacheManager;

class ImageController extends Controller
{
    /**
     * @return CacheManager
     */
    private function getImagineCacheManager()
    {
        return $this->container->get('phpmob.imagine.cache_manager');
    }

    /**
     * @param string $path
     * @param string $filter
     * @param string $mode
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function filterRuntimeAction($path, $filter, $mode = 'inset')
    {
        if ($path instanceof ImageInterface) {
            $path = $path->getPath();
        }

        $runtimeConfig = [
            'thumbnail' => [
                'size' => explode('x', strtolower($filter)),
                'mode' => $mode,
            ],
        ];

        return $this->redirect(
            $this->getImagineCacheManager()->getBrowserPath($path, 'phpmob_imagine', $runtimeConfig
        ));
    }
}
